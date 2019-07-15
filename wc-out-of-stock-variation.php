add_action('pre_get_posts','remove_products');

function remove_products($query) {
   if(! is_admin() && $query->is_main_query()){
	 
	 
	if(isset($_GET['filter_megethos'])){
		   
	$fltrmeg = sanitize_key($_GET['filter_megethos']);
	  
	$xplfltrmeg = explode(',', $fltrmeg);
  
 
   	$current_category = get_queried_object();

      $args = array(
         'post_type'                => 'product',
         'post_status'              => 'publish',
         'posts_per_page'           => get_option('posts_per_page'),
         'tax_query'                => array(
            array(
               'taxonomy'           => 'product_cat',
               'field'              => 'term_id',
               'terms'              => $current_category->term_id,
            )
         )
      );

      $loop = get_posts($args);
	  $post__in1 = array();
	  $post__in2 = array();
	  $post__in3 = array();

      foreach ($loop as $post) {

         //Product object
         $product = wc_get_product($post->ID);

         //Get product info i.e variations > meta keys
         $product_variations = $product->get_children();		

         foreach ($product_variations as $variation) {

            // Store only the meta keys needed
            $product_attribute = get_post_meta($variation, 'attribute_pa_megethos'); // 'attribute slug name'
            $stock_status = get_post_meta($variation, '_stock_status'); // 'in stock / out of stock'
			 
			 if(in_array($product_attribute[0], $xplfltrmeg)){
			   if(in_array('outofstock', $stock_status)) {
			   	$post__in2[] = $post->ID;
			 }
			   if(in_array('instock', $stock_status)) {
			   	$post__in3[] = $post->ID;
			 }
			 
		   }
		 }
	  }
	 
	 $post__in1 = array_diff($post__in2, $post__in3);

      //Exclude the product
      if(is_array($post__in1) && $post__in1 != null) {
         $query->set('post__not_in', $post__in1);
      }

	}
	}
}
