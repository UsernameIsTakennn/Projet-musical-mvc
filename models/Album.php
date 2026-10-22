<?php

namespace App\Models;
use App\Models\CRUD;

class Album extends CRUD{
    protected $table = 'album';
    protected $primaryKey = 'id';
    protected $fillable = ['titre', 'date_sortie', 'description', 'artiste_id'];

    public function obtenirChansons(int $albumId): array
    {
        $sql = "SELECT chanson.*
            FROM chanson
            WHERE chanson.album_id = :album_id
            ORDER BY chanson.titre";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':album_id', $albumId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}