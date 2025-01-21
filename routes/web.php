<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\posController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\authController;
use App\Http\Controllers\itemController;
use App\Http\Controllers\userController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\expenseController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\receiptController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\quickorderController;
use App\Http\Controllers\salereportController;
use App\Http\Controllers\pointRedeenController;
use App\Http\Controllers\invoice_voidController;
use App\Http\Controllers\customer_orderController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(salereportController::class)->group(function () {

    Route::get('/dailysalereport','daily_sale_report')->name('daily.sale.report')->middleware(['auth']);
    Route::get('/dailysalereportpdf','daily_sale_report_pdf')->name('daily.sale.report.pdf')->middleware(['auth']);


});//end group

Route::controller(authController::class)->group(function () {

    Route::get('/','index')->name('auth')->middleware('guest');
    Route::post('/auth','login')->name('auth.login')->middleware(['guest','throttle:login']);

    Route::get('/create_account','create_account')->name('auth.create_account')->middleware('guest');
    Route::post('/create_account','create_account_process')->name('auth.create_account.create')->middleware('guest');

    Route::get('/logout','logout')->name('auth.logout');

    Route::get('/forgot_password', 'forgot_password')->name('auth.forgot_password')->middleware('guest');
    Route::post('/forgot_password', 'forgot_password_email')->name('auth.forgot_password.email')->middleware('guest');

    Route::get('/reset-password/{token}','reset')->name('password.reset')->middleware('guest');
    Route::post('/reset-password','reset_password')->name('password.update')->middleware('guest');

});// end group

Route::controller(dashboardController::class)->group(function () {

    Route::get('/dashboard','index')->name('dashboard')->middleware(['auth']);
    Route::post('/send_receipt','send_receipt')->name('dashboard.send_receipt')->middleware(['auth']);

    Route::get('/payment_status','payment_status')->name('invoice.payment.status');

});//end group

Route::controller(invoice_voidController::class)->group(function () {

    Route::get('/invoice_void','index')->name('invoice_void')->middleware(['auth']);
    Route::get('/invoice_void_view','view')->name('invoice_void.view')->middleware(['auth']);
    Route::post('/invoice_void_void','invoice_void')->name('invoice_void.void')->middleware(['auth']);
    Route::get('/invoice_void_list','list_void')->name('invoice_void.list')->middleware(['auth']);
    Route::get('/invoice_void_list_view','list_void_view')->name('invoice_void.list.view')->middleware(['auth']);

});//end group


Route::controller(receiptController::class)->group(function () {

    Route::get('/receipt','index')->name('receipt')->middleware(['auth']);
    Route::get('/receipt_view','invoice_receipt')->name('receipt.view')->middleware(['auth']);
    
});//end group

Route::controller(userController::class)->group(function () {
   

    Route::post('/change_password','change_password_process')->name('user.change_password_process')->middleware(['auth','verified']);
    
    Route::get('/activity_log','activity_log')->name('user.activity_log')->middleware(['auth','verified','check_toyyip']);

    Route::get('/profiles','index')->name('user.profile')->middleware(['auth']);
    
    Route::post('/user_update_profile','update_profile')->name('user.update.profile')->middleware('auth');
    Route::post('/user_remove_image','remove_image')->name('user.remove.image')->middleware('auth');
    Route::post('/user_update_image','update_image')->name('user.update.image')->middleware('auth');

    Route::get('/account_setting','account_setting')->name('user.account.setting')->middleware(['auth']);
    Route::post('/update_toyyip','update_toyyip')->name('user.account.setting.toyyip')->middleware('auth');

    Route::post('/company_update_detail','company_update_detail')->name('user.company.update.detail')->middleware('auth');
    Route::post('/company_remove_image','company_remove_image')->name('user.company.remove.image')->middleware('auth');
    Route::post('/company_update_image','company_update_image')->name('user.company.update.image')->middleware('auth');
});

Route::controller(employeeController::class)->group(function () {

    Route::get('/employee','index')->name('employee')->middleware(['auth']);
    Route::get('/employee_create','create')->name('employee.create')->middleware(['auth','verified']);
    Route::post('/employee_store','store')->name('employee.store')->middleware(['auth']);
    Route::get('/employee_view','view')->name('employee.view')->middleware(['auth']);
    Route::get('/employee_edit','edit')->name('employee.edit')->middleware(['auth']);
    Route::post('/employee_update_image','update_image')->name('employee.update.image')->middleware(['auth']);
    Route::post('/employee_remove_image','remove_image')->name('employee.remove.image')->middleware(['auth']);
    Route::post('/employee_update','update')->name('employee.update')->middleware(['auth']);
    Route::post('/employee_status','status')->name('employee.status')->middleware(['auth']);
    Route::post('/reset_password_employee','reset_password_employee')->name('employee.reset.password')->middleware(['auth']);
});

Route::controller(customerController::class)->group(function () {

    Route::get('/customer_create','create')->name('customer.create')->middleware(['auth','verified']);
    Route::post('/customer_store','store')->name('customer.store')->middleware(['auth']);
    Route::get('/customer','index')->name('customer')->middleware(['auth']);
    Route::get('/customer_view','view')->name('customer.view')->middleware(['auth']);
    Route::get('/customer_edit','edit')->name('customer.edit')->middleware(['auth']);
    Route::post('/customer_update','update')->name('customer.update')->middleware(['auth']);
    Route::get('/customer_purchase_detail','purchase_detail')->name('customer.purchase.detail')->middleware(['auth','verified']);
    

});

Route::controller(expenseController::class)->group(function () {

    
    Route::get('/expense_create','create')->name('expense.create')->middleware(['auth','verified']);
    Route::post('/expense_store','store')->name('expense.store')->middleware(['auth']);
    Route::get('/expense','index')->name('expense')->middleware(['auth']);
    Route::get('/expense_view','view')->name('expense.view')->middleware(['auth']);
    Route::get('/expense_edit','edit')->name('expense.edit')->middleware(['auth']);
    Route::post('/expense_update','update')->name('expense.update')->middleware(['auth']);
    Route::post('/expense_remove','remove')->name('expense.remove')->middleware(['auth']);
    
    

});

Route::controller(customer_orderController::class)->group(function () {

    
    Route::get('/customer_order_create','create')->name('customer_order.create')->middleware(['auth','verified']);
    Route::post('/customer_order_store','store')->name('customer_order.store')->middleware(['auth']);
    Route::get('/customer_order','index')->name('customer_order')->middleware(['auth']);
    Route::post('/customer_order_update_contact','update_contact')->name('customer_order.update.contact')->middleware(['auth']);
    Route::post('/customer_order_update_status','update_status')->name('customer_order.update.status')->middleware(['auth']);
    Route::get('/customer_order_view','view')->name('customer_order.view')->middleware(['auth']);
    Route::get('/customer_order_edit','edit')->name('customer_order.edit')->middleware(['auth']);
    Route::post('/customer_order_update','update')->name('customer_order.update')->middleware(['auth']);
    Route::post('/customer_order_remove','remove')->name('customer_order.remove')->middleware(['auth']);

});


Route::controller(itemController::class)->group(function () {

    Route::get('/item','index')->name('item')->middleware(['auth']);
    Route::get('/item_create','create')->name('item.create')->middleware(['auth','verified']);
    Route::post('/item_store','store')->name('item.store')->middleware(['auth']);
    Route::get('/item_view','view')->name('item.view')->middleware(['auth']);
    Route::get('/item_edit','edit')->name('item.edit')->middleware(['auth']);
    Route::post('/item_update_image','update_image')->name('item.update.image')->middleware(['auth']);
    Route::post('/item_remove_image','remove_image')->name('item.remove.image')->middleware(['auth']);
    Route::post('/item_update','update')->name('item.update')->middleware(['auth']);
    Route::post('/item_status','status')->name('item.status')->middleware(['auth']);
    //::post('/reset_password_employee','reset_password_employee')->name('employee.reset.password')->middleware(['auth']);
});

Route::controller(posController::class)->group(function () {

    Route::get('/pos','index')->name('pos')->middleware(['auth','verified']);
    Route::post('/pos_add_item','add_item')->name('pos.add.item')->middleware(['auth']);
    Route::get('/pos_searching_item','search_item')->name('pos.search.item')->middleware(['auth','verified']);
    Route::get('/pos_update_quantity_page','update_quantity_page')->name('pos.update.quantity.page')->middleware(['auth']);
    Route::get('/pos_update_price_page','update_price_page')->name('pos.update.price.page')->middleware(['auth']);
    Route::post('/pos_update_quantity','update_quantity')->name('pos.update.quantity')->middleware(['auth']);
    Route::post('/pos_update_price','update_price')->name('pos.update.price')->middleware(['auth']);
    Route::post('/pos_remove_item','item_remove')->name('pos.remove.item')->middleware(['auth']);
    Route::post('/pos_remove_all','remove_all')->name('pos.remove.all')->middleware(['auth']);
    Route::post('/pos_suspend','suspend')->name('pos.suspend')->middleware(['auth']);
    Route::get('/pos_suspend_view','suspend_view')->name('pos.suspend.list')->middleware(['auth']);
    Route::post('/pos_unsuspend','unsuspend')->name('pos.unsuspend')->middleware(['auth']);

    Route::get('/pos_add_remark','add_remark')->name('pos.add.remark')->middleware(['auth']);
    Route::post('/pos_update_remark','update_remark')->name('pos.update.remark')->middleware(['auth']);

    Route::get('/pos/quick/order/page','quick_order_page')->name('pos.quick.order.page')->middleware(['auth','verified']);
    Route::post('/pos/quick/order','quick_order')->name('pos.quick.order')->middleware(['auth','verified']);

});//end group


Route::controller(invoiceController::class)->group(function () {

    Route::get('/invoice','index')->name('invoice')->middleware(['auth']);
    Route::get('/invoice_cash_method','cash_method')->name('invoice.cash.method')->middleware(['auth']);
    Route::get('/invoice_digital_method','digital_method')->name('invoice.digital.method')->middleware(['auth']);
    Route::get('/invoice_hybrid_method','hybrid_method')->name('invoice.hybrid.method')->middleware(['auth']);
    Route::get('/invoice_toyyibpay_method','toyyibpay_method')->name('invoice.toyyibpay.method')->middleware(['auth','check_toyyip']);
    Route::get('/invoice_add_member_cash','add_member_cash')->name('invoice.add_member.cash')->middleware(['auth']);
    Route::get('/invoice_add_member_digital','add_member_digital')->name('invoice.add_member.digital')->middleware(['auth']);
    Route::get('/invoice_add_member_hybrid','add_member_hybrid')->name('invoice.add_member.hybrid')->middleware(['auth']);
    Route::get('/invoice_add_member_toyyibpay','add_member_toyyibpay')->name('invoice.add_member.toyyibpay')->middleware(['auth']);
    Route::post('/invoice_pay','pay')->name('invoice.pay')->middleware(['auth']);
    Route::get('/invoice_receipt','invoice_receipt')->name('invoice.receipt')->middleware(['auth']);
    Route::get('/list_online_manual','list_online_manual')->name('invoice.list_online_manual')->middleware(['auth']);
    Route::get('/invoice_online_manual','invoice_online_manual')->name('invoice.invoice_online_manual')->middleware(['auth']);
    Route::post('/invoice_online_manual_process','invoice_online_manual_process')->name('invoice.invoice_online_manual_process')->middleware(['auth']);

});//end group

Route::controller(pointRedeenController::class)->group(function () {

    Route::get('/pointredeen','index')->name('pointredeen')->middleware(['auth']);
    Route::get('/pointredeen_create','create')->name('pointredeen.create')->middleware(['auth','verified']);
    Route::post('/pointredeen_store','store')->name('pointredeen.store')->middleware(['auth']);
    Route::get('/pointredeen_view','view')->name('pointredeen.view')->middleware(['auth']);
    Route::get('/pointredeen_edit','edit')->name('pointredeen.edit')->middleware(['auth']);
    Route::post('/pointredeen_update','update')->name('pointredeen.update')->middleware(['auth']);
    Route::post('/pointredeen_status','status')->name('pointredeen.status')->middleware(['auth']);
    Route::post('/pointredeen_delete','delete')->name('pointredeen.delete')->middleware(['auth']);
    Route::get('/pointredeen_customer_redeem','customer_redeem')->name('pointredeen.customer_redeem')->middleware(['auth']);
    Route::get('/pointredeen_search_customer','search_customer')->name('pointredeen.search_customer')->middleware(['auth']);
    Route::post('/pointredeen_redeen','redeen')->name('pointredeen.redeen')->middleware(['auth']);
    //::post('/reset_password_employee','reset_password_employee')->name('employee.reset.password')->middleware(['auth']);
});

Route::controller(quickorderController::class)->group(function () {

    Route::get('/quick/order','index')->name('quick')->middleware(['guest']);
    Route::get('/quick/order/list/company','list_company')->name('quick.list.company')->middleware(['guest']);
    Route::get('/quick/order/list','list')->name('quick.list')->middleware(['guest']);
    Route::get('/quick/order/add/item','add_item')->name('quick.add.item')->middleware(['guest']);
    Route::get('/quick/order/view','view')->name('quick.view')->middleware(['guest']);
    Route::get('/quick/order/cart','cart_view')->name('quick.cart.view')->middleware(['guest']);
    Route::post('/quick/order/','cart_checkout')->name('quick.cart.checkout')->middleware(['guest']);
    Route::post('/quick/order/remove/item','item_remove')->name('quick.remove.item')->middleware(['guest']);
    Route::get('/quick/order/add/remark','add_remark')->name('quick.add_remark')->middleware(['guest']);
    Route::post('/quick/order/update_remark','update_remark')->name('quick.update_remark')->middleware(['guest']);
    Route::get('/quick/order/update_quantity_page','update_quantity_page')->name('quick.update_quantity_page')->middleware(['guest']);
    Route::post('/quick/order/update_quantity','update_quantity')->name('quick.update_quantity')->middleware(['guest']);
    //::post('/reset_password_employee','reset_password_employee')->name('employee.reset.password')->middleware(['auth']);
});






/////////////////////////////////////////////////////


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect(route('dashboard'))->with('success','Verification Email Success');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('github-varify');
 
Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();
 
    $existingUser = User::where('email', $githubUser->email)->first();
     //dd($existingUser->email);

    if ($existingUser) {

        $existingUser->github_id = $githubUser->id;
        $existingUser->github_token = $githubUser->token;
        $existingUser->save();

        // Log the user in if they already exist
        Auth::login($existingUser);
        
            return redirect('/dashboard');
    } else{
        //return redirect(route('auth'));
    }
    return redirect(route('auth'))->with('error','accout or password is not exit');
});



Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google-varify');
 
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
 
    $existingUser = User::where('email', $googleUser->email)->first();
     //dd($googleUser);

    if ($existingUser) {

        $existingUser->google_id = $googleUser->id;
        $existingUser->google_token = $googleUser->token;
        $existingUser->save();

        // Log the user in if they already exist
        Auth::login($existingUser);
        
            return redirect('/dashboard');
    } else{
        //return redirect(route('auth'));
    }
    return redirect(route('auth'))->with('error','accout or password is not exit');
});




Route::get('/auth/linkedin/redirect', function () {
    return Socialite::driver('linkedin')->redirect();
});
 
Route::get('/auth/linkedin/callback', function () {
    $linkedinUser = Socialite::driver('linkedin')->user();
 
    $existingUser = User::where('email', $linkedinUser->email)->first();
     //dd($googleUser);

    if ($existingUser) {

        $existingUser->linkedin_id = $linkedinUser->id;
        $existingUser->linkedin_token = $linkedinUser->token;
        $existingUser->save();

        // Log the user in if they already exist
        Auth::login($existingUser);
        
            return redirect('/dashboard');
    } else{
        //return redirect(route('auth'));
    }
    return redirect(route('auth'))->with('error','accout or password is not exit');
});