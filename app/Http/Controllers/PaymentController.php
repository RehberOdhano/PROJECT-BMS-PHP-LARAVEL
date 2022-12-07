<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    // will display all the payments in the descending order
    public function index()
    {
        if (session()->has('superadmin')) {
            $lastPayment = DB::table('payments')->orderBy('id', 'DESC')->first();
            $payments = collect(Payment::where('id', '>=', 1)->get());
            foreach ($payments as $payment) {
                $dist = collect((Distribution::where('id', '=', $payment->distribution_id)->get()));
                foreach ($dist as $item) {
                    $payment["dist_name"] = $item->name;
                }
            }
            // sorting the payments in the descending order so that the latest payment
            // can be shown on the top...
            $sortedPayArr = array();
            for ($i = count($payments) - 1; $i >= 0; $i--) {
                array_push($sortedPayArr, $payments[$i]);
            }
            return view('super-admin.payments', ["payments" => $sortedPayArr]);
        } else return redirect('/');
    }

    // adding a payment and based on it updating the distributions table as well...
    public function add_payment(Request $req, $id)
    {
        $status = $req->status;
        DB::update('UPDATE distributions SET status = ? WHERE id = ?', [$status, $id]);

        $payment = new Payment();
        $payment->distribution_id = $id;
        $payment->amount_paid = $req->amount_paid;
        $payment->due_amount = $req->amount_due;
        $payment->status = $req->status;
        $payment->date_amount_paid = $req->date_amount_paid;
        $payment->save();
        session()->put('success', "Payment is successfully made.");
        return redirect('/superadmin/payments');
    }

    // editing/updating payment and based on it updating the distributions 
    //  table as well...
    public function edit_payment(Request $req, $id)
    {
        $payment_data = Payment::where(['id' => $id])->first();
        $dist_id = $payment_data->distribution_id;
        $amount_paid = $req->amount_paid;
        $due_amount = $req->amount_due;
        $status = $req->status;
        $payment_date = $req->payment_date;

        DB::update('UPDATE payments SET amount_paid = ?, due_amount = ?, date_amount_paid = ?, status = ?
        WHERE id = ?', [$amount_paid, $due_amount, $payment_date, $status, $id]);
        DB::update('UPDATE distributions SET status = ? WHERE id = ?', [$req->status, $dist_id]);
        session()->put('update', "Payment is successfully updated.");
        return redirect('/superadmin/payments');
    }

    // find payments, where status = paid or pending
    public function searchPayment(Request $req)
    {
        $data = NULL;
        if ($req->input('query') == "") {
            $data = Distribution::where('id', '>=', 1)->get();
        } else {
            $data = Distribution::where('status', $req->input('query'))->get();
        }
        return view('super-admin.payments', ['payments' => $data, 'query' => $req->input('query')]);
    }
}