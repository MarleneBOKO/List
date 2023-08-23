<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }


    public function tasks()
{
    return $this->hasMany(Task::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
    protected $fillable = ['message', 'completed', 'user_id'];






}
