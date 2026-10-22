<?php

namespace App\Models;
use App\Models\CRUD;

class Genre extends CRUD {
    protected $table = 'genre';
    protected $primaryKey = 'id';
    protected $fillable = ['nom'];


    public function ajouterChanson(int $chansonId, int $genreId): bool
    {
        $sql = "INSERT INTO chanson_genre (chanson_id, genre_id)
            VALUES (:chanson_id, :genre_id)";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':chanson_id', $chansonId, \PDO::PARAM_INT);
        $stmt->bindValue(':genre_id', $genreId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function obtenirChansons(int $genreId): array
    {
        $sql = "SELECT chanson.*
            FROM chanson
            INNER JOIN chanson_genre
                ON chanson.id = chanson_genre.chanson_id
            WHERE chanson_genre.genre_id = :genre_id
            ORDER BY chanson.titre";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':genre_id', $genreId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}