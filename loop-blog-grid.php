<?php 
/* SCHEMA FIX FUCNTION */
	function imageration($the_image_url,$best_width,$best_height){
		list($img_width, $img_height, $ing_type, $img_attr) = getimagesize($the_image_url);
		$the_ratio =$img_width/$img_height; // width/height
		if( $the_ratio > 1) {
		    return array($best_width,$best_width/$the_ratio);
		}
		else {
		    return array($best_height*$the_ratio,$best_height);
		}
	}
/* END SCHEMA FIX FUCNTION */
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part('includes/grid-blog/post-format' , get_post_format() );
	endwhile; endif;
?>