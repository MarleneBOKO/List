<?php

namespace App\Models;

use App\Events\TaskCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Task extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // App\Models\Task.php
protected $fillable = ['message', 'completed'];

protected $dispatchesEvents = [
    'created' => TaskCreated::class,
];


}
