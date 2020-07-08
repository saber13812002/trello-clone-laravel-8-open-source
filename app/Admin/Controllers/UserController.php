<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));

        // $grid->column('status')->switch();
        // $states = [
        //     'on' => ['value' => true, 'text' => 'فعال', 'color' => 'primary'],
        //     'off' => ['value' => false, 'text' => 'غیرفعال', 'color' => 'default'],
        // ];
        // $grid->column('status')->switch($states);

        $grid->column('status', __('Status'));

        // $grid->column('status')->radio([
        //     0 => 'تایید نشده',
        //     1 => 'تایید شده',
        //     2 => 'بلاک شده',
        //     3 => 'غیرفعال',
        // ]);

        // $grid->column('password', __('Password'));
        // $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        // $grid->column('token', __('Token'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('status', __('Status'));
        // $show->field('password', __('Password'));
        // $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        // $show->field('token', __('Token'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->number('status', __('Status'));
        // $form->password('password', __('Password'));
        // $form->text('remember_token', __('Remember token'));
        // $form->text('token', __('Token'));

        return $form;
    }
}
