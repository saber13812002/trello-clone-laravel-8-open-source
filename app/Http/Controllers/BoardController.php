<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;


use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use \App\Models\Board;
use \App\Models\CardTag;
use \App\Models\BoardList;
use \App\Models\BoardCard;

class BoardController extends Controller
{
    protected $board;
    protected $user;
    protected $cardTag;
    protected $boardList;
    protected $boardCard;

    public function __construct(Board $board, User $user, CardTag $cardTag, BoardList $boardList, BoardCard $boardCard)
    {
        $this->board = $board;
        $this->user = $user;
        $this->cardTag = $cardTag;
        $this->boardList = $boardList;
        $this->boardCard = $boardCard;
    }

    /**
     * Creates a new Board
     * @param  Request $request have the input data
     * @return object return the newly created board            
     */
    public function postBoard(Request $request)
    {
        $this->validate($request, [
            'boardTitle'        => 'required|unique:board,boardTitle',
            'boardPrivacyType'  => 'required',
        ]);

        return $this->board->createBoard($request, Auth::id());
    }

    /**
     * Get the Board details
     * @param  Request $request have the input data
     * @return view board page or view
     */
    public function getBoardDetail(Request $request)
    {
        $authId = Auth::id();
        $boardDetail = $this->board->getBoard($request->id);
        $lists = $this->boardList->getBoardList($request->id);
        $cards = json_decode(json_encode($this->boardCard->getBoardCards()), True);
        $cardTaskCount = json_decode(json_encode($this->boardCard->cardTotalTask()), True);
        $boards = $this->board->getUserBoards($authId);
        $recentBoards = $this->board->getUserRecentBoards($authId);
        $users = User::all();

        return view('user.board', compact('boardDetail', 'lists', 'cards', 'cardTaskCount', 'boards', 'recentBoards', 'users', 'authId'));
    }

    /**
     * Update the board is_favourite attribute in the database. 
     * @param  Request $request have the input data
     * @return object the updated data           
     */
    public function updateBoardFavourite(Request $request)
    {
        return $this->board->updateBoardFavourite($request);
    }

    public function setBaordAdmin(Request $request)
    {
        $this->board->setBaordAdmin($request);

        return [
            'success' => 'success',
        ];
    }
}
