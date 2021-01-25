<?php


use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Bus\dispatch;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('sendEmail',function(){
	
	/*SendEmailJob::dispatch();*//*For Running the job queue we ndd to run job work*/
	SendEmailJob::dispatch()
                ->delay(Carbon::now()->addSeconds(5));
	return "Email is send successfully";
});
