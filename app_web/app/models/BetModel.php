<?php

class BetModel extends Model
{

    public function addBet(int $id_game, int $id_team, int $amount, int $id_user): void
    {   try {
            $query = $this->pdo->prepare("INSERT INTO bet SET bet.id_game = :id, bet.id_team = :id_team, bet.amount = :amount , bet.id_user = :id_user;");
            $query->execute([
                ':id' => $id_game,
                ':id_team' => $id_team,
                ':amount' => $amount,
                ':id_user' => $id_user
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    public function update(int $id, int $id_team, int $amount, int $id_user): void
    {
        try {
            $query = $this->pdo->prepare("UPDATE bet SET bet.id_team = :id_team, bet.amount = :amount, date = :date WHERE id_game = :id;");
            $query->execute([
                ':id' => $id,
                ':id_team' => $id_team,
                ':amount' => $amount,
                ':date' => date("Y-m-d H:i:s")
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        } 
    }

    public function delete(int $id_game, int $id_user): void
    {
        try {
            $query = "DELETE FROM bet WHERE id_game = :id_game AND id_user = :id_user;";
            $query = $this->pdo->prepare($query);
            $query->execute([
                ':id_game' => $id_game,
                ':id_user' => $id_user
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    public function findAllBetsByUserId(int $id_user): array {
        $query = $this->pdo->query("SELECT *, t1.name AS t1_name, t2.name AS t2_name, DATE_FORMAT(start_time, '%Hh%i') AS start, DATE_FORMAT(end_time, '%Hh%i') AS end, DATE_FORMAT(start_time, '%d/%m/%Y') AS game_date, DATE_FORMAT(bet.date, '%d/%m/%Y %Hh%i') AS date_mise, (profits + losses) AS earnings 
            FROM bet 
            JOIN game ON bet.id_game = game.id_game
            JOIN team t1 ON game.id_team1 = t1.id_team
            JOIN team t2 ON game.id_team2 = t2.id_team
            WHERE bet.id_user = $id_user
            ORDER BY start_time ASC;");
        $bets = $query->fetchAll();
        foreach ($bets as $i => $bet) {
            $bets[$i]['gameStatus'] = GameModel::gameStatus($bet['start_time'], $bet['end_time']);
        }
        return $bets;
    }

    public function betExist(int $id_game, $id_user): array
    {
        try {
            $query = "SELECT * FROM bet WHERE id_game = :id_game AND id_user = :id_user;";
            $query = $this->pdo->prepare($query);
            $query->execute([
                ':id_game' => $id_game,
                ':id_user' => $id_user
            ]);
            $bet = $query->fetch();
            if (!empty($bet)) {
                return $bet;
            } else {
                return [];
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }
}