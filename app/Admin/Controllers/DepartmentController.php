<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DepartmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Department';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Department());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        // $grid->column('owner_id', __('Owner id'));
        
        $grid->owner_id(__('models.name_of_user'))->display(function ($owner_id) {
            return ($owner_id ? User::find($owner_id)->name : null);
        });

        $grid->column('group_id', __('Group id'));
        $grid->column('limit', __('Limit'));
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
        $show = new Show(Department::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        // $show->field('owner_id', __('Owner id'));
        $users = User::all()->toArray();
        $usersArray = [];
        foreach ($users as $item) {
            $usersArray[$item['id']] = $item['name'];
        }
        $show->owner_id(__('models.name_of_user'))->using($usersArray);
        $show->field('group_id', __('Group id'));
        $show->field('limit', __('Limit'));
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
        $form = new Form(new Department());

        $form->text('name', __('Name'));
        //$form->number('owner_id', __('Owner id'));
        $form->select('owner_id', __('models.name_of_user'))->options(User::all()->pluck('name', 'id'));

        $form->number('group_id', __('Group id'));
        $form->number('limit', __('Limit'));

        return $form;
    }
}
