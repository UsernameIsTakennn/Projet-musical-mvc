{{ include('layouts/header.php', {title: 'Chansons'}) }}

<main>
    <h1>Chansons</h1>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Durée</th>
                <th>Date de sortie</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            {% for chanson in chansons %}
            <tr>
                <td>{{ chanson.titre }}</td>
                <td>{{ chanson.duration }}</td>
                <td>{{ chanson.date_sortie }}</td>
                <td>
                    <a href="{{ base }}/chanson/show?id={{ chanson.id }}">
                        Voir plus
                    </a>
                </td>
            </tr>
            {% else %}
            <tr>
                <td colspan="4">Aucune chanson trouvée.</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>

    <a href="{{ base }}/chanson/create" class="btn-create">Ajouter une chanson</a>
</main>

{{ include('layouts/footer.php') }}