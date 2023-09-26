<?php

class UserController
{
    protected $model;
    protected $betModel;
    protected $teamModel;

    public function __construct() {
        $this->model = new UserModel();
        $this->betModel = new BetModel();
        $this->teamModel = new TeamModel();
    }

    // Afficher la page de connexion
    public function login(): void
    {
        render('user/login', ['pageTitle' => 'Se connecter']);
    }

    // Afficher la page d'inscription
    public function signup(): void
    {
        render('user/signup', ['pageTitle' => 'S\'inscrire']);
    }

    // Déconnecter l'utilisateur
    public function logout(): void
    {
        session_unset();
        header('Location: index.php?game/home');
    }

    // Afficher la page pour demander la réinitialisation de son mot de passe
    public function resetpassword(): void
    {
        render('user/resetpassword', ['pageTitle' => 'Mot de passe oublié']);
    }

    // Vérifier que l'e-mail et le mot de passe sont corrects pour se connecter
    public function loginverif(): void
    {
        try {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $this->model->loginVerif($email, $password);
                if (!empty($_SESSION['user'])) {
                    header('Location: index.php?user/dashboard');
                } else {
                    throw new Exception("E-mail ou mot de passe incorrects.");
                }
            } else {
                throw new Exception("E-mail ou mot de passe manquants.");
            }
        } catch (Exception $e) {
            render('user/login', ['pageTitle' => 'Se connecter', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Afficher l'espace utilisateur
    public function dashboard(): void
    {
        try {
            if (!empty($_SESSION['user'])) {
                $id_user = $_SESSION['user']['id_user'];
                if ($_SESSION['user']['role'] == 'admin') {
                    $teams = $this->teamModel->findAllTeams();
                    render('user/admin', ['pageTitle' => 'Espace administrateur', 'teams' => $teams]);
                } elseif ($_SESSION['user']['role'] == 'user') {
                    $bets = $this->betModel->findAllBetsByUserId($id_user);
                    render('user/dashboard', ['pageTitle' => 'Mon espace', 'bets' => $bets]);
                }
            } else {
                throw new Exception("Vous devez être connecté.");
            }
        } catch (Exception $e) {
            render('user/login', ['pageTitle' => 'Se connecter','errorMessage' => $e->getMessage()]);
        }
    }

    // Afficher la page de confirmation d'inscription
    public function signupconfirm(): void
    {
        render('user/signupconfirm', ['pageTitle' => 'Créer un mot de passe']);
    }

    // Inscrire un utilisateur
    public function add() : void
    {   try { 
            if (!empty($_POST['name']) && !empty($_POST['first_name']) && !empty($_POST['email'])) {
                $name = htmlspecialchars($_POST['name']);
                $first_name = htmlspecialchars($_POST['first_name']);
                $email = htmlspecialchars($_POST['email']);
                $this->model->addUser($name, $first_name, $email);
                render('user/login', ['pageTitle' => 'Se connecter', 'successMessage' => 'Vous avez reçu un mail pour confirmer votre inscription.']);
            
            } else {
                throw new Exception("Impossible de vous inscrire.");    
            }
        } catch (Exception $e) {
            render('user/login', ['pageTitle' => 'Se connecter', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Confirmer l'inscription d'un utilisateur
    public function tokenverif(int $id, string $token): void
    {
        try {
            if (!empty($token) && !empty($id)) {
                if ($this->model->tokenVerif($id, $token)) {
                    render('user/newpassword', ['pageTitle' => 'Nouveau mot de passe', 'id' => $id]);
                } else {
                    throw new Exception("Lien expiré.");  
                }
            } else {
                throw new Exception("Lien expiré.");  
            }
            
        } catch (Exception $e) {
            render('user/login', ['pageTitle' => 'Se connecter', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Ajouter un mot de passe à l'utilisateur
    public function addpassword(): void
    {
        try {
            if (!empty($_POST['id']) && !empty($_POST['password'])) {
                $id_user = htmlspecialchars($_POST['id']);
                $password = htmlspecialchars($_POST['password']);
                $this->model->addPassword($id_user, $password);
                render('user/login', ['pageTitle' => 'Se connecter', 'successMessage' => 'Votre nouveau mot de passe a bien été créé.']);
            } else {
                throw new Exception("Une erreur est survenue, veuillez réessayer.");
            }
        } catch (Exception $e) {
            render('user/login', ['pageTitle' => 'Se connecter', 'errorMessage' => $e->getMessage()]);
        }
    }

    // Envoyer un mail pour réinitialiser le mot de passe
    public function newpassword(): void
    {
        try {
            if (!empty($_POST['name']) && !empty($_POST['first_name']) && !empty($_POST['email'])) {
                $name = htmlspecialchars($_POST['name']);
                $first_name = htmlspecialchars($_POST['first_name']);
                $email = htmlspecialchars($_POST['email']);
                $this->model->newPassword($name, $first_name, $email);
                render('user/login', ['pageTitle' => 'Se connecter', 'successMessage' => 'Vous avez reçu un mail pour réinitialiser votre mot de passe.']);
            } else {
                throw new Exception("Veuillez remplir tous les champs pour réinitialiser votre mot de passe.");
            }
        } catch (Exception $e) {
            render('user/login', ['pageTitle' => 'Se connecter', 'errorMessage' => $e->getMessage()]);
        }
    }
}