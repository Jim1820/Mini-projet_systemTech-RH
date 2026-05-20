<?php
$file = 'app/Controllers/AdminController.php';
$content = file_get_contents($file);

$methods = <<<'METHODS'
    public function updateEmploye()
    {
        if (!$this->validate([
            'id'             => 'required|numeric',
            'prenom'         => 'required|min_length[2]',
            'nom'            => 'required|min_length[2]',
            'email'          => 'required|valid_email|is_unique[employes.email,id,{id}]',
            'role'           => 'required|in_list[employe,rh,admin]',
            'departement_id' => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $id = $this->request->getPost('id');
        $this->employeModel->update($id, [
            'prenom'         => $this->request->getPost('prenom'),
            'nom'            => $this->request->getPost('nom'),
            'email'          => $this->request->getPost('email'),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
        ]);

        return redirect()->to('/admin/employes')->with('success', 'Employé mis à jour avec succès.');
    }

    public function deactivateEmploye($id)
    {
        $this->employeModel->update($id, ['statut' => 'inactif']);
        return redirect()->to('/admin/employes')->with('success', 'Employé désactivé.');
    }

    public function reactivateEmploye($id)
    {
        $this->employeModel->update($id, ['statut' => 'actif']);
        return redirect()->to('/admin/employes')->with('success', 'Employé réactivé.');
    }
METHODS;

// Insert methods before the closing bracket of AdminController class
$content = preg_replace('/}(?=\s*$)/', "\n" . $methods . "\n}", $content);

file_put_contents($file, $content);
