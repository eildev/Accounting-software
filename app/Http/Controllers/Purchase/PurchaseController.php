<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $supplier = Supplier::get();

        return view('all_modules.purchase.purchase', compact('products', 'supplier'));
    }

    // store function
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required',
                'date' => 'required',
                'document' => 'file|mimes:jpg,pdf,png,svg,webp,jpeg,gif|max:5120'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 500,
                    'error' => $validator->messages()
                ]);
            }

            $totalQty = collect($request->quantity)->sum();
            $totalAmount = collect($request->quantity)
                ->zip($request->unit_price)
                ->map(fn($pair) => $pair[0] * $pair[1])
                ->sum();

            $purchaseDate = Carbon::createFromFormat('d-M-Y', $request->date)->format('Y-m-d');

            // Handle document upload if exists
            $docName = $request->hasFile('document') ?
                $request->file('document')->storeAs('uploads/purchase', uniqid() . '.' . $request->document->getClientOriginalExtension()) :
                null;

            // Create the purchase
            $purchase = Purchase::create([
                'branch_id' => Auth::user()->branch_id,
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $purchaseDate,
                'purchase_by' => Auth::user()->id,
                'total_quantity' => $totalQty,
                'total_amount' => $totalAmount,
                'invoice' => $request->invoice ?: $this->generateUniqueInvoice(),
                'grand_total' => $request->sub_total,
                'paid' => 0,
                'due' => 0,
                'carrying_cost' => $request->carrying_cost,
                'note' => $request->note,
                'document' => $docName,
            ]);

            // Create purchase items and stock updates
            foreach ($request->product_id as $index => $productId) {
                $quantity = $request->quantity[$index];
                $unitPrice = $request->unit_price[$index];
                $totalPrice = $quantity * $unitPrice;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                ]);

                Stock::create([
                    'branch_id' => Auth::user()->branch_id,
                    'product_id' => $productId,
                    'stock_quantity' => $quantity,
                ]);

                Product::where('id', $productId)->update([
                    'cost' => $unitPrice,
                    'price' => $request->sell_price[$index],
                ]);
            }


            $supplier = Supplier::findOrFail($request->supplier_id);

            $supplier->update([
                'wallet_balance' =>  $supplier->wallet_balance + $totalAmount,
                'total_receivable' => $supplier->total_receivable + $totalAmount,
            ]);

            return response()->json([
                'status' => 200,
                'data' => $purchase,
                'message' => 'Purchase Completed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate a unique invoice number.
     */
    private function generateUniqueInvoice()
    {
        do {
            $invoice = rand(123456, 999999);
        } while (Purchase::where('invoice', $invoice)->exists());
        return $invoice;
    }


    // invoice function
    public function invoice($id)
    {
        $purchase = Purchase::findOrFail($id);
        $branch = Branch::findOrFail($purchase->branch_id);
        $supplier = Supplier::findOrFail($purchase->supplier_id);
        $products = PurchaseItem::where('purchase_id', $purchase->id)->get();
        if ($purchase->purchase_by) {
            $authName = User::findOrFail($purchase->purchase_by)->name;
        } else {
            $authName = "Data not Found";
        }

        return view('all_modules.purchase.invoice', compact('purchase', 'branch', 'supplier', 'products', 'authName'));
    }

    // Money Receipt
    public function moneyReceipt($id)
    {
        $purchase = Purchase::findOrFail($id);
        return view('all_modules.purchase.receipt', compact('purchase'));
    }

    // view Function
    public function view()
    {

        $purchase = Purchase::latest()->get();

        //     $purchase = Purchase::where('branch_id', Auth::user()->branch_id)->latest()->get();

        // return view('pos.purchase.view');
        return view('all_modules.purchase.view', compact('purchase'));
    }

    // supplierName function
    public function supplierName($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json([
            'status' => 200,
            'supplier' => $supplier
        ]);
    }

    // destroy function
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        if ($purchase->document) {
            $previousDocumentPath = public_path('uploads/purchase/') . $purchase->document;
            if (file_exists($previousDocumentPath)) {
                unlink($previousDocumentPath);
            }
        }
        $purchase->delete();
        return back()->with('message', "Purchase successfully Deleted");
    }

    // filter function
    public function filter(Request $request)
    {
        // dd($request->all());
        $purchaseQuery = Purchase::query();

        // Filter by product_id if provided
        if ($request->product_id != "Select Product") {
            $purchaseQuery->whereHas('purchaseItem', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            });
        }
        // Filter by supplier_id if provided
        if ($request->supplier_id != "Select Supplier") {
            $purchaseQuery->where('supplier_id', $request->supplier_id);
        }

        // Filter by date range if both start_date and end_date are provided
        if ($request->start_date && $request->end_date) {
            $purchaseQuery->whereBetween('purchase_date', [$request->start_date, $request->end_date]);
        }

        // Execute the query
        $purchase = $purchaseQuery->get();

        return view('all_modules.purchase.table', compact('purchase'))->render();
    }


    // purchaseItem Function
    public function purchaseItem($id)
    {
        // Fetch PurchaseItem records with associated Product using eager loading
        $purchaseItems = PurchaseItem::where('purchase_id', $id)
            ->with(['product.unit']) // Eager load both product and its unit
            ->get();

        if ($purchaseItems->isNotEmpty()) {
            // If data exists, return the purchase items with product details
            return response()->json([
                'status' => 200,
                'purchaseItems' => $purchaseItems
            ]);
        } else {
            // If no data found, return an error response
            return response()->json([
                'status' => 500,
                'message' => 'Data Not Found'
            ]);
        }
    }

    // get supplier details
    public function getSupplierDetails($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json(['data' => $supplier], 200);
    }

    // image to PDF
    public function imageToPdf($id)
    {
        $purchase = Purchase::findOrFail($id);
        $documentPath = public_path('uploads/purchase/' . $purchase->document);
        // Define the data to pass to the PDF generation
        $data = [
            'imagePath' => $documentPath,  // Pass the moved document path
            'title' => "$purchase->document"
        ];

        $pdf = PDF::loadView('pdf.document', $data);
        // dd($pdf);

        // Return the generated PDF for download or streaming
        return response()->json([
            "status" => 200,
            "data" => $pdf
        ]);
    }
}
