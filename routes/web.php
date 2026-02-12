<?php

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Task;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Log;





Route::get('/home', function () {
    $welcome = Session::get('welcome');
    $username = Session::get('username');
    return view('index', compact('welcome', 'username'));
})->name('home');


Route::get('/course',function(){
    return view('course');
})->name('courses');


Route::get('/about',function(){
    return view('about');
})->name('about.us');

//--------------------------user form-------------------------------------

// Optional redirect
Route::redirect('/here', '/there', 301);


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/verify-email', [AuthController::class, 'verifyEmailLink'])
        ->middleware('throttle:6,1')
        ->name('verify.email');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login')
        ->middleware('throttle:5,1');
});


Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');
});

// Admin-only routes
Route::prefix('admin')->as('admin.')->middleware(['auth:web', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['show']);
});


Route::get('/profile', function () {
    return view('profile');
})->name('profile');



Route::get('/secure-check', function () {
    return request()->secure() ? 'HTTPS ✅' : 'HTTP ❌';
});

use App\Http\Controllers\PaytmController;

// Payment form (optional if you have a front-end button)
Route::get('/paytm', [PaytmController::class, 'showForm'])->name('paytm.form');

// Initiate payment
Route::get('/paytm-initiate', [PaytmController::class, 'initiatePayment'])->name('paytm.initiate');

// Paytm callback
Route::post('/paytm-callback', [PaytmController::class, 'paymentCallback'])->name('paytm.callback');

// routes/web.php
use App\Http\Controllers\CourseController;

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

//*************************ProductContrller************ */
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

//*************************************************************** */

// ********************Google LOGIN ************************
use App\Http\Controllers\Auth\GoogleController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

//********************** End Google login*************************************** */


//Route::view('/login/request-otp', 'auth.request-otp')->name('otp.request.form');

// handle the POST that sends an OTP
//Route::post('/login/request-otp', [OtpController::class, 'requestOtp'])
//    ->name('otp.request');

// optional: verify-OTP POST
//Route::post('/login/verify-otp', [OtpController::class, 'verifyOtp'])
//     ->middleware('throttle:5,1')
//     ->name('otp.verify');
// redirect /login → /login/request-otp
//Route::get('/login', fn () => redirect()->route('otp.request.form'));

// OTP verification routes
//Route::get('/form/verify', [AuthController::class, 'verifyOtpForm'])->name('verify.form');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



Route::get('/test-mail', function () {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME');
        $mail->Password   = env('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress('yourreceiver@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Test Email';
        $mail->Body    = 'This is a test email.';

        $mail->send();
        return 'Email sent successfully!';
    } catch (Exception $e) {
        return 'Email failed: ' . $e->getMessage();
    }
});





Route::get('/api/tasks', [AuthController::class, 'TaskApiController']);
/*  Route::get('/tasks', function () {
    $tasks = Task::paginate(10); // 10 items per page
    return view('tasks', compact('tasks'));
})->name('tasks.list');
*/


// Show Edit Form for a Task
Route::get('/tasks/edit/{id}', function ($id) {
    $task = Task::findOrFail($id);
    return view('edit', compact('task'));
})->name('edit.task');

// Show Create Task Form
Route::view('/form/create', 'create')->name('html_login_form');

// Store New Task
Route::post('/form', function (TaskRequest $request) {
    $validated = sanitizeTaskInput($request->validated());
    $validated['completed'] = false;

    Task::create($validated);

    return redirect()->route('tasks.list')->with('success', 'Task saved to database!');
})->name('add.task');

// Update Existing Task
Route::put('/tasks/update/{id}', function (TaskRequest $request, $id) {
    $task = Task::findOrFail($id);

    $validated = sanitizeTaskInput($request->validated());

    $task->update($validated);

    return redirect()->route('tasks.list')->with('success', 'Task updated successfully!');
})->name('update.task');
//Route::resource('tasks', TaskController::class);

Route::delete('/tasks/{task}', function(Task $task) {
    $task->delete();
    return redirect()->route('tasks.list')->with('success','Task Deleted Successfully');
})->name('delete.id');