<?php

require_once 'database.php';

// Récupération des données
$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$data = [];

function findAllCommentsByIdGame(pdo $pdo, int $id): array
{
    $query = "SELECT * FROM comment WHERE id_game = $id;";
    $query = $pdo->query($query);
    return $query->fetchAll();
}

function findScore1(pdo $pdo, int $id): array
{
    $query = "SELECT score_1 FROM game WHERE id_game = $id;";
    $query = $pdo->query($query);
    return $query->fetch();
}

function findScore2(pdo $pdo, int $id): array
{
    $query = "SELECT score_2 FROM game WHERE id_game = $id;";
    $query = $pdo->query($query);
    return $query->fetch();
}

$data["comments"] = findAllCommentsByIdGame($pdo, $obj['id_game']);
$data["score_1"] = findScore1($pdo, $obj['id_game']);
$data["score_2"] = findScore2($pdo, $obj['id_game']);

header('Content-Type: application/json');
// Envoi des données
echo json_encode($data);
