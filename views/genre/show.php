{{ include('layouts/header.php', {title: 'Genre - ' ~ genre.nom}) }}

<main>
    <div class="container">
        <h1>{{ genre.nom }}</h1>

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

        <a href="{{ base }}/genre/edit?id={{ genre.id }}" class="bouton_modifier">
            Modifier
        </a>

        <form action="{{ base }}/genre/delete" method="post" style="display:inline">
            <input type="hidden" name="id" value="{{ genre.id }}">
            <input type="submit" value="Supprimer" class="btn red">
        </form>
    </div>
</main>

{{ include('layouts/footer.php') }}