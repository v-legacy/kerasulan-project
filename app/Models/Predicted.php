<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predicted extends Model
{
    use HasFactory;

    protected $table = 'predicted';
    protected $guarded = [];
}
