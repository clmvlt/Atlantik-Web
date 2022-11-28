<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visiteur extends CI_Controller {
	public function __construct() {
		parent::__construct();
       	$this->load->helper('url');
        $this->load->helper('file');
       	$this->load->library("pagination");
        $this->load->model('ModeleUtilisateur');
	}

	public function login()
	{
		$this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Atlantik - Login';
        
        $this->form_validation->set_rules('txtMail', 'Mail', 'required');
        $this->form_validation->set_rules('txtPw', 'Mot de passe', 'required');
        
        if ($this->form_validation->run() === FALSE) 
        {   
            $this->load->view('templates/header');
            $this->load->view('visiteur/login', $data);
            $this->load->view('templates/footer');
        }
        else // formulaire envoyé
        {   
            $mail = $this->input->post('txtMail');
            $pw = $this->input->post('txtPw');
            
            $returnedUser = $this->ModeleUtilisateur->getUser($mail, $pw);
            if (!($returnedUser == null)) 
            {
                $this->session->mail = $returnedUser->mel;
                $this->session->id = $returnedUser->noclient;

                $data['id'] = $this->session->id; 
                $this->load->view('templates/header');
                $this->load->view('visiteur/loginSuccess', $data);
                $this->load->view('templates/footer');
            }
            else // utilisateur non trouvé on renvoie le formulaire de connexion
            {       
                $this->load->view('templates/header');
                $this->load->view('visiteur/loginError');
                $this->load->view('visiteur/login', $data);
                $this->load->view('templates/footer');
            } 
        }
	} // fin login

    public function logout() { // destruction de la session = déconnexion
        $this->session->sess_destroy();
        redirect(site_url('Welcome/index'));
    } // fin logout

    public function signIn() {
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
            $this->load->view('visiteur/signIn');
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

            if ($this->ModeleUtilisateur->isMailUsed($data["txtMail"])) // mail déjà utilisé
            {
                $this->load->view('templates/header');
                $this->load->view('visiteur/signInError');
                $this->load->view('visiteur/signIn', $data);
                $this->load->view('templates/footer');
            }
            else // aucun utilisateur n'a ce mail
            {       
                if ($this->ModeleUtilisateur->createUser($data)) 
                {
                    $this->load->view('templates/header');
                    $this->load->view('visiteur/signInSuccess', $data);
                    $this->load->view('templates/footer');
                }
                else // utilisateur non ajouté
                {       
                    $this->load->view('templates/header');
                    $this->load->view('visiteur/signInError');
                    $this->load->view('visiteur/signIn', $data);
                    $this->load->view('templates/footer');
                } 
            }
            
            
        }
    } // fin signIn

    public function afficherRes() {
        $config = array();
        $config["base_url"] = site_url('Visiteur/afficherRes');
        $config["total_rows"] = $this->ModeleUtilisateur->nbRes();
        $config["per_page"] = 2;
        $config["uri_segment"] = 3;

        $config['first_link'] = 'Premier';
        $config['last_link'] = 'Dernier';
        $config['next_link'] = 'Suivant';
        $config['prev_link'] = 'Précédent';

        $this->pagination->initialize($config);
        $noPage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; 

        $data['tabRes'] = $this->ModeleUtilisateur->getResLimite($config["per_page"], $noPage);
        $data["liensPagination"] = $this->pagination->create_links();

        $this->load->view('templates/header');
        $this->load->view('visiteur/afficherRes', $data);
        $this->load->view('templates/footer');
    }
}
