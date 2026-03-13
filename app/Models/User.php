<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ⬅️ tambahkan HasApiTokens
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'complete_name',
        'username',
        'user_level_id',
        'phone',
        'email',
        'profile_photo',
        'school_id',
        'password',
        'is_active',
        'deleted_at',
        'is_delete',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function parent()
    {
        return $this->hasOne(StudentParent::class, 'user_id');
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'id', 'merchant_id');
    }

    public function level()
    {
        return $this->belongsTo(UserLevel::class, 'user_level_id', 'user_level_id');
    }

    public function ewallet()
    {
        return $this->hasOne(EWallet::class, 'user_id');
    }
}
