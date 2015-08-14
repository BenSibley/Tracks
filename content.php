<div <?php post_class(); ?>>
    <?php ct_tracks_featured_image(); ?>
    <div class="entry-meta">
        <?php get_template_part('content/post-meta'); ?>
    </div>
    <div class='entry-header'>
        <h1 class='entry-title'><?php the_title(); ?></h1>
    </div>
    <div class="entry-container">
        <div class="entry-content">
            <article>
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => '<p class="singular-pagination">' . __('Pages:','tracks'), 'after' => '</p>', ) ); ?>
            </article>
        </div>
        <?php get_template_part('sidebar','after-post-content'); ?>
        <div class='entry-meta-bottom'>
            <?php get_template_part('content/further-reading'); ?>
            <?php get_template_part('content/category-links'); ?>
            <?php get_template_part('content/tag-links'); ?>
        </div>
        <?php
        if(get_theme_mod('additional_options_author_meta_settings') != 'hide'){ ?>
            <div class="author-meta">
                <div class="author">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', get_the_author() ); ?>
                    <span><?php
                            _e( 'Written by:', 'tracks');
                            the_author_posts_link();
                          ?>
                    </span>
                </div>
                <div class="bio">
                    <p><?php the_author_meta( 'description' ); ?></p>
                    <?php get_template_part('content/author-social-icons'); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>