{{ include('layouts/header.php', {title: 'Chanson - ' ~ chanson.titre}) }}

<main>
    <div class="container">
        <h1>{{ chanson.titre }}</h1>

        <p>
            <strong>Durée :</strong>
            {{ chanson.duration }}
        </p>

        <p>
            <strong>Date de sortie :</strong>
            {{ chanson.date_sortie }}
        </p>

        <h3>Genres</h3>

        {% if genres is defined and genres %}
        <ul>
            {% for genre in genres %}
            <li>
                <a href="{{ base }}/genre/show?id={{ genre.id }}">
                    {{ genre.nom }}
                </a>
            </li>
            {% endfor %}
        </ul>
        {% else %}
        <p>Aucun genre associé pour l'instant.</p>
        {% endif %}

        <a href="{{ base }}/chanson/edit?id={{ chanson.id }}" class="bouton_modifier">
            Modifier
        </a>

        <form action="{{ base }}/chanson/delete" method="post" style="display:inline">
            <input type="hidden" name="id" value="{{ chanson.id }}">
            <input type="submit" value="Supprimer" class="btn red">
        </form>
    </div>
</main>

{{ include('layouts/footer.php') }}