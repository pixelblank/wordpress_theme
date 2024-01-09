<?php
/* Template Name: Connexion */
?>
<?php
get_header();
?>

<main>
    <div class="form_wrp">
        <h1>Connexion</h1>
        <?php
        $args = array(
            'echo'           => true,
            'redirect'       => home_url(),
            'form_id'        => 'loginform',
            'label_username' => __( 'Nom d\'utilisateur' ),
            'label_password' => __( 'Mot de passe' ),
            'label_rememberme'   => __( 'remember' ),
            'label_log_in'   => __( 'Se connecter' ),
            'id_username' => 'user_login',
            'id_password' => 'user_pass',
            'remember'       => true
        );

        wp_login_form( $args );
        ?>
        <div class="password_wrp">
            <a href="<?php echo site_url() ?>/inscription">Vous n'avez pas encore de compte ?</a>
            <a href="<?php echo wp_lostpassword_url(); ?>">Mot de passe oublié ?</a>
        </div>

    </div>
</main>

<?php
get_footer();
?>