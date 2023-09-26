<?php

class TeamController
{
    protected $model;

    public function __construct() {
        $this->model = new TeamModel();
    }

    // Ajout d'une équipe
    public function add() : void
    {   
        try {
            $teams = $this->model->findAllTeams();
            if (empty($_SESSION['user']['role'] == 'admin')) {
                throw new Exception("Vous devez être administrateur pour effectuer cette action.");
            } else {
                if (!empty($_POST['name']) && !empty($_POST['country'])) {
                    $name = htmlspecialchars($_POST['name']);
                    $country = htmlspecialchars($_POST['country']);
                    // Envoi des données au modèle
                    $this->model->addTeam($name, $country);
                    $teams = $this->model->findAllTeams();
                    render('user/admin', ['pageTitle' => 'Espace administrateur', 'teams' => $teams, 'successMessage' => 'Équipe ajoutée avec succès.']);
                } else {
                    throw new Exception("Veuillez remplir tous les champs pour ajouter une équipe.");
                }
            }
        } catch (Exception $e) {
            render('user/admin', ['pageTitle' => 'Espace administrateur', 'teams' => $teams, 'errorMessage' => $e->getMessage()]);
        }
        
    }
}