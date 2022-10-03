<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package indro
 */

get_header();
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
				<div class="container">
					<div class="row">

					<?php 	if ( 'sidebar_left' === $sidebar_position ) : ?>
							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 order-lg-0 order-1 pt-5 pt-md-4 pt-lg-0">
								<?php get_sidebar(); ?>	
							</div> 
						<?php endif; ?>
						<div class="<?php echo esc_attr( $center_column_width ); ?>">
							<div class="layout-full">
								<div class="row">

									<?php if ( have_posts() ) : ?>
										<?php
										/* Start the Loop */
										while ( have_posts() ) :
											the_post();

											/**
											 * Run the loop for the search to output the results.
											 * If you want to overload this in a child theme then include a file
											 * called content-search.php and that will be used instead.
											 */
											get_template_part( 'template-parts/content', 'search' );

										endwhile;

										the_posts_navigation( array(
											
											'next_text' => __( '→', 'indro' ),
											'prev_text' => __( '←', 'indro' ),
										));

									else :

										get_template_part( 'template-parts/content', 'none' );

									endif;
									?>
								</div>
							</div>
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
get_footer();
