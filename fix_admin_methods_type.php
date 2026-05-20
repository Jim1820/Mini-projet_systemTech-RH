<?php
$file = 'app/Controllers/AdminController.php';
$content = file_get_contents($file);

$methods = <<<'METHODS'
    // --- TYPE CONGES CRUD ---
    public function types()
    {
        $typeModel = new \App\Models\TypeCongeModel();
        return view('admin/types', [
            'types' => $typeModel->findAll()
        ]);
    }

    public function storeType()
    {
        if (!$this->validate([
            'libelle'          => 'required|min_length[2]|is_unique[types_conge.libelle]',
            'jours_alloues'    => 'required|numeric|greater_than[0]',
            'description'      => 'permit_empty|string'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $typeModel = new \App\Models\TypeCongeModel();
        $typeModel->insert([
            'libelle'          => $this->request->getPost('libelle'),
            'jours_alloues'    => (int)$this->request->getPost('jours_alloues'),
            'description'      => $this->request->getPost('description'),
            'est_deductible'   => $this->request->getPost('est_deductible') ? 1 : 0,
            'statut'           => 'actif'
        ]);

        return redirect()->to('/admin/types')->with('success', 'Type de congé ajouté.');
    }

    public function updateType()
    {
        if (!$this->validate([
            'id'               => 'required|numeric',
            'libelle'          => 'required|min_length[2]|is_unique[types_conge.libelle,id,{id}]',
            'jours_alloues'    => 'required|numeric|greater_than[0]',
            'description'      => 'permit_empty|string'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $typeModel = new \App\Models\TypeCongeModel();
        $typeModel->update($this->request->getPost('id'), [
            'libelle'          => $this->request->getPost('libelle'),
            'jours_alloues'    => (int)$this->request->getPost('jours_alloues'),
            'description'      => $this->request->getPost('description'),
            'est_deductible'   => $this->request->getPost('est_deductible') ? 1 : 0
        ]);

        return redirect()->to('/admin/types')->with('success', 'Type de congé mis à jour.');
    }

    public function deactivateType($id)
    {
        $typeModel = new \App\Models\TypeCongeModel();
        $typeModel->update($id, ['statut' => 'inactif']);
        return redirect()->to('/admin/types')->with('success', 'Type désactivé.');
    }

    public function reactivateType($id)
    {
        $typeModel = new \App\Models\TypeCongeModel();
        $typeModel->update($id, ['statut' => 'actif']);
        return redirect()->to('/admin/types')->with('success', 'Type réactivé.');
    }
METHODS;

$content = preg_replace('/}(?=\s*$)/', "\n" . $methods . "\n}", $content);
file_put_contents($file, $content);
