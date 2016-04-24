<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

?>
<?php
if( is_singular ( 'clients' ) ||
 	is_singular ( 'hb_pricing_table' ) ) {
	wp_redirect(home_url()); exit;
} 
?>
<?php get_header(); ?>
<!-- BEGIN #main-content -->
<div id="main-content">
	<div class="container">

	<?php 
		$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
		$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

		if ( $sidebar_layout == "default" || $sidebar_layout == "" ) {
			$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
			$sidebar_name = hb_options('hb_choose_sidebar');
		}

		$pagination_style = vp_metabox('page_settings.hb_pagination_settings.0.hb_pagination_style');
		$blog_grid_column_class = vp_metabox('page_settings.hb_blog_grid_settings.0.hb_grid_columns');
	?>

	<div class="row <?php echo $sidebar_layout; ?> main-row">
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
		<!-- BEGIN .hb-main-content -->
		<?php if ( $sidebar_layout != "fullwidth") { ?>
			<div class="col-9 hb-equal-col-height hb-main-content">
		<?php } else { ?>
			<div class="col-12 hb-main-content">
		<?php } ?>
			<!-- BEGIN #single-blog-wrapper -->
			<div class="single-blog-wrapper clearfix">
				<!-- BEGIN .hentry -->
				<article id="post-<?php the_ID(); ?>" <?php post_class( get_post_format() . '-post-format single' ); ?> itemscope itemType="http://schema.org/BlogPosting">
					<?php 
					if ( hb_options('hb_blog_enable_featured_image') && vp_metabox('general_settings.hb_hide_featured_image') == 0 )
						get_template_part('includes/single' , 'featured-format' ) ; 
					?>

					<!-- BEGIN .single-post-content -->
					<div class="single-post-content">
	
						<?php if (! is_attachment() ) { ?>	
						<!-- BEGIN .post-header -->
						<div class="post-header">
							<h1 class="title entry-title" itemprop="headline"><?php the_title(); ?></h1>

							<!-- BEGIN .post-meta-info -->
							<div class="post-meta-info">
								<span class="blog-author minor-meta">
									<?php if ( hb_options('hb_blog_enable_date' ) ) { ?>
									<span class="post-date date updated"><time datetime="<?php echo get_the_time('c'); ?>" itemprop="datePublished"><?php echo get_the_time('M j, Y'); ?></time></span>
									<?php } ?>
									
									<?php if ( hb_options('hb_blog_enable_by_author') && hb_options('hb_blog_enable_date') ) { ?>
									<span class="text-sep">|</span>
									<?php } ?>
									<?php /* START AUTHOR BOX CHANGE
									https://developers.google.com/structured-data/rich-snippets/articles#article_markup_properties */
									$custom_logo = get_post_meta( get_the_ID(), 'publisher_logo' );
									$custom_publisher = get_post_meta( get_the_ID(), 'publisher' );

									function imageration($the_image_url,$best_width,$best_height){
										list($img_width, $img_height, $ing_type, $img_attr) = getimagesize($the_image_url);
										$the_ratio =$img_width/$img_height; // width/height
										if( $ratio > 1) {
										    return array($best_width,$best_width/$the_ratio);
										}
										else {
										    return array($best_height*$the_ratio,$best_height);
										}
									}
									?>
									<div itemprop="author" itemscope itemtype="https://schema.org/Person">
										<span itemprop="name"><?php the_author_meta('display_name'); ?></span>
									</div>
									<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
									<?php
										$feat_image[0] = hb_options('hb_logo_option');
										if (has_post_thumbnail( $post->ID ) ){ 
										$feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
										}

										list ($feature_width,$feature_height) = imageration($feat_image[0],700,700);
										echo '<meta itemprop="url" content="'.$feat_image[0].'">';
										echo '<meta itemprop="width" content="'.$feature_width.'">';
										echo '<meta itemprop="height" content="'.$feature_height.'">';
									?>
									</div>
									<div class="publisher-info-update hidden"  itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
									    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
									    <?php
											if($custom_logo[0]) {
												list ($custom_width,$custom_height) = imageration($custom_logo[0],600,60);
												echo '<meta itemprop="url" content=""'.$custom_logo[0].'">';
												echo '<meta itemprop="width" content="'.$custom_width.'">';
											    echo '<meta itemprop="height" content="'.$custom_height.'">';
											}else{
												list ($hb_logo_width,$hb_logo_height) = imageration(hb_options('hb_logo_option'),600,60);
												echo '<meta itemprop="url" content="'.hb_options('hb_logo_option').'">';
												echo '<meta itemprop="width" content="'.$hb_logo_width.'">';
											    echo '<meta itemprop="height" content="'.$hb_logo_height.'">';
											}
										?>
										</div>
										<?php
									    if($custom_publisher[0]) {
												echo '<span class="author-box-publisher2 hidden" itemprop="name">'.$custom_publisher[0].'</span>';
											}else{
												echo  '<span class="author-box-publisher3 hidden" itemprop="name">';
												the_author_meta('display_name');
												echo'</span>';
											}
										?>
									</div>
									<span class="author-box-datemod2 hidden" itemprop="dateModified"><?php echo get_the_time('M j, Y'); ?></span>
									<span class="author-box-entryof hidden" itemprop="mainEntityOfPage"><?php echo the_permalink(); ?></span>
<?php /* END AUTOR BOX CHANGE */?>
									<?php if ( hb_options('hb_blog_enable_by_author') ) { ?>
									<?php _e('Posted by' , 'hbthemes'); ?>
									<span class="entry-author-link" itemprop="name">
										<span class="vcard author">
											<span class="fn">
												<a href="<?php echo get_author_posts_url ( get_the_author_meta ('ID') ); ?>" title="<?php _e('Posts by ' , 'hbthemes'); the_author_meta('display_name');?>" rel="author"><?php the_author_meta('display_name'); ?></a>
											</span>
										</span>
									</span>
									<?php } ?>
								</span>
								<?php if ( hb_options('hb_blog_enable_by_author') || hb_options('hb_blog_enable_date') ) { ?>
								<span class="text-sep">|</span>
								<?php } ?>

								<?php 
								$categories = get_the_category();
								if ( $categories && hb_options('hb_blog_enable_categories') ) {
									?>
									<!-- Category info -->
									<span class="blog-categories minor-meta"> 
									<?php
									$cat_count = count($categories);
									foreach($categories as $category) { 
										$cat_count--;
									?>
										<a href="<?php echo get_category_link( $category->term_id ); ?>" title="<?php echo esc_attr( sprintf( __( "View all posts in %s", "hbthemes" ), $category->name ) ); ?>"><?php echo $category->cat_name; ?></a><?php if ( $cat_count > 0 ) echo ', '; ?>			
									<?php } ?>
									<span class="text-sep">|</span>
								<?php } ?>

								<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
								<span class="comment-container minor-meta">
									<a href="<?php the_permalink (); ?>#comments" class="comments-link scroll-to-comments" title="<?php printf ( __("Comment on %s" , "hbthemes" ) , get_the_title()); ?>">
										<?php comments_number( __( '0 comments' , 'hbthemes' ) , __( '1 comment' , 'hbthemes' ), __( '% comments' , 'hbthemes' ) ); ?> 
									</a>
								</span>
								<span class="text-sep">|</span>
								<?php } ?>
							</div>
							<!-- END .post-meta-info -->

						</div>
						<!-- END .post-header -->
						<?php } ?>
						
						<?php if ( !has_post_format('quote') && !has_post_format('link') && !has_post_format('status') ) {?>
						<!-- BEGIN .entry-content -->
						<div class="entry-content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
							<div class="page-links"><?php wp_link_pages(array('next_or_number'=>'next', 'previouspagelink' => ' <i class="icon-angle-left"></i> ', 'nextpagelink'=>' <i class="icon-angle-right"></i>')); ?></div>
						</div>
						<!-- END .entry-content -->
						<?php } ?>

						<?php 
							if ( hb_options('hb_blog_enable_tags' ) )
								the_tags('<div class="single-post-tags"><span>Tags: </span>','','</div>'); 
						?>

					</div>
					<!-- END .single-post-content -->
				</article>

				<?php if (! is_attachment() ) { ?>
				<section class="bottom-meta-section clearfix">
					<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
					<div class="float-left comments-holder"><a href="<?php the_permalink(); ?>#comments" class="comments-link scroll-to-comments" title="<?php _e('View comments on ', 'hbthemes'); the_title(); ?>"><?php comments_number( __( '0 Comments' , 'hbthemes' ) , __( '1 Comment' , 'hbthemes' ), __( '% Comments' , 'hbthemes' ) ); ?></a></div>
					<?php } ?>

					<?php if ( hb_options('hb_blog_enable_likes') ) { ?>
					<div class="float-right">
					<?php echo hb_print_likes(get_the_ID()); ?>
					</div>
					<?php } ?>

					<?php if ( hb_options('hb_blog_enable_share') ) { ?>
					<div class="float-right">
						<?php get_template_part ( 'includes/hb' , 'share' ); ?>
					</div>
					<!-- END .float-right -->
					<?php } ?>
				</section>
				<?php } ?>

				<?php if ( hb_options('hb_blog_author_info') && is_singular('post')) { 
					get_template_part('includes/post','author-info'); 
				} 

				if ( hb_options('hb_blog_enable_related_posts') ) { 
					get_template_part('includes/post','related-articles'); 
				} ?>

			</div>
			<!-- END #single-blog-wrapper -->
			<?php if (! is_attachment() ) {
				if ( comments_open() ) comments_template();
			} ?>

		</div>
		<!-- END .hb-main-content -->
		<?php if ( $sidebar_layout != "fullwidth" ){ ?>
			<!-- BEGIN .hb-sidebar -->
			<div class="col-3  hb-equal-col-height hb-sidebar">
			<?php 		
				if ( $sidebar_name && function_exists('dynamic_sidebar') )
					dynamic_sidebar($sidebar_name);
			?>
			</div>
			<!-- END .hb-sidebar -->
		<?php } ?>


		<?php endwhile; endif; ?>	

	</div>
		
	</div>
</div>
<!-- END #main-content -->
<?php get_footer(); ?>