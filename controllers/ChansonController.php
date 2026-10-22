<?php

namespace App\Controllers;

use App\Models\Chanson;
use App\Models\Album;
use App\Models\Genre;
use App\Providers\View;
use App\Providers\Validator;

class ChansonController{
    public function index() {
        $chanson = new Chanson;
        $chansons = $chanson->select('titre');

        return View::render('chanson/index', [
            'chansons' => $chansons
        ]);
    }

    public function create()
    {
        $album = new Album;
        $albums = $album->select('titre');

        $genre = new Genre;
        $genres = $genre->select('nom');

        $chanson = [
            'titre' => '',
            'duration' => '',
            'date_sortie' => '',
            'album_id' => ''
        ];

        return View::render('chanson/create', [
            'chanson' => $chanson,
            'albums' => $albums,
            'genres' => $genres
        ]);
    }

    public function show($data = [])
    {
        if (isset($data['id'])) {
            $chanson = new Chanson;
            $chansonInfo = $chanson->selectId($data['id']);

            if ($chansonInfo) {
                $genres = $chanson->obtenirGenres((int) $data['id']);

                return View::render('chanson/show', [
                    'chanson' => $chansonInfo,
                    'genres' => $genres
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Chanson introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }

    public function store(array $data)
    {
        $titre = '';
        $duration = '';
        $date_sortie = '';
        $album_id = '';
        $genre_id = '';

        if (isset($data['titre'])) $titre = trim($data['titre']);
        if (isset($data['duration'])) $duration = trim($data['duration']);
        if (isset($data['date_sortie'])) $date_sortie = trim($data['date_sortie']);
        if (isset($data['album_id'])) $album_id = $data['album_id'];
        if (isset($data['genre_id'])) $genre_id = $data['genre_id'];

        $data = [
            'titre' => $titre,
            'duration' => $duration,
            'date_sortie' => $date_sortie,
            'album_id' => $album_id
        ];

        $val = new Validator;
        $val->field('titre', $data['titre'], 'titre')->required()->min(2)->max(100);
        $val->field('date_sortie', $data['date_sortie'], 'date de sortie')->date();

        if ($val->isSuccess()) {
            if (empty($data['duration'])) $data['duration'] = null;
            if (empty($data['date_sortie'])) $data['date_sortie'] = null;
            if (empty($data['album_id'])) $data['album_id'] = null;

            $chanson = new Chanson;
            $insert = $chanson->insert($data);

            if ($insert) {
                if ($genre_id !== '') {
                    $genre = new Genre;
                    $genre->ajouterChanson((int) $insert, (int) $genre_id);
                }

                return View::redirect('chanson/show?id=' . $insert);
            } else {
                $album = new Album;
                $albums = $album->select('titre');

                $genre = new Genre;
                $genres = $genre->select('nom');

                return View::render('chanson/create', [
                    'chanson' => $data,
                    'albums' => $albums,
                    'genres' => $genres,
                    'errors' => [
                        'general' => "Erreur lors de l'ajout de la chanson."
                    ]
                ]);
            }
        } else {
            $album = new Album;
            $albums = $album->select('titre');

            $genre = new Genre;
            $genres = $genre->select('nom');

            return View::render('chanson/create', [
                'chanson' => $data,
                'albums' => $albums,
                'genres' => $genres,
                'errors' => $val->getErrors()
            ]);
        }
    }

    public function edit($data = [])
    {
        if (isset($data['id'])) {
            $chanson = new Chanson;
            $chansonInfo = $chanson->selectId($data['id']);

            if ($chansonInfo) {
                $album = new Album;
                $albums = $album->select('titre');

                $genre = new Genre;
                $genres = $genre->select('nom');

                return View::render('chanson/edit', [
                    'chanson' => $chansonInfo,
                    'albums' => $albums,
                    'genres' => $genres
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Chanson introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }

    public function update(array $data)
    {
        $id = '';
        $titre = '';
        $duration = '';
        $date_sortie = '';
        $album_id = '';
        $genre_id = '';

        if (isset($data['id'])) $id = $data['id'];
        if (isset($data['titre'])) $titre = trim($data['titre']);
        if (isset($data['duration'])) $duration = trim($data['duration']);
        if (isset($data['date_sortie'])) $date_sortie = trim($data['date_sortie']);
        if (isset($data['album_id'])) $album_id = $data['album_id'];
        if (isset($data['genre_id'])) $genre_id = $data['genre_id'];

        $chanson = new Chanson;
        $chansonInfo = $chanson->selectId($id);

        if (!$chansonInfo) {
            return View::render('error', [
                'msg' => 'Chanson introuvable.'
            ]);
        }

        $data = [
            'titre' => $titre,
            'duration' => $duration,
            'date_sortie' => $date_sortie,
            'album_id' => $album_id
        ];

        $val = new Validator;
        $val->field('titre', $data['titre'], 'titre')->required()->min(2)->max(100);
        $val->field('date_sortie', $data['date_sortie'], 'date de sortie')->date();

        if ($val->isSuccess()) {
            if (empty($data['duration'])) $data['duration'] = null;
            if (empty($data['date_sortie'])) $data['date_sortie'] = null;
            if (empty($data['album_id'])) $data['album_id'] = null;

            $update = $chanson->update($data, $id);

            if ($update) {
                $genre = new Genre;

                // Supprimer les anciennes associations de genres.
                $genre->delete('chanson_genre', $id, 'chanson_id');

                // Ajouter le genre sélectionné, s'il y en a un.
                if (!empty($genre_id)) {
                    $genre->ajouterChanson((int) $id, (int) $genre_id);
                }

                return View::redirect('chanson/show?id=' . $id);
            } else {
                $album = new Album;
                $albums = $album->select('titre');

                $genre = new Genre;
                $genres = $genre->select('nom');

                return View::render('chanson/edit', [
                    'chanson' => array_merge($data, ['id' => $id]),
                    'albums' => $albums,
                    'genres' => $genres,
                    'errors' => [
                        'general' => "Erreur lors de la modification de la chanson."
                    ]
                ]);
            }
        } else {
            $album = new Album;
            $albums = $album->select('titre');

            $genre = new Genre;
            $genres = $genre->select('nom');

            return View::render('chanson/edit', [
                'chanson' => array_merge($data, ['id' => $id]),
                'albums' => $albums,
                'genres' => $genres,
                'errors' => $val->getErrors()
            ]);
        }
    }

    public function delete(array $data) {
        if (isset($data['id'])) {
            $chanson = new Chanson;
            $chansonInfo = $chanson->selectId($data['id']);

            if ($chansonInfo) {
                $chanson->delete('chanson_genre', $data['id'], 'chanson_id');

                $delete = $chanson->delete('chanson', $data['id']);

                if ($delete) {
                    return View::redirect('chansons');
                } else {
                    return View::render('error', [
                        'msg' => "Erreur lors de la suppression de la chanson."
                    ]);
                }
            } else {
                return View::render('error', [
                    'msg' => 'Chanson introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }
}
