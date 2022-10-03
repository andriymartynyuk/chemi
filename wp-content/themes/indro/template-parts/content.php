<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package indro
 */

?>
<?php if ( !is_single() ) { ?>
	<div class="col-sm-12 col-xs-12 col-xs-12">
<?php } ;?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>


		<?php if ( !is_single() ) { ?>
			<div class="entry-date">
				<?php indro_posted_on() ;?>
			</div><!-- .entry-meta -->
		<?php } ;?>

	<div class="post-thumbnail-image <?php if ( is_single() ) : echo 'single-post-thumb'; endif; ?>">
		
		<?php 
		if (has_post_thumbnail() ) {
			the_post_thumbnail('standard-size', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			 if ( is_single() ) { ?>
				<div class="entry-meta-single">
					<?php
					indro_post_category();
					//indro_posted_by();
					?>
				</div><!-- .entry-meta -->
				<div class="entry-date-single">
					<?php indro_posted_on() ;?>
				</div><!-- .entry-meta -->
			<?php } 
		} else {
			echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" />';
		} ?>
		
	</div>

	<div class="meta-items">
	<?php
		if ( 'post' === get_post_type() && !is_single() ) :
			?>
			<div class="entry-meta gridview_meta d-flex justify-content-between">
				<?php
				indro_post_category();
				indro_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</div>
	<div class="entry-meta gridview_meta d-flex justify-content-between">
                    <?php
                        indro_posted_by();
                        indro_comments_count_for_gridview();
                        
                    ?>
        </div><!-- .entry-meta -->
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			null;
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
			?>
	</header><!-- .entry-header -->


	<?php
		if ( !is_single() && 'post' === get_post_type()) {
			?>
			<?php the_excerpt() ;?>

		<?php }else { ?>
	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'indro' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'indro' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	<?php } ;?>
	<footer class="entry-footer">
	
		<?php indro_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
<?php if ( !is_single() ) { ?>
	</div>
<?php } ;?>
