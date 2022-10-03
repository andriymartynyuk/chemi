<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package indro
 */

get_header('post');
?>
<?php 
	$sidebar_position = indro_get_sidebar();
	
	if ( 'sidebar_right' === $sidebar_position || 'sidebar_left' === $sidebar_position ) :
		$center_column_width = 'col-lg-8 col-md-12 col-sm-12 order-lg-0 order-0';
	else :
		$center_column_width = 'col-lg-12 order-lg-0 order-0 full__width';
	endif;
?>

	<main id="primary" class="site-main">
		<section class="post-content_section">
				<div class="container post-container">
					<div class="row">
						<?php 	if ( 'sidebar_left' === $sidebar_position ) : ?>
							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 order-lg-0 order-1 pt-5 pt-md-4 pt-lg-0">
								<?php get_sidebar(); ?>	
							</div> 
						<?php endif; ?>
						<div class="<?php echo esc_attr( $center_column_width ); ?>">
							
									<?php
									while ( have_posts() ) :
										the_post();

										get_template_part( 'template-parts/content', get_post_type() );

										the_post_navigation(
											array(
												'prev_text' => __( '←', 'indro' ),
												'next_text' => __( '→', 'indro' ),
											)
										);

										// If comments are open or we have at least one comment, load up the comment template.
										if ( comments_open() || get_comments_number() ) :
											comments_template();
										endif;

									endwhile; // End of the loop.
									?>
   							
						</div>

						<?php if ( 'sidebar_right' === $sidebar_position ) : ?>
							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 order-lg-1 order-1 pt-5 pt-md-4 pt-lg-0">
								<?php get_sidebar(); ?>	
							</div> 
						<?php endif; ?>
				</div><!-- Row -->
			</div> <!-- Container -->
		</section>
	</main><!-- #main -->
<?php
get_sidebar();
get_footer();
