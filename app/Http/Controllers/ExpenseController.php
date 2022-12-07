<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseTitle;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Session();

class ExpenseController extends Controller
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
            $admin = session()->get('admin');
            $status = User::where('id', '=', $admin->id)->select('status')->first();
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
            $expenses = Expense::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();

            $expTitles = ExpenseTitle::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();

            $sum = DB::table('expenses')->where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->sum('amount');

            return view('dist-admin-pages.expenses', [
                'expenses' => $expenses,
                'total' => $sum,
                "titles" => $expTitles
            ]);
        }
    }

    public function add_expense(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $expense = new Expense();
        $expense->distribution_id = $dist_id;
        $expense->user_id = $userID;
        $expenseData = explode('-', $req->expTitle);
        $expense->expense_title_id = $expenseData[1];
        $expense->expense_title = $expenseData[0];
        if ($req->amount > 2147483647) {
            session()->put('int-error', 'Amount value is too big!');
            return redirect('/dists/admin/expenses');
        } else {
            $expense->amount = $req->amount;
            $expense->date = $req->date;
            $expense->save();
            session()->put('success', 'Expense is successfully added.');
            return redirect('/dists/admin/expenses');
        }
    }

    public function edit_expense(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }
        $expense_title = $req->expTitle;
        $amount = $req->amount;
        if ($amount > 2147483647) {
            session()->put('int-error', 'Amount value is too big!');
            return redirect('/dists/admin/expenses');
        } else {
            $date = $req->date;
            Expense::where([
                ["id", $id],
                ["user_id", $userID]
            ])->update([
                "date" => $date,
                "expense_title" => $expense_title,
                "amount" => $amount,
            ]);
            session()->put('update', 'Expense is successfully updated.');
            return redirect('/dists/admin/expenses');
        }
    }

    public function delete_expense($id)
    {
        Expense::destroy($id);
        session()->put('deleted', 'Expense is successfully deleted.');
        return redirect('/dists/admin/expenses');
    }
}