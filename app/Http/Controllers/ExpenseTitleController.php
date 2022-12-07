<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseTitle;
use App\Models\Expense;
use App\Models\User;

Session();

class ExpenseTitleController extends Controller
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
            $expenses = ExpenseTitle::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();

            return view('dist-admin-pages.expense-titles', ['expenses' => $expenses]);
        }
    }

    public function addExpenseTitle(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $expense = new ExpenseTitle();
        $expense->distribution_id = $dist_id;
        $expense->user_id = $userID;
        $expense->title = $req->exp_title;
        $expense->save();
        session()->put('success', 'Expense Title is successfully added.');
        return redirect('/dists/admin/expense/titles');
    }

    public function editExpenseTitle(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }

        // updating the expense title table...
        $expense_title = $req->exp_title;
        ExpenseTitle::where([
            ["id", $id],
            ["user_id", $userID]
        ])->update([
            "title" => $expense_title,
        ]);

        // updating the expense table accordingly...
        Expense::where([
            ["expense_title_id", $id]
        ])->update([
            "expense_title" => $expense_title
        ]);
        session()->put('update', 'Expense Title is successfully updated.');
        return redirect('/dists/admin/expense/titles');
    }

    public function deleteExpenseTitle($id)
    {
        // deleting the expense title and all the records related to it in the
        // expene table accordingly...
        $exp = ExpenseTitle::find($id);
        $exp->getTitleSpecificExpenses()->delete();
        $exp->delete();
        session()->put('deleted', 'Expense is successfully deleted.');
        return redirect('/dists/admin/expenses');
    }
}