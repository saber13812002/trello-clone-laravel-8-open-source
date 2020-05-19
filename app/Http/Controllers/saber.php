<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class saber extends Controller
{

    function index()
    {
        return  json_encode($this->arrayDiff([1, 2], [1]));
    }

    function arrayDiff($a, $b)
    {
        $results = [];
        foreach ($a as $item) {
            $flag = true;
            foreach ($b as $item2) {
                if ($item == $item2)
                    $flag = false;
            }
            if ($flag == true)
                array_push($results, $item);
        }
        return $results;
    }
}
