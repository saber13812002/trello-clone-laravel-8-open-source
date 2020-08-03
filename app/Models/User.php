<?php

namespace App\Models;

use App\Helpers\Bot;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Finds the user by email
     * @param  string $email Email of the user
     * @return User
     */
    public function findByEmail($email) 
    {
        return $this->where('email', $email)->first();
    }

    public function createUserAccount($input)
    {
        $user = $this->create([
            'name'     => $input->get('name'),
            'email'    => $input->get('email'),
            'password' => \Hash::make($input->get('password')),
        ]);
        
        if ($user && $user->id > 0) {
            Bot::sendMsg('user created');
        }

        return true;
    }


    /**
     * Get the members for this user.
     */
    public function members()
    {
        return $this->hasMany('App\Models\BoardMember');
    }

    /**
     * Get the boards for this user.
     */
    public function boards()
    {
        return $this->hasMany('App\Models\Board');
    }
}
