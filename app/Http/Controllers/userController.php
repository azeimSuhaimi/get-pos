<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Events\Registered;


use App\Models\user;
use App\Models\activity_log;
use App\Models\company;
use App\Models\toyyibpay;

class userController extends Controller
{
    public function index()
    {
        return view('user.index');
    }// end method

    public function change_password()
    {
        
        return view('user.change_password');
    }//end method

    public function change_password_process(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
            'password1' => 'required|min:4',
            'password2' => 'required|min:4|same:password1',
        ]);

        if (! Hash::check($validated['password'], $request->user()->password)) {

            return back()->with('error','current password not match')->onlyInput('password1','password2','password');
        }

        $pass = Hash::make($validated['password1']);

        $users = user::find(auth()->user()->id);
        $users->password = $pass;
        $users->save();

        $request->session()->passwordConfirmed();

        activity_log::addActivity('Change Password',' change it password to new');

        return back()->with('success','current password is update now');

        
    }//end method

        //edit image for profile 
        public function update_image(Request $request)
        {
            // validated input
            $validated = $request->validate([
                'id' => 'required',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $user = user::find($validated['id']);// find table  based id
    
            // validate file upload 
            if ($request->hasFile('file')) 
            {
                // get upload image to change and validated rule
                $file = $request->file('file');
                $fileName = time().'.'.$file->getClientOriginalExtension();// change name file avoid redundant
        
                $file->move(public_path('profile/'), $fileName); // location image store
    
                if($user->picture != 'empty.png')
                {
                    
                    $filePath = public_path('profile/'.$user->picture); // store file to location
    
                    // delete fine from past
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
    
                }
                
                // store image name to database
                $user->picture = $fileName;
                $user->save();

                activity_log::addActivity('Change image',' change it image profile to new');
                return redirect(route('user.profile'))->with('success',$fileName);
                
            }//end validated file
    
            return redirect(route('user.profile'))->with('error','fail edit image');
    
        }//end method
    
        //edit image for profile 
        public function remove_image(Request $request)
        {
            // validated input
            $validated = $request->validate([
                'id' => 'required',
            ]);
    
            $user = user::find($validated['id']);// find table  based id
    
    
                if($user->picture != 'empty.png')
                {
                    
                    $filePath = public_path('profile/'.$user->picture); // store file to location
    
                    // delete fine from past
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
    
                }
                
                // store image name to database
                    $user->picture = 'empty.png';
                    $user->save();
    
                    activity_log::addActivity('remove image',' remove image profile to empty');
    
                return redirect(route('user.profile'))->with('success','success remove image');
                
    
        }//end method

        
            //update  data 
    public function update_profile(Request $request)
    {
        // validate data profile update base rule
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' =>['required','numeric',Rule::unique('users')->ignore( $request->input('phone'),'phone')] ,

            
            
        ]);

        //store data update to database
        $user = user::find(auth()->user()->id);
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->save();

        activity_log::addActivity('update details profile ',' change it details profile '.$validated['name']);

        return redirect(route('user.profile'))->with('success','edit details profile '.$validated['name']);

    }//end method

    public function activity_log()
    {
        $activity_log = activity_log::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        return view('user.activity_log',['activity_log' => $activity_log]);
    }//end method

    public function account_setting()
    {
        $company = company::where('user_id',auth()->user()->id)->first();
        $toyyibpay = toyyibpay::where('user_id',auth()->user()->id)->first();

        $data = [
            'company' => $company,
            'toyyibpay' => $toyyibpay
        ];
        return view('user.account_setting',$data);
    }// end method

    //update toyyip pay data 
    public function update_toyyip(Request $request)
    {
        // validate data employee update base rule
        $validated = $request->validate([
            'toyyip_key' => 'required',
            'toyyip_category' => 'required',
        ]);

        //store data update to database
        $user = toyyibpay::where('user_id',auth()->user()->id)->first();
        if($user)
        {
            $user->toyyip_key = Crypt::encryptString($validated['toyyip_key']) ;
            $user->toyyip_category = Crypt::encryptString($validated['toyyip_category']);
            $user->save();
        }
        else
        {
            $user = new toyyibpay;
            $user->toyyip_key = Crypt::encryptString($validated['toyyip_key']) ;
            $user->toyyip_category = Crypt::encryptString($validated['toyyip_category']);
            $user->user_id = auth()->user()->id;
            $user->save();
        }




        activity_log::addActivity('update toyyip pay ',' change it toyyip pay key and category ');

        return back()->with('success','edit toyyip pay details please log out first before use ');

    }//end method

            //edit image for profile 
            public function company_update_image(Request $request)
            {
                // validated input
                $validated = $request->validate([
                    'id' => 'required',
                    'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
        
                $company = company::find($validated['id']);// find table  based id
        
                // validate file upload 
                if ($request->hasFile('file')) 
                {
                    // get upload image to change and validated rule
                    $file = $request->file('file');
                    $fileName = time().'.'.$file->getClientOriginalExtension();// change name file avoid redundant
            
                    $file->move(public_path('logo/'), $fileName); // location image store
        
                    if($company->logo != '42862.jpg')
                    {
                        
                        $filePath = public_path('logo/'.$company->logo); // store file to location
        
                        // delete fine from past
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
        
                    }
                    
                    // store image name to database
                    $company->logo = $fileName;
                    $company->save();
    
                    activity_log::addActivity('Change image logo',' change it image logo to new');
                    return back()->with('success',$fileName);
                    
                }//end validated file
        
                return back()->with('error','fail edit image');
        
            }//end method


                    //edit image for profile 
        public function company_remove_image(Request $request)
        {
            // validated input
            $validated = $request->validate([
                'id' => 'required',
            ]);
    
            $company = company::find($validated['id']);// find table  based id
    
    
                if($company->logo != '42862.jpg')
                {
                    
                    $filePath = public_path('logo/'.$company->logo); // store file to location
    
                    // delete fine from past
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
    
                }
                
                // store image name to database
                    $company->logo = '42862.jpg';
                    $company->save();
    
                    activity_log::addActivity('remove logo company ',' remove image company to empty');
    
                return back()->with('success','success remove image company');
                
    
        }//end method

        public function company_update_detail(Request $request)
        {
            // validate data profile update base rule
            $validated = $request->validate([
                'id' => 'required',
                'company_name' => 'required|string',
                'shop_name' => 'required|string',
                'company_id' => 'required|string',
                'address' => 'required|string',
                'poscode' => 'required|numeric',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'phone' => 'required|numeric',
                'description' => 'required|string',
                
    
                
                
            ]);
    
            //store data update to database
            $company = company::find($validated['id']);
            $company->company_name = $validated['company_name'];
            $company->shop_name = $validated['shop_name'];
            $company->company_id = $validated['company_id'];
            $company->address = $validated['address'];
            $company->poscode = $validated['poscode'];
            $company->city = $validated['city'];
            $company->state = $validated['state'];
            $company->country = $validated['country'];
            $company->description = $validated['description'];
            $company->phone = $validated['phone'];
            $company->save();
    
            activity_log::addActivity('update details company ',' change it details company '.$validated['company_name']);
    
            return back()->with('success','edit details company '.$validated['company_name']);
    
        }//end method

}//end class
