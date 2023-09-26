<?php

class GameModel extends Model{
    
    public function findAllGamesToday(): array
    {
        try {
            $query = "SELECT game.id_game, t1.name AS t1_name, t2.name AS t2_name, DATE_FORMAT(start_time, '%Hh%i') AS game_date
            FROM game
            JOIN team t1 ON game.id_team1 = t1.id_team
            JOIN team t2 ON game.id_team2 = t2.id_team
            WHERE DATE(start_time) = CURDATE();";
            $query = $this->pdo->query($query);
            return $query->fetchAll();
        } catch (PDOException $dbError) {
            throw new Exception("Erreur de la base de données.");
        }
    }
    
    public function findOneGameById(int $id): array
    {
        try {
            $query = $this->pdo->prepare("SELECT *, t1.name AS t1_name, t2.name AS t2_name, DATE_FORMAT(end_time, '%Hh%i') AS end, DATE_FORMAT(start_time, '%d/%m/%Y - %Hh%i') AS game_date
            FROM game
            JOIN team t1 ON game.id_team1 = t1.id_team
            JOIN team t2 ON game.id_team2 = t2.id_team
            WHERE game.id_game = :id;");
            $query->execute(['id' => $id]);
            $game = $query->fetch();
            $game['status'] = $this->gameStatus($game['start_time'], $game['end_time']);
            return $game;
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    public function findAllGames(): array
    {
        try {
            $query = "SELECT *, t1.name AS t1_name, t2.name AS t2_name, DATE_FORMAT(start_time, '%d/%m/%Y - %Hh%i') AS game_date
            FROM game
            JOIN team t1 ON game.id_team1 = t1.id_team
            JOIN team t2 ON game.id_team2 = t2.id_team";
            $query = $this->pdo->query($query);
            $games = $query->fetchAll();
            foreach ($games as $i => $game) {
                $games[$i]['status'] = $this->gameStatus($game['start_time'], $game['end_time']);
            }
            return $games;
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }
    
    public function findAllGamesById(array $id_games): array
    {
        try {
            $query = "SELECT *, t1.name AS t1_name, t2.name AS t2_name, DATE_FORMAT(start_time, '%d/%m/%Y - %Hh%i') AS game_date
            FROM game
            JOIN team t1 ON game.id_team1 = t1.id_team
            JOIN team t2 ON game.id_team2 = t2.id_team
            WHERE id_game IN (".implode(',', $id_games).")";
            $query = $this->pdo->query($query);
            return $query->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    // Détermine le statut d'un match
    public static function gameStatus($start_time, $end_time): string
    {
        if($end_time) {
            return 'Terminé';
        } elseif(date("Y-m-d H:i:s") > $start_time){
            return 'En cours';
        } else {
            return 'À venir';
        } 
    }
    
    // Ajout d'un match
    public function addGame(int $id_team1, float $odds_1, int $id_team2, float $odds_2, string $date) : void
    {   
        try {
            $query = $this->pdo->prepare("INSERT INTO game (id_team1, odds_1, id_team2, odds_2, start_time) VALUES (:id_team1, :odds_1, :id_team2, :odds_2, :date);");
            $query->execute([
                ':id_team1' => $id_team1,
                ':odds_1' => $odds_1,
                ':id_team2' => $id_team2,
                ':odds_2' => $odds_2,
                ':date' => $date
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");   
        }   
    } 
}