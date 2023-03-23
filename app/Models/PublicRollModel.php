<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicRollModel extends Model
{
    // use HasFactory;
    protected $connection = 'pgsql';
    protected $schema = 'public';
    protected $table = 'roll';
    protected $primary = 'id';
}
