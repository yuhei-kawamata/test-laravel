<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password' => 'hashed',
        ];
    }

    // リレーションを定義
    // userは多くのタスクを持つ（１対多の関係⇒hasMany）
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // userが管理者権限を持っているかを判定する関数
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // 特定のロールを持っているかどうかを判定する関数
    // 引数$roleで特定したい関数を指定する
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
