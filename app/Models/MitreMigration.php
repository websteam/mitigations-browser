<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitreMigration extends Model
{
    use HasFactory;

    protected $fillable = ['migration_date'];
    public $timestamps = false;
}
