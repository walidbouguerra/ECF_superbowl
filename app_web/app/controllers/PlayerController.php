<?php

class PlayerController
{
    protected $model;
    protected $teamModel;

    public function __construct() {
        $this->model = new PlayerModel();
        $this->teamModel = new TeamModel();
    }

    // Ajouter un joueur
    public function add() : void
    {   
        try {
            $teams = $this->teamModel->findAllTeams();
            if (empty($_SESSION['user']['role'] == 'admin')) {
                throw new Exception("Vous devez être administrateur pour effectuer cette action.");
            } else {
                if (!empty($_POST['name']) && !empty($_POST['firstName']) && isset($_POST['number']) && isset($_POST['idTeam']) && $_SESSION['user']['role'] == 'admin') {
                    $name = htmlspecialchars($_POST['name']);
                    $firstName = htmlspecialchars($_POST['firstName']);
                    $number = htmlspecialchars($_POST['number']);
                    $idTeam = htmlspecialchars($_POST['idTeam']);
                    $this->model->addPlayer($name, $firstName, $number, $idTeam);
                    render('user/admin', ['pageTitle' => 'Espace administrateur', 'teams' => $teams, 'successMessage' => 'Joueur ajouté avec succès.']);
                } else {
                    throw new Exception("Veuillez remplir tous les champs pour ajouter un joueur.");
                }
            }
        } catch (Exception $e) {
            render('user/admin', ['pageTitle' => 'Espace administrateur', 'teams' => $teams, 'errorMessage' => $e->getMessage()]);
        }
    }
}