<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;

Session();

class ReportController extends Controller {

    public function index() {
        if(session()->has('admin')) {

        } else return redirect('/');
    }

    
}
