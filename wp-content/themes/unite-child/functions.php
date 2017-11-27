<?php
/**
 * Author: Anderson Alves
 */


{/* Inheriting parent theme's styles */

    add_action('wp_enqueue_scripts', 'enqueue_parent_styles');

    function enqueue_parent_styles() {
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    }
}


{/* Register Films post type */

    add_action('init', 'create_films_post_type');

    function create_films_post_type() {
        register_post_type('films', [
            'labels' => [
                'name' => __('Films'),
                'singular_name' => __('Film')
            ],
            'public' => true,
            'has_archive' => true,
        ]);
    }
}


{/* Adding Taxonomies */

    add_action('init', 'register_films_taxonomies');

    function register_films_taxonomies() {
        register_taxonomy('genre', 'films', [
            'label' => __('Genre'),
            'rewrite' => ['slug' => 'genre'],
            'hierarchical' => true
        ]);

        register_taxonomy('country', 'films', [
            'label' => __('Country'),
            'rewrite' => ['slug' => 'country'],
        ]);

        register_taxonomy('year', 'films', [
            'label' => __('Year'),
            'rewrite' => ['slug' => 'year'],
        ]);

        register_taxonomy('actor', 'films', [
            'label' => __('Actor'),
            'rewrite' => ['slug' => 'actor'],
        ]);
    }
}


{/* Adding Films Custom Fields */

    add_action('admin_init', 'custom_fields_init');

    function custom_fields_init() {
        add_meta_box('ticket_price-meta', 'Ticket Price', 'ticket_price_field', 'films', 'normal', 'low');
        add_meta_box('release_date-meta', 'Release Date', 'release_date_field', 'films', 'normal', 'low');
    }

    function ticket_price_field() {
        global $post;
        $custom = get_post_custom($post->ID);
        $ticketPrice = $custom['ticket_price'][0];
        ?>
        <label>Price ($):</label>
        <input title="" name="ticket_price" type="number" step="0.2" value="<?= $ticketPrice; ?>"/>
        <?php
    }

    function release_date_field() {
        global $post;
        $custom = get_post_custom($post->ID);
        $ticketPrice = $custom['release_date'][0];
        ?>
        <label>Release Date:</label>
        <input title="" name="release_date" type="date" value="<?= $ticketPrice; ?>"/>
        <?php
    }
}



{/* Save custom post details */

    add_action('save_post', 'save_post_details');

    function save_post_details() {
        global $post;

        update_post_meta($post->ID, 'ticket_price', $_POST['ticket_price']);
        update_post_meta($post->ID, 'release_date', $_POST['release_date']);
    }
}

{/* Showing two custom columns for the custom fields of the custom type */

    add_action('manage_posts_custom_column', 'films_custom_columns');
    add_filter('manage_edit-films_columns', 'films_edit_columns');

    function films_edit_columns($columns) {
        $columns = array_merge($columns, [
            'description' => 'Description',
            'genre' => 'Genre',
            'ticket_price' => 'Ticket Price',
            'release_date' => 'Release Date',
        ]);

        return $columns;
    }

    function films_custom_columns($column) {
        global $post;

        switch ($column) {
            case 'description':
                the_excerpt();
                break;
            case 'genre':
                print get_taxonomies_imploded($post->ID, 'genre');
                break;
            case 'ticket_price':
                $custom = get_post_custom();
                print $custom['ticket_price'][0];
                break;
            case 'release_date':
                $custom = get_post_custom();
                print $custom['release_date'][0];
                break;
        }
    }
}

{ /* Custom functions */

    function get_taxonomies_imploded($postId, $taxName, $limitQnt = false) {
        $terms = get_the_terms($postId, $taxName);
        $taxs = [];

        foreach ($terms as $term) {
            $taxs[] = $term->name;
        }

        if ($limitQnt && is_numeric($limitQnt)) {
            $taxs = array_slice($taxs, 0, $limitQnt);
        }

        return implode(', ', $taxs);
    }

}

{/* Get Last posts from Films */

    add_action('pre_get_posts', 'films_pre_posts');
    /**
     * Change that query! No need to return anything $q is an object passed by
     * reference {@link http://php.net/manual/en/language.oop5.references.php}.
     *
     * @param   WP_Query $q The query object.
     * @return  void
     */
    function films_pre_posts($q) {
        // bail if it's the admin, not the main query or isn't the (posts) page.
        if (is_admin() || !$q->is_main_query() || !is_home())
            return;

        // whatever type(s) you want.
        $q->set('post_type', ['films']);
    }
}

add_shortcode('last-films', 'last_films_widget');

function last_films_widget() {
    ob_start();
    get_template_part('last-films-widget');
    $template = ob_get_contents();
    ob_end_clean();

    return $template;
}