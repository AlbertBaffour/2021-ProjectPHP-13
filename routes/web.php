<?php

use App\Http\Controllers\CostCenterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');

Route::redirect('home', '/');
Route::view('/', 'home');

Route::view('HelpPage', 'HelpPage');
Route::group(['middleware' => 'auth'], function()
{
    Route::middleware(['auth','admin'])->resource('manageUsers', 'Admin\ManageUsersController',
        ['parameters' => ['manageUsers' => 'user']]);
    Route::middleware(['auth','admin'])->get('createUser', 'Admin\ManageUsersController@create');
    Route::middleware(['auth','admin'])->post('createUser', 'Admin\ManageUsersController@save');
    Route::middleware(['auth','admin'])->post('manageUsers', 'Admin\ManageUsersController@update');

    Route::resource('modifyContactDetails', 'UserDetailsController');


    Route::resource('user', 'User\PasswordController');
    Route::get('password', 'User\PasswordController@edit');
    Route::post('password', 'User\PasswordController@update');

    //cost centers
    Route::middleware(['auth','admin'])->resource('cost_centers', 'Admin\CostCenterController');
    Route::post('/cost_center/getUsers/', 'Admin\CostCenterController@getUsers')->name('cost_center.getUsers');

    Route::middleware(['auth','admin'])->resource('cost_settings', 'Admin\CostSettingController');


    Route::middleware(['auth','admin'])->resource('email_texts', 'Admin\EmailTextController');
    Route::middleware(['auth','admin'])->get('mailtekst', 'Admin\EmailTextController@edit');
    Route::middleware(['auth','admin'])->get('mailtekst', 'Admin\EmailTextController@index');
    Route::middleware(['auth','admin'])->post('mailtekst', 'Admin\EmailTextController@update');


    //budget
    Route::middleware(['auth','admin'])->resource('budgets', 'Admin\BudgetController');


    Route::resource('expense_allowances', 'ExpenseAllowanceController');
    Route::post('/expense_allowance/getCostCenters/','ExpenseAllowanceController@getCostCenters')->name('expense_allowance.getCostCenters');
    Route::resource('expenses', 'ExpenseController');
    Route::get('expense_allowance/delete/{expense_allowance}', ['as' => 'expense_allowance.delete', 'uses' => 'ExpenseAllowanceController@destroy']);
    Route::get('expense/delete/{expense}', ['as' => 'expense.delete', 'uses' => 'ExpenseController@destroy']);
    Route::post('file','ExpenseController@storeFile')->name('file.storeFile');
    Route::get('/getSorted/{value}','ExpenseAllowanceController@getSorted');

//Expense Allowance review(verantwoordelijke)
    Route::get('expense_allowance_review',  'ExpenseAllowanceReviewController@index');
    Route::get('expense_allowance_review/{expense_allowance}/edit',  'ExpenseAllowanceReviewController@edit');
    Route::put('expense_allowance_review/{expense_allowance}/update',  'ExpenseAllowanceReviewController@update');
    Route::get('expense_allowance_review/{laptop_allowance}/edit2',  'ExpenseAllowanceReviewController@edit2');
    Route::put('expense_allowance_review/{laptop_allowance}/update2',  'ExpenseAllowanceReviewController@update2');
    Route::get('/getProofs/{expense_id}','ExpenseAllowanceReviewController@getProofs');

    //Payment(financieel)
    Route::middleware(['auth','admin'])->get('payment_review',  'PaymentController@index');
    Route::middleware(['auth','admin'])->get('payment_review/{expense_allowance}/edit',  'PaymentController@edit');
    Route::middleware(['auth','admin'])->put('payment_review/{expense_allowance}/update',  'PaymentController@update');
    Route::middleware(['auth','admin'])->get('payment_review/{laptop_allowance}/edit2',  'PaymentController@edit2');
    Route::middleware(['auth','admin'])->put('payment_review/{laptop_allowance}/update2',  'PaymentController@update2');
    Route::get('/getProofs/{expense_id}','ExpenseAllowanceReviewController@getProofs');

//Laptop Allowance
    Route::resource('laptop_allowances', 'LaptopAllowanceController');
//Route::post('/expense_allowance/getCostCenters/','ExpenseAllowanceController@getCostCenters')->name('expense_allowance.getCostCenters');
    Route::get('laptop_allowance/delete/{laptop_allowance}', ['as' => 'laptop_allowance.delete', 'uses' => 'LaptopAllowanceController@destroy']);
    Route::get('/getLaptops','LaptopAllowanceController@getLaptops');

//bicycle allowance
    Route::resource('bicycle_allowance', 'BicycleAllowanceController');


    Route::get('/request_menu','ExpenseAllowanceController@getMenu');
});








