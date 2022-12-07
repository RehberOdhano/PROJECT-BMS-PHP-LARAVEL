<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DebitCredit;
use App\Models\Distribution;
use App\Models\User;

Session();
class DebitCreditController extends Controller
{

    // displays all the records
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
            $debitCreditData = DebitCredit::where('distribution_id', $dist_id)
                ->where('user_id', $id)->get();

            $totalDebitAmount = DebitCredit::where('distribution_id', $dist_id)
                ->where('user_id', $id)->sum('debit');

            $totalCreditAmount = DebitCredit::where('distribution_id', $dist_id)
                ->where('user_id', $id)->sum('credit');

            return view('dist-admin-pages.debit-credit', [
                "debitCredits" => $debitCreditData,
                'totalCreditAmount' => $totalCreditAmount, "totalDebitAmount" => $totalDebitAmount,
                "totalBalance" => ($totalDebitAmount - $totalCreditAmount)
            ]);
        }
    }

    // will be used to add debit/credit records in the table... first, it'll
    // check if an entry already exists... if not, then this means it's the first
    // record going to be added to the table... otherwise computations will be 
    // done based on the latest entry entered in the table...
    public function addDebitDredit(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $debitCreditData = DebitCredit::where([
            ['user_id', $userID],
            ['distribution_id', $dist_id]
        ])->orderBy('id', 'DESC')->get();
        $credit = $req->credit == "" ? 0 : $req->credit;
        $debit = $req->debit == "" ? 0 : $req->debit;
        $balance = 0;
        if (count($debitCreditData)) {
            $debitCreditData = $debitCreditData["0"];
            $balance = $debitCreditData->balance;
            if ($debit != 0) {
                $balance = $balance + $debit;
            } else if ($credit != 0) {
                $balance -= $credit;
            }
        } else {
            if ($debit != 0) {
                $balance = $debit;
            } else if ($credit != 0) {
                $balance = $credit;
            }
        }
        $debitCredit = new DebitCredit();
        $debitCredit->distribution_id = $dist_id;
        $debitCredit->user_id = $userID;
        $debitCredit->date = $req->date;
        $debitCredit->description = $req->description;
        $debitCredit->debit = $debit;
        $debitCredit->credit = $credit;
        $debitCredit->balance = $balance;
        $debitCredit->save();
        session()->put('success', 'Debit/Credit is successfully added.');
        return redirect('/dists/admin/debit-credit');
    }

    // will be used to add debit/credit records in the table... the computations will be 
    // done based on the latest entry entered in the table...
    public function editDebitCredit(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $debitCreditData = DebitCredit::where('distribution_id', $dist_id)
            ->where('id', $id)->where('user_id', $userID)->first();
        $balance = $debitCreditData->balance;
        $credit = $req->credit == "" ? $debitCreditData->credit : $req->credit;
        $debit = $req->debit == "" ? $debitCreditData->debit : $req->debit;
        if ($req->debit != "") {
            $balance = ($debit + $debitCreditData->balance) - $debitCreditData->debit;
        } else if ($req->credit != "") {
            $balance = ($balance - $credit) + $debitCreditData->credit;
        }
        $description = ($req->descripton == "") ? $debitCreditData->description : $req->description;
        $debitAmount = ($req->debit == "") ? $debitCreditData->debit : $req->debit;
        $creditAmount = ($req->credit == "") ? $debitCreditData->crebit : $req->credit;
        $date = ($req->date == "") ? $debitCreditData->date : $req->date;
        DebitCredit::where('distribution_id', '=', $dist_id)
            ->where('id', $id)->where('user_id', $userID)
            ->update([
                "date" => $date,
                "description" => $description,
                "debit" => $debitAmount,
                "credit" => $creditAmount,
                "balance" => $balance
            ]);
        session()->put('update', 'Debit/Credit is successfully updated.');
        return redirect('/dists/admin/debit-credit');
    }

    // deletes the record from the table based on id
    public function deleteEditCredit($id)
    {
        DebitCredit::destroy($id);
        session()->put('delete', 'Debit/Credit is successfully deleted.');
        return redirect('/dists/admin/debit-credit');
    }
}