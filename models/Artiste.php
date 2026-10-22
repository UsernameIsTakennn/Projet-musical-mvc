<?php

namespace App\Models;
use App\Models\CRUD;

class Artiste extends CRUD {
    protected $table = 'artiste';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'pays', 'date_naissance', 'biographie'];

    public function obtenirAlbums(int $artisteId): array
    {
        $sql = "SELECT album.*
            FROM album
            WHERE album.artiste_id = :artiste_id
            ORDER BY album.titre";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':artiste_id', $artisteId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}