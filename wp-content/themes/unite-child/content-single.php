<?php
/**
 * @package unite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header page-header">

        <?php
        if (of_get_option('single_post_image', 1) == 1) :
            the_post_thumbnail('unite-featured', array('class' => 'thumbnail'));
        endif;
        ?>

        <h1 class="entry-title "><?php the_title(); ?></h1>

        <div class="entry-meta">
            <?php unite_posted_on(); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-content col-sm-12">
        <?php the_content(); ?>

        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'unite'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <div class="col-sm-12" style="margin: 40px 0">
        <h3 class="h3">
            Details
        </h3>
        <hr class="hr"/>

        <div class="card float-left col-sm-6" style="font-size: 16px; padding: 5px 5px 4px 0; ">
            <strong>Release Date:</strong> <?= get_post_custom()['release_date'][0] ?>
        </div>
        <div class="card float-left col-sm-6" style="font-size: 16px; padding: 5px 5px 4px 0;">
            <strong>Genre(s):</strong> <?= get_taxonomies_imploded(get_the_ID(), 'genre') ?>
        </div>
        <div class="card float-left col-sm-6" style="font-size: 16px; padding: 5px 5px 4px 0;">
            <strong>Country:</strong> <?= get_taxonomies_imploded(get_the_ID(), 'country') ?>
        </div>
        <div class="card float-left col-sm-6" style="font-size: 16px; padding: 5px 5px 4px 0;">
            <strong>Ticket Price:</strong> $ <?= get_post_custom()['ticket_price'][0] ?>
        </div>
    </div>

    <footer class="entry-meta">
        <?php
        /* translators: used between list items, there is a space after the comma */
        $category_list = get_the_category_list(__(', ', 'unite'));

        /* translators: used between list items, there is a space after the comma */
        $tag_list = get_the_tag_list('', __(', ', 'unite'));

        if (!unite_categorized_blog()) {
            // This blog only has 1 category so we just need to worry about tags in the meta text
            if ('' != $tag_list) {
                $meta_text = '<i class="fa fa-folder-open-o"></i> %2$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
            } else {
                $meta_text = '<i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
            }

        } else {
            // But this blog has loads of categories so we should probably display them here
            if ('' != $tag_list) {
                $meta_text = '<i class="fa fa-folder-open-o"></i> %1$s <i class="fa fa-tags"></i> %2$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
            } else {
                $meta_text = '<i class="fa fa-folder-open-o"></i> %1$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
            }

        } // end check for categories on this blog

        printf(
            $meta_text,
            $category_list,
            $tag_list,
            get_permalink()
        );
        ?>

        <?php edit_post_link(__('Edit', 'unite'), '<i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span>'); ?>
        <?php unite_setPostViews(get_the_ID()); ?>
        <hr class="section-divider">
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
