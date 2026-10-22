{{ include('layouts/header.php', {title: 'Albums'}) }}

<main>
    <h1>Albums</h1>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date de sortie</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            {% for album in albums %}
            <tr>
                <td>{{ album.titre }}</td>
                <td>{{ album.date_sortie }}</td>
                <td>{{ album.description }}</td>
                <td>
                    <a href="{{ base }}/album/show?id={{ album.id }}">
                        Voir plus
                    </a>
                </td>
            </tr>
            {% else %}
            <tr>
                <td colspan="4">Aucun album trouvé.</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>

    <a href="{{ base }}/album/create" class="btn-create">Ajouter un album</a>
</main>

{{ include('layouts/footer.php') }}