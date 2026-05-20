<?php

namespace App\Filters;

use App\Models\UserRoleModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $allowedRoles = array_values(array_filter($arguments ?? []));

        if ($allowedRoles === []) {
            return redirect()->to('/auth/login')->with('error', 'Accès refusé.');
        }

        $role = (string) $session->get('user_role');

        if ($role === '' || ! in_array($role, $allowedRoles, true)) {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous n’avez pas le bon rôle.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien à faire après la requête.
    }
}