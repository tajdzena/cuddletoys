<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slika extends Model
{
    use HasFactory;
    protected $table = 'slika';
    protected $primaryKey = 'idSlika';
}
