<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BaseModelNotForAdmin extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

}
