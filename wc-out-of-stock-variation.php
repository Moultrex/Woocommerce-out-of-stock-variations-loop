add_action( 'woocommerce_before_shop_loop_item_title', 'wk_out_of_stock_variations_loop' );
function wk_out_of_stock_variations_loop(){
    global $product;
    if ( $product->product_type == 'variable' ) { // if variation product is out of stock
        $available = $product->get_available_variations();
        if ( $available )foreach ( $available as $instockvar ) {
            if ( isset($instockvar['attributes']['attribute_pa_megethos'] ) ) {
              
			  
		if(isset($_GET['filter_megethos'])){
		   
		   $destostock = $_GET['filter_megethos'];
			  
		  
		  $array = explode(',', $destostock);
		  


    if (in_array($instockvar['attributes']['attribute_pa_megethos'], $array )&& (!$instockvar['max_qty']>0)){
		   global $product;
		   $id = $product->get_id();
	  
			echo "<style>.post-$id{display: none}</style>";

	}
		  else{
			
		  if (in_array($instockvar['attributes']['attribute_pa_megethos'], $array )&& ($instockvar['max_qty']>0)){
		   global $product;
		   $id = $product->get_id();
	  
			echo "<style>.post-$id{display: block !important}</style>";
		  
		  }
		  }
            
        }
    }	
 
}
	}
}
