<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = [
        'note',
        'is_done',
        'date_done',
    ];

    function TodoType()
    {
        return $this->belongsTo(TodoType::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
