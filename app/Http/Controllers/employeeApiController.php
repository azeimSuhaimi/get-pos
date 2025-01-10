<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

use App\Models\employee;
use App\Models\user;

class employeeApiController extends Controller
{
        // list all employee 
        public function index($email)
        {
            $validated = $request->validate([
            
                //'email' => 'required|email',
                
            ]);

            $employee = employee::where('user_email',$email)->orderBy('created_at','desc')->get(); // get all employee 
    
            return response()->json(['data' =>$employee]);
        }//end method

        public function show(Request $request)
        {
            $validated = $request->validate([
            
                'key' => 'required',
                'id' => 'required',
                
            ]);
    
            $user = User::where('key', $validated['key'])->first();
            
            if(!$user)
            {
                return response()->json('sorry key given is not correct');
            }
            $employee = employee::where('user_email',$user->email)->where('id',$validated['id'])->first();
            
            if(!$employee)
            {
                return response()->json('sorry id employee given is not correct');
            }

            $employee = employee::findOrFail($validated['id']);
    
            //return response()->json(['data' =>$invoice]);
    
            return response()->json($employee); // resource untuk colection satu row data sahaja
    
            
        }

            // store new employee data
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'key' => 'required',
            
            
        ]);

        $user = User::where('key', $validated['key'])->first();

        if(!$user)
        {
            return response()->json('sorry key given is not correct');
        }

        $user_email = $user->email;

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
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);

        $now = Carbon::now();// get date today
        


        
        // validate file upload 
        if ($request->hasFile('file')) 
        {
            // get upload image to change and validated rule
            $file = $request->file('file');
            $fileName = time().'.'.$file->getClientOriginalExtension();// change name file avoid redundant
    
            $file->move(public_path('profile/'), $fileName); // location image store

            
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
                    $employee->picture = $fileName;
                    $employee->user_email = $user_email;
                    
                    // store image name to database
                    $employee->picture = $fileName;
                    $employee->save();

                
                    return response()->json('success upload image and data');
            
        }//end validated file

        return response()->json('fail upload image');

    }//end method

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            
            'key' => 'required',
            'id' => 'required',
            
        ]);

        $user = User::where('key', $validated['key'])->first();

        if(!$user)
        {
            return response()->json('sorry key given is not correct');
        }
        $employee = employee::where('user_email',$user->email)->where('id',$validated['id'])->first();
        
        if(!$employee)
        {
            return response()->json('sorry id employee given is not correct');
        }
        $employee = employee::find($employee->id);
        $employee->delete();

        return response()->json('this data employee is delete');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            
            'key' => 'required',
            'id' => 'required',
            
        ]);

        $user = User::where('key', $validated['key'])->first();
        
        if(!$user)
        {
            return response()->json('sorry key given is not correct');
        }
        $employee = employee::where('user_email',$user->email)->where('id',$validated['id'])->first();
        
        if(!$employee)
        {
            return response()->json('sorry id employee given is not correct');
        }

        $user_email = $user->email;

        
            $validated = $request->validate([
                'name' => 'required|string',
                'id' => 'required',
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


        return response()->json('this data employee is update');

    }//end method

        //edit image for profile employee
        public function update_image(Request $request)
        {

            $validated = $request->validate([
            
                'key' => 'required',
                'id' => 'required',
                
            ]);
    
            $user = User::where('key', $validated['key'])->first();
            
            if(!$user)
            {
                return response()->json('sorry key given is not correct');
            }
            $employee = employee::where('user_email',$user->email)->where('id',$validated['id'])->first();
            
            if(!$employee)
            {
                return response()->json('sorry id employee given is not correct');
            }


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
    
                    
                    return response()->json('success update image');
                
            }//end validated file
    
            return response()->json('sorry fail to update image');
    
        }//end method

            //edit image for profile employee
    public function remove_image(Request $request)
    {

        $validated = $request->validate([
            
            'key' => 'required',
            'id' => 'required',
            
        ]);

        $user = User::where('key', $validated['key'])->first();
        
        if(!$user)
        {
            return response()->json('sorry key given is not correct');
        }
        $employee = employee::where('user_email',$user->email)->where('id',$validated['id'])->first();
        
        if(!$employee)
        {
            return response()->json('sorry id employee given is not correct');
        }


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

                

            return response()->json('success remove image');
            

    }//end method


}//end class
