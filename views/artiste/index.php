{{ include('layouts/header.php', {title: 'Artistes'}) }}

<section>
    <h1>Artistes</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Pays</th>
                <th>Date de naissance</th>
                <th>Biographie</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            {% for artiste in artistes %}
            <tr>
                <td>{{ artiste.nom }}</td>
                <td>{{ artiste.pays }}</td>
                <td>{{ artiste.date_naissance }}</td>
                <td>{{ artiste.biographie }}</td>
                <td>
                    <a href="{{ base }}/artiste/show?id={{ artiste.id }}">
                        Voir plus
                    </a>
                </td>
            </tr>
            {% else %}
            <tr>
                <td colspan="5">Aucun artiste trouvé.</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>

    <p>
        <a href="{{ base }}/artiste/create" class="btn-create">
            Ajouter un artiste
        </a>
    </p>
</section>

{{ include('layouts/footer.php') }}