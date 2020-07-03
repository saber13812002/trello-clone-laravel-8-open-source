<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;

class Department extends Model
{
    //

    
    /**
     * Get the borads for this department.
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }
    // >>> $dep = App\Models\Department::find(1);
    // >>> $boards = $dep->borads;
    // or
    // >>> $boards = App\Models\Department::find(1)->boards;
    // $boards->first()->department;
    // $boards->first();
}
