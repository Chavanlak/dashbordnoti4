<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipmenttype extends Model
{
    protected $table = 'equipmenttype';

    protected $primaryKey = 'equipmenttypeId';
    public $timestamps = false;
    use HasFactory;
}
