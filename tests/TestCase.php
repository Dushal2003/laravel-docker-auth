<?php

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

class TaskData
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ?string $long_description,
        public bool $completed,
        public string $created_at,
        public string $updated_at
    ) {}
}

$tasks = [
    new TaskData(1, 'Buy groceries', 'Task 1 description', 'Task 1 long description', false, '2023-03-01 12:00:00', '2023-03-01 12:00:00'),
    new TaskData(2, 'Sell old stuff', 'Task 2 description', null, false, '2025-06-11 12:00:00', '2025-06-11 12:00:00'),
    new TaskData(3, 'Learn programming', 'Task 3 description', 'Task 3 long description', true, '2023-03-03 12:00:00', '2023-03-03 12:00:00'),
    new TaskData(4, 'Take dogs for a walk', 'Task 4 description', null, false, '2023-03-04 12:00:00', '2023-03-04 12:00:00'),
];

Route::get('/', function () use ($tasks) {
    return view('index', ['tasks' => $tasks]);
})->name('index.task');

Route::get('/task/{id}', function ($id) use ($tasks) {
    $task = collect($tasks)->firstWhere('id', $id);

    if (!$task) {
        abort(404, 'Task not found');
    }

    return "{$id}: {$task->title}";
})->name('task.show');





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


//user form


Route::view('/form/register', 'register')->name('rg_form');
Route::view('/form/login', 'login')->name('login_form');

Route::post('/register', function (UserRequest $request) {
    $validated = sanitizeTaskInput($request->validated());

    // Only extract allowed user fields
    $userData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ];

    User::create($userData);

    return redirect()->route('login_form')->with('success', 'Register saved to database!');
})->name('user_register');



Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = sanitizeTaskInput($request->only('email', 'password'));

    $user = User::where('email', $credentials['email'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
    }

    return redirect()->back()->with('success', 'Invalid credentials!');
})->name('user_login');







Route::get('/hello', fn() => 'Hello, Dushal!');

Route::get('/Dushal', fn() => 'Dushal jain hello New world')->name('dushal.hello');

Route::get('/Dashal', fn() => redirect('/Dushal'))->name('Wrong URL');

Route::get('/get/{name}', fn($name) => 'Hello ' . $name . '!');

Route::fallback(fn() => 'Not Working here');
