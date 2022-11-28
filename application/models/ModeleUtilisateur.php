<?php
class ModeleUtilisateur extends CI_Model {
 
    public function __construct()
    {
        $this->load->database();
    }

    public function getUser($mail, $pw)
    {
        $requete = $this->db->get_where('client',array('mel' => $mail, 'motdepasse'=>$pw));
        return $requete->row();
    }

    public function getUserByNo($id)
    {
        $requete = $this->db->get_where('client',array('noclient' => $id));
        return $requete->row();
    }

    public function isMailUsed($mail)
    {
        $requete = $this->db->get_where('client',array('mel' => $mail));
        return !($requete->row() == null);
    }

    public function createUser($data) {
        $record = array(
            "mel" => $data['txtMail'],
            "motdepasse" => $data['txtPw'],
            "nom" => $data['txtNom'],
            "prenom" => $data['txtPnom'],
            "telephonefixe" => $data['txtTelFixe'],
            "telephonemobile" => $data['txtTel'],
            "adresse" => $data['txtAd'],
            "ville" => $data['txtVille'],
            "codepostal" => $data['txtCodpost']
        );
        return $this->db->insert("client", $record); 
    }

    public function updateUser($data, $idClient) {
        $record = array(
            "mel" => $data['txtMail'],
            "motdepasse" => $data['txtPw'],
            "nom" => $data['txtNom'],
            "prenom" => $data['txtPnom'],
            "telephonefixe" => $data['txtTelFixe'],
            "telephonemobile" => $data['txtTel'],
            "adresse" => $data['txtAd'],
            "ville" => $data['txtVille'],
            "codepostal" => $data['txtCodpost']
        );
    
        return $this->db->update('client',$record,array('noclient ='=>$idClient));
    }

    public function getLiaisonsBySecteur() {
        $this->db->select('secteur.nom as snom, liaison.noliaison, liaison.distance, pdep.nom as pdepnom, parr.nom as parrnom');
        $this->db->from('secteur');
        $this->db->join("liaison", 'secteur.nosecteur = liaison.nosecteur');
        $this->db->join("port as pdep", 'liaison.noport_depart = pdep.noport');
        $this->db->join("port as parr", 'liaison.noport_arrivee = parr.noport');
        $res = $this->db->get()->result();
        return $res;
    }

    public function getTarifs($noliaison) {
        $this->db->select('periode.noperiode, liaison.noliaison, periode.datedebut, periode.datefin, liaison.distance, categorie.libelle, categorie.lettrecategorie, type.notype, type.libelle, tarifer.tarif');
        $this->db->from('liaison');
        $this->db->join('tarifer', 'tarifer.noliaison = liaison.noliaison');
        $this->db->join('type', 'tarifer.notype = type.notype');
        $this->db->join('categorie', 'type.lettrecategorie = categorie.lettrecategorie and tarifer.lettrecategorie = categorie.lettrecategorie');
        $this->db->join('periode', 'tarifer.noperiode = periode.noperiode');
        $this->db->join("port as pdep", 'liaison.noport_depart = pdep.noport');
        $this->db->join("port as parr", 'liaison.noport_arrivee = parr.noport');
        $this->db->where(array('periode.datefin >=' => date('Y-m-d')));
        if (!isset($noliaison) || $noliaison == null) {
            return $this->db->get()->result();
        } else {
            return $this->db->where(array('liaison.noliaison =' => $noliaison))->get()->result();
        }
    }

    public function getSecteurs() {
        $this->db->select('*');
        $this->db->from('secteur');
        return $this->db->get()->result();
    }

    public function getLiaisons($nosecteur) {
        $this->db->select('liaison.noliaison, pdep.nom as pdep, parr.nom as parr');
        $this->db->from('liaison');
        $this->db->join('port pdep', 'liaison.noport_depart = pdep.noport');
        $this->db->join('port parr', 'liaison.noport_arrivee = parr.noport');
        $this->db->join('secteur', 'secteur.nosecteur = liaison.nosecteur');
        $this->db->where(array('secteur.nosecteur =' => $nosecteur));
        return $this->db->get()->result();
    }

    public function getPeriodes() {
        $this->db->select('*');
        $this->db->from('periode');
        return $this->db->get()->result();
    }

    public function getQuantiteEnregistree($notrav, $lettrecat) {
        $this->db->select('*');
        $this->db->from('traversee');
        $this->db->join('reservation', 'traversee.notraversee = reservation.notraversee');
        $this->db->join('enregistrer', 'reservation.noreservation = enregistrer.noreservation');
        $this->db->join('type', 'type.notype = enregistrer.notype and type.lettrecategorie = enregistrer.lettrecategorie');
        $this->db->where(array(
            'traversee.notraversee =' => $notrav,
            'type.lettrecategorie =' => $lettrecat
        ));
        $res = $this->db->get()->result();
        $total = 0;
        foreach ($res as $item) {
            $total += $item->quantite;
        }
        return $total;
    }

    public function getCapMax($notrav, $lettrecat) {
        $this->db->select('*');
        $this->db->from('traversee');
        $this->db->join('bateau', 'bateau.nobateau = traversee.nobateau');
        $this->db->join('contenir', 'traversee.nobateau = bateau.nobateau and contenir.nobateau = traversee.nobateau');
        $this->db->where(array(
            'traversee.notraversee =' => $notrav,
            'contenir.lettrecategorie =' => $lettrecat
        ));
        return $this->db->get()->row()->capacitemax;
    }

    public function getCapMaxByLettre($lettrecat) {
        $this->db->select('*');
        $this->db->from('contenir');
        $this->db->where(array(
            'contenir.lettrecategorie =' => $lettrecat,
        ));
        return $this->db->get()->row()->capacitemax;
    }

    public function getCats() {
        $this->db->select('*');
        $this->db->from('categorie');
        return $this->db->get()->result();
    }

    public function getAllCats() {
        $this->db->select('categorie.lettrecategorie, type.notype, type.libelle as catlibelle, type.libelle as typelibelle');
        $this->db->from('categorie');
        $this->db->join('type', 'categorie.lettrecategorie = type.lettrecategorie');
        return $this->db->get()->result();
    }

    public function  getTravs($noLiaison, $dateTraversee) {
        $this->db->select('traversee.notraversee, bateau.nom, traversee.dateheuredepart');
        $this->db->from('traversee');
        $this->db->join('bateau', 'bateau.nobateau = traversee.nobateau');
        $this->db->where(array(
            'traversee.noliaison =' => $noLiaison,
            'traversee.dateheuredepart >=' => $dateTraversee
        ));

        return $this->db->get()->result();
    }

    public function getTravByNo($notrav) {
        $this->db->select('pdep.nom as pdepnom, parr.nom as parrnom, traversee.notraversee, traversee.dateheuredepart, traversee.noliaison');
        $this->db->from('traversee');
        $this->db->join('liaison', 'traversee.noliaison = liaison.noliaison');
        $this->db->join('port pdep', 'liaison.noport_depart = pdep.noport');
        $this->db->join('port parr', 'liaison.noport_arrivee = parr.noport');
        $this->db->where(array(
            'traversee.notraversee =' => $notrav
        ));
        return $this->db->get()->row();
    }

    public function insererReservation($notraversee, $noclient, $montant, $isPaid) {
        $record = array(
            'notraversee' => $notraversee,
            'noclient' => $noclient,
            'dateheure' => date("Y-m-d H:i:s"),
            'montanttotal' => $montant,
            'paye' => $isPaid,
            'modereglement' => null
        );
        $this->db->insert("reservation", $record);
        return $this->db->insert_id(); 
    }

    public function insererEnregistrement($nores, $lettre, $notype, $quantite) {
        $record = array(
            'noreservation' => $nores,
            'lettrecategorie' => $lettre,
            'notype' => $notype,
            'quantite' => $quantite
        );
        $this->db->insert("enregistrer", $record);
    }

    public function getRes() {
        $this->db->select('reservation.noreservation, reservation.dateheure, pdep.nom as pdepnom, parr.nom as parrnom, traversee.dateheuredepart, reservation.montanttotal, reservation.paye');
        $this->db->from('reservation');
        $this->db->join('traversee', 'reservation.notraversee = traversee.notraversee');
        $this->db->join('liaison', 'liaison.noliaison = traversee.noliaison');
        $this->db->join('port pdep', 'liaison.noport_depart = pdep.noport');
        $this->db->join('port parr', 'liaison.noport_arrivee = parr.noport');
        return $this->db->get()->result();
    }

    public function nbRes() {
        return $this->db->count_all('reservation');
    }

    public function getResLimite($limit, $firstL) {
        $this->db->select('reservation.noreservation, reservation.dateheure, pdep.nom as pdepnom, parr.nom as parrnom, traversee.dateheuredepart, reservation.montanttotal, reservation.paye');
        $this->db->from('reservation');
        $this->db->join('traversee', 'reservation.notraversee = traversee.notraversee');
        $this->db->join('liaison', 'liaison.noliaison = traversee.noliaison');
        $this->db->join('port pdep', 'liaison.noport_depart = pdep.noport');
        $this->db->join('port parr', 'liaison.noport_arrivee = parr.noport');
        $this->db->limit($limit, $firstL);
        return $this->db->get()->result();
    }
}