<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AdminController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        return view('/admin/dashbord', [
            'title' => 'Dashboard',
            'user'  => [
                'id'      => session()->get('user_id'),
                'role_id' => session()->get('user_role_id'),
                'role'    => session()->get('user_role'),
                'name'    => session()->get('user_name'),
                'email'   => session()->get('user_email'),
            ],
        ]);
    }
    
}
