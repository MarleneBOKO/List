<?php

namespace App\Models;

use App\Events\TaskCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

   
    protected $fillable = ['message', 'completed', 'user_id'];

protected $dispatchesEvents = [
    'created' => TaskCreated::class,
];


}
