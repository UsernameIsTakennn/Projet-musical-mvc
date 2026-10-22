{{ include('layouts/header.php', {title:'Error'}) }}
<div class="error-page">
    <h1>Error 404: Page not found!</h1>
    <p>{{ message }}</p>
    <a href="{{ base }}/">Retour à l'accueil</a>
</div>
{{ include('layouts/footer.php')}}