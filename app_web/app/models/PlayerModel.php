<?php

class PlayerModel extends Model
{
    public function findAllPlayersByIdTeam(int $id): array
    {
        try {
            $query = "SELECT * FROM player WHERE id_team = $id;";
            $query = $this->pdo->query($query);
            return $query->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données");     
        }
    }

    public function addPlayer(string $name, string $first_name, int $number, int $id_team) : void
    {
        try {
            $query = $this->pdo->prepare("INSERT INTO player (id_player, name, first_name, id_team) VALUES (:number, :name, :first_name, :id_team);");
            $query->execute([
                'number' => $number,
                ':name' => $name,
                ':first_name' => $first_name,
                ':id_team' => $id_team
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données");     
        }
    }
}