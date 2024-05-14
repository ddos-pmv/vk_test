<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

//use Illuminate\Auth\Access\Gate;

class ManageController extends Controller
{
    public function delete(Request $request){
        if(!Gate::allows('admin_action', auth()->user())){
            return response()->json(['msg' => 'Unauthorized: You are not allowed to delete users'], 403);
        }
        $user = User::find($request->input('id'));
        if (! $user) {
            return response()->json(['msg' => 'User not found'], 404);
        }
        try {
            $user->delete();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            // Log the exception and return a generic error response
            report($e);
            return response()->json(['msg' => 'An error occurred during deletion'], 500);
        }
    }

    public function all(){
        if(!Gate::allows('admin_action', auth()->user())){
            return response()->json(['msg' => 'Unauthorized: You are not allowed to delete users'], 403);
        }
        try {
            $data = User::all();
            return $data;
        }
        catch (\Exception $e) {
            report($e);
            return response()->json(['msg' => 'An error occurred during getting'], 500);
        }


    }
}
