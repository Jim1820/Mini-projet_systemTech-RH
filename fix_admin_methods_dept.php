<?php
$file = 'app/Controllers/AdminController.php';
$content = file_get_contents($file);

$methods = <<<'METHODS'
    // --- DEPARTEMENTS CRUD ---
    public function departements()
    {
        $departementModel = new \App\Models\DepartementModel();
        return view('admin/departements', [
            'departements' => $departementModel->findAll()
        ]);
    }

    public function storeDepartement()
    {
        if (!$this->validate([
            'nom'         => 'required|min_length[2]|is_unique[departements.nom]',
            'description' => 'permit_empty|string'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $departementModel = new \App\Models\DepartementModel();
        $departementModel->insert([
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'statut'      => 'actif'
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département ajouté.');
    }

    public function updateDepartement()
    {
        if (!$this->validate([
            'id'          => 'required|numeric',
            'nom'         => 'required|min_length[2]|is_unique[departements.nom,id,{id}]',
            'description' => 'permit_empty|string'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $departementModel = new \App\Models\DepartementModel();
        $departementModel->update($this->request->getPost('id'), [
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département mis à jour.');
    }

    public function deactivateDepartement($id)
    {
        $departementModel = new \App\Models\DepartementModel();
        $departementModel->update($id, ['statut' => 'inactif']);
        return redirect()->to('/admin/departements')->with('success', 'Département désactivé.');
    }

    public function reactivateDepartement($id)
    {
        $departementModel = new \App\Models\DepartementModel();
        $departementModel->update($id, ['statut' => 'actif']);
        return redirect()->to('/admin/departements')->with('success', 'Département réactivé.');
    }
METHODS;

$content = preg_replace('/}(?=\s*$)/', "\n" . $methods . "\n}", $content);
file_put_contents($file, $content);
