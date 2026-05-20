<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\EmployeModel;
use App\Models\SoldeModel;
use App\Models\TypeCongeModel;

class EmployeController extends BaseController
{
    public function dashboard()
    {
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();
        
        $userId = session()->get('user_id');
        $annee = date('Y');

        $demandes = $congeModel->where('employe_id', $userId)->orderBy('created_at', 'DESC')->findAll(5);
        $soldes = $soldeModel->select('soldes.*, types_conge.libelle')
                             ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
                             ->where('employe_id', $userId)
                             ->where('annee', $annee)
                             ->findAll();

        $enAttenteCount = $congeModel->where('employe_id', $userId)->where('statut', 'en_attente')->countAllResults();
        $approuveesCount = $congeModel->where('employe_id', $userId)->where('statut', 'approuvee')->countAllResults();

        return view('employe/dashboard', [
            'title' => 'Tableau de bord - Employé',
            'demandes' => $demandes,
            'soldes' => $soldes,
            'enAttenteCount' => $enAttenteCount,
            'approuveesCount' => $approuveesCount
        ]);
    }

    public function nouvelleDemande()
    {
        $typeCongeModel = new TypeCongeModel();
        $soldeModel = new SoldeModel();

        $userId = session()->get('user_id');
        $types = $typeCongeModel->findAll();
        
        $soldes = $soldeModel->select('soldes.*, types_conge.libelle')
                             ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
                             ->where('employe_id', $userId)
                             ->where('annee', date('Y'))
                             ->findAll();

        return view('employe/demande', [
            'title' => 'Nouvelle Demande',
            'types' => $types,
            'soldes' => $soldes
        ]);
    }

    public function sauvegarderDemande()
    {
        $rules = [
            'type_conge_id' => 'required|is_natural_no_zero',
            'date_debut'    => 'required|valid_date',
            'date_fin'      => 'required|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez remplir correctement la demande.');
        }

        $userId = session()->get('user_id');
        $type_id = $this->request->getPost('type_conge_id');
        $debut = $this->request->getPost('date_debut');
        $fin = $this->request->getPost('date_fin');
        $motif = $this->request->getPost('motif');

        // Basic date validation
        if (strtotime($debut) >= strtotime($fin)) {
            return redirect()->back()->withInput()->with('error', 'La date de début doit être antérieure à la date de fin.');
        }

        // Calculate business days
        $nb_jours = 0;
        $currentDate = strtotime($debut);
        $endDate = strtotime($fin);
        
        while ($currentDate <= $endDate) {
            $dayOfWeek = date('N', $currentDate);
            // 1 (Monday) to 5 (Friday)
            if ($dayOfWeek < 6) {
                $nb_jours++;
            }
            $currentDate = strtotime('+1 day', $currentDate);
        }

        if ($nb_jours == 0) {
            return redirect()->back()->withInput()->with('error', 'La période sélectionnée ne contient aucun jour ouvrable.');
        }

        // Overlap verification
        $congeModel = new CongeModel();
        
        // Find existing congés overlapping
        // Check if there is any record matching overlapping criteria
        $overlapping = $congeModel->where('employe_id', $userId)
            ->whereIn('statut', ['en_attente', 'approuvee'])
            ->groupStart()
                ->groupStart()
                    ->where('date_debut <=', $fin)
                    ->where('date_fin >=', $debut)
                ->groupEnd()
            ->groupEnd()
            ->first();

        if ($overlapping) {
            return redirect()->back()->withInput()->with('error', 'Cette demande chevauche une de vos demandes (en attente ou approuvée).');
        }

        // Balance Check
        $soldeModel = new SoldeModel();
        $annee = date('Y', strtotime($debut));
        $solde = $soldeModel->where('employe_id', $userId)
                            ->where('type_conge_id', $type_id)
                            ->where('annee', $annee)
                            ->first();

        if (!$solde) {
            return redirect()->back()->withInput()->with('error', 'Solde introuvable pour ce type de congé cette année.');
        }

        $restant = $solde['jours_attribues'] - $solde['jours_pris'];
        if ($restant < $nb_jours) {
            return redirect()->back()->withInput()->with('error', "Solde insuffisant. Il vous reste {$restant} jour(s) de ce type, mais vous demandez {$nb_jours} jour(s).");
        }

        $congeModel->insert([
            'employe_id'    => $userId,
            'type_conge_id' => $type_id,
            'date_debut'    => $debut,
            'date_fin'      => $fin,
            'nb_jours'      => $nb_jours,
            'motif'         => $motif,
            'statut'        => 'en_attente'
        ]);

        return redirect()->to('/employe/mes-demandes')->with('success', 'Votre demande de congé a été soumise avec succès.');
    }

    public function mesDemandes()
    {
        $congeModel = new CongeModel();
        $userId = session()->get('user_id');

        $demandes = $congeModel->select('conges.*, types_conge.libelle')
                               ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                               ->where('employe_id', $userId)
                               ->orderBy('conges.created_at', 'DESC')
                               ->findAll();

        return view('employe/mes_demandes', [
            'title' => 'Mes demandes',
            'demandes' => $demandes
        ]);
    }

    public function annulerDemande($id)
    {
        $congeModel = new CongeModel();
        $demande = $congeModel->find($id);

        if ($demande && $demande['employe_id'] == session()->get('user_id') && $demande['statut'] === 'en_attente') {
            $congeModel->update($id, ['statut' => 'annulee']);
            return redirect()->back()->with('success', 'Demande annulée.');
        }

        return redirect()->back()->with('error', 'Impossible d\'annuler cette demande.');
    }

    public function profil()
    {
        $employeModel = new EmployeModel();
        $employe = $employeModel->find(session()->get('user_id'));

        return view('employe/profil', [
            'title' => 'Mon Profil',
            'employe' => $employe
        ]);
    }

    public function updateProfil()
    {
        $rules = [
            'nom'      => 'required|min_length[2]',
            'prenom'   => 'required|min_length[2]',
            'email'    => 'required|valid_email',
        ];

        if ($this->request->getPost('password_nouveau')) {
            $rules['password_actuel'] = 'required';
            $rules['password_nouveau'] = 'required|min_length[6]';
            $rules['password_confirmer'] = 'required|matches[password_nouveau]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez corriger les erreurs.')->with('validation', $this->validator);
        }

        $employeModel = new EmployeModel();
        $userId = session()->get('user_id');
        $employe = $employeModel->find($userId);

        $data = [
            'nom'    => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email'  => $this->request->getPost('email'),
        ];
        
        // Check email distinct uniqueness except current
        $emailExists = $employeModel->where('email', $data['email'])->where('id !=', $userId)->first();
        if ($emailExists) {
            return redirect()->back()->withInput()->with('error', 'Cet email est déjà utilisé.');
        }

        if ($this->request->getPost('password_nouveau')) {
            if (!password_verify($this->request->getPost('password_actuel'), $employe['password'])) {
                return redirect()->back()->withInput()->with('error', 'Mot de passe actuel incorrect.');
            }
            $data['password'] = password_hash($this->request->getPost('password_nouveau'), PASSWORD_DEFAULT);
        }

        $employeModel->update($userId, $data);
        
        // Update session
        session()->set([
            'user_name' => $data['prenom'] . ' ' . $data['nom'],
            'user_email' => $data['email']
        ]);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function calendrier()
    {
        $congeModel = new CongeModel();
        $userId = session()->get('user_id');

        $demandes = $congeModel->select('conges.*, types_conge.libelle')
                               ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                               ->where('employe_id', $userId)
                               ->findAll();
        
        $events = [];
        foreach ($demandes as $d) {
            $color = '#3498db'; // default
            if ($d['statut'] == 'approuvee') $color = '#2ecc71';
            else if ($d['statut'] == 'en_attente') $color = '#f1c40f';
            else if ($d['statut'] == 'refusee') $color = '#e74c3c';
            
            $events[] = [
                'title' => $d['libelle'] . ' (' . str_replace('_', ' ', $d['statut']) . ')',
                'start' => $d['date_debut'],
                'end'   => date('Y-m-d', strtotime($d['date_fin'] . ' +1 day')), // FullCalendar exclusive end
                'color' => $color,
                'allDay'=> true
            ];
        }

        return view('employe/calendrier', [
            'eventsJson' => json_encode($events)
        ]);
    }

    // public function calendrier()
    // {
    //     $congeModel = new CongeModel();
    //     $userId = session()->get('user_id');

    //     $demandes = $congeModel->select('conges.*, types_conge.libelle')
    //                            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
    //                            ->where('employe_id', $userId)
    //                            ->findAll();
        
    //     $events = [];
    //     foreach ($demandes as $d) {
    //         $color = '#3498db'; // default
    //         if ($d['statut'] == 'approuvee') $color = '#2ecc71';
    //         else if ($d['statut'] == 'en_attente') $color = '#f1c40f';
    //         else if ($d['statut'] == 'refusee') $color = '#e74c3c';
            
    //         $events[] = [
    //             'title' => $d['libelle'] . ' (' . str_replace('_', ' ', $d['statut']) . ')',
    //             'start' => $d['date_debut'],
    //             'end'   => date('Y-m-d', strtotime($d['date_fin'] . ' +1 day')), // FullCalendar exclusive end
    //             'color' => $color,
    //             'allDay'=> true
    //         ];
    //     }

    //     return view('employe/calendrier', [
    //         'eventsJson' => json_encode($events)
    //     ]);
    // }
}
