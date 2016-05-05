<!-- BEGIN .post-content -->
<div class="post-content">
	<!-- BEGIN .post-header -->
	<div class="post-header">
		<h2 class="title" itemprop="headline"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( hb_options('hb_blog_enable_date') ) { ?>
		<time class="date-container minor-meta updated" itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time(get_option('date_format')); ?></time>
		<?php } ?>

		<?php
		if (is_sticky()) { ?>
			<div class="sticky-post-icon"><i class="hb-moon-pushpin"></i></div>
		<?php } ?>
		<?php /* START AUTHOR BOX CHANGE
https://developers.google.com/structured-data/rich-snippets/articles#article_markup_properties */
if (get_post_meta( get_the_ID(), 'publisher_logo' )){
$custom_logo = get_post_meta( get_the_ID(), 'publisher_logo' );
}else{ $custom_logo = "";}

if (get_post_meta( get_the_ID(), 'publisher' )){
	$custom_publisher = get_post_meta( get_the_ID(), 'publisher' );
}else{$custom_publisher = "";}

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
		if($custom_logo) {
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
    if($custom_publisher) {
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
	</div>
	<!-- END .post-header -->

	<p class="hb-post-excerpt clearfix">
		<?php 
		if ( hb_options('hb_blog_excerpt_disable') )  {
			the_content();
		} else {
			if ( has_excerpt() ) echo get_the_excerpt();
			else
			{
				echo wp_trim_words ( strip_shortcodes ( get_the_content() ) , hb_options('hb_blog_excerpt_length') , '...' );
			}
		}
		?>
		<br/>
		<?php if ( hb_options('hb_blog_read_more_button') ) { ?>
			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'hbthemes'); ?></a>		
		<?php } ?>			
	</p>

	<?php if ( hb_options('hb_blog_read_more_button') ) { ?>
		<div class="post-meta-footer">
	<?php } else { ?>
		<div class="post-meta-footer no-read-more">
	<?php } ?>
		<div class="inner-meta-footer clearfix">
			<div class="float-right">
				<?php if ( hb_options('hb_blog_enable_likes') ) echo hb_print_likes(get_the_ID()); ?>
			</div>
			<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
			<a href="<?php the_permalink(); ?>#comments" class="comments-holder float-right"><i class="hb-moon-bubbles-10"></i>
				<?php comments_number( __( '0' , 'hbthemes' ) , __( '1' , 'hbthemes' ), __( '%' , 'hbthemes' ) ); ?> 
			</a>
			<?php } ?>
		</div>
	</div>

</div>
<!-- END .post-content -->