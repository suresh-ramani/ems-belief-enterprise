<?php

namespace App\Http\Controllers;

use App\Enums\User\Role;
use App\Models\Industry;
use App\Models\Meter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax() && request()->wantsJson()){
            return datatables()->of(User::notSuperAdmin()->withCount("meters"))
                ->editColumn("role", function($user){
                    return $user->role->badge();
                })
                ->editColumn("action", function($user){
                    return view("user.datatable-action", compact("user"))->render();
                })
                ->rawColumns(['action', 'role'])
                ->make(true);
        }

        return view("user.list");
    }

    private function getMeters()
    {
        return Meter::with("industry")->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user.create", [
            "meters" => $this->getMeters(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'meter_ids' => ['required', 'array', 'min:1'],
            'meter_ids.*' => ['required', 'integer', Rule::exists('meters', 'id')],
        ], [
            'meter_ids.required' => 'Please select at least one meter.',
            'meter_ids.array' => 'The selected meters are invalid.',
            'meter_ids.min' => 'Please select at least one meter.',
        
            'meter_ids.*.required' => 'A meter selection is required.',
            'meter_ids.*.integer' => 'The selected meter is invalid.',
            'meter_ids.*.exists' => 'One or more selected meters do not exist.',
        ]);

        try{
            $user = User::create($request->post()+['role' => Role::USER->value]);
            $user->meters()->attach($request->meter_ids);

            return to_route("users.index")->with([
                "status" => "success",
                "message" => "User Created Successfully."
            ]);
        }catch(\Exception $e){
            report($e);
            return back()->withInput()->with([
                "status" => "error",
                "message"=> "Something went wrong."
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $selectedMeterIds = $user->meters->pluck('id')->toArray();

        return view('user.edit', [
            'meters' => $this->getMeters(),
            'user' => $user,
            'selectedMeterIds' => $selectedMeterIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable'],
            'meter_ids' => ['required', 'array', 'min:1'],
            'meter_ids.*' => ['required', 'integer', Rule::exists('meters', 'id')],
        ], [
            'meter_ids.required' => 'Please select at least one meter.',
            'meter_ids.array' => 'The selected meters are invalid.',
            'meter_ids.min' => 'Please select at least one meter.',
        
            'meter_ids.*.required' => 'A meter selection is required.',
            'meter_ids.*.integer' => 'The selected meter is invalid.',
            'meter_ids.*.exists' => 'One or more selected meters do not exist.',
        ]);

        try{
            $post_data = $request->post();
            if(empty($post_data['password'])){
                unset($post_data['password']);
            }

            $user->fill($post_data)->save();
            $user->meters()->sync($request->meter_ids);

            return to_route("users.index")->with([
                "status" => "success",
                "message" => "User Updated Successfully."
            ]);
        }catch(\Exception $e){
            report($e);
            return back()->withInput()->with([
                "status" => "error",
                "message"=> "Something went wrong."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return response()->json([
                "message" => "User Deleted Successfully."
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                "message" => "Something went wrong."
            ], 500);
        }
    }
}
