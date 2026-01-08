<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserAccount extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users_accounts';
    
    // FIXED: Added missing columns to fillable
    protected $fillable = [
        'name', 'username', 'email', 'password', 'phone_number', 
        'role', 'is_suspended', 'suspension_note', 'suspended_until'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_suspended' => 'boolean',
        'suspended_until' => 'datetime'
    ];

    public function isAdmin() { return $this->role === 'admin'; }
    
    public function isSuspended() { 
        return $this->is_suspended === true && ($this->suspended_until === null || $this->suspended_until > now()); 
    }

    public function canAccessItems() { return !$this->isSuspended() && ($this->isAdmin() || $this->role === 'user'); }
    
    public function scopeAdmins($query) { return $query->where('role', 'admin'); }
    
    public function scopeActive($query) {
        return $query->where(function($q) {
            $q->where('is_suspended', false)
              ->orWhere(function($subQ) {
                  $subQ->where('is_suspended', true)->where('suspended_until', '<', now());
              });
        });
    }
}