<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nip', 'nama', 'email', 'unit_kerja', 'jabatan', 'no_hp', 'role', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
