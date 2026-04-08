<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    protected $table = 'api_logs';

    const UPDATED_AT = null;


    protected $fillable =
    [
        'user_id','ip_address','end_point', 'parameters', 'auth_key',
    ];



    
}
