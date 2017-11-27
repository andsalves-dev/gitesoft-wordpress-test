<?php query_posts(['posts_per_page' => 5, 'post_type' => 'films']) ?>
<ul style="padding: 0 0 10px 5px;" class="float-left col-sm-12">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <li class="col-sm-12" style="list-style: none; padding: 2px 0; font-size: 18px;">
                <div class="col-sm-12" style="padding: 0">
                    <a class="float-left col-sm-8" href="<?php the_permalink(); ?>" style="color: #555; padding: 0">
                        <?php the_title(); ?>
                    </a>
                    <div class="col-sm-4 text-right" style="font-size: 14px; color: #555; padding: 0">
                        <?= get_the_time('d/m/Y') ?>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-top: -8px; padding-left: 5px">
                    <span style="color: #999; font-size: 10px;">
                        <?= get_taxonomies_imploded(get_the_ID(), 'genre', 2) ?> /
                        Ticket: $<?= get_post_custom(get_the_ID())['ticket_price'][0] ?>
                    </span>
                </div>
                <hr class="col-sm-12" style="padding: 0; margin: 0" />
            </li>
        <?php endwhile; ?>
    <?php endif; ?>
</ul>