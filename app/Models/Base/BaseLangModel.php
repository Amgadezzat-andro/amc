<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BaseLangModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    

}
