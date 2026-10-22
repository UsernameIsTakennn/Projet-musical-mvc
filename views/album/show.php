{{ include('layouts/header.php', {title: 'Album - ' ~ album.titre}) }}

<div class="container">
    <h1>{{ album.titre }}</h1>

    <p>
        <strong>Date de sortie :</strong>
        {{ album.date_sortie }}
    </p>

    <p>
        <strong>Description :</strong>
        {{ album.description }}
    </p>

    <h3>Chansons</h3>

    {% if chansons is defined and chansons %}
    <ul>
        {% for chanson in chansons %}
        <li>
            <a href="{{ base }}/chanson/show?id={{ chanson.id }}">
                {{ chanson.titre }}
            </a>
        </li>
        {% endfor %}
    </ul>
    {% else %}
    <p>Aucune chanson associée pour l'instant.</p>
    {% endif %}

    <a href="{{ base }}/album/edit?id={{ album.id }}" class="bouton_modifier">
        Modifier
    </a>

    <form action="{{ base }}/album/delete" method="post" style="display:inline">
        <input type="hidden" name="id" value="{{ album.id }}">
        <input type="submit" value="Supprimer" class="btn red">
    </form>
</div>

{{ include('layouts/footer.php') }}