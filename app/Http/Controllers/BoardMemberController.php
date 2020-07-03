<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardMember;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Validation\ValidationException;
use Response;

class BoardMemberController extends Controller
{
    protected $boardMember;

    public function __construct(BoardMember $boardMember)
    {
        $this->$boardMember = $boardMember;
    }


    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function create(Request $request)
    {

        $this->validate($request, [
                'owner_id' => 'required',
                'user_id' => 'required',
                'board_id' => 'required',
            ]
        );


        return $this->boardMember->createBoardMember($request, $request->user_id); //Auth::id()

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BoardMember $boardMember
     * @return \Illuminate\Http\Response
     */
    public function show(BoardMember $boardMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\BoardMember $boardMember
     * @return \Illuminate\Http\Response
     */
    public function edit(BoardMember $boardMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\BoardMember $boardMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoardMember $boardMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BoardMember $boardMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoardMember $boardMember)
    {
        //
    }
}
