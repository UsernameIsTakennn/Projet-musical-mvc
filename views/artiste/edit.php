{{ include('layouts/header.php', {title: 'Modifier un artiste'}) }}

<div class="container">
    <form action="{{ base }}/artiste/update" method="post">
        <h2>Modifier l'artiste</h2>

        {% if errors is defined and errors %}
        <ul class="errors">
            {% for error in errors %}
            <li>{{ error }}</li>
            {% endfor %}
        </ul>
        {% endif %}

        <input type="hidden" name="id" value="{{ artiste.id }}">

        <label>
            Nom
            <input
                type="text"
                name="nom"
                value="{{ artiste.nom }}"
                required>
        </label>

        <label>
            Pays
            <input
                type="text"
                name="pays"
                value="{{ artiste.pays }}"
                required>
        </label>

        <label>
            Date de naissance
            <input
                type="date"
                name="date_naissance"
                value="{{ artiste.date_naissance }}">
        </label>

        <label>
            Biographie
            <input
                type="text"
                name="biographie"
                value="{{ artiste.biographie }}">
        </label>

        <input type="submit" value="Enregistrer">
    </form>
</div>

{{ include('layouts/footer.php') }}