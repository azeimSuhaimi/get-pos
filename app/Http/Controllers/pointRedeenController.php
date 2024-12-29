<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activity_log;
use App\Models\itemredeen;
use Illuminate\Validation\Rule;

class pointRedeenController extends Controller
{
        //get all list item product
        public function index()
        {
            $itemredeen = itemredeen::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();
    
            return view('pointredeen.index',['itemredeen' => $itemredeen]);
        }//end method

            //create new item page
    public function create()
    {
        return view('pointredeen.create');
    }//end method

    // store new Item data
    public function store(Request $request)
    {
        $user_email =auth()->user()->email;

        // validated new items data 
        $validated = $request->validate([
            
            'name' => ['required','string',Rule::unique('itemredeens')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'point' => 'required|integer',
            'description' => 'required|string',
            
        ]);

        
        //store data to database 
        $item = new itemredeen;
        $item->name = $validated['name'];
        $item->point = $validated['point'];
        $item->description = $validated['description'];
        $item->user_email = auth()->user()->email;
        $item->save();

        activity_log::addActivity('Add New Redeem Item',' add new item Redeem '.$validated['name'].'into system');

        return redirect(route('pointredeen'))->with('success','add new item redeem, success make new items '.$validated['name']);
        
    }//end method

        //edit items page
        public function edit(Request $request)
        {
            $items = itemredeen::find($request->input('id'));// id items input
    
            return view('pointredeen.edit',['items'=>$items]);
        }//end method
    
        //view items page
        public function view(Request $request)
        {
            $items = itemredeen::find($request->input('id'));// id items input
    
            return view('pointredeen.view',['items'=>$items]);
        }//end method

        public function status(Request $request)
        {
            $validated = $request->validate([
                'id' => 'required',
            ]);
    
            $item = itemredeen::find($request->input('id'));
    
            if($item->status == true)
            {
                $item->status = false;
                $item->save();
                
                activity_log::addActivity('change status',' change status item redeen to deactive');
                return redirect(route('pointredeen.edit').'?id='.$request->input('id'))->with('success','item is deactive');
            }
            else
            {
                $item->status = true;
                $item->save();
    
                activity_log::addActivity('change status',' change status item redeen to active back');
                return redirect(route('pointredeen.edit').'?id='.$request->input('id'))->with('success','item is active back');
            }
    
            return back();
        }//end method

                    //update item data 
    public function update(Request $request)
    {
        $user_email =auth()->user()->email;

        // validate data item update base rule
        $validated = $request->validate([
            'id' => 'required',
            'name' => ['required','string',Rule::unique('itemredeens')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'point' => 'required|integer',
            'descriptions' => 'required',
                        
        ]);

        //store data update to database
        $item = itemredeen::find($validated['id']);
        $item->name = $validated['name'];
        $item->point = $validated['point'];
        $item->description = $validated['descriptions'];
        $item->save();

        activity_log::addActivity('update details item redeen ',' change it details item redeen '.$validated['name']);

        return redirect(route('pointredeen.edit').'?id='.$validated['id'])->with('success','edit details item '.$validated['name']);

    }//end method

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $item = itemredeen::find($request->input('id'));

        $item->delete();

        return redirect(route('pointredeen'));
    }//end method

}//end class
