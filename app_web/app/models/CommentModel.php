<?php

class CommentModel extends Model
{
    public function findAllCommentsByIdGame(int $id): array
    {
        try {
            $query = "SELECT * FROM comment WHERE id_game = $id;";
            $query = $this->pdo->query($query);
            return $query->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données");     
        }
    }
}