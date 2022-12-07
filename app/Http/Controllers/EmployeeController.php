<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

Session();

class EmployeeController extends Controller
{

    public function index()
    {
        if (session()->has('user')) {
            $id = session()->get('user')['id'];
            $status = User::where('id', '=', $id)->select('status')->first();
            $email = session()->get('user')['email'];
        }
        if (session()->has('admin')) {
            $id = session()->get('admin')['id'];
            $email = session()->get('admin')['email'];
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
            $userData = User::where('email', '=', $email)->first();
            $employees = Employee::where('distribution_id', '=', $userData->distribution_id)
                ->where('user_id', $id)->get();
            return view('dist-admin-pages.employees', ['employees' => $employees]);
        }
    }

    public function add_employee(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        // getting the employee data from the database based on the form details
        // and checks whether the employee already exists or not... if exists, then
        // error message will be displayed otherwise new employee will be created...
        $employeeData = Employee::where('user_id', $userID)
            ->where('distribution_id', $dist_id)
            ->where('name', $req->name)
            ->where('designation', $req->designation)
            ->first();
        if ($employeeData == null) {
            $employee = new Employee();
            $employee->distribution_id = $dist_id;
            $employee->user_id = $userID;
            $employee->name = $req->name;
            $employee->designation = $req->designation;
            $employee->department = $req->dept;
            $employee->contact = $req->contact;
            $employee->employee_since = $req->date;
            $employee->salary = $req->salary;
            $employee->save();
            session()->put('success', 'Employee is successfully added.');
        } else {
            session()->put('error', 'This employee is adready added to the system!');
        }

        return redirect('/dists/admin/employees');
    }

    public function edit_employee(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }

        $employee = Employee::where('id', $id)->where('user_id', $userID)->first();

        $name = ($req->name == "") ? $employee->name : $req->name;
        $designation = ($req->designation == "") ? $employee->designation : $req->designation;
        $department = ($req->dept == "") ? $employee->department : $req->dept;
        $contact = ($req->contact == "") ? $employee->contact : $req->contact;
        $employee_since = ($req->date == "") ? $employee->employee_since : $req->date;
        $salary = ($req->salary == "") ? $employee->salary : $req->salary;

        Employee::where([
            ["id", $id],
            ["user_id", $userID]
        ])->update([
            "name" => $name,
            "designation" => $designation,
            "department" => $department,
            "contact" => $contact,
            "employee_since" => $employee_since,
            "salary" => $salary
        ]);
        session()->put('update', 'Employee is successfully updated.');
        return redirect('/dists/admin/employees');
    }

    public function delete_employee($id)
    {
        Employee::destroy($id);
        session()->put('delete', 'Employee is successfully deleted.');
        return redirect('/dists/admin/employees');
    }
}