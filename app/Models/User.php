<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

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
    ];

    public function isApprover()
    {
        return (($this->id_job_position === 'JP3') or ($this->id_job_position === 'JP15') or ($this->id_job_position === 'JP17') or ($this->id_job_position === 'JP36'));
    }

    public function is_GA_TL_ATL()
    {
        return ((($this->id_job_position === 'JP3') or ($this->id_job_position === 'JP15') or ($this->id_job_position === 'JP17') or ($this->id_job_position === 'JP36')) and ($this->id_org_unit === 'OU78'));
    }

    public function isAdmin()
    {
        return $this->priv === 'admin';
    }

    public function isPIC()
    {
        return $this->priv === 'pic';
    }
}
