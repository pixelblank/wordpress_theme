<?php
get_header();

global $wpdb;
$author_id = get_queried_object_id(); // Obtient l'ID de l'auteur courant
$custom_avatar = get_user_meta($author_id, 'custom_avatar', true);
global $wpdb;
$author_id = get_queried_object_id(); // Obtenez l'ID de l'auteur courant.

// Préparez la requête SQL pour calculer la moyenne des notes pour les posts de cet auteur.
$query = "
            SELECT AVG(rating) as average_rating
            FROM {$wpdb->prefix}rating_system
            WHERE post_id IN (
                SELECT ID FROM {$wpdb->posts}
                WHERE post_author = %d AND post_type = 'post' AND post_status = 'publish'
            )
        ";
$average_rating = $wpdb->get_var($wpdb->prepare($query, $author_id));

?>

    <div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="author-profile">

            <div class="author-details">
                <div class="author-left">
                    <?php if($custom_avatar){ ?>
                        <div class="author-picture" style="background-image:url('<?php echo esc_url($custom_avatar)?>')"></div>
                    <?php }else{echo get_avatar(get_the_author_meta('ID'), 90);} ?>
                </div>
                <div class="author-right">
                    <div class="author-header">
                        <h2><?php the_author(); ?></h2>
                        <div class="rating_wrp">
                            <?php
                            if (!is_null($average_rating)) {?>

                                <div class="annonceur-info" data-annonceur-id="<?php echo $author_id; ?>">
                                    <div class="annonceur-rating-cnt">
                                        <div class="annonceur-stars-background">★★★★★</div>
                                        <div class="annonceur-stars-foreground" data-foreground-for-author-id="<?php echo $author_id; ?>" style="width: <?php echo esc_attr($average_rating * 20); ?>%;">★★★★★</div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo '<div>Cet auteur n\'a pas encore reçu de votes.</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <p class="author-description" contenteditable="true">
                        <?php echo nl2br(get_the_author_meta('description')); ?>
                    </p>
                </div>
            </div>

        </div>
        <?php
        echo ('<div class="post_cnt">');
        if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                    <div class="author_annonce">
                            <span class="pre_icone_wrp">
                                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); // 32 est la taille de l'avatar en pixels ?>
                            </span>
                        <span class="pre_title">Autheur:</span>

                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                            <?php the_author(); ?>
                        </a>

                        <?php
                            $post_id = get_the_ID(); // Récupérer l'ID du post courant
                            $user_rating = $wpdb->get_var($wpdb->prepare("SELECT rating FROM {$wpdb->prefix}rating_system WHERE post_id = %d AND user_id = %d", $post_id, get_current_user_id()));
                            if ($user_rating !== null) {
                                $stars_width = $user_rating * 20; // Convertir la note en largeur en pourcentage
                            }
                        ?>

                        <div class="rating-container" data-post-id="<?php the_ID(); ?>"> <!-- Ajoutez un identifiant de post ici -->
                            <div class="stars-background">★★★★★</div>
                            <div class="stars-foreground" data-foreground-for-post-id="<?php the_ID(); ?>" style="width:<?php echo esc_attr($stars_width); ?>%">★★★★★</div> <!-- Mettez à jour cette largeur dynamiquement -->
                            <div class="rating-inputs">
                                <?php for ($star = 1; $star <= 5; $star++): ?>
                                    <a href="#" class="rating-link" data-post-id="<?php the_ID(); ?>" data-rating="<?php echo $star; ?>">
                                        <span class="">★</span>
                                    </a>
                                <?php endfor; ?>
                            </div>
                        </div>

                    </div>
                </header>
                <a href="<?php echo the_permalink()?> ">
                    <div class="content">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        <?php endif; ?>

                        <h2><?php the_title(); ?></h2>
                    </div>
                </a>
                <footer>
                    <div class="category_annonce">
                        <div class="categorie_title_cnt">
                                     <span class="pre_icone_wrp">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 236.7 234.1" style="enable-background:new 0 0 236.7 234.1;" xml:space="preserve">
                                            <g><path class="st0" d="M186,31c10.8,0,19.6,8.8,19.6,19.6v14.8c0,10.8-8.8,19.6-19.6,19.6h-34.4V50.6c0-10.8,8.8-19.6,19.6-19.6H186 M186,8h-14.8c-23.5,0-42.6,19.1-42.6,42.6V108H186c23.5,0,42.6-19.1,42.6-42.6V50.6C228.6,27.1,209.5,8,186,8L186,8z"/></g>
                                            <g><path class="st0" d="M186,149.1c10.8,0,19.6,8.8,19.6,19.6v14.8c0,10.8-8.8,19.6-19.6,19.6h-14.8c-10.8,0-19.6-8.8-19.6-19.6v-34.4 H186 M186,126.1h-57.4v57.4c0,23.5,19.1,42.6,42.6,42.6H186c23.5,0,42.6-19.1,42.6-42.6v-14.8C228.6,145.2,209.5,126.1,186,126.1 L186,126.1z"/></g>
                                            <g><path class="st0" d="M85.1,149.1v34.4c0,10.8-8.8,19.6-19.6,19.6H50.7c-10.8,0-19.6-8.8-19.6-19.6v-14.8c0-10.8,8.8-19.6,19.6-19.6 H85.1 M108.1,126.1H50.7c-23.5,0-42.6,19.1-42.6,42.6v14.8c0,23.5,19.1,42.6,42.6,42.6h14.8c23.5,0,42.6-19.1,42.6-42.6V126.1 L108.1,126.1z"/></g>
                                            <g><path class="st0" d="M65.5,31c10.8,0,19.6,8.8,19.6,19.6V85H50.7c-10.8,0-19.6-8.8-19.6-19.6V50.6c0-10.8,8.8-19.6,19.6-19.6H65.5 M65.5,8H50.7C27.2,8,8.1,27.1,8.1,50.6v14.8c0,23.5,19.1,42.6,42.6,42.6h57.4V50.6C108.1,27.1,89,8,65.5,8L65.5,8z"/></g>
                                        </svg>
                                     </span>
                            <span class="pre_title">
                                        Catégorie:
                                    </span>
                        </div>
                        <span class="category_list">
                                    <?php the_category(', '); ?>
                                </span>

                    </div>
                </footer>

            </article>

        <?php endwhile; else : ?>
            <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
        <?php
            endif;
            echo ('</div>')
        ?>

    </main>
    </div>
<?php get_footer(); ?>
