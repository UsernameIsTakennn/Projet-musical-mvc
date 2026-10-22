<?php

namespace App\Models;
use App\Models\CRUD;

class Chanson extends CRUD {
    protected $table = 'chanson';
    protected $primaryKey = 'id';
    protected $fillable = ['titre', 'duration', 'date_sortie', 'album_id'];

    public function obtenirGenres(int $chansonId): array
    {
        $sql = "SELECT genre.*
            FROM genre
            INNER JOIN chanson_genre
                ON genre.id = chanson_genre.genre_id
            WHERE chanson_genre.chanson_id = :chanson_id
            ORDER BY genre.nom";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':chanson_id', $chansonId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}