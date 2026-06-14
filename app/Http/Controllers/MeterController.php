<?php

namespace App\Http\Controllers;

use App\Enums\Meter\Status as StatusEnum;
use App\Models\Industry;
use App\Models\Meter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MeterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax() && request()->wantsJson()){
            return datatables()->of(Meter::with("industry"))
                ->editColumn("status", function($meter){
                    return $meter->status->badge();
                })
                ->editColumn("action", function($meter){
                    return view("meter.datatable-action", compact("meter"))->render();
                })
                ->editColumn("last_reading_at", function($meter){
                    return $meter->last_reading_at ? $meter->last_reading_at->diffForHumans() : "-";
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view("meter.list");
    }

    private function statusOptions()
    {
        return StatusEnum::asOptions();
    }

    private function getIndustries()
    {
        return Industry::select("id", "name")->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("meter.create", [
            'statusOptions' => $this->statusOptions(),
            "industries" => $this->getIndustries(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "industry_id" => "required",
            "code" => "required|unique:meters,code",
            "name" => "required",
            "location" => "required",
            "status" => "required"
        ],[
            "industry_id.required" => 'The industry field is required.'
        ]);

        try{
            Meter::create($request->post());

            return to_route("meters.index")
                ->with([
                    "status" => "success",
                    "message" => "Meter Added Successfully."
                ]);
        }catch(\Exception $e){
            report($e);
            return back()->withInput()->with([
                "status" => "error",
                "message" => "Something went wrong."
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Meter $meter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meter $meter)
    {
        return view("meter.edit", [
            "meter" => $meter,
            'statusOptions' => $this->statusOptions(),
            "industries" => $this->getIndustries(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meter $meter)
    {
        $request->validate([
            "industry_id" => "required",
            'code' => [
                'required',
                Rule::unique('meters', 'code')->ignore($meter->id),
            ],
            "name" => "required",
            "location" => "required",
            "status" => "required"
        ],[
            "industry_id.required" => 'The industry field is required.'
        ]);

        try{
            $meter->fill($request->post())->save();

            return to_route("meters.index")
                ->with([
                    "status" => "success",
                    "message" => "Meter Updated Successfully."
                ]);
        }catch(\Exception $e){
            report($e);
            return back()->withInput()->with([
                "status" => "error",
                "message" => "Something went wrong."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meter $meter)
    {
        try{
            $meter->delete();
            return response()->json([
                "message" => "Meter Deleted Successfully."
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                "message" => "Something went wrong."
            ], 500);
        }
    }
}
