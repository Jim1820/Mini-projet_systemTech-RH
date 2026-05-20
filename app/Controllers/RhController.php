<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\SoldeModel;

class RhController extends BaseController
{
    public function demandes()
    {
        $congeModel = new CongeModel();
        
        $statut = $this->request->getGet('statut');
        
        $builder = $congeModel->select('conges.*, employes.nom, employes.prenom, types_conge.libelle, soldes.jours_attribues, soldes.jours_pris')
                              ->join('employes', 'employes.id = conges.employe_id')
                              ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                              ->join('soldes', 'soldes.employe_id = conges.employe_id AND soldes.type_conge_id = conges.type_conge_id AND soldes.annee = ' . date('Y'), 'left');

        if ($statut && in_array($statut, ['en_attente', 'approuvee', 'refusee', 'annulee'])) {
            $builder->where('conges.statut', $statut);
        }

        $demandes = $builder->orderBy('conges.created_at', 'DESC')->findAll();

        return view('rh/demandes', [
            'title' => 'Toutes les demandes',
            'demandes' => $demandes,
            'statut_actif' => $statut,
        ]);
    }

    public function approuver($id)
    {
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();

        $demande = $congeModel->find($id);

        if (!$demande || $demande['statut'] !== 'en_attente') {
            return redirect()->back()->with('error', 'Demande introuvable ou déjà traitée.');
        }

        $annee = date('Y', strtotime($demande['date_debut']));
        $solde = $soldeModel->where('employe_id', $demande['employe_id'])
                            ->where('type_conge_id', $demande['type_conge_id'])
                            ->where('annee', $annee)
                            ->first();

        if (!$solde) {
            return redirect()->back()->with('error', 'Aucun solde trouvé pour cet employé.');
        }

        $restant = $solde['jours_attribues'] - $solde['jours_pris'];
        if ($restant < $demande['nb_jours']) {
            return redirect()->back()->with('error', 'Solde insuffisant pour approuver cette demande.');
        }

        // Deduct balance
        $soldeModel->update($solde['id'], [
            'jours_pris' => $solde['jours_pris'] + $demande['nb_jours']
        ]);

        $commentaire = $this->request->getPost('commentaire_rh');

        $congeModel->update($id, [
            'statut' => 'approuvee',
            'commentaire_rh' => $commentaire,
            'traite_par' => session()->get('user_id')
        ]);

        return redirect()->back()->with('success', 'La demande a été approuvée.');
    }

    public function refuser($id)
    {
        $congeModel = new CongeModel();
        $demande = $congeModel->find($id);

        if (!$demande || $demande['statut'] !== 'en_attente') {
            return redirect()->back()->with('error', 'Demande introuvable ou déjà traitée.');
        }

        $commentaire = $this->request->getPost('commentaire_rh');

        $congeModel->update($id, [
            'statut' => 'refusee',
            'commentaire_rh' => $commentaire,
            'traite_par' => session()->get('user_id')
        ]);

        return redirect()->back()->with('success', 'La demande a été refusée.');
    }
}
