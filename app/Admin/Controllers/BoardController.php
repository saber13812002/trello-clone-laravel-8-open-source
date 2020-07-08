<?php

namespace App\Admin\Controllers;

use App\Models\Board;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BoardController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Board';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Board());

        $grid->column('id', __('Id'));
        // $grid->column('user_id', __('user_id'));

        
        $grid->user_id(__('models.name_of_user'))->display(function ($user_id) {
            return ($user_id ? User::find($user_id)->name : null);
        });

        $grid->column('boardTitle', __('boardTitle'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Board::findOrFail($id));


        $show->field('id', __('Id'));

        $show->field('user_id', __('user_id'));
        $users = User::all()->toArray();
        $usersArray = [];
        foreach ($users as $item) {
            $usersArray[$item['id']] = $item['name'];
        }
        $show->user_id(__('models.name_of_user'))->using($usersArray);

        $show->field('boardTitle', __('boardTitle'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Board());

        $form->text('boardTitle', __('boardTitle'));
        $form->select('user_id', __('models.name_of_user'))->options(User::all()->pluck('name', 'id'));

        return $form;
    }
}
