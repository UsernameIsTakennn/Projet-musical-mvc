<?php

namespace App\Controllers;

use App\Models\Artiste;
use App\Providers\View;
use App\Providers\Validator;

class ArtisteController{
    public function index() {
        $artiste = new Artiste();
        $artistes = $artiste->select();

        return View::render('artiste/index', [
            'artistes' => $artistes
        ]);
    }

    public function create(){
        return View::render('artiste/create', [
            'artiste' => [
                'nom' => '',
                'pays' => '',
                'date_naissance' => '',
                'biographie' => ''
            ]
        ]);
    }

    public function show($data = [])
    {
        if (isset($data['id'])) {
            $artiste = new Artiste;
            $artisteInfo = $artiste->selectId($data['id']);

            if ($artisteInfo) {
                $albums = $artiste->obtenirAlbums((int) $data['id']);

                return View::render('artiste/show', [
                    'artiste' => $artisteInfo,
                    'albums' => $albums
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Artiste introuvable.'
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
        $pays = '';
        $date_naissance = '';
        $biographie = '';

        if (isset($data['nom'])) {
            $nom = trim($data['nom']);
        }

        if (isset($data['pays'])) {
            $pays = trim($data['pays']);
        }

        if (isset($data['date_naissance'])) {
            $date_naissance = trim($data['date_naissance']);
        }

        if (isset($data['biographie'])) {
            $biographie = trim($data['biographie']);
        }

        $data = [
            'nom' => $nom,
            'pays' => $pays,
            'date_naissance' => $date_naissance,
            'biographie' => $biographie
        ];

        $val = new Validator;

        $val->field('nom', $data['nom'], 'nom')
            ->required()
            ->min(2)
            ->max(100);

        $val->field('pays', $data['pays'], 'pays')
            ->required()
            ->max(100);

        $val->field('date_naissance', $data['date_naissance'], 'date de naissance')
            ->date();

        $val->field('biographie', $data['biographie'], 'biographie');

        if ($val->isSuccess()) {
            if (empty($data['date_naissance'])) {
                $data['date_naissance'] = null;
            }

            $artiste = new Artiste;
            $insert = $artiste->insert($data);

            if ($insert) {
                return View::redirect('artiste/show?id=' . $insert);
            } else {
                return View::render('error', [
                    'msg' => "Erreur lors de l'ajout de l'artiste."
                ]);
            }
        } else {
            return View::render('artiste/create', [
                'errors' => $val->getErrors(),
                'artiste' => $data
            ]);
        }
    }

    public function edit($data = [])
    {
        if (isset($data['id'])) {
            $artiste = new Artiste;
            $artisteInfo = $artiste->selectId($data['id']);

            if ($artisteInfo) {
                return View::render('artiste/edit', [
                    'artiste' => $artisteInfo
                ]);
            } else {
                return View::render('error', [
                    'msg' => 'Artiste introuvable.'
                ]);
            }
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }
    }

    public function update(array $data, $get = [])
    {
        if (isset($data['id'])) {
            $id = $data['id'];
        } elseif (isset($get['id'])) {
            $id = $get['id'];
        } else {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }

        $nom = '';
        $pays = '';
        $date_naissance = '';
        $biographie = '';

        if (isset($data['nom'])) {
            $nom = trim($data['nom']);
        }

        if (isset($data['pays'])) {
            $pays = trim($data['pays']);
        }

        if (isset($data['date_naissance'])) {
            $date_naissance = trim($data['date_naissance']);
        }

        if (isset($data['biographie'])) {
            $biographie = trim($data['biographie']);
        }

        $data = [
            'nom' => $nom,
            'pays' => $pays,
            'date_naissance' => $date_naissance,
            'biographie' => $biographie
        ];

        $val = new Validator;

        $val->field('nom', $data['nom'], 'nom')
            ->required()
            ->min(2)
            ->max(100);

        $val->field('pays', $data['pays'], 'pays')
            ->required()
            ->max(100);

        $val->field('date_naissance', $data['date_naissance'], 'date de naissance')
            ->date();

        $val->field('biographie', $data['biographie'], 'biographie');

        if ($val->isSuccess()) {
            if (empty($data['date_naissance'])) {
                $data['date_naissance'] = null;
            }

            $artiste = new Artiste;

            if ($artiste->update($data, $id)) {
                return View::redirect('artiste/show?id=' . $id);
            } else {
                return View::render('error', [
                    'msg' => "Erreur lors de la modification de l'artiste."
                ]);
            }
        } else {
            $data['id'] = $id;

            return View::render('artiste/edit', [
                'errors' => $val->getErrors(),
                'artiste' => $data
            ]);
        }
    }

    public function delete($data)
    {
        if (!isset($data['id'])) {
            return View::render('error', [
                'msg' => 'Code 404 - Page introuvable.'
            ]);
        }

        $artiste = new Artiste;
        $artisteInfo = $artiste->selectId($data['id']);

        if (!$artisteInfo) {
            return View::render('error', [
                'msg' => 'Artiste introuvable.'
            ]);
        }

        $stmt = $artiste->prepare(
            'SELECT id FROM album WHERE artiste_id = :id'
        );
        $stmt->execute(['id' => $data['id']]);
        $albums = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($albums as $album) {
            $stmt = $artiste->prepare(
                'SELECT id FROM chanson WHERE album_id = :id'
            );
            $stmt->execute(['id' => $album['id']]);
            $chansons = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($chansons as $chanson) {
                $artiste->delete(
                    'chanson_genre',
                    $chanson['id'],
                    'chanson_id'
                );

                $artiste->delete('chanson', $chanson['id']);
            }

            $artiste->delete('album', $album['id']);
        }

        $artiste->delete('artiste', $data['id']);

        return View::redirect('artistes');
    }
}