<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="header">
    <nav>
        <div class="nav_left">
            <div class="logo-container">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php endif; ?>
                <div class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>
            </div>
            <div class="menu-header">
                <div class="menu_icone">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
                </div>
                    <?php
                    if ( has_nav_menu( 'menu-header' ) ) {
                        wp_nav_menu( array(
                                'theme_location' => 'menu-header',
                                'container_class' => 'menu_list',
                                'link_before'		=> '<span class="link_icon"></span><span class="link_title">', // (string) Text before the link text.
                                'link_after'        => '</span>',
                                'walker' => new Custom_Walker_Nav_Menu(),
                            )
                        );
                    }else{
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                            Accueil
                        </a>
                        <?php
                    }
                    ?>
            </div>
        </div>
        <div class="nav_right">
            <div class="search_bar">
                <?php get_search_form(); ?>
            </div>
            <div class="customer_nav">
                <a href="http://localhost/wordpress_advert/connexion">Connexion</a>
            </div>
        </div>
    </nav>
</header>
