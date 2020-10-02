<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Department;

class Board extends Model
{
    protected $table = "board";

    protected $fillable = [
        'user_id', 'boardTitle', 'boardPrivacyType', 'department_id', 'owner_id',
    ];

    public function getUserBoards($user_id)
    {
        // $this::with('boardcard.')
        return $this::with('owner')->where(['user_id' => $user_id,])->get();
    }

    public function getUserStarredBoards($user_id)
    {
        return $this->where(['user_id' => $user_id, 'is_starred' => 1])->orderBy('created_at', 'desc')->get();
    }

    public function createBoard($input, $user_id)
    {
        // get current_user department id 
        $department_id = Department::getDepartmentIdByUserId($user_id) ?: 0;

        return $this->create([
            'user_id' => $user_id,
            'boardTitle' => $input->get('boardTitle'),
            'boardPrivacyType' => $input->get('boardPrivacyType'),
            'department_id' => $department_id,
            'owner_id' => $input->get('boardAdminUserId'),
        ]);
    }

    public function getBoard($board_id)
    {
        return $this->findOrFail(['id' => $board_id])->first();
    }

    public function getUserRecentBoards($user_id)
    {
        return $this->where(['user_id' => $user_id,])->orderBy('created_at', 'desc')->take(3)->get();
    }

    public function updateBoardFavourite($input)
    {
        return $this->where("id", $input->get("boardId"))->update(["is_starred" => $input->get("isFavourite"),]);
    }


    /**
     * Get the department that owns the board.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function setBaordAdmin($input)
    {
        $boardAdminUserId = $input->get("boardAdminUserId");
        $boardId = $input->get("board_id");
        $board = Board::where('id', $boardId)->first();
        $board->owner_id = $boardAdminUserId;
        $board->save();
        return true;
    }


    public function boardcard()
    {
        return $this->hasMany(BoardCard::class);
    }
}
