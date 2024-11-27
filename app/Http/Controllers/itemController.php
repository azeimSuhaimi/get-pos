<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

use App\Models\activity_log;
use App\Models\item;

class itemController extends Controller
{
    //get all list item product
    public function index()
    {
        $items = item::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();

        return view('item.index',['items' => $items]);
    }//end method

    //create new item page
    public function create()
    {
        return view('item.create');
    }//end method

    // store new Item data
    public function store(Request $request)
    {
        $user_email =auth()->user()->email;

        // validated new items data 
        $validated = $request->validate([
            
            'name' => ['required','string',Rule::unique('items')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'shortcode' => ['required','string',Rule::unique('items')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'quantity' => 'required|integer',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category' => 'required',
            
        ]);

        
        //store data to database 
        $item = new item;
        $item->name = $validated['name'];
        $item->shortcode = $validated['shortcode'];
        $item->quantity = $validated['quantity'];
        $item->cost = $validated['cost'];
        $item->price = $validated['price'];
        $item->description = $validated['description'];
        $item->category = $validated['category'];
        $item->user_email = auth()->user()->email;

        $item->save();

        activity_log::addActivity('Add New Item',' add new item '.$validated['name'].'into system');

        return back()->with('success','add new item, success make new items '.$validated['name']);
        
    }//end method

    //edit items page
    public function edit(Request $request)
    {
        $items = item::find($request->input('id'));// id items input

        return view('item.edit',['items'=>$items]);
    }//end method

    //view items page
    public function view(Request $request)
    {
        $items = item::find($request->input('id'));// id items input

        return view('item.view',['items'=>$items]);
    }//end method

    //edit image for items
    public function update_image(Request $request)
    {
        // validated input
        $validated = $request->validate([
            'id' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item = item::find($validated['id']);// find table employee based id

        // validate file upload 
        if ($request->hasFile('file')) 
        {
            // get upload image to change and validated rule
            $file = $request->file('file');
            $fileName = time().'.'.$file->getClientOriginalExtension();// change name file avoid redundant
    
            $file->move(public_path('items/'), $fileName); // location image store

            if($item->picture != 'empty.png')
            {
                
                $filePath = public_path('items/'.$item->picture); // store file to location

                // delete fine from past
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

            }
            
            // store image name to database
                $item->picture = $fileName;
                $item->save();

                activity_log::addActivity('Change image',' change it image item to new');
            return redirect(route('item.edit').'?id='.$validated['id'])->with('success',$fileName);
            
        }//end validated file

        return redirect(route('item.edit').'?id='.$validated['id'])->with('error','fail edit image');

    }//end method

    //edit image for item
    public function remove_image(Request $request)
    {
        // validated input
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $item = item::find($validated['id']);// find table employee based id


            if($item->picture != 'empty.png')
            {
                
                $filePath = public_path('items/'.$item->picture); // store file to location

                // delete fine from past
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

            }
            
            // store image name to database
                $item->picture = 'empty.png';
                $item->save();

                activity_log::addActivity('remove image',' remove image item to empty');

            return redirect(route('item.edit').'?id='.$validated['id'])->with('success','success remove image');
            

    }//end method

    public function status(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $item = item::find($request->input('id'));

        if($item->status == true)
        {
            $item->status = false;
            $item->save();
            
            activity_log::addActivity('change status',' change status item to deactive');
            return redirect(route('item.edit').'?id='.$request->input('id'))->with('success','item is deactive');
        }
        else
        {
            $item->status = true;
            $item->save();

            activity_log::addActivity('change status',' change status item to active back');
            return redirect(route('item.edit').'?id='.$request->input('id'))->with('success','item is active back');
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
            'name' => ['required','string',Rule::unique('items')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'shortcode' => ['required','string',Rule::unique('items')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'quantity' => 'required|numeric',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'descriptions' => 'required',
            'category' => 'required',
                        
        ]);

        //store data update to database
        $item = item::find($validated['id']);
        $item->name = $validated['name'];
        $item->shortcode = $validated['shortcode'];
        $item->quantity = $validated['quantity'];
        $item->cost = $validated['cost'];
        $item->price = $validated['price'];
        $item->description = $validated['descriptions'];
        $item->category = $validated['category'];
        $item->save();

        activity_log::addActivity('update details item ',' change it details item '.$validated['name']);

        return redirect(route('item.edit').'?id='.$validated['id'])->with('success','edit details item '.$validated['name']);

    }//end method

}//end class
