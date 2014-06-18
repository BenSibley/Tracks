<div class='entry'>
    <div class="entry-meta">
        <span class="date"><?php echo get_the_date('F j'); ?> / </span>
        <span class="author"><?php the_author_posts_link(); ?></span>
    </div>
    <div class='entry-header'>
        <h1 class='entry-title'><?php the_title(); ?></h1>
    </div>
    <div class="entry-container">
        <div class="entry-content">
            <article>
                <?php
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                $image = $image[0];
                echo "<img src='$image' />";
                ?>
            </article>
        </div>
    </div>
</div>

