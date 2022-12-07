<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class InvoiceController extends Controller {
    
    public function index() {
        if(session()->has('admin')) {
            
        } else return redirect('/');
    }
}
