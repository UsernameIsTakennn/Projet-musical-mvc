<?php

namespace App\Controllers;

use App\Models\Genre;
use App\Models\Chanson;
use App\Providers\View;
use App\Providers\Validator;

class GenreController{
    public function index() {
        $genre = new Genre;
        $genres = $genre->select('nom');

        return View::render('genre/index', [
            'genres' => $genres
        ]);
    }


    public function create()
    {
        $genre = [
            'nom' => ''
        ];

        $chanson = new Chanson;
        $chansons = $chanson->select('titre');

        return View::render('genre/create', [
            'genre' => $genre,
            'chansons' => $chansons
        ]);
    }


    public function show($data = [])
    {
        if (isset($data['id'])) {
            $genre = new Genre;
            $genreInfo = $genre->selectId($data['id']);

            if ($genreInfo) {
                $chansons = $genre->obtenirChansons((int) $data['id']);

                return View::render('genre/show', [
                    'genre' => $genreInfo,
                    'chansons' => $chansons
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Genre introuvable.'
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
        $nom = '';

        if (isset($data['nom'])) {
            $nom = trim($data['nom']);
        }

        $chansonId = $data['chanson_id'] ?? '';

        $genreData = [
            'nom' => $nom
        ];

        $val = new Validator;
        $val->field('nom', $genreData['nom'], 'nom')
            ->required()
            ->min(2)
            ->max(100);

        if ($val->isSuccess()) {
            $genre = new Genre;
            $insert = $genre->insert($genreData);

            if ($insert) {
                if ($chansonId !== '') {
                    $genre->ajouterChanson(
                        (int) $chansonId,
                        (int) $insert
                    );
                }

                return View::redirect('genre/show?id=' . $insert);
            } else {
                $chanson = new Chanson;
                $chansons = $chanson->select('titre');

                return View::render('genre/create', [
                    'genre' => $genreData,
                    'chansons' => $chansons,
                    'errors' => [
                        'general' => "Erreur lors de l'ajout du genre."
                    ]
                ]);
            }
        } else {
            $chanson = new Chanson;
            $chansons = $chanson->select('titre');

            return View::render('genre/create', [
                'genre' => $genreData,
                'chansons' => $chansons,
                'errors' => $val->getErrors()
            ]);
        }
    }


    public function edit($data = [])
    {
        if (isset($data['id'])) {
            $genre = new Genre;
            $genreInfo = $genre->selectId($data['id']);

            if ($genreInfo) {
                $chanson = new Chanson;
                $chansons = $chanson->select('titre');

                return View::render('genre/edit', [
                    'genre' => $genreInfo,
                    'chansons' => $chansons
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Genre introuvable.'
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
        $id = $data['id'] ?? null;

        if ($id === null) {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }

        $genre = new Genre;
        $genreInfo = $genre->selectId($id);

        if (!$genreInfo) {
            return View::render('error', [
                'msg' => 'Genre introuvable.'
            ]);
        }

        $nom = trim($data['nom'] ?? '');
        $chansonId = $data['chanson_id'] ?? '';

        $genreData = [
            'nom' => $nom
        ];

        $val = new Validator;
        $val->field('nom', $nom, 'nom')
            ->required()
            ->min(2)
            ->max(100);

        if (!$val->isSuccess()) {
            $chanson = new Chanson;
            $chansons = $chanson->select('titre');

            return View::render('genre/edit', [
                'genre' => array_merge($genreInfo, $genreData, [
                    'id' => $id,
                    'chanson_id' => $chansonId
                ]),
                'chansons' => $chansons,
                'errors' => $val->getErrors()
            ]);
        }

        $update = $genre->update($genreData, $id);

        if (!$update) {
            return View::render('error', [
                'msg' => 'Erreur lors de la modification du genre.'
            ]);
        }

        // Supprimer l'ancienne association du genre.
        $genre->delete('chanson_genre', $id, 'genre_id');

        // Ajouter la nouvelle association si une chanson est sélectionnée.
        if ($chansonId !== '') {
            $genre->ajouterChanson((int) $chansonId, (int) $id);
        }

        return View::redirect('genre/show?id=' . $id);
    }




    public function delete(array $data) {
        if (isset($data['id'])) {
            $genre = new Genre;
            $genreInfo = $genre->selectId($data['id']);

            if ($genreInfo) {
                $delete = $genre->delete('genre', $data['id']);

                if ($delete) {
                    return View::redirect('genres');
                } else {
                    return View::render('error', [
                        'msg' => 'Erreur lors de la suppression du genre.'
                    ]);
                }
            } else {
                return View::render('error', [
                    'msg' => 'Genre introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }
}
