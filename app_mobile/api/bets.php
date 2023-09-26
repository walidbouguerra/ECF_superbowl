<?php

 // Détermine le statut d'un match
function gameStatus($start_time, $end_time): string
{
    if($end_time) {
        return 'Terminé';
    } elseif(date("Y-m-d H:i:s") > $start_time){
        return 'En cours';
    } else {
        return 'À venir';
    } 
}

function findAllBetsByUserId(pdo $pdo, int $id_user): array {
    $query = $pdo->prepare("SELECT *, t1.name AS t1_name, t2.name AS t2_name, t3.name AS t3_name, DATE_FORMAT(start_time, '%Hh%i') AS start, DATE_FORMAT(end_time, '%Hh%i') AS end, DATE_FORMAT(start_time, '%d/%m/%Y') AS game_date, DATE_FORMAT(bet.date, '%d/%m/%Y %Hh%i') AS date_mise, (profits + losses) AS earnings 
        FROM bet 
        JOIN game ON bet.id_game = game.id_game
        JOIN team t1 ON game.id_team1 = t1.id_team
        JOIN team t2 ON game.id_team2 = t2.id_team
        JOIN team t3 ON bet.id_team = t3.id_team
        WHERE bet.id_user = :id_user
        ORDER BY start_time ASC;");
    $query->execute([":id_user" => $id_user]);
    $bets = $query->fetchAll();
    foreach ($bets as $i => $bet) {
        $bets[$i]['gameStatus'] = gameStatus($bet['start_time'], $bet['end_time']);
    }
    return $bets;
}

function findAllCommentsByIdGame(int $id): array
{
    $query = "SELECT * FROM comment WHERE id_game = $id;";
    $query = $this->pdo->query($query);
    return $query->fetchAll();
   
}