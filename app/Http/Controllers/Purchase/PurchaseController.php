<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
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
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'date' => 'required',
            'document' => 'file|mimes:jpg,pdf,png,svg,webp,jpeg,gif|max:5120'
        ]);

        if ($validator->passes()) {
            $totalQty = 0;
            $totalAmount = 0;
            // Assuming all arrays have the same length
            $arrayLength = count($request->product_name);
            for ($i = 0; $i < $arrayLength; $i++) {
                $totalQty += $request->quantity[$i];
                $totalAmount += ($request->unit_price[$i] * $request->quantity[$i]);
            }
            $purchaseDate = Carbon::createFromFormat('d-M-Y', $request->date)->format('Y-m-d');

            // purchase table Crud
            $purchase = new Purchase;
            $purchase->branch_id = Auth::user()->branch_id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->purchase_date =  $purchaseDate;
            $purchase->purchase_by =  Auth::user()->id;
            $purchase->total_quantity =  $totalQty;
            $purchase->total_amount =  $totalAmount;
            if ($request->invoice) {
                $purchase->invoice = $request->invoice;
            } else {
                do {
                    $invoice = rand(123456, 999999); // Generate a random number
                    $existingInvoice = Purchase::where('invoice', $invoice)->first(); // Check if the random invoice exists
                } while ($existingInvoice); // Keep generating until a unique invoice number is found
                $purchase->invoice = $invoice;
            }
            $purchase->discount_amount = $request->discount_amount;
            if ($request->carrying_cost > 0) {
                $purchase->sub_total = $request->sub_total - $request->carrying_cost;
                $purchase->grand_total = $request->grand_total - $request->carrying_cost;
                $purchase->paid = $request->total_payable - $request->carrying_cost;
                $due = ($request->grand_total - $request->carrying_cost) - ($request->total_payable - $request->carrying_cost);
            } else {
                $purchase->sub_total = $request->sub_total;
                $purchase->grand_total = $request->grand_total;
                $purchase->paid = $request->total_payable;
                $due = $request->grand_total - $request->total_payable;
            }
            if ($due > 0) {
                $purchase->due = $due;
            } else {
                $purchase->due = 0;
            }
            $purchase->carrying_cost = $request->carrying_cost;
            $purchase->payment_method = $request->payment_method;
            $purchase->note = $request->note;
            if ($request->document) {
                $docName = rand() . '.' . $request->document->getClientOriginalExtension();
                $request->document->move(public_path('uploads/purchase/'), $docName);
                $purchase->document = $docName;
            }
            $purchase->save();

            // get purchaseId
            $purchaseId = $purchase->id;

            for ($i = 0; $i < $arrayLength; $i++) {
                $items = new PurchaseItem;
                $items->purchase_id = $purchaseId;
                $items->product_id = $request->product_id[$i];
                $items->unit_price = $request->unit_price[$i];
                $items->quantity = $request->quantity[$i];
                $items->total_price = $request->unit_price[$i] * $request->quantity[$i];
                $items->save();


                $product = Product::findOrFail($request->product_id[$i]);
                $product->stock += $request->quantity[$i];
                $product->cost = $request->unit_price[$i];
                $product->price = $request->sell_price[$i];
                $product->save();
            }


            return response()->json([
                'status' => '200',
                'data' => $purchase,
                'message' => 'Purchase Completed'
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
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