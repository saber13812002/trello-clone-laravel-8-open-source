<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardTask extends Model
{
    protected $table = "card_task";

    protected $fillable = [
        'card_id', 'task_title', 'owner_id', 'is_completed', 'created_at', 'updated_at',
    ];

    protected $appends = [
        'owner'
    ];

    public function updateTaskIsCompleted($input)
    {
        $this->where("id", "=", $input->get("taskId"))->update(["is_completed" => $input->get("isCompleted"),]);
        return true;
    }

    public function totalTasksCompleted($input)
    {
        return $this->where(['card_id' => $input->get("cardId"), "is_completed" => 1])->count();
    }

    public function totalTasks($input)
    {
        return $this->where(['card_id' => $input->get("cardId")])->count();
    }

    public function deleteTask($input)
    {
        $this->where("id", "=", $input->get("taskId"))->delete();
        return true;
    }

    public function createTask($input)
    {
        return $this->create([
            "task_title" => $input->get("taskTitle"),
            "card_id" => $input->get("cardId"),
            "owner_id" => $input->get("taskOwnerId"),
            "is_completed" => 0,
        ]);
    }

    public function getCardTasks($cardId)
    {
        return $this->where('card_id', '=', $cardId)->latest()->get();
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function getOwnerAttribute()
    {
        if ($this->owner_id) {
            if ($user = User::find($this->owner_id)) {
                return $user->fullname();
            }
        }
    }
}
