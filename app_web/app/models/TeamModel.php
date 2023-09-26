<?php

class TeamModel extends Model
{
    public function findAllTeams(): array
    {
        try {
            $query = "SELECT * FROM team;";
            $query = $this->pdo->query($query);
            return $query->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données");     
        }
    }

    // Ajout d'une équipe
    public function addTeam(string $name, string $country) : void
    {
        try {
            $query = $this->pdo->prepare("INSERT INTO team SET name = :name, country = :country;");
            $query->execute([
                ':name' => $name,
                ':country' => $country
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données");
        }
    }
}