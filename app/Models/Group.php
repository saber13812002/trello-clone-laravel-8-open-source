<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    
    protected $table = "groups";

    protected $fillable = [
        'user_id', 'name', 'description',
    ];

    public function getUserGroup($user_id)
    {
        return $this->where("user_id", $user_id)->get();;
    }

    public function createGroup($input, $user_id)
    {
        return $this->create([
            'user_id'                 => $user_id,
            'name'             => $input->get("name"),
            "description"    => $input->get("description"),
        ]);
    }
}
