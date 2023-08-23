<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('tasks', TaskController::class)

    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);



    Route::post('/tasks/{task}/markAsCompleted', [TaskController::class, 'markAsCompleted'])->name('tasks.markAsCompleted');
    Route::get('/tasks/separated', [TaskController::class, 'separatedTasks'])->name('tasks.separated');



    Route::resource('projects', ProjectController::class)

    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

    Route::get('/tasks/{task}/edit/{project}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}/{project}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
   Route::post('/projects/{project}/markAsCompleted', [ProjectController::class, 'markAsCompleted'])->name('projects.markAsCompleted');
    Route::get('/projects/separateds', [ProjectController::class, 'separatedProjects'])->name('projects.separated');
    Route::get('/assigned-tasks/{project}/', [ProjectController::class, 'assignedTasks'])->name('projects.assignedTasks');

    Route::post('/assigned-tasks/{project}/{task}/markAsCompleted', [ProjectController::class, 'markTaskAsCompleted'])->name('projects.markTaskAsCompleted');






    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
