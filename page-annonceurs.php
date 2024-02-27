<?php
/* Template Name: Annonceurs */
?>
<?php get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Récupérer les utilisateurs avec le rôle 'Author'
        $utilisateurs = get_users(array('role' => 'Author', 'orderby' => 'user_nicename', 'order' => 'ASC'));

        if (!empty($utilisateurs)) {
            echo '<ul class="liste-annonceurs">';
            foreach ($utilisateurs as $utilisateur) {
                // Récupérer le nombre de posts publiés par l'utilisateur
                $args = array(
                    'author' => $utilisateur->ID,
                    'post_type' => 'post', // ou votre type de post personnalisé si nécessaire
                    'post_status' => 'publish',
                    'fields' => 'ids', // Optimisation pour récupérer uniquement les IDs
                );
                $posts_query = new WP_Query($args);
                $nombre_posts = $posts_query->found_posts;
                $url_auteur = get_author_posts_url($utilisateur->ID);;

                // Afficher les informations de l'utilisateur avec un lien vers sa page
                echo '<li>';
                echo '<a href="' . esc_url($url_auteur) . '">' . get_avatar($utilisateur->ID) . '</a><br>'; // Avatar avec lien
                echo 'Nom : ' . esc_html($utilisateur->first_name) . '<br>'; // Prénom
                echo 'Prénom : ' . esc_html($utilisateur->last_name) . '<br>'; // Nom
                echo 'Nombre d\'annonces publiées : ' . $nombre_posts . '<br>'; // Nombre de posts
                echo '<a href="' . esc_url($url_auteur) . '">Voir le profil de ' . esc_html($utilisateur->first_name) . '</a>'; // Lien vers la page de l'auteur
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Aucun annonceur trouvé.</p>';
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>
