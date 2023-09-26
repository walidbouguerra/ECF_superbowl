<?php

class GameController {
    protected $model;
    protected $playerModel;
    protected $commentModel;
    protected $teamModel;

    public function __construct() {
        $this->model = new GameModel();
        $this->playerModel = new PlayerModel();
        $this->commentModel = new CommentModel();
        $this->teamModel = new TeamModel();
    }
    
    // Affiche la page d'accueil
    public function home(): void
    {
        try {
            $games = $this->model->findAllGamesToday();
            if (!empty($games)) {
                render('home', ['pageTitle' => 'Accueil', 'games' => $games]);
            } else {
                throw new Exception("Pas de matchs aujourd'hui.");
            }
        } catch (Exception $e) {
            render('home', ['pageTitle' => 'Accueil', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Affiche la page de la liste des matchs
    public function list(): void
    {
        try {
            $games = $this->model->findAllGames();
            if (!empty($games)) {
                render('game/gamelist', ['pageTitle' => 'Matchs', 'games' => $games]);
            } else {
                throw new Exception("Pas de matchs.");
            }
        } catch (Exception $e) {
            render('game/gamelist', ['pageTitle' => 'Matchs', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Affiche un match
    public function show(int $id): void
    {
        try {
            $game = $this->model->findOneGameById($id);
            if (!empty($game)) {
                $game['players_1'] = $this->playerModel->findAllPlayersByIdTeam($game['id_team1']);
                $game['players_2'] = $this->playerModel->findAllPlayersByIdTeam($game['id_team2']);
                $game['comments'] = $this->commentModel->findAllCommentsByIdGame($game['id_game']);
                render('game/gameshow', ['pageTitle' => $game['t1_name'] . ' vs ' . $game['t2_name'], 'game' => $game]);
            } else {
                throw new Exception("Match introuvable.");
            }
            
        } catch (Exception $e) {
            render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Affiche une liste de matchs à sélectionner
    public function select(): void
    {
        try {
            $games = $this->model->findAllGames();
            if (!empty($games)) {
                foreach ($games as $i => $game) {
                    if ($game['status'] != "À venir") {
                        unset($games[$i]);
                    };
                }
                render('game/gameselection', ['pageTitle' => 'Parier', 'games' => $games]);
            } else {
                throw new Exception("Pas de matchs.");
            }
        } catch (Exception $e) {
            render('game/gameselection', ['pageTitle' => 'Parier', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Ajout d'un match
    public function add() : void
    {
        try {
            if (empty($_SESSION['user']['role'] == 'admin')) {
                throw new Exception("Vous devez être administrateur pour effectuer cette action.");
            } else {
                $teams = $this->teamModel->findAllTeams();
                if (isset($_POST['idTeam1']) && isset($_POST['odds1']) && isset($_POST['idTeam2']) && isset($_POST['odds2']) && !empty($_POST['date'])) {
                    $idTeam1 = htmlspecialchars($_POST['idTeam1']);
                    $odds1 = htmlspecialchars($_POST['odds1']);
                    $idTeam2 = htmlspecialchars($_POST['idTeam2']);
                    $odds2 = htmlspecialchars($_POST['odds2']);
                    $date = htmlspecialchars($_POST['date']);
                    if ($idTeam1 == $idTeam2) {
                        throw new Exception("Vous devez choisir deux équipes différentes pour créer un match.");
                    }
                    // Envoi des données au modèle
                    $this->model->addGame($idTeam1, $odds1, $idTeam2, $odds2, $date);
                    render('user/admin', ['pageTitle' => 'Espace administrateur','teams' => $teams, 'successMessage' => 'Match ajouté avec succès.']);
                } else {
                    throw new Exception("Veuillez remplir tous les champs pour ajouter un match.");
                }
            }
        } catch (Exception $e) {
            render('user/admin', ['pageTitle' => 'Espace administrateur', 'teams' => $teams, 'errorMessage' => $e->getMessage()]);
        }
    }
}