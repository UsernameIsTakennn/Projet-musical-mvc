{{ include('layouts/header.php', {title: 'Modifier la chanson'}) }}

<main>
    <div class="container">
        <form action="{{ base }}/chanson/update" method="post">
            <h2>Modifier la chanson</h2>

            {% if errors is defined and errors %}
            <ul class="errors">
                {% for error in errors %}
                <li>{{ error }}</li>
                {% endfor %}
            </ul>
            {% endif %}

            <input type="hidden" name="id" value="{{ chanson.id }}">

            <label>
                Titre
                <input type="text" name="titre" value="{{ chanson.titre }}" required>
            </label>

            <label>
                Durée
                <input type="time" name="duration" step="1" value="{{ chanson.duration }}">
            </label>

            <label>
                Date de sortie
                <input type="date" name="date_sortie" value="{{ chanson.date_sortie }}">
            </label>

            <label>
                Album
                <select name="album_id">
                    <option value="">— Aucun —</option>
                    {% for album in albums %}
                    <option value="{{ album.id }}"
                        {% if chanson.album_id == album.id %}selected{% endif %}>
                        {{ album.titre }}
                    </option>
                    {% endfor %}
                </select>
            </label>

            <label>
                Genre
                <select name="genre_id">
                    <option value="">— Aucun —</option>
                    {% for genre in genres %}
                    <option value="{{ genre.id }}">
                        {{ genre.nom }}
                    </option>
                    {% endfor %}
                </select>
            </label>


            <input type="submit" value="Enregistrer">
        </form>
    </div>
</main>

{{ include('layouts/footer.php') }}