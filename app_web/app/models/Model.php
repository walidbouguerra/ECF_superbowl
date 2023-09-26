<?php

abstract class Model
{
    protected PDO $pdo;

    public function __construct() {
        try {
            // Connexion à la base de donnée
            $this->pdo = new PDO('mysql:host=localhost;dbname=superbowl;charset=utf8', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données");   
        }
    }
}