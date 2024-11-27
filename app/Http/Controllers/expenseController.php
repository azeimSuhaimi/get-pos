<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\expense;
use App\Models\activity_log;

class expenseController extends Controller
{
        //get all list custmer member
        public function index()
        {
            //get all list custmer data
            $expense = expense::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();
    
            return view('expense.index',['expense' => $expense]);
        }//end method

        public function create()
        {
            return view('expense.create');
        }//end method


        public function store(Request $request)
        {
            $user_email =auth()->user()->email;

            // validation all input expense add
            $validated = $request->validate([
                
                'date' => 'required|date|nullable',
                'description' => 'required',
                'amount' => 'required|numeric',
                'receipt' => 'string|nullable',
                'notes' => 'string|nullable'
            ]);
    
            //store data to database 
            $expense = new expense;
            $expense->date = $validated['date'];
            $expense->description = $validated['description'];
            $expense->amount = $validated['amount'];
            $expense->receipt = $validated['receipt'];
            $expense->notes = $validated['notes'];
            $expense->user_email = auth()->user()->email;
            $expense->save();

            activity_log::addActivity('add new details expense ',' add new expense '.$validated['description']);
    
            return back()->with('success','Add new expense ');
        }// end method

                //edit expense page
                public function edit(Request $request)
                {
                    $expense = expense::find($request->input('id'));// id expense input
            
                    return view('expense.edit',['expense'=>$expense]);
                }//end method
            
                //view expense page
                public function view(Request $request)
                {
                    $expense = expense::find($request->input('id'));// id expense input
            
                    return view('expense.view',['expense'=>$expense]);
                }//end method

                            //update employee data 
    public function update(Request $request)
    {
        $user_email =auth()->user()->email;

            // validation all input expense 
            $validated = $request->validate([
                'id' => 'required',
                'date' => 'required|date|nullable',
                'description' => 'required',
                'amount' => 'required|numeric',
                'receipt' => 'string|nullable',
                'notes' => 'string|nullable'
            ]);

        //store data update to database
        $expense = expense::find($validated['id']);
        $expense->description = $validated['description'];
        $expense->amount = $validated['amount'];
        $expense->receipt = $validated['receipt'];
        $expense->notes = $validated['notes'];
        $expense->save();

        activity_log::addActivity('update details expense ',' change it details expense '.$validated['description']);

        return redirect(route('expense.edit').'?id='.$validated['id'])->with('success','edit details customer '.$validated['description']);

    }//end method

    public function remove (Request $request)
    {
        $user_email =auth()->user()->email;

            // validation all input expense 
            $validated = $request->validate([
                'id' => 'required',
            ]);

            $expense = expense::find($validated['id']);
 
            activity_log::addActivity('remove  expense ',' remove it details expense '.$expense->description);
            $expense->delete();


        return back()->with('success','remove details expense '.$expense->description);

    }//end method

}//end class
