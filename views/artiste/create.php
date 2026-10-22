{{ include('layouts/header.php', {title: 'Nouvel artiste'}) }}

<div class="container">
    <form action="{{ base }}/artiste/create" method="post">
        <h2>Nouvel artiste</h2>

        {% if errors is defined and errors %}
        <ul class="errors">
            {% for error in errors %}
            <li>{{ error }}</li>
            {% endfor %}
        </ul>
        {% endif %}

        <label for="nom">
            Nom
            <input
                type="text"
                id="nom"
                name="nom"
                value="{{ artiste.nom }}"
                required>
        </label>

        <label for="pays">
            Pays
            <input
                type="text"
                id="pays"
                name="pays"
                value="{{ artiste.pays }}">
        </label>

        <label for="date_naissance">
            Date de naissance
            <input
                type="date"
                id="date_naissance"
                name="date_naissance"
                value="{{ artiste.date_naissance }}">
        </label>

        <label for="biographie">
            Biographie
            <input
                type="text"
                id="biographie"
                name="biographie"
                value="{{ artiste.biographie }}">
        </label>

        <input type="submit" value="Enregistrer">
    </form>
</div>

{{ include('layouts/footer.php') }}