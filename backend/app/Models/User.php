<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Lecturize\Addresses\Traits\HasAddresses;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasAddresses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Orders::class);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function findOrError($userId)
    {
        $user = self::find($userId);
        if (!$user) {
            throw new NotFoundHttpException('Not found user', null, 404);
        }
        return $user;
    }
}
