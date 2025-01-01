<?php

namespace App\Http\Controllers;

use App\Models\test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = item::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();

        return view('item.index',['items' => $items]);
    }//end method

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item.create');
    }//end method

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_email =auth()->user()->email;

        // validated new employee data 
        $validated = $request->validate([
            
            'name' => 'required|string',
            'email' => ['required','email',Rule::unique('employees')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'phone' => ['required','numeric',Rule::unique('employees')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'work_id' => ['required','string',Rule::unique('employees')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'birthday' => 'required',
            'gender' => 'required|string',
            'ic' => ['required','numeric',Rule::unique('employees')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'address' => 'required',
            'address2' => 'required',
            'position' => 'required',
            
        ]);

        $now = Carbon::now();// get date today
        
        //store data to database 
        $employee = new employee;
        $employee->name = $validated['name'];
        $employee->email = $validated['email'];
        $employee->phone = $validated['phone'];
        $employee->gender = $validated['gender'];
        $employee->birthday = $validated['birthday'];
        $employee->ic = $validated['ic'];
        $employee->work_id = $validated['work_id'];
        $employee->address = $validated['address'];
        $employee->position = $validated['position'];
        $employee->date_register = $now;
        $employee->user_email = auth()->user()->email;
        $employee->save();

        // Manually fire the Registered event
        event(new Registered($employee));

        activity_log::addActivity('Add New Employee',' add new employee '.$validated['name'].' into system');

        return back()->with('success','add new employee '.$validated['name']);
        
    }//end method


    /**
     * Display the specified resource.
     */
    public function show(test $test)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $employee = employee::find($request->input('id'));// id employee input

        return view('employee.view',['employee'=>$employee]);
    }//end method

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(test $test)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $employee = employee::find($request->input('id'));// id employee input

        return view('employee.edit',['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, test $test)
    {
        $user_email =auth()->user()->email;

        // validate data employee update base rule
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'email' =>['required','email',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })] ,
            'phone' => ['required','numeric',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'work_id' =>['required','string',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'birthday' => 'required',
            'gender' => 'required|string',
            'ic' =>['required','numeric',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })] ,
            'address' => 'required',
            'address2' => 'required',
            'position' => 'required',
            
            
        ]);

        //store data update to database
        $employee = employee::find($validated['id']);

        if(!$employee)
        {
            return response()->json(['messege' => 'data not found']);
            return 'tiada data '.$id ;
        }

        if($employee->user_email != auth()->user()->email)
        {
            return response()->json(['messege' => 'you are not unauthorize']);
        }

        $employee->name = $validated['name'];
        $employee->email = $validated['email'];
        $employee->phone = $validated['phone'];
        $employee->gender = $validated['gender'];
        $employee->birthday = $validated['birthday'];
        $employee->ic = $validated['ic'];
        $employee->work_id = $validated['work_id'];
        $employee->address = $validated['address'];
        $employee->address2 = $validated['address2'];
        $employee->save();

        activity_log::addActivity('update details employee ',' change it details employee '.$validated['name']);

        return redirect(route('employee.edit').'?id='.$validated['id'])->with('success','edit details employee '.$validated['name']);

    }//end method

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(test $test)
    {
        // validation all input expense 
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $customer_order = customer_order::find($id);
        if(!$customer_order)
        {
            return response()->json(['messege' => 'data not found']);
            return 'tiada data '.$id ;
        }

        if($customer_order->user_email != auth()->user()->email)
        {
            return response()->json(['messege' => 'you are not unauthorize']);
        }
        $customer_order->delete();

        activity_log::addActivity('remove  customer order ',' remove customer order ');

        return back()->with('success','remove customer order  ');
    }//end method

    //edit image for profile employee
    public function update_image(Request $request)
    {
        // validated input
        $validated = $request->validate([
            'id' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $employee = employee::find($validated['id']);// find table employee based id

        // validate file upload 
        if ($request->hasFile('file')) 
        {
            // get upload image to change and validated rule
            $file = $request->file('file');
            $fileName = time().'.'.$file->getClientOriginalExtension();// change name file avoid redundant
    
            $file->move(public_path('profile/'), $fileName); // location image store

            if($employee->picture != 'empty.png')
            {
                
                $filePath = public_path('profile/'.$employee->picture); // store file to location

                // delete fine from past
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

            }
            
            // store image name to database
                $employee->picture = $fileName;
                $employee->save();

                activity_log::addActivity('Change image',' change it image employee to new');
            return redirect(route('employee.edit').'?id='.$validated['id'])->with('success',$fileName);
            
        }//end validated file

        return redirect(route('employee.edit').'?id='.$validated['id'])->with('error','fail edit image');

    }//end method

    //edit image for profile employee
    public function remove_image(Request $request)
    {
        // validated input
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $employee = employee::find($validated['id']);// find table employee based id


            if($employee->picture != 'empty.png')
            {
                
                $filePath = public_path('profile/'.$employee->picture); // store file to location

                // delete fine from past
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

            }
            
            // store image name to database
                $employee->picture = 'empty.png';
                $employee->save();

                activity_log::addActivity('remove image',' remove image employee to empty');

            return redirect(route('employee.edit').'?id='.$validated['id'])->with('success','success remove image');
            

    }//end method

    public function send_receipt(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required',
            'email' => 'required|email',
        ]);

        $company = company::where('user_email',auth()->user()->email)->first();
        $payment_type = payment_type::all();

        $datas = [
            'payment_type' => $payment_type,
            'company' => $company,
            'invoice' => invoice::firstWhere('invoice_id', $validated['invoice_id']),
            'invoice_detail' => invoice_detail::where('invoice_id', $validated['invoice_id'])->get(),
            'payment_method' => payment_method::where('invoice_id', $validated['invoice_id'])->get()
        ];

        Mail::to($validated['email'])->send(new send_receipt( $datas));
        return redirect(route('dashboard'))->with('success','send receipt to to email '.$validated['email']);
    }//end method

    public function list_softdelete_only()
    {
        $items = item::onlyTrashed()->where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();

        return view('item.index',['items' => $items]);
    }//end method

    public function list_all_including_softdelete()
    {
        $items = item::withTrashed()->where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();

        if($items->trashed())
        {
            //test data softdelete or not
        }
        return view('item.index',['items' => $items]);
    }//end method

    public function restore_softdelete_all(Request $request)
    {
        $items = item::restore();
        return back()->with('success','remove customer order  ');
    }

    public function restore_softdelete_by_id(Request $request)
    {
        $items = item::where('user_email',auth()->user()->email)->restore();
        return back()->with('success','remove customer order  ');
    }

}//end class
