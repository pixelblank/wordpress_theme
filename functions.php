<?php

/*
Theme Name: pixeltheme
Theme URI: #
Author: pixelb
Author URI: #
Description: theme
Version: 1.0
*/

function load_script_styles() {
    // Scripts pour le panneau d'administration
    wp_enqueue_script('pixeltheme-admin-script', get_template_directory_uri() . '/assets/js/admin_script.js', array('jquery'), null, true);
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }

    // Styles pour le panneau d'administration en fonction du rôle de l'utilisateur
    $current_user = wp_get_current_user();
    if($current_user->roles && is_admin()){
        if (in_array('administrator', $current_user->roles)) {
            wp_enqueue_style('custom-admin-style', get_stylesheet_directory_uri() . '/assets/css/admin-style.css');
        } elseif (in_array('author', $current_user->roles)) {
            wp_enqueue_style('custom-admin-style-editor', get_template_directory_uri() . '/assets/css/admin-style-editor.css');
        }
    }

    // Styles communs
    wp_enqueue_style('ico_css', get_stylesheet_directory_uri() . '/assets/css/ico-style.css');
    wp_enqueue_style('pixel_root_style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('pixel-style', get_stylesheet_directory_uri() . '/assets/css/main.css');
    wp_enqueue_style('pixel-style-header', get_stylesheet_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('pixel-style-articles', get_stylesheet_directory_uri() . '/assets/css/articles.css');
    wp_enqueue_style('pixel-style-auth', get_stylesheet_directory_uri() . '/assets/css/author.css');

    // Font Awesome
    wp_enqueue_style('fontawesome_css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('fontawesome_map_css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css.map');
    wp_enqueue_style('fontawesome_otf', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/FontAwesome.otf');
    wp_enqueue_style('fontawesome_eot', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.eot');
    wp_enqueue_style('fontawesome_svg', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.svg');
    wp_enqueue_style('fontawesome_ttf', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.ttf');
    wp_enqueue_style('fontawesome_woff', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff');
    wp_enqueue_style('fontawesome_woff2', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2');

    // Styles spécifiques pour la page de connexion
    if (for_custom_page()) {
        wp_enqueue_style('styles-page-connexion', get_template_directory_uri() . '/assets/css/connexion.css');
    }
}
add_action('wp_enqueue_scripts', 'load_script_styles');

// Fonction pour vérifier quel template est utilisé
function for_custom_page() {
    if (is_page_template('page-connexion.php')) {
        return true;
    }
    return false;
}


// Ajout du support pour les images à la une
function img_avnt_setup() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'img_avnt_setup' );

// Support pour le logo personnalisé
function pixeltheme_setup() {
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
}
add_action( 'after_setup_theme', 'pixeltheme_setup' );

// Support du format SVG
function pixeltheme_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'pixeltheme_allow_svg_upload');

// Ajouter le slug à la classe de l'élément de menu
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($item->object_id) {
            $post = get_post($item->object_id);
            $slug = $post->post_name;
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-slug-' . $slug;
            $item->classes = $classes;
        }
        parent::start_el($output, $item, $depth, $args, $id);
    }
}

// Ajout des differents menu
function pregister_nav_menu() {
    register_nav_menus( array(
        'menu-header' => __( 'Menu Header', 'pixeltheme' ),
        'menu-footer' => __( 'Menu Footer', 'pixeltheme' ),
    ) );
}
add_action( 'after_setup_theme', 'pregister_nav_menu' );

// custom register
function custom_user_register() {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = esc_attr($_POST['password']);

        // Assurez-vous que le champ supplémentaire est défini
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $adresse = isset($_POST['adresse']) ? sanitize_text_field($_POST['adresse']) : '';
        $zipcode = isset($_POST['zipcode']) ? sanitize_text_field($_POST['zipcode']) : '';
        $ville = isset($_POST['ville']) ? sanitize_text_field($_POST['ville']) : '';

        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {
            // Sauvegardez le champ supplémentaire dans les métadonnées de l'utilisateur
            if (!empty($phone)) {
                update_user_meta($user_id, 'phone', $phone);
            }
            if (!empty($adresse)) {
                update_user_meta($user_id, 'adresse', $adresse);
            }
            if (!empty($zipcode)) {
                update_user_meta($user_id, 'zipcode', $zipcode);
            }
            if (!empty($ville)) {
                update_user_meta($user_id, 'ville', $ville);
            }
            if (isset($_POST['first_name'])) {
                update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            }
            if (isset($_POST['last_name'])) {
                update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
            }
            wp_redirect(home_url());
            exit;
        } else {
            echo $user_id->get_error_message();
        }
    }
}

add_action('init', 'custom_user_register');

function wp_custom_user_profile_fields($user) {
    ?>
    <h3><?php _e("Informations supplémentaires", "votre-textdomain"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="phone"><?php _e("Téléphone"); ?></label></th>
            <td>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr(get_the_author_meta('phone', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="adresse"><?php _e("Adresse"); ?></label></th>
            <td>
                <input type="text" name="adresse" id="adresse" value="<?php echo esc_attr(get_the_author_meta('adresse', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="zipcode"><?php _e("Code Postal"); ?></label></th>
            <td>
                <input type="text" name="zipcode" id="zipcode" value="<?php echo esc_attr(get_the_author_meta('zipcode', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ville"><?php _e("Ville"); ?></label></th>
            <td>
                <input type="text" name="ville" id="ville" value="<?php echo esc_attr(get_the_author_meta('ville', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="custom_avatar"><?php _e("Uploader une nouvelle photo", "custom-user-avatar"); ?></label></th>
            <td>
                <input type="file" name="custom_avatar" id="custom_avatar">
                <?php
                // Afficher l'avatar actuel
                $custom_avatar = get_user_meta($user->ID, 'custom_avatar', true);
                if ($custom_avatar) {
                    echo '<img src="' . esc_url($custom_avatar) . '" alt="" style="width:100px;">';
                }
                ?>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'wp_custom_user_profile_fields');
add_action('edit_user_profile', 'wp_custom_user_profile_fields');

function wp_save_custom_user_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'phone', $_POST['phone']);
    update_user_meta($user_id, 'adresse', $_POST['adresse']);
    update_user_meta($user_id, 'zipcode', $_POST['zipcode']);
    update_user_meta($user_id, 'ville', $_POST['ville']);
    if (!empty($_FILES['custom_avatar']['name'])) {
        $uploaded = wp_upload_bits($_FILES['custom_avatar']['name'], null, file_get_contents($_FILES['custom_avatar']['tmp_name']));
        if (isset($uploaded['error']) && $uploaded['error'] == 0) {
            // Le fichier a été téléchargé avec succès, sauvegarder l'URL de l'image
            update_user_meta($user_id, 'custom_avatar', $uploaded['url']);
        } else {
            // Afficher une erreur lors du téléchargement
            wp_die('Il y a eu une erreur lors du téléchargement de votre fichier. L\'erreur est: ' . $uploaded['error']);
        }
    }
}
add_action('personal_options_update', 'wp_save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'wp_save_custom_user_profile_fields');

function custom_user_profile_form_tag() {
    echo ' enctype="multipart/form-data"';
}
add_action('user_edit_form_tag', 'custom_user_profile_form_tag');

// données nécessaires
function pixeltheme_needed_pages(){
    //chemin des templates
    $theme_directory = get_template_directory();

    $pages = array(
        'inscription' => array(
            'title' => 'Inscription',
            'content' => '',
            'template' => 'page-inscription.php'
        ),
        'connexion' => array(
            'title' => 'Connexion',
            'content' => '',
            'template' => 'page-connexion.php'
        ),
        'categories' => array(
            'title' => 'Catégories',
            'content' => '',
            'template' => 'page-categories.php'
        )
    );
    foreach ($pages as $slug => $page){
        $page_verif = get_page_by_path($slug);
        if(!$page_verif){
            $page_id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug
            ));
            // Vérifier si le template existe avant de l'associer
            if (isset($page['template']) && file_exists($theme_directory . '/' . $page['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page['template']);
            }
        }
    }
}
add_action('after_switch_theme', 'pixeltheme_needed_pages');

function montheme_admin_notice_demo_data() {
    if (get_option('montheme_demo_data_installed') != 'yes') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Souhaitez-vous installer les données de démonstration pour le thème ?', 'montheme'); ?></p>
            <p>
                <a href="<?php echo esc_url(add_query_arg('install_demo_data', 'true', admin_url())); ?>" class="button button-primary"><?php _e('Installer les données de démo', 'montheme'); ?></a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'montheme_admin_notice_demo_data');

function montheme_install_demo_data() {
    if (isset($_GET['install_demo_data']) && $_GET['install_demo_data'] == 'true') {
        // Logique pour installer les données de démo

        // Marquer que les données de démo ont été installées
        update_option('montheme_demo_data_installed', 'les données de demo ont été installées');
    }
}
add_action('admin_init', 'montheme_install_demo_data');


function enqueue_my_ajax_script() {
    wp_enqueue_script( 'my-ajax-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery') );

    // Ajouter l'URL admin-ajax.php et un identifiant de nonce à votre script
    wp_localize_script( 'my-ajax-script', 'ajax_object', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce('my_ajax_nonce')
    ));
}
add_action( 'wp_enqueue_scripts', 'enqueue_my_ajax_script' );


function req_cat() {
    check_ajax_referer('my_ajax_nonce', 'nonce');

    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 'all';
    //var_dump($category_id);

    // Récupérer les articles de la catégorie
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => -1, // Nombre d'articles à afficher, -1 pour tous
        'cat' => $category_id, // Utilisez 'cat' pour filtrer par ID de catégorie
    );
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 'all';
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Votre formatage pour l'affichage des articles ici
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
    <?php
        }
    } else {
        echo '<div>Aucun article trouvé dans cette catégorie.</div>';
    }

    wp_die(); // Arrêter le script
}
add_action('wp_ajax_req_cat', 'req_cat'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_req_cat', 'req_cat'); // Pour les utilisateurs non connectés


////////////////////////////////////////////////// ajout d'icones aux categories

// listing des icones depuis le css generer par icomoon
function get_icon_classes_from_css() {
    $icons = [];
    $css_file = get_stylesheet_directory() . '/assets/css/ico-style.css'; // Chemin vers votre fichier CSS

    if(file_exists($css_file)) {
        $css_content = file_get_contents($css_file);
        preg_match_all('/\.icon-([a-zA-Z0-9_-]+):before\s*\{\s*content\s*:\s*"\\\\e[0-9a-f]{3,4}";\s*\}/', $css_content, $matches);
        if(!empty($matches) && isset($matches[1])) {
            $icons = $matches[1];
        }
    }

    return $icons;
}


function add_category_icon_field_create($taxonomy) {
    $icons = get_icon_classes_from_css();
    ?>
    <div class="form-field term-group">
        <label for="icone_cat"><?php _e('Icône de la catégorie', 'text-domain'); ?></label>
        <select id="icone_cat" name="icone_cat" class="icone-cat-field">
            <?php foreach($icons as $icon): ?>
                <option value="icon-<?php echo esc_attr($icon); ?>">icon-<?php echo $icon; ?></span></option>
            <?php endforeach; ?>
        </select>
        <p class="description"><?php _e('Entrez l’URL de l’icône pour cette catégorie.', 'text-domain'); ?></p>
    </div>
    <?php
}
add_action('category_add_form_fields', 'add_category_icon_field_create');

function add_category_icon_field($term) {
    // Récupérer la valeur existante, si elle existe
    $icone_cat = get_term_meta($term->term_id, 'icone_cat', true);
    $icons = get_icon_classes_from_css();
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="icone_cat">
                <?php _e('Icône de la catégorie', 'text-domain'); ?>
            </label></th>
        <td>
            <input type="text" id="icone_cat" name="icone_cat" class="icone-cat-field" value="<?php echo esc_attr($icone_cat); ?>">
            <select id="icone_cat" name="icone_cat" class="icone-cat-field">
                <?php foreach($icons as $icon): ?>
                    <option value="icon-<?php echo esc_attr($icon); ?>">icon-<?php echo $icon; ?></span></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php _e('Entrez l’URL de l’icône pour cette catégorie.', 'text-domain'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'add_category_icon_field');

function save_category_icon_field_create($term_id) {
    if (isset($_POST['icone_cat'])) {
        update_term_meta($term_id, 'icone_cat', sanitize_text_field($_POST['icone_cat']));
    }
}
add_action('created_category', 'save_category_icon_field_create');

function save_category_icon_field($term_id) {
    if (isset($_POST['icone_cat'])) {
        update_term_meta($term_id, 'icone_cat', sanitize_text_field($_POST['icone_cat']));
    }
}
add_action('edited_category', 'save_category_icon_field');


add_filter('wp_mail_from', 'custom_wp_mail_from');
function custom_wp_mail_from($email) {
    return 'seb@gmail.com'; // Remplacez par l'adresse e-mail souhaitée
}

add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');
function custom_wp_mail_from_name($name) {
    return 'Seb'; // Remplacez par le nom souhaité
}