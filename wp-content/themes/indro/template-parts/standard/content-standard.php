<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package indro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-standard mb-5'); ?>>

	<div class="post-thumbnail-image single-post-thumb">
		
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php 
		if (has_post_thumbnail() ) {
			the_post_thumbnail('standard-size', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			
		} else {
			echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" />';
		} ?>
		 </a>
		 
		<div class="entry-meta-single">
			<?php
			indro_post_category();
			//indro_posted_by();
			?>
		</div><!-- .entry-meta -->
		<div class="entry-date-single">
			<?php indro_posted_on() ;?>
		</div><!-- .entry-meta -->
			
	</div>

	<div class="post-standard-body-content">
		<div class="entry-meta gridview_meta d-flex justify-content-between align-items-end">
                    <?php
                        indro_posted_by();
                        //indro_comments_count_for_gridview();
                        
                    ?>
            </div><!-- .entry-meta -->
		<header class="entry-header">
			<?php
			 the_title( '<h3 class="entry-title title-truncate"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );

			if ( 'post' === get_post_type() ) :
				?>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php
		if ( 'post' === get_post_type() ) {
			?>
			<?php the_excerpt() ;?>

		<?php }else { ?>
			<div class="entry-content">
			<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'indro' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'indro' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
		<?php } ;?>
				
		<footer class="entry-footer">
			<?php indro_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
