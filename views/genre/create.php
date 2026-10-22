{{ include('layouts/header.php', {title: 'Nouveau genre'}) }}

<main>
    <div class="container">
        <form action="{{ base }}/genre/create" method="post">
            <h2>Nouveau genre</h2>

            {% if errors is defined and errors %}
            <ul class="errors">
                {% for error in errors %}
                <li>{{ error }}</li>
                {% endfor %}
            </ul>
            {% endif %}

            <label>
                Nom
                <input
                    type="text"
                    name="nom"
                    value="{{ genre.nom }}"
                    required>
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