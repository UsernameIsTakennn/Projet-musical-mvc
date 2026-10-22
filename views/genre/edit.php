{{ include('layouts/header.php', {title: 'Modifier le genre'}) }}

<main>
    <div class="container">
        <form action="{{ base }}/genre/update" method="post">
            <h2>Modifier le genre</h2>

            <input type="hidden" name="id" value="{{ genre.id }}">

            <label>
                Nom
                <input type="text" name="nom" value="{{ genre.nom }}" required>
            </label>

            <label>
                Chanson
                <select name="chanson_id">
                    <option value="">— Aucun —</option>

                    {% for chanson in chansons %}
                    <option value="{{ chanson.id }}"
                        {% if chanson.id == genre.chanson_id %}selected{% endif %}>
                        {{ chanson.titre }}
                    </option>
                    {% endfor %}
                </select>
            </label>

            <input type="submit" value="Enregistrer">
        </form>
    </div>
</main>

{{ include('layouts/footer.php') }}