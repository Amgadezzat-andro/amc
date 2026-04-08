<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\CustomHasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use OwenIt\Auditing\Contracts\Auditable;
use Afsakar\FilamentOtpLogin\Models\Contracts\CanLoginDirectly;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements FilamentUser, Auditable, canLoginDirectly
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,
        CustomHasPanelShield, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = 'user';

    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'status', 'first_name', 'last_name',
        'created_at', 'updated_at', 'without_otp', 'superadmin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['name'] = $this->first_name . " ". $this->last_name;
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function canLoginDirectly(): bool
    {
        return $this->without_otp == 1;
    }


    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;
    const STATUS_BANNED = -1;

    public static function getStatusList()
    {
        return
        [
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_INACTIVE => __('Inactive'),
            self::STATUS_BANNED => __('Banned'),
        ];
    }



    public static function getAllList()
    {
        return self::all()->mapWithKeys(function($i) {
            return [$i->id => $i->username];
        });
    }
}
