{{ include('layouts/header.php', {title: 'Home'}) }}

<section>
    <div>
        <h1>Projet musical</h1>
        <p>Un système de gestion simple pour découvrir les artistes, explorer leurs albums, consulter leurs chansons et consulter les genres musicaux.</p>
    </div>
</section>

<section>
    <h3>Artistes</h3>
    <a href="{{base}}/artistes">
        <p>Découvrez les artistes!</p>
    </a>

    <h3>Albums</h3>
    <a href="{{base}}/albums">
        <p>Explorez les albums!</p>
    </a>

    <h3>Chansons</h3>
    <a href="{{base}}/chansons">
        <p>Consultez les chansons!</p>
    </a>

    <h3>Genres</h3>
    <a href="{{base}}/genres">
        <p>Découvrez les genres musicaux!</p>
    </a>
</section>

{{ include('layouts/footer.php') }}