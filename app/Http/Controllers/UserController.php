<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function tasks(): HasMany
     {
         return $this->hasMany(Task::class);
     }


public function viewAddedTasks()
{
    $addedTasks = auth()->user()->addedTasks; // Remplacez addedTasks par la méthode que vous avez définie dans la relation
    return view('tasks.view_added', compact('addedTasks'));
}


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
