{{ include('layouts/header.php', {title: 'Nouvel album'}) }}

<main>
    <div class="container">
        <form action="{{ base }}/album/create" method="post">
            <h2>Nouvel album</h2>

            {% if errors is defined and errors %}
            <ul class="errors">
                {% for error in errors %}
                <li>{{ error }}</li>
                {% endfor %}
            </ul>
            {% endif %}

            <label>
                Titre
                <input
                    type="text"
                    name="titre"
                    value="{{ album.titre }}"
                    required>
            </label>

            <label>
                Date de sortie
                <input
                    type="date"
                    name="date_sortie"
                    value="{{ album.date_sortie }}">
            </label>

            <label>
                Description
                <input
                    type="text"
                    name="description"
                    value="{{ album.description }}">
            </label>

            <label>
                Artiste
                <select name="artiste_id">
                    <option value="">— Aucun —</option>

                    {% for artiste in artistes %}
                    <option value="{{ artiste.id }}"
                        {% if album.artiste_id == artiste.id %}selected{% endif %}>
                        {{ artiste.nom }}
                    </option>
                    {% endfor %}
                </select>
            </label>

            <input type="submit" value="Enregistrer">
        </form>
    </div>
</main>

{{ include('layouts/footer.php') }}