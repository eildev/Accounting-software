<?php

namespace App\Http\Controllers\ServiceSale;

use App\Http\Controllers\Controller;
use App\Models\ServiceSale\ServiceSale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceSaleController extends Controller
{
    public function index()
    {
        return view('all_modules.service_sale.service_sale');
    } //End Method
    public function store(Request $request)
    {

        $serviceNames = $request->input('serviceName', []);
        $volumes = $request->input('volume', []);
        $prices = $request->input('price', []);
        $totals = $request->input('total', []);
        $formattedDate = Carbon::parse($request->date)->format('Y-m-d') ?? Carbon::parse(Carbon::now())->format('Y-m-d');

        // Loop through the arrays and insert each service
        foreach ($serviceNames as $key => $serviceName) {
            ServiceSale::create([
                'branch_id' => Auth::user()->branch_id,
                'customer_id' => $request->customer_id,
                'date' => $formattedDate,
                'name' => $serviceName,
                'volume' => $volumes[$key],
                'price' => $prices[$key],
                'total' => $totals[$key],
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Services added successfully!',
        ]);
    } //End Method
    public function view() {
        $serviceSales = ServiceSale::all();
        return view('all_modules.service_sale.service_sale_view',compact('serviceSales'));
    }//End Method
}//Mian End
