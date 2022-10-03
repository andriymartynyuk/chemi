<?php
/**
 * Template part for displaying a post in a grid view (2 Columns) With SideBar
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package indro
 */

?>

    <div class="col-md-12 col-lg-6 pb-5">    
        <article id="post-<?php the_ID(); ?>" <?php post_class('post-grid post-grid-left-right-sidebar'); ?> >
            <div class="gridview-post-img">
                <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php
                    if (has_post_thumbnail() ) {
                        the_post_thumbnail('grid-size', array(
                            'alt' => the_title_attribute( array(
                                'echo' => false,
                            ) ),
                        ) );
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" />';
                    }
                ?>
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

            <div class="article-inner-content">

                <div class="entry-meta gridview_meta d-flex justify-content-between align-items-end">
                    <?php
                        indro_posted_by();
                        indro_comments_count_for_gridview();
                        
                    ?>
                </div><!-- .entry-meta -->
                <?php the_title( '<h3 class="article-title title-truncate"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
                    <div class="entry-meta gridview_meta d-flex justify-content-between">
                        <?php
                            //indro_author_for_gridview();
                            //indro_comments_count_for_gridview();
                        ?>
                    </div><!-- .entry-meta -->
                
                    <?php the_excerpt() ;?>
            </div>
            
            <div class="article-footer d-flex justify-content-between align-items-center"> 
                <?php $read_more = get_theme_mod( 'indro_language_readmore_setting', '...Read More' );?>                                        
                <a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html_e( 'Read_more' , 'indro' );?><span class="icon-align-right">
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                </a>
                <footer class="entry-footer gridview_edited">
			        <?php indro_post_edit(); ?>
		        </footer><!-- .entry-footer -->
            </div>
           
        </article><!-- #post-<?php the_ID(); ?> -->
    </div><!--//column  -->