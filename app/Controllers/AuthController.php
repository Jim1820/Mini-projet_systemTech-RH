<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
        $email = (string) $this->request->getPost('email');
        $password = (string) $this->request->getPost('mot_de_passe');
        $employeModel = new EmployeModel();

        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('auth/login', [
                'title' => 'Connexion',
                'error' => null,
            ]);
        }

        $rules = [
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email',
            ],
            'mot_de_passe' => [
                'label'  => 'Mot de passe',
                'rules'  => 'required',
            ],
        ];

        if (! $this->validate($rules)) {
            return view('auth/login', [
                'title' => 'Connexion',
                'error' => 'Données de connexion invalides.',
                'validation' => $this->validator,
                'email' => $email,
            ]);
        }

        try {
            $user = $employeModel->where('email', $email)->first();
        } catch (\Throwable $exception) {
            return view('auth/login', [
                'title' => 'Connexion',
                'error' => 'Connexion impossible: la base de données n\'est pas encore disponible.',
                'email' => $email,
            ]);
        }

        if (!$user || !password_verify($password, $user['password'])) {
            return view('auth/login', [
                'title' => 'Connexion',
                'error' => 'Email ou mot de passe incorrect.',
                'email' => $email,
            ]);
        }

        if (isset($user['actif']) && $user['actif'] == 0) {
            return view('auth/login', [
                'title' => 'Connexion',
                'error' => 'Votre compte est désactivé.',
                'email' => $email,
            ]);
        }

        // Set session
        $sessionData = [
            'user_id'    => $user['id'],
            'user_role'  => $user['role'],
            'user_name'  => $user['prenom'] . ' ' . $user['nom'],
            'user_email' => $user['email'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // Redirect based on role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        } elseif ($user['role'] === 'rh') {
            return redirect()->to('/rh');
        } else {
            return redirect()->to('/employe');
        }
    }

    public function logout(): ResponseInterface
    {
        session()->destroy();

        return redirect()->to('/auth/login');
    }

    public function me(): ResponseInterface
    {
        if (! session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => 'error',
                'message' => 'Aucune session active.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'user'   => [
                'id'       => session()->get('user_id'),
                'role'     => session()->get('user_role'),
                'name'     => session()->get('user_name'),
                'email'    => session()->get('user_email'),
            ],
        ]);
    }

}