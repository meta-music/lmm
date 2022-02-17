<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Role;

class AuthController extends BaseAuthController
{
    public function index()
    {
        return redirect('welcome');
    }

    /**
     * Create interface.
     *
     * @param  Content  $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            // ->translation($this->translation())
            ->title('Register')
            // ->description($this->description()['create'] ?? trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->form()->store();
    }

    public function form()
    {
        return Form::make(Administrator::with(['roles']), function (Form $form) {
            $userTable = config('admin.database.users_table');

            $connection = config('admin.database.connection');

            $form->text('username', trans('admin.username'))
                ->required()
                ->creationRules(['required', "unique:{$connection}.{$userTable}"]);
                // ->updateRules(['required', "unique:{$connection}.{$userTable},username"]);
            $form->text('name', trans('admin.name'))->required();
            // $form->image('avatar', trans('admin.avatar'))->autoUpload();

            $form->password('password', trans('admin.password'))
            ->required()
            ->minLength(5)
            ->maxLength(20);

            $form->password('password_confirmation', trans('admin.password_confirmation'))->same('password');

            $form->ignore(['password_confirmation']);

            $form->disableHeader();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        })->saving(function (Form $form) {
            if ($form->password && $form->model()->get('password') != $form->password) {
                $form->password = bcrypt($form->password);
            }
            if (! $form->password) {
                $form->deleteInput('password');
            }
        })->saved(function (Form $form, $id) {
            $user = Administrator::with('roles')->find($id);
            $user->roles()->sync([2]);
            // $admin = auth('admin');
            // $admin->login($user,true);
            // return redirect('/admin/');
            // return $form->response()->error('服务器出错了~');
        });
    }
}
