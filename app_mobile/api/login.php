<?php

require_once 'database.php';
require_once 'bets.php';

// Récupération des données
$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$data = [];

// Vérification des informations de connexion
if (!empty($obj["email"]) && !empty($obj["password"])) {
    $email = $obj["email"];
    $password = $obj["password"];

    $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $query->execute([":email" => $email]);
    $user = $query->fetch();

    if (!empty($user)) {
        if (password_verify($password, $user['password'])) {
            $data["success"] = true;
            $data["user"] = $user;
            $data["bets"] = findAllBetsByUserId($pdo, $user['id_user']);
        } else {
            $data["success"] = false;
            $data["message"] = "Mot de passe incorrect.";
        }
    } else {
        $data["success"] = false;
        $data["message"] = "Utilisateur introuvable.";
    }
} else {
    $data["success"] = false;
    $data["message"] = "E-mail ou mot de passe vides.";
}


header('Content-Type: application/json');
// Envoi des données
echo json_encode($data);
