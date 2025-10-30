<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

use App\Models\waste;
use App\Models\item;
use App\Models\activity_log;

class wasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wastes = waste::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();

        return view('waste.index',['wastes' => $wastes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('waste.create');
    }

    public function store(Request $request)
    {
        $user_id =auth()->user()->id;

        // validated new items data 
        $validated = $request->validate([
            
            'quantity' => 'required|integer',
            'shortcode' => 'required',
            'reason' => 'required',
            'remark' => 'required|string',
            
        ]);

        $item = item::where('user_id',auth()->user()->id)->where('shortcode', $validated['shortcode'])->first();

        if (!$item) 
            {
                return back()->with('error',' item not exist in system '.$validated['shortcode']);
            }

            if($item->category == 'retail')
            {

                    //store data update to database
                    $item = item::where('user_id',auth()->user()->id)->where('shortcode',$validated['shortcode'])->first();
                    $item->quantity = $item->quantity - $validated['quantity'];
                    $item->save();
                

            }

        
        
        
        //store data to database 
        $waste = new waste;
        $waste->name = $item->name;
        $waste->shortcode = $item->shortcode;
        $waste->quantity = $validated['quantity'];
        $waste->cost = $item->cost;
        $waste->price = $item->price;
        $waste->description = $item->description;
        $waste->category = $item->category;
        $waste->reason = $validated['reason'];
        $waste->remark = $validated['remark'];
        $waste->user_id = auth()->user()->id;

       $waste->save();

        activity_log::addActivity('Add New Item waste',' add new item waste '.$item->name.'into system');

        return back()->with('success','add new item waste '.$item->name);
        
    }//end method

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            
            'id' => 'required',
            
        ]);
        $waste = waste::find($request->input('id'));// id items input

        return view('waste.view',['waste'=>$waste]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
