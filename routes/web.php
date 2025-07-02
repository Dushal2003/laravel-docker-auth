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





Route::get('/home', function () {
    
    $welcome = Session::get('welcome');      
    $username = Session::get('username');    

    return view('index', compact('welcome', 'username'));
    
})->name('home');

Route::get('/courses',function(){
    return view('courses');
})->name('courses');


Route::get('/about',function(){
    return view('about');
})->name('about.us');

//--------------------------user form-------------------------------------
// Register routes

// Auth: Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/verify-email', [AuthController::class, 'verifyEmailLink'])->name('verify.email');

// Auth: Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);
    //Http::post(env('API_URL'), $credentials);

    $response = Http::withoutVerifying()
        ->post('https://nginx-server/api/auth/login', $credentials);

    if (!$response->successful()) {
        return back()->withErrors([
            'email' => $response->json('message') ?? 'Login failed.',
        ])->withInput();
    }

    $apiUser = $response->json('user') ?? [];

    $user = \App\Models\User::updateOrCreate(
        ['email' => $credentials['email']],
        [
            'name'       => $apiUser['name']      ?? $credentials['email'],
            'password'   => Hash::make($credentials['password']),
            'user_type'  => $apiUser['user_type'] ?? 'user',
            'is_verified'=> true,
            'email_verified_at' => now(),
        ]
    );

    
    Auth::guard('web')->login($user);
    request()->session()->regenerate();
    session([
        'token'    => $response['access_token'],
        'username' => $user->name,
    ]);

    return $user->user_type === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->name('login')->middleware('throttle:5,1');


// Admin routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class)->except(['show']);
    });



// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('success', 'Logged out successfully.');
})->name('logout');




Route::get('/secure-check', function () {
    return request()->secure() ? 'HTTPS ✅' : 'HTTP ❌';
});


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

require_once base_path('app/Libraries/PHPMailer/PHPMailer.php');
require_once base_path('app/Libraries/PHPMailer/SMTP.php');
require_once base_path('app/Libraries/PHPMailer/Exception.php');

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




Route::get('/tasks', function () {
    $tasks = Task::paginate(10); // 10 items per page
    return view('tasks', compact('tasks'));
})->name('tasks.list');


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