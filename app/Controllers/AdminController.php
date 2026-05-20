<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\CongeModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $employeModel = new EmployeModel();
        $congeModel = new CongeModel();
        $departementModel = new \App\Models\DepartementModel();

        $totalEmployes = $employeModel->where('actif', 1)->countAllResults();
        $enAttenteCount = $congeModel->where('statut', 'en_attente')->countAllResults();
        $approuveesCeMois = $congeModel->where('statut', 'approuvee')
                                       ->where('date_debut >=', date('Y-m-01'))
                                       ->where('date_debut <=', date('Y-m-t'))
                                       ->countAllResults();
                                       
        $departementsCount = $departementModel->countAll();
        
        $absentsAujourdhui = $congeModel->where('statut', 'approuvee')
                                        ->where('date_debut <=', date('Y-m-d'))
                                        ->where('date_fin >=', date('Y-m-d'))
                                        ->countAllResults();

        $absentsList = $congeModel->select('employes.nom, employes.prenom, conges.date_fin, types_conge.libelle')
                                  ->join('employes', 'employes.id = conges.employe_id')
                                  ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                                  ->where('statut', 'approuvee')
                                  ->where('date_debut <=', date('Y-m-d'))
                                  ->where('date_fin >=', date('Y-m-d'))
                                  ->findAll();

        $demandes = $congeModel->select('conges.*, employes.nom, employes.prenom, types_conge.libelle')
                               ->join('employes', 'employes.id = conges.employe_id')
                               ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                               ->orderBy('conges.created_at', 'DESC')
                               ->findAll(5);

        return view('admin/dashboard', [
            'title' => 'Dashboard Admin',
            'totalEmployes' => $totalEmployes,
            'enAttenteCount' => $enAttenteCount,
            'approuveesCeMois' => $approuveesCeMois,
            'departementsCount' => $departementsCount,
            'absentsAujourdhui' => $absentsAujourdhui,
            'absentsList' => $absentsList,
            'demandes' => $demandes
        ]);
    }

    public function employes()
    {
        $employeModel = new EmployeModel();
        $departementModel = new \App\Models\DepartementModel();

        $employes = $employeModel->select('employes.*, departements.nom as dep_nom')
                                 ->join('departements', 'departements.id = employes.departement_id', 'left')
                                 ->findAll();
                                 
        $departements = $departementModel->findAll();

        return view('admin/employes', [
            'title' => 'Gestion des Employés',
            'employes' => $employes,
            'departements' => $departements
        ]);
    }

    public function storeEmploye()
    {
        $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|valid_email|is_unique[employes.email]',
            'password' => 'required|min_length[6]',
            'departement_id' => 'required|is_natural_no_zero',
            'role' => 'required|in_list[employe,rh,admin]',
            'date_embauche' => 'required|valid_date'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Erreur de validation.')->with('validation', $this->validator);
        }

        $employeModel = new EmployeModel();
        
        $employeModel->insert([
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'departement_id' => $this->request->getPost('departement_id'),
            'role' => $this->request->getPost('role'),
            'date_embauche' => $this->request->getPost('date_embauche'),
            'actif' => 1
        ]);

        return redirect()->back()->with('success', 'Employé créé avec succès.');
    }

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




    // --- HISTORIQUE GLOBAL ---
    public function historique()
    {
        $congeModel = new \App\Models\CongeModel();
        
        $demandes = $congeModel->select('conges.*, employes.nom, employes.prenom, types_conge.libelle')
                               ->join('employes', 'employes.id = conges.employe_id')
                               ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                               ->orderBy('conges.created_at', 'DESC')
                               ->findAll();

        return view('admin/historique', [
            'demandes' => $demandes
        ]);
    }
}
