{{ include('layouts/header.php', {title: 'Modifier l’album'}) }}

<main>
    <div class="container">
        <form action="{{ base }}/album/update" method="post">
            <h2>Modifier l'album</h2>

            {% if errors is defined and errors %}
            <ul class="errors">
                {% for error in errors %}
                <li>{{ error }}</li>
                {% endfor %}
            </ul>
            {% endif %}

            <input type="hidden" name="id" value="{{ album.id }}">

            <label>
                Titre
                <input type="text" name="titre" value="{{ album.titre }}" required>
            </label>

            <label>
                Date de sortie
                <input type="date" name="date_sortie" value="{{ album.date_sortie }}">
            </label>

            <label>
                Description
                <input type="text" name="description" value="{{ album.description }}">
            </label>

            <label>
                Artiste
                <select name="artiste_id">
                    <option value="">— Aucun —</option>
                    {% for artiste in artistes %}
                    <option value="{{ artiste.id }}"
                        {% if artiste.id == album.artiste_id %}selected{% endif %}>
                        {{ artiste.nom }}
                    </option>
                    {% endfor %}
                </select>
            </label>

            <label>
                Chanson
                <select name="chanson_id">
                    <option value="">— Aucune chanson —</option>

                    {% for chanson in chansons %}
                    <option value="{{ chanson.id }}">
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