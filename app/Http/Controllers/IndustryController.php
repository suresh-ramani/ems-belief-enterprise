<?php

namespace App\Http\Controllers;

use App\Enums\Meter\Status as StatusEnum;
use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax() && request()->wantsJson()){
            return datatables()->of(Industry::withCount('meters'))
                ->editColumn("status", function($industry){
                    return $industry->status->badge();
                })
                ->editColumn("action", function($industry){
                    return view("industry.datatable-action", compact("industry"))->render();
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('industry.list');
    }

    private function statusOptions()
    {
        return StatusEnum::asOptions();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('industry.create', [
            'statusOptions' => $this->statusOptions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'owner_name' => "nullable",
            'owner_email' => "nullable",
            'owner_phone' => "nullable",
            'status' => "required|in:".implode(",", StatusEnum::values()),
            "address" => 'nullable'
        ]);

        try{
            Industry::create($request->post());

            return to_route("industries.index")->with([
                'status' => 'success',
                'message' => 'Industry Added Successfully.'
            ]);
        }catch(\Exception $e){
            report($e);
            return back()->withInput()->with([
                'status' => 'error',
                'message' => 'Something goes wrong.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Industry $industry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industry $industry)
    {
        return view("industry.edit", [
            'industry' => $industry,
            'statusOptions' => $this->statusOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required',
            'owner_name' => "nullable",
            'owner_email' => "nullable",
            'owner_phone' => "nullable",
            'status' => "required|in:".implode(",", StatusEnum::values()),
            "address" => 'nullable'
        ]);

        try{
            $industry->fill($request->post())->save();

            return to_route("industries.index")->with([
                'status' => 'success',
                'message' => 'Industry Updated Successfully.'
            ]);
        }catch(\Exception $e){
            report($e);
            return back()->withInput()->with([
                'status' => 'error',
                'message' => 'Something goes wrong.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        try{
            $industry->delete();            
            return response()->json([
                'message' => "Industry deleted successfully."
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'message' => "Something goes wrong."
            ]);
        }
    }
}
