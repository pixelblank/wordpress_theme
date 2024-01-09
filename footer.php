<footer>
    <!-- Contenu du pied de page ici -->
    <div>
        <?php
            if ( has_nav_menu( 'menu-header' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'menu-footer',
                    'container_class' => 'menu-footer-class'
                ) );
            }
            ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>