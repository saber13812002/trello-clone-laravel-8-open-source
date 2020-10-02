<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BoardCard extends Model
{
    protected $table = "board_card";

    protected $fillable = [
        'board_id', 'user_id', 'list_id', 'card_title',
    ];

    public function createCard($input, $user_id)
    {
        return $this->create([
            'board_id' => $input->get('board_id'),
            'user_id' => $user_id,
            'list_id' => $input->get('list_id'),
            'card_title' => $input->get('card-title'),
        ]);
    }

    public function updateCardListid($input)
    {
        return $this->where('id', $input->get('cardId'))->update(['list_id' => $input->get('listId')]);
    }

    public function deleteCard($input)
    {
        $card = $this->find($input->get("cardId"));
        $this->find($input->get("cardId"))->delete();
        return $card;
    }

    public function getCard($cardId)
    {
        return $this->findOrFail($cardId);
    }

    public function updateCard($input)
    {
        $this->where('id', $input->get("cardId"))->update([
            "card_title" => $input->get("cardName"),
            //Empty //updateCardownerid
            "card_description" => ($input->get("cardDescription") != "چیزی ثبت نشده لطفا کلیک کنید و توضیحی اضافه کنید") ? $input->get("cardDescription") : '',
            "card_color" => $input->get("cardColor"),
            "due_date" => date("Y-m-d H:i:s", strtotime($input->get("cardDueDate"))),
            "owner_id" => $input->get("ownerId"),
        ]);
        return true;
    }

    public function getBoardCards()
    {
        return $this->select([
            'board_card.*',
            DB::raw("COUNT(comment.id) as totalComments"),
            'users.name as ownerName'
        ])
            ->leftJoin('comment', 'board_card.id', '=', 'comment.card_id')
            ->leftJoin('users', 'users.id', '=', 'board_card.owner_id')
            ->groupBy('board_card.id')
            ->get();
    }

    public function cardTotalTask()
    {
        return $this->select([
            'board_card.*',
            DB::raw("COUNT(card_task.id) as totalTasks"),
        ])
            ->leftJoin('card_task', 'board_card.id', '=', 'card_task.card_id')
            ->groupBy('board_card.id')
            ->get();
    }

    /**
     * Get the borads for this boardCard.
     */
    public function boards()
    {
        return $this->belongsTo('App\Models\Board', 'board_id');
    }
    // public function boardsOwner($owner_id)
    // {
    //     return $this->belongsTo('App\Models\Board', 'board_id')
    //         ;
    // }

    public static function getDepartmentIdByUserId($user_id)
    {
        $department = Department::where('owner_id', $user_id)->firstOrFail();
        return $department->id;
    }


    /**
     * Define relation to User table with owner_id.
     *
     * @param  string  $value
     * @return void
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }
}
