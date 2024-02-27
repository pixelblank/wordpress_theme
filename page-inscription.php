<?php
/* Template Name: Inscription */
?>
<?php get_header(); ?>

<main>
    <div class="form_wrp">
        <h1>Inscription</h1>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <p>
                <label for="first_name">Nom d'utilisateur</label>
                <input type="text" name="first_name" id="first_name" placeholder="Prénom" required>
            </p>
            <p>
                <label for="last_name">Nom d'utilisateur</label>
                <input type="text" name="last_name" id="last_name" placeholder="Nom" required>
            </p>
            <p>
                <label for="user_login">Nom d'utilisateur</label>
                <input type="text" name="username" id="user_login" placeholder="Utilisateur" required>
            </p>
            <p>
                <label for="user_pass">Mot de passe</label>
                <input type="password" name="password" id="user_pass" placeholder="Mot de pass" required>
            </p>
            <p>
                <label for="user_email">Adresse Email</label>
                <input type="email" name="email" id="user_email" placeholder="email" required>
            </p>
            <p>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" placeholder="Numéro de téléphone" required>
            </p>
            <p>
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" placeholder="Adresse" required>
            </p>
            <p>
                <label for="zipcode">Code Postal</label>
                <input type="text" name="zipcode" id="zipcode" placeholder="Code Postal" required>
            </p>
            <p>
                <label for="ville">Ville</label>
                <input type="text" name="ville" id="ville" placeholder="Ville" required>
            </p>
            <input type="hidden" name="action" value="custom_user_register">
            <p>
                <input type="submit" name="submit" value="S'inscrire">
            </p>
        </form>
    </div>

</main>
<?php get_footer(); ?>
