<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ledger;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    public function index()
    {
        if (session()->has('user')) {
            $id = session()->get('user')['id'];
            $dist_id = session()->get('user')['distribution_id'];
            $status = User::where('id', '=', $id)->select('status')->first();
        }
        if (session()->has('admin')) {
            $id = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
            $status = User::where('id', '=', $id)->select('status')->first();
        }

        if (strcmp($status->status, "BLOCKED") == 0) {
            if (session()->has('admin')) {
                session()->forget('admin');
            }
            if (session()->has('user')) {
                session()->forget('user');
            }
            return redirect('/');
        } else {
            $data = Ledger::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();
            return view('dist-admin-pages.ledger', ['details' => $data]);
        }
    }

    public function addLedger($data)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $ledger = new Ledger();
        $ledger->distribution_id = $dist_id;
        $ledger->user_id = $userID;
        $ledger->sale_id = $data["sale_id"];
        $ledger->outlet = $data["outlet"];
        $ledger->salesman = $data["salesman"];
        $ledger->total_amount = $data["total_amount"];
        $ledger->amount_paid = $data["amount_paid"];
        $ledger->amount_due = $data["amount_due"];
        $ledger->save();

        // session()->put('success', 'Ledger is successfully added.');
        // return redirect('/dists/admin/ledger');
    }

    public function updateLedger(Request $req, $sale_id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }
        DB::table('ledgers')
            ->where('sale_id', $sale_id)->where('user_id', $userID)
            ->update([
                'total_amount' => $req->totalAmount,
                'amount_paid' => $req->amountPaid,
                'amount_due' => $req->amountDue,
            ]);
        DB::table("sales")
            ->where("id", $sale_id)->update([
                'total_amount' => $req->totalAmount,
                'amount_received' => $req->amountPaid,
                'due_amount' => $req->amountDue,
            ]);
        session()->put('update', 'Ledger is successfully updated.');
        return redirect('/dists/admin/ledger');
    }

    // public function deleteLedger($id)
    // {
    //     Ledger::destroy($id);
    //     session()->put('delete', 'Ledger is successfully deleted.');
    //     return redirect('/dists/admin/ledger');
    // }
}