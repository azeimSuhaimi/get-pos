<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Registered;

use App\Models\employee;
use App\Models\user;
use App\Models\activity_log;

class employeeController extends Controller
{
    // list all employee 
    public function index()
    {
        $employee = employee::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get(); // get all employee 

        return view('employee.index',['employee' => $employee]);
    }//end method

    // create employee page
    public function create()
    {
        return view('employee.create');
    }//end method

    // store new employee data
    public function store(Request $request)
    {
        $user_id =auth()->user()->id;

        // validated new employee data 
        $validated = $request->validate([
            
            'name' => 'required|string',
            'email' => ['required','email',Rule::unique('employees')->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'phone' => ['required','numeric',Rule::unique('employees')->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'work_id' => ['required','string',Rule::unique('employees')->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'birthday' => 'required',
            'gender' => 'required|string',
            'ic' => ['required','numeric',Rule::unique('employees')->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
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
        $employee->address2 = $validated['address2'];
        $employee->position = $validated['position'];
        $employee->date_register = $now;
        $employee->user_id = auth()->user()->id;
        $employee->save();

        // Manually fire the Registered event
        event(new Registered($employee));

        activity_log::addActivity('Add New Employee',' add new employee '.$validated['name'].' into system');

        return back()->with('success','add new employee '.$validated['name']);
        
    }//end method

    //edit employee page
    public function edit(Request $request)
    {
        $employee = employee::find($request->input('id'));// id employee input

        return view('employee.edit',['employee'=>$employee]);
    }//end method

    //view employee page
    public function view(Request $request)
    {
        $employee = employee::find($request->input('id'));// id employee input

        return view('employee.view',['employee'=>$employee]);
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

    //update employee data 
    public function update(Request $request)
    {
        $user_id =auth()->user()->id;

        // validate data employee update base rule
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'email' =>['required','email',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })] ,
            'phone' => ['required','numeric',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'work_id' =>['required','string',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'birthday' => 'required',
            'gender' => 'required|string',
            'ic' =>['required','numeric',Rule::unique('employees')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })] ,
            'address' => 'required',
            'address2' => 'required',
            'position' => 'required',
            
            
        ]);

        //store data update to database
        $employee = employee::find($validated['id']);
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

    public function status(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $employee = employee::find($request->input('id'));

        if($employee->status == true)
        {
            $employee->status = false;
            $employee->save();
            
            activity_log::addActivity('change status',' change status employee to resign');
            return redirect(route('employee.edit').'?id='.$request->input('id'))->with('success','employee is resign');
        }
        else
        {
            $employee->status = true;
            $employee->save();

            activity_log::addActivity('change status',' change status employee to active back');
            return redirect(route('employee.edit').'?id='.$request->input('id'))->with('success','employee is active back');
        }

        return back();
    }//end method

    /*
    public function reset_password_employee(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $users = user::find($validated['id']);

        $pass = Hash::make($users->ic);

        $users->password = $pass;
        $users->save();

        activity_log::addActivity('reset password',' reset password employee');
        return back()->with('success',' password is reset to ic now');
        
    }*///end method

}//end class
