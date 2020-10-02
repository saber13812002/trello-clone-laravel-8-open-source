<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use \App\Models\User;
use \App\Models\Board;
use Validator;
use App\Helpers\Bot;
use App\Models\BoardCard;
use App\Models\Department;

class UserController extends Controller
{
    protected $board;
    protected $user;

    public function __construct(Board $board, User $user)
    {
        $this->board = $board;
        $this->user = $user;
    }

    /**
     * Get the dashboard view
     * @return view home view
     */
    public function getDashboard()
    {
        $boardCreationPermission = false;

        $auth_id = Auth::id();

        $departmentWithOwnerAndBoard = Department::with(['boards', 'owner']);

        $boardCards = BoardCard::with(['boards', 'owner'])->where('owner_id', $auth_id);

        if ($boardCards->count()) {
            $boardCreationPermission = true;
            $boards = Board::with(['boardcard' => function ($query) use ($auth_id) {
                $query->where('owner_id', $auth_id);
            }])->get();
        }

        if (env('USER_ADMIN_ID1') == $auth_id || env('USER_ADMIN_ID2') == $auth_id) {
            $departments = $departmentWithOwnerAndBoard->get();
            $boardCreationPermission = false;
        }

        $departments = $departmentWithOwnerAndBoard->where('owner_id', $auth_id)->get();
        if (sizeof($departments) > 0) {
            $boardCreationPermission = false;
        }

        //dd($departments->toArray());
        $b = Board::with('owner')->where('owner_id', $auth_id)->get();
        if (sizeof($b) > 0) {
            $boardCreationPermission = false;
            $boards = Board::with('owner')->where('owner_id', $auth_id)->get();
        }

        $users = User::all();


        if (!isset($boards)) {
            $boards = [];
        }

        if (!$departments->count()) {
            $departments = array();
            foreach ($boards as $board) {
                if (!$this->existIn($departments, $board->department))
                    $departments[] = $board->department;
            }
        }


        if (!isset($starredBoards)) {
            $starredBoards = [];
        }

        return view('user.home', compact('boards', 'starredBoards', 'departments', 'boardCreationPermission', 'users'));
    }


    private function existIn($departments, $department)
    {
        foreach ($departments as $dep) {
            if ($dep->id == $department->id)
                return true;
        }
        return false;
    }



    /**
     * Get the board view
     * @return view board view
     */
    public function getBoard()
    {
        return view('user.board');
    }

    /**
     * Gets the user profile
     * @return view profile view
     */
    public function getProfile()
    {
        $boards = $this->board->getUserBoards(Auth::id());
        $page = 'profile';
        return view('user.profile', compact('boards', 'page'));
    }

    /**
     * Get the user login page or view.
     * @return view user login page or view
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Validate the user login input data against the user data in database.
     * @param  Request $request have the input data for this function
     * @return view reirect to specific view
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        $loginStatus = Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], $request->get('remember'));

        if (!$loginStatus) {
            return redirect()->back()->with('alert', 'Can\'t log you in with given information.');
        }

        return redirect()->route('user.dashboard')->with('info', 'You are logged in.');
    }

    /**
     * Get the user register view
     * @return view user register view or page
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Create a new user account or register a user into our website "Dingo"
     * @param  Request $request has the user registeration data
     * @return view reirect to specific view
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name'                  => 'required|unique:users,name',
            'email'                 => 'required|unique:users,email',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $this->user->createUserAccount($request);

        return redirect()->route('auth.login')->with('alert', 'Your account has been created.');
    }
}
