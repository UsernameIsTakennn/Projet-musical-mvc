<?php

namespace App\Controllers;

use App\Models\Album;
use App\Models\Artiste;
use App\Models\Chanson;
use App\Providers\View;
use App\Providers\Validator;

class AlbumController{
    public function index() {
        $album = new Album;
        $albums = $album->select('titre');

        return View::render('album/index', [
            'albums' => $albums
        ]);
    }

    public function create() {
        $artiste = new Artiste;
        $artistes = $artiste->select('nom');

        $album = [
            'titre' => '',
            'date_sortie' => '',
            'description' => '',
            'artiste_id' => ''
        ];

        return View::render('album/create', [
            'album' => $album,
            'artistes' => $artistes
        ]);
    }

    public function show($data = [])
    {
        if (isset($data['id'])) {
            $album = new Album;
            $albumInfo = $album->selectId($data['id']);

            if ($albumInfo) {
                $chansons = $album->obtenirChansons((int) $data['id']);

                return View::render('album/show', [
                    'album' => $albumInfo,
                    'chansons' => $chansons
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Album introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }

    public function store(array $data) {
        $titre = '';
        $date_sortie = '';
        $description = '';
        $artiste_id = '';

        if (isset($data['titre'])) {
            $titre = trim($data['titre']);
        }

        if (isset($data['date_sortie'])) {
            $date_sortie = trim($data['date_sortie']);
        }

        if (isset($data['description'])) {
            $description = trim($data['description']);
        }

        if (isset($data['artiste_id'])) {
            $artiste_id = $data['artiste_id'];
        }

        $data = [
            'titre' => $titre,
            'date_sortie' => $date_sortie,
            'description' => $description,
            'artiste_id' => $artiste_id
        ];

        $val = new Validator;

        $val->field('titre', $data['titre'], 'titre')
            ->required()
            ->min(2)
            ->max(100);

        $val->field('date_sortie', $data['date_sortie'], 'date de sortie')
            ->date();

        if ($val->isSuccess()) {
            if (empty($data['date_sortie'])) {
                $data['date_sortie'] = null;
            }

            if (empty($data['artiste_id'])) {
                $data['artiste_id'] = null;
            }

            $album = new Album;
            $insert = $album->insert($data);

            if ($insert) {
                return View::redirect('album/show?id=' . $insert);
            } else {
                $artiste = new Artiste;
                $artistes = $artiste->select('nom');

                return View::render('album/create', [
                    'album' => $data,
                    'artistes' => $artistes,
                    'errors' => [
                        'general' => "Erreur lors de l'ajout de l'album."
                    ]
                ]);
            }
        } else {
            $artiste = new Artiste;
            $artistes = $artiste->select('nom');

            return View::render('album/create', [
                'errors' => $val->getErrors(),
                'album' => $data,
                'artistes' => $artistes
            ]);
        }
    }

    public function edit($data = [])
    {
        if (isset($data['id'])) {
            $album = new Album;
            $albumInfo = $album->selectId($data['id']);

            if ($albumInfo) {
                $artiste = new Artiste;
                $artistes = $artiste->select('nom');

                $chanson = new Chanson;
                $chansons = $chanson->select('titre');

                return View::render('album/edit', [
                    'album' => $albumInfo,
                    'artistes' => $artistes,
                    'chansons' => $chansons
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Album introuvable.'
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
        $date_sortie = '';
        $description = '';
        $artiste_id = '';
        $chanson_id = '';

        if (isset($data['id'])) $id = $data['id'];
        if (isset($data['titre'])) $titre = trim($data['titre']);
        if (isset($data['date_sortie'])) $date_sortie = trim($data['date_sortie']);
        if (isset($data['description'])) $description = trim($data['description']);
        if (isset($data['artiste_id'])) $artiste_id = $data['artiste_id'];
        if (isset($data['chanson_id'])) $chanson_id = $data['chanson_id'];

        $album = new Album;
        $albumInfo = $album->selectId($id);

        if (!$albumInfo) {
            return View::render('error', [
                'msg' => 'Album introuvable.'
            ]);
        }

        $data = [
            'titre' => $titre,
            'date_sortie' => $date_sortie,
            'description' => $description,
            'artiste_id' => $artiste_id
        ];

        $val = new Validator;
        $val->field('titre', $data['titre'], 'titre')->required()->min(2)->max(100);
        $val->field('date_sortie', $data['date_sortie'], 'date de sortie')->date();

        if ($val->isSuccess()) {
            if (empty($data['date_sortie'])) $data['date_sortie'] = null;
            if (empty($data['artiste_id'])) $data['artiste_id'] = null;

            $update = $album->update($data, $id);

            if ($update) {
                // Associer la chanson sélectionnée à cet album.
                if (!empty($chanson_id)) {
                    $chanson = new Chanson;
                    $chansonUpdate = $chanson->update([
                        'album_id' => (int) $id
                    ], (int) $chanson_id);

                    if (!$chansonUpdate) {
                        return View::render('error', [
                            'msg' => 'Erreur lors de l’association de la chanson à l’album.'
                        ]);
                    }
                }

                return View::redirect('album/show?id=' . $id);
            } else {
                $artiste = new Artiste;
                $artistes = $artiste->select('nom');

                $chanson = new Chanson;
                $chansons = $chanson->select('titre');

                return View::render('album/edit', [
                    'album' => array_merge($data, ['id' => $id]),
                    'artistes' => $artistes,
                    'chansons' => $chansons,
                    'errors' => [
                        'general' => "Erreur lors de la modification de l'album."
                    ]
                ]);
            }
        } else {
            $artiste = new Artiste;
            $artistes = $artiste->select('nom');

            $chanson = new Chanson;
            $chansons = $chanson->select('titre');

            return View::render('album/edit', [
                'album' => array_merge($data, ['id' => $id]),
                'artistes' => $artistes,
                'chansons' => $chansons,
                'errors' => $val->getErrors()
            ]);
        }
    }

    public function delete(array $data) {
        if (isset($data['id'])) {
            $album = new Album;
            $albumInfo = $album->selectId($data['id']);

            if ($albumInfo) {
                $delete = $album->delete('album', $data['id']);

                if ($delete) {
                    return View::redirect('albums');
                } else {
                    return View::render('error', [
                        'msg' => "Erreur lors de la suppression de l'album."
                    ]);
                }
            } else {
                return View::render('error', [
                    'msg' => 'Album introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }
}