<?php

namespace App\Admin\Controllers;

use App\Models\BoardCard;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BoardCardController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'BoardCard';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BoardCard());

        $grid->column('id', __('Id'));
        $grid->column('board_id', __('Board id'));
        $grid->column('user_id', __('User id'));
        $grid->column('list_id', __('List id'));
        $grid->column('card_title', __('Card title'));
        $grid->column('card_description', __('Card description'));
        $grid->column('card_color', __('Card color'));
        // $grid->column('owner_id', __('Owner id'));
        
        $grid->owner_id(__('models.name_of_user'))->display(function ($owner_id) {
            return ($owner_id ? User::find($owner_id)->name : null);
        });

        $grid->column('due_date', __('Due date'));
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
        $show = new Show(BoardCard::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('board_id', __('Board id'));
        $show->field('user_id', __('User id'));
        $show->field('list_id', __('List id'));
        $show->field('card_title', __('Card title'));
        $show->field('card_description', __('Card description'));
        $show->field('card_color', __('Card color'));
        
        // $show->field('owner_id', __('Owner id'));
        $users = User::all()->toArray();
        $usersArray = [];
        foreach ($users as $item) {
            $usersArray[$item['id']] = $item['name'];
        }

        $show->field('due_date', __('Due date'));
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
        $form = new Form(new BoardCard());

        $form->number('board_id', __('Board id'));
        $form->number('user_id', __('User id'));
        $form->number('list_id', __('List id'));
        $form->text('card_title', __('Card title'));
        $form->text('card_description', __('Card description'));
        $form->text('card_color', __('Card color'));
        
        //$form->number('owner_id', __('Owner id'));
        $form->select('owner_id', __('models.name_of_user'))->options(User::all()->pluck('name', 'id'));

        $form->datetime('due_date', __('Due date'))->default(date('Y-m-d H:i:s'));


        return $form;
    }
}
