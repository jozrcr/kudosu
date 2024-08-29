<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SudokuProblem extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem',
        'unique_hash',
        'max_value',
        'date',
    ];
}
