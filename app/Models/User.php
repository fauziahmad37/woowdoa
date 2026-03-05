<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ⬅️ pastikan ini ada

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
        'is_delete'
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
}
