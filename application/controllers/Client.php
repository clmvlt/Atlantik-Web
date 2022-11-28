<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {
	public function __construct() {
		parent::__construct();
       	$this->load->helper('url');
        $this->load->helper('file');
       	$this->load->library("pagination");
        $this->load->model('ModeleUtilisateur');
        if (!isset($this->session->id)) {
            redirect(site_url('Visiteur/login'));
        }
	}

	public function afficherLiaisonsSecteur() {
        $data["tableauSecteurLiaisons"] = $this->ModeleUtilisateur->getLiaisonsBySecteur();
        $this->load->view('templates/header');
        $this->load->view('client/afficherLiaisonsSecteur',$data);
        $this->load->view('templates/footer');
    }

    public function tarifLiaison($no) {
        $data["tabTarifs"] = $this->ModeleUtilisateur->getTarifs($no);
        $this->load->view('templates/header');
        $this->load->view('client/afficherTarifsParLiaisons',$data);
        $this->load->view('templates/footer');
    }

    public function horrairesTravs($nosecteur=null) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('ddLiaisons', 'Liaisons', 'required');

        $data["tabSecteurs"] = $this->ModeleUtilisateur->getSecteurs();
        $data["tabLiaisons"] = $this->ModeleUtilisateur->getLiaisons($nosecteur);
        $data["tabPeriodes"] = $this->ModeleUtilisateur->getPeriodes();
        $data["nosecteur"] = $nosecteur;

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('client/afficherSecteurs',$data);
            $this->load->view('client/afficherHorrairesTravs',$data);
            $this->load->view('templates/footer');
        } else {
            $cats = $this->ModeleUtilisateur->getCats();
            $tab = array();
            foreach ($this->ModeleUtilisateur->getTravs((int)$this->input->post('ddLiaisons'), $this->input->post('ddPeriodes')) as $item) {
                foreach ($cats as $cat) {
                    array_push($tab, "<p><a href='".site_url('Client/ReservationTrav/'.$item->notraversee)."'>".$item->notraversee."</a>"." ".$item->dateheuredepart." ".$item->nom." ".$cat->lettrecategorie." ".$cat->libelle." ".($this->ModeleUtilisateur->getCapMax($item->notraversee, $cat->lettrecategorie) - $this->ModeleUtilisateur->getQuantiteEnregistree($item->notraversee, $cat->lettrecategorie))."</p>");
                }
            }
            $data['tabTarifsTravs'] = $tab;
            $this->load->view('templates/header');
            $this->load->view('client/afficherSecteurs',$data);
            $this->load->view('client/afficherHorrairesTravs',$data);
            $this->load->view('templates/footer');
        }
    }

    public function ReservationTrav($notrav=null) {
        if (!isset($notrav) || $notrav == null) {
            redirect(site_url('Welcome/index'));
            return;
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('submit', 'Réserver', 'required');

        foreach ($this->ModeleUtilisateur->getAllCats() as $item) {
            $this->form_validation->set_rules($item->lettrecategorie.';'.$item->notype, $item->typelibelle, 'numeric');
        }

        $data['userInfo'] = $this->ModeleUtilisateur->getUserByNo($this->session->id);
        $data['travInfo'] = $this->ModeleUtilisateur->getTravByNo((int)$notrav);
        $data['tarifs'] = $this->ModeleUtilisateur->getTarifs((int)$data['travInfo']->noliaison);

        if ($this->form_validation->run() === FALSE) {
    

            $this->load->view('templates/header');
            $this->load->view('client/reservationTrav', $data);
            $this->load->view('templates/footer');
        } else {
            $data['tabQuantiteRes'] = array();
            $data["montant"] = 0;
            foreach ($data['tarifs'] as $item) {
                if ((int)$this->input->post($item->lettrecategorie.';'.$item->notype) != null) {
                    $data['tabQuantiteRes'][$item->libelle] = (int)$this->input->post($item->lettrecategorie.';'.$item->notype);
                    $data["montant"] += (int)$this->input->post($item->lettrecategorie.';'.$item->notype) * $item->tarif;
                    if ((int)$this->input->post($item->lettrecategorie.';'.$item->notype) > $this->ModeleUtilisateur->getCapMaxByLettre($item->lettrecategorie)) {
                        $this->load->view('templates/header');
                        $this->load->view('client/echecReservation', $data);
                        $this->load->view('templates/footer');
                        return;
                    }
                }
            }

            $resId = $this->ModeleUtilisateur->insererReservation($notrav, $this->session->id, $data["montant"], true);
            foreach ($data['tarifs'] as $item) {
                if ((int)$this->input->post($item->lettrecategorie.';'.$item->notype) != null) {    
                    $this->ModeleUtilisateur->insererEnregistrement($resId, $item->lettrecategorie, $item->notype, (int)$this->input->post($item->lettrecategorie.';'.$item->notype));
                }
            }

            $this->load->view('templates/header');
            $this->load->view('client/confirmationReservation', $data);
            $this->load->view('templates/footer');
        }
    }

    public function updateAccount() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txtMail', 'Mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('txtPw', 'Mot de passe', 'required');
        $this->form_validation->set_rules('txtTel', 'Tel', 'required');
        $this->form_validation->set_rules('txtTelFixe', 'Tel. Fixe', 'required');
        $this->form_validation->set_rules('txtNom', 'Nom', 'required|alpha');
        $this->form_validation->set_rules('txtPnom', 'Prénom', 'required|alpha');
        $this->form_validation->set_rules('txtAd', 'Adresse', 'required');
        $this->form_validation->set_rules('txtCodpost', 'Code Postal', 'required|numeric');
        $this->form_validation->set_rules('txtVille', 'Ville', 'required');

        
        if ($this->form_validation->run() === FALSE) 
        {   
            $this->load->view('templates/header');
            $this->load->view('visiteur/modifieCompte');
            $this->load->view('templates/footer');
        }
        else // formulaire envoyé
        {   
            $data = array();
            $data["txtMail"] = $this->input->post('txtMail');
            $data["txtPw"] = $this->input->post('txtPw');
            $data["txtNom"] = $this->input->post('txtNom');
            $data["txtPnom"] = $this->input->post('txtPnom');
            $data["txtTelFixe"] = $this->input->post('txtTelFixe');
            $data["txtTel"] = $this->input->post('txtTel');
            $data["txtAd"] = $this->input->post('txtAd');
            $data["txtVille"] = $this->input->post('txtVille');
            $data["txtCodpost"] = $this->input->post('txtCodpost');
   
            if ($this->ModeleUtilisateur->updateUser($data, $this->session->id)) 
            {
                $this->load->view('templates/header');
                $this->load->view('visiteur/updateSuccess', $data);
                $this->load->view('templates/footer');
            }
            else // utilisateur non ajouté
            {       
                $this->load->view('templates/header');
                $this->load->view('visiteur/signInError');
                $this->load->view('visiteur/modifieCompte', $data);
                $this->load->view('templates/footer');
            } 
        }
    }
}
