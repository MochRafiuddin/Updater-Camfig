<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MVersioning extends Authenticatable
{
    protected $table = 'versioning';
    protected $primaryKey = 'id';
    protected $fillable = ['version', 'subversion', 'sequence_version', 'db', 'composer', 'composer_command', 'released'];
}

