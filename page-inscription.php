<?php
/* Template Name: Inscription */
?>
<?php get_header(); ?>

<main>
    <div class="form_wrp">
        <h1>Inscription</h1>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <p>
                <label for="user_login">Nom d'utilisateur</label>
                <input type="text" name="username" id="user_login" placeholder="Utilisateur">
            </p>
            <p>
                <label for="user_pass">Mot de passe</label>
                <input type="password" name="password" id="user_pass" placeholder="Mot de pass">
            </p>
            <p>
                <label for="user_email">Adresse Email</label>
                <input type="email" name="email" id="user_email" placeholder="email">
            </p>
            <input type="hidden" name="action" value="custom_user_register">
            <p>
                <input type="submit" name="submit" value="S'inscrire">
            </p>
        </form>
    </div>

</main>
<?php get_footer(); ?>
