<?php

class BetController {
    protected $model;
    protected $gameModel;

    public function __construct() {
        $this->model = new BetModel();
        $this->gameModel = new GameModel();
    }
    
    // Afficher un pari
    public function show(int $id): void
    {
        try {
            if (!empty($_SESSION['user']['id_user'])) {
                $id_game = $id;
                $game = $this->gameModel->findOneGameById($id_game);
                $id_user = $_SESSION['user']['id_user'];
                // Vérifier si le pari existe déjà pour un utilisateur
                $bet = $this->model->betExist($id_game, $id_user);
                if (!empty($bet)) {
                    $action = "update";
                } else {
                    $action = "add";
                }
                if (!empty($game)) {
                    render('bet/betshow', ['pageTitle' => $game['t1_name'] . ' vs ' . $game['t2_name'], 'game' => $game, 'action' => $action]);
                } else {
                    throw new Exception("Match introuvable.");
                }
            } else {
                throw new Exception("Match introuvable.");
            }
        } catch (Exception $e) {
            render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Ajouter un pari
    public function add(int $id) : void
    {   
        try {
            if (!empty($_POST['id_team']) && !empty($_POST['amount']) && !empty($_SESSION['user']['id_user'])) {
                $id_game = $id;
                $id_team = htmlspecialchars($_POST['id_team']);
                $amount = htmlspecialchars($_POST['amount']);
                $id_user = $_SESSION['user']['id_user'];
                $this->model->addBet($id_game, $id_team, $amount, $id_user);
                render('alert', ['pageTitle' => 'Pari ajouté', 'successMessage' => 'Le pari a bien été ajouté.']);
            } else {
                throw new Exception("Impossible d'ajouter le pari.");
            }
        } catch (Exception $e) {
            render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
        }   
    }

    // Modifier un pari
    public function update(int $id) : void
    {  
        try {
            if (!empty($_POST['id_team']) && !empty($_SESSION['user']['id_user'])) {
                $id_game = $id;
                $id_team = htmlspecialchars($_POST['id_team']);
                $amount = htmlspecialchars($_POST['amount']);
                $id_user = $_SESSION['user']['id_user'];
                if ($amount == 0) {
                    $this->model->delete($id_game, $id_user);
                    render('alert', ['pageTitle' => 'Paris supprimés', 'successMessage' => 'Les paris ont bien été supprimés.']);
                } else {
                    $this->model->update($id_game, $id_team, $amount, $id_user);
                    render('alert', ['pageTitle' => 'Pari modifié', 'successMessage' => 'Le pari a bien été modifié.']);
                }
            } else {
                throw new Exception("Impossible de modifier le pari.");
            }
        } catch (Exception $e) {
            render('alert', ['pageTitle' => 'Error', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Supprimer un pari
    public function delete(int $id): void
    {
        try {
            if (!empty($_SESSION['user']['id_user'])) {
                $id_user = $_SESSION['user']['id_user'];
                $id_game = $id;
                $this->model->delete($id_game, $id_user);
                $bets = $this->model->findAllBetsByUserId($id_user);
                render('user/dashboard', ['pageTitle' => 'Mon espace', 'bets' => $bets, 'successMessage' => 'Pari supprimé avec succès.']);
            
            } else {
                throw new Exception("Vous devez être connecté pour effectuer cette action.");
            }
        } catch (Exception $e) {
            render('user/dashboard', ['pageTitle' => 'Mon espace', 'bets' => $bets, 'errorMessage' => $e->getMessage()]);
        }
    }    

    // Afficher une liste de paris à effectuer
    public function list(): void
    {
        try {
            if (!empty($_POST['id_games'])) {
                $games = $this->gameModel->findAllGamesById($_POST['id_games']);
                if (!empty($games)) {
                    render('bet/betlist', ['pageTitle' => 'Parier', 'games' => $games]);
                } else {
                    throw new Exception("Aucun match trouvé.");
                }
            } else {
                throw new Exception("Aucun match trouvé.");
            }
        } catch (\Throwable $th) {
            render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Ajouter une liste de paris
    public function addlist(): void
    {
        try {     
            if (!empty($_POST['id_team']) && !empty($_POST['amount']) && !empty($_POST['id_game']) && !empty($_SESSION['user']['id_user'])) {
                $id_team = $_POST['id_team'];
                $amount = $_POST['amount'];
                $id_game = $_POST['id_game'];
                $id_user = $_SESSION['user']['id_user'];
                for ($i=0; $i < count($id_game); $i++) {
                    $bet = $this->model->betExist($id_game[$i], $id_user); 
                    if (!empty($bet)) {
                        if ($amount[$i] == 0) {
                            $this->model->delete($id_game[$i], $id_user);
                        } else {
                            $this->model->update($id_game[$i], $id_team[$id_game[$i]], $amount[$i], $id_user);
                        }
                    } else {
                        $this->model->addBet($id_game[$i], $id_team[$id_game[$i]], $amount[$i], $id_user);
                    }
                }
                render('alert', ['pageTitle' => 'Succès', 'successMessage' => 'Les actions sur les paris ont bien été enregistrés.']);
            }   
            else {
                throw new Exception("Impossible d'ajouter les paris.");
            }
        } catch (Exception $e) {
            render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
        }
    }


}