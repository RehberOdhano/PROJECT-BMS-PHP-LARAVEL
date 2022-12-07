<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\User;

class VehicleController extends Controller
{
    public function index()
    {
        if (session()->has('user')) {
            $id = session()->get('user')['id'];
            $dist_id = session()->get('user')['distribution_id'];
            $user = session()->get('user');
            $status = User::where('id', '=', $user->id)->select('status')->first();
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
            $vehicles = Vehicle::where('distribution_id', $dist_id)
                ->where('user_id', $id)->get();
            return view('dist-admin-pages.vehicles', ["vehicles" => $vehicles]);
        }
    }

    public function addVehicle(Request $req)
    {
        if (session()->has('user')) {
            $id = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $id = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $data = Vehicle::where('distribution_id', '=', $dist_id)
            ->where('user_id', $id)
            ->where('number_plate', '=', $req->num_plate)
            ->get();
        if ($data->isEmpty() || $data == null) {
            $vehicle = new Vehicle();
            $vehicle->user_id = $id;
            $vehicle->distribution_id = $dist_id;
            $vehicle->number_plate = $req->num_plate;
            $vehicle->make = ($req->make == "") ? "NONE" : $req->make;
            $vehicle->model = ($req->model == "") ? "NONE" : $req->model;
            $vehicle->fuel_type = ($req->fuel_type == "") ? "NONE" : $req->fuel_type;
            $vehicle->mileage = ($req->mileage == "") ? "NONE" : $req->mileage;
            $vehicle->engine_num = ($req->engine_num == "") ? "NONE" : $req->engine_num;
            $vehicle->save();
            session()->put('success', 'Vehicle is successfully added.');
        } else {
            session()->put('warning', 'Vehicle with this number already exists.');
        }
        return redirect('/dists/admin/vehicle');
    }

    public function updateVehicle(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $vehicle = Vehicle::where([
            ['id', '=', $id],
            ['user_id', '=', $userID],
            ['distribution_id', '=', $dist_id]
        ])
            ->first();
        $number_plate = ($req->num_plate == "") ? $vehicle->number_plate : $req->num_plate;
        $make = ($req->make == "") ? $vehicle->make : $req->make;
        $model = ($req->model == "") ? $vehicle->model : $req->model;
        $fuel_type = ($req->fuel_type == "") ? $vehicle->fuel : $req->fuel_type;
        $mileage = ($req->mileage == "") ? $vehicle->mileage : $req->mileage;
        $engine_num = ($req->engine_num == "") ? $vehicle->engine_num : $req->engine_num;
        Vehicle::where([
            ["id", $id],
            ["user_id", $userID],
            ["distribution_id", $dist_id]
        ])->update([
            "number_plate" => $number_plate,
            "make" => $make,
            "model" => $model,
            "fuel_type" => $fuel_type,
            "mileage" => $mileage,
            "engine_num" => $engine_num
        ]);
        session()->put('update', 'Vehicle is successfully updated.');
        return redirect('/dists/admin/vehicle');
    }

    public function deleteVehicle($id)
    {
        Vehicle::destroy($id);
        session()->put('delete', 'Vehicle is successfully deleted.');
        return redirect('/dists/admin/vehicle');
    }
}