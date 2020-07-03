<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{

    protected $guarded = [];
    /**
     * Get the user that owns the member.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function createBoardMember($input, $user_id)
    {
        return $this->create([
            'user_id' => $input->get('user_id'),
            'board_id' => $input->get('board_id'),
            'level' => $input->get('level'),
            'owner_id' => $user_id,
        ]);
    }
}
