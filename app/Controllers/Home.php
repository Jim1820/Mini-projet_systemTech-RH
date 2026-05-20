<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();

        if (! $session->get('isLoggedIn') || ! $session->get('user_id')) {
            return redirect()->to('/auth/login');
        }

        $role = (string) $session->get('user_role');

        if ($role === 'admin') {
            return redirect()->to('/admin');
        } elseif ($role === 'rh') {
            return redirect()->to('/rh');
        } else {
            return redirect()->to('/employe');
        }
    }
}
