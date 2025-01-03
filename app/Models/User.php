<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'hired_at',
        'profile',
        'status',
        'password',
        'role_id',
        'company_id',
        'designation_id',
        'department_id',
        'shift_start',
        'punch_in_behavior',
        'shift_end'
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    
    public function hasPermission($permission)
    {
        $permissions = json_decode($this->role->permissions->permissions);
        return in_array($permission, $permissions);
    }
    public function leave_requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
    
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function salary()
    {
        return $this->hasMany(Salary::class)->where('status',1);
    }
}
