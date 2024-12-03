<?php

namespace App\Http\Controllers\ServiceSale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceSaleController extends Controller
{
    public function index(){
        return view('all_modules.service_sale.service_sale');
    }//End Method

}//Mian End
