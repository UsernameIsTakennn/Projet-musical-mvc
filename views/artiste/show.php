{{ include('layouts/header.php', {title: 'Artiste - ' ~ artiste.nom}) }}

<div class="container">
    <h1>{{ artiste.nom }}</h1>

    <p>
        <strong>Pays :</strong>
        {{ artiste.pays }}
    </p>

    <p>
        <strong>Date de naissance :</strong>
        {{ artiste.date_naissance }}
    </p>

    <p>
        <strong>Biographie :</strong>
        {{ artiste.biographie }}
    </p>

    <h3>Albums</h3>

    {% if albums is defined and albums %}
    <ul>
        {% for album in albums %}
        <li>
            <a href="{{ base }}/album/show?id={{ album.id }}">
                {{ album.titre }}
            </a>
        </li>
        {% endfor %}
    </ul>
    {% else %}
    <p>Aucun album associé pour l'instant.</p>
    {% endif %}

    <a href="{{ base }}/artiste/edit?id={{ artiste.id }}" class="bouton_modifier">
        Modifier
    </a>

    <form action="{{ base }}/artiste/delete" method="post" style="display:inline">
        <input type="hidden" name="id" value="{{ artiste.id }}">
        <input type="submit" value="Supprimer" class="btn red">
    </form>
</div>

{{ include('layouts/footer.php') }}