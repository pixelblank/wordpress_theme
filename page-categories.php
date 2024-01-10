<?php
/* Template Name: Catégories */
?>
<?php get_header(); ?>

<main>
    <div id="catLoader">
        loading
    </div>
    <div class="categories_nav">
        <ul>
            <?php
            $categories = get_categories();
            foreach($categories as $category) {
                $icone_cat = get_term_meta($category->term_id, 'icone_cat', true);
                if ($icone_cat) {
                    echo '<li><a href="#" class="category-link" data-category="' . esc_attr($category->term_id) . '"><span class="cat-ico ' . $icone_cat . '"></span><span class="cat-title">' . esc_html($category->name) . '</span></a></li>';
                }else{
                    echo '<li><a href="#" class="category-link" data-category="' . esc_attr($category->term_id) . '"><span class="cat-title">' . esc_html($category->name) . '</span></a></li>';
                }
            }
            ?>
        </ul>
    </div>
    <div class="post_cnt">
        <?php if ( have_posts() ) : ?>
            <?php

            while ( have_posts() ) : the_post();
                if($post->post_type === 'page'){
                    continue;
                }
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header>
                        <div class="author_annonce">
                                <span class="pre_icone_wrp">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); // 32 est la taille de l'avatar en pixels ?>
                                    <!--
                                    <svg version="1.1" class="author_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 102 102" style="enable-background:new 0 0 102 102;" xml:space="preserve">
                                        <path class="author_path" d="M85.4,11.4L45.8,51l-1.7-3.3c-1.1-2.2-2.9-3.9-5-5L35.8,41L75.4,1.4L85.4,11.4z M98.2,24.2l-10-10 L48.6,53.8l3.3,1.7c2.2,1.1,3.9,2.9,5,5l1.7,3.3L98.2,24.2z M12.3,87.3L25.9,81l-7.3-7.3L12.3,87.3z M55.4,67L51.7,60 c-1.5-2.5-5.7-3.5-8.9-3.1c0.5-3.4-0.6-7.5-3.1-8.9l-7.1-3.7L20.8,68.9l9.9,9.9L55.4,67z M96.5,98.1c0-1.4-1.1-2.5-2.5-2.5H6.3 c-1.4,0-2.5,1.1-2.5,2.5s1.1,2.5,2.5,2.5H94C95.4,100.6,96.5,99.5,96.5,98.1z"/>
                                    </svg>
                                    -->
                                </span>
                            <span class="pre_title">Autheur:</span>

                            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                                <?php the_author(); ?>
                            </a>
                        </div>
                    </header>
                    <a href="<?php echo the_permalink()?> ">
                        <div class="content">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink() ?>">
                                        <?php the_post_thumbnail(); ?>
                                    </a>

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
                            <span class="category_list 2">
                                <?php
                                $categories = get_the_category();
                                $separator = ', ';
                                $output = '';

                                if (!empty($categories)) {
                                    foreach ($categories as $category) {
                                        $output .= '<a href="#" class="category_list" data-category="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</a>' . $separator;
                                    }
                                    echo trim($output, $separator);
                                }
                                ?>
                            </span>

                        </div>
                    </footer>

                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
    </div>

</main>

<?php get_footer(); ?>
