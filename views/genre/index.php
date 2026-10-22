{{ include('layouts/header.php', {title: 'Genres'}) }}

<main>
    <h1>Genres</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            {% for genre in genres %}
            <tr>
                <td>{{ genre.nom }}</td>
                <td>
                    <a href="{{ base }}/genre/show?id={{ genre.id }}">
                        Voir plus
                    </a>
                </td>
            </tr>
            {% else %}
            <tr>
                <td colspan="2">Aucun genre trouvé.</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>

    <a href="{{ base }}/genre/create" class="btn-create">Ajouter un genre</a>
</main>

{{ include('layouts/footer.php') }}