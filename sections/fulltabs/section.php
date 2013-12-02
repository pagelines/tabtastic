<?php
/*
	Section: FullTabs
	Author: elSue
	Author URI: http://dms.elsue.com
	Description: Creates tabs and tab layouts
	Class Name: FullTabs
	Filter: component
	PageLines: true
	v3: true
	Version: 1.0
	Demo: http://pagelines.ellenjanemoore.com/tabs
*/

/**
 * FullTabs Section
 *
 * @package PageLines Framework
 * @author PageLines
 */



class FullTabs extends PageLinesSection {
	var $taxID = 'tabs-sets';
	var $ptID = 'tabtastic';
	
	const version = '1.0';

    // Begin Section Functions 

    function section_styles(){
		wp_enqueue_script( 'tabdrop', $this->base_url.'/../../js/bootstrap-tabdrop.js',array( 'jquery' ), self::version);		
		
	}


	
	function section_head(){
		$fulltabs_clone = $this->get_the_id();
		$fulltabs_id = 'tabs-'.$this->get_the_id();
		$fulltabs_width = ($this->opt('fulltab_max_width')) ? $this->opt('fulltab_max_width') : null;
		$fulltab_nav_text = ($this->opt('fulltab_nav_text')) ? $this->opt('fulltab_nav_text') : __('<i class="icon-align-justify"></i>', 'tabtastic');
		$fulltab_nav_color = ( $this->opt( 'fulltab_nav_color'  ) ) ? $this->opt( 'fulltab_nav_color'  ) : '000000';
		$fulltab_nav_bg = ( $this->opt( 'fulltab_nav_bg'  ) ) ? $this->opt( 'fulltab_nav_bg'  ) : 'ffffff';
		$fulltab_nav_hover = $this->adjustBrightness($fulltab_nav_bg, -20);
		
		// Initiate Tabdrop
		?>
		<script>
			jQuery(document).ready(function(){
			
					jQuery('.fulltabs .nav-tabs').tabdrop({
						text: '<?php echo $fulltab_nav_text ?>'
					}).on("click", function(){
				    	jQuery('.fulltabs .nav-tabs').tabdrop('layout');
					});

		//Set height
			var height = 0;
			jQuery('.fulltabs.<?php echo $fulltabs_id;?> li.tab a').each(function(){
			    if(height < jQuery(this).height())
			        height = jQuery(this).height();    
			});
			//+20 because of the top-offset
			jQuery(".fulltabs.<?php echo $fulltabs_id;?> li.tab a").css("height",(height)+"px"); 

			});
			
		
		</script>

		<?php
		 if($fulltabs_width) {
			?>
			<style type="text/css">
				.fulltabs.<?php echo $fulltabs_id;?> li.tab a{
					width: <?php echo $fulltabs_width ?>px;
				}
		</style>
		<?php
		 
		}
		// Styling for Tabdrop Dropdown
		?>
			<style>
				#fulltabs<?php echo $fulltabs_clone ?> .tabdrop .dropdown-toggle {
					color: #<?php echo $fulltab_nav_color ?>;
					background: #<?php echo $fulltab_nav_bg ?>;
				}
				#fulltabs<?php echo $fulltabs_clone ?> .tabdrop .caret{
					border-top-color: #<?php echo $fulltab_nav_color ?>;
					border-bottom-color: #<?php echo $fulltab_nav_color ?>;
					
				}
				#fulltabs<?php echo $fulltabs_clone ?> .tabdrop .dropdown-toggle:hover {
					background: <?php echo $fulltab_nav_hover ?>;
				}
				
			</style>
		<?php
}
	

	/**
	* PHP that always loads no matter if section is added or not.
	*/
	function section_persistent(){
			
		
	}
	
	

	// Section Options Method
    function section_opts(){

		$options = array();

		$options[] = array(
			'key'           => 'fulltab_set_options',
			'title' => __( 'FullTabs Options', 'tabtastic' ),
			'type'	=> 'multi',
			'col'		=> 1,
        	'opts'=> array(
	            array(
	                'type'		=> 'select_taxonomy',
					'taxonomy_id'	=> $this->taxID,
					'default'		=> 'default-tabs',
	                'title'         => 'Select Tab Set',
	                'key'           => 'fulltab_set',
	                'label'         => 'Tab Set'
	                
	            ),
	                array(
		            'key'           => 'fulltab_orderby',
		            'type'          => 'select', 
		            'label'         => 'Order Tabs By',
		            'opts'=> array(
		                'ID' 		=> array('name' => __( 'Post ID (default)', 'tabtastic') ),
						'title' 	=> array('name' => __( 'Title', 'tabtastic') ),
						'date' 		=> array('name' => __( 'Date', 'tabtastic') ),
						'modified' 	=> array('name' => __( 'Last Modified', 'tabtastic') ),
						'rand' 		=> array('name' => __( 'Random', 'tabtastic') ),
					)
					
	            ), 
	                array(
	                    'key'           => 'fulltab_order',
			            'type'          => 'select',
			            'default'		=> 'DESC', 
			            'label'         => 'Descending or Ascending?',
			            'opts'=> array(
			                'DESC' 		=> array('name' => __( 'Descending', 'tabtastic') ),
							'ASC' 		=> array('name' => __( 'Ascending', 'tabtastic') ),
									
	                )
			     ),       
		           
            )
	
	);
			$options[] = array(
	            'key'           => 'fulltab_set_colors',
	            'type'          => 'multi', 
	            'title'         => 'FullTab Colors', 
	            'col'			=> 2,
	            'help'			=> 'You may set individual tab colors when you create or edit a tab. Individual tab colors will override the colors set here unless you select Override Tab Colors below.',
	            'opts'=> array(
	                array(
	                   'key'           => 'fulltab_set_title_color',
            			'type'          => 'color', 
            			'default'		=> '#000000',
						'label'			=>  __( 'Tab Title Text','tabtastic' ),
	                ), 
	                array(
	                    'key'           => 'fulltab_set_title_bg',
           				'type'          => 'color', 
           				'default'		=> '#dddddd',
						'label'			=>  __( 'Tab Title Background','tabtastic' ),
									
	                ),
	                array(
	                    'key'           => 'fulltab_set_cont',
           				'type'          => 'color', 
           				'default'		=> '#000000',
						'label'			=>  __( 'Tab Content Text','tabtastic' ),
	                ),
	                array(
	                    'key'           => 'fulltab_set_cont_bg',
           				'type'          => 'color', 
           				'default'		=> '#ffffff',
						'label'			=>  __( 'Tab Content BG','tabtastic' ),
	                ),
	                array(
			            'key'           => 'color_override',
			            'type'          => 'check',  
			            'label'			=>  __( 'Override Individual Tab Colors?','tabtastic' ),

			        ),

	            )
	        );
		
			$options[] = array(

			'title' => __( 'Additional Options', 'tabtastic' ),
			'type'	=> 'multi',
			'col'		=> 1,
        	'opts'=> array(
				 array(
					'key'			=> 'fulltab_max_width',
					'type' 			=> 'text',
					'label' 	=> __( 'Width of Each Title Tab (Optional)', 'tabtastic' ),
				),
				 array(
					'key'			=> 'fulltab_nav_text',
					'type' 			=> 'text',
					'default'		=> '<i class="icon-align-justify"></i>',
					'label' 	=> __( 'Text for More Tabs Navigation. Icon class can be used here', 'tabtastic' ),
				),
				array(
                   'key'           => 'fulltab_nav_color',
        			'type'          => 'color', 
        			'default'		=> '#000000',
					'label'			=> __( 'More Tabs Navigation Text Color', 'tabtastic' ),
                ), 
                array(
                    'key'           => 'fulltab_nav_bg',
       				'type'          => 'color', 
       				'default'		=> '#ffffff',
					'label'			=> __( 'More Tabs Navigation Background Color', 'tabtastic' ),
								
                ),

             )   

        ); 
        
        return $options;
    }
	
	
	
	
	/**
	* Section template.
	*/
   function section_template() {    
	
		$fulltabs_id = 'tabs-'.$this->get_the_id();
		global $post;

		// Options
			
			$fulltab_set = ( $this->opt( 'fulltab_set'  ) ) ? $this->opt( 'fulltab_set'  ) : null;
			$fulltab_set = preg_replace('/[^a-zA-Z0-9-]/', '', $fulltab_set);
			
		// Actions	
			// Set up the query for this page
				$orderby = ( $this->opt('fulltab_orderby' ) ) ? $this->opt('fulltab_orderby' ) : 'ID';
				$order = ( $this->opt('fulltab_order' ) ) ? $this->opt('fulltab_order' ) : 'DESC';
				$params = array( 'orderby'	=> $orderby, 'order' => $order, 'post_type'	=> $this->ptID, 'posts_per_page' => -1 );
				$params[ $this->taxID ] = ( $this->opt( 'fulltab_set'  ) ) ? $this->opt( 'fulltab_set'  ) : null;
				$fulltabs_query = new WP_Query( $params );
				$title_count = 0;
				$content_count = 0;

				if(empty($fulltabs_query->posts)){
					echo setup_section_notify( $this, 'Add Tab Posts To Activate.', admin_url('edit.php?post_type='.$this->ptID), 'Add Posts' );
					return;
				}
		

				
		// Begin Template	


			?>

			<div class="fulltabs tabbable hentry <?php echo $fulltabs_id;?>" >
				<ul class="nav nav-tabs ">
					<?php while ( $fulltabs_query->have_posts() ) : $fulltabs_query->the_post();
					

						$this->draw_fulltab_title();
					endwhile; ?>
				</ul>
			<div class="tab-content">
				<?php while ( $fulltabs_query->have_posts() ) : $fulltabs_query->the_post(); 
					$this->draw_fulltab_content();
			 	endwhile; ?>
		</div>
				
		<?php	
	}


				
	function draw_fulltab_title(){
		global $post; global $pagelines_ID;	
		global $title_count;	
		
		$fulltabs_id = 'tabs-'.$this->get_the_id();		
		$fulltab_set_title_color = ( $this->opt( 'fulltab_set_title_color'  ) ) ? $this->opt( 'fulltab_set_title_color'  ) : '000';
		$fulltab_set_title_bg = ( $this->opt( 'fulltab_set_title_bg'  ) ) ? $this->opt( 'fulltab_set_title_bg'  ) : 'dddddd';
		$fulltab_title_color = ( get_post_meta($post->ID, 'fulltab_title_color', true ));
		$fulltab_title_bg = ( get_post_meta( $post->ID, 'fulltab_title_background', true ) );
		$color_override = ( $this->opt( 'color_override'  ) ) ? $this->opt( 'color_override'  ) : null;
		if($this->opt( 'color_override'  )) {
			$title_color = '#' . $fulltab_set_title_color;
		}
		elseif(get_post_meta($post->ID, 'fulltab_title_color', true)) {
			$title_color = $fulltab_title_color;
		} else {
			$title_color = '#' . $fulltab_set_title_color;
		}
		if($this->opt( 'color_override'  )) {
			$title_background = '#' . $fulltab_set_title_bg ;
		}
		elseif(get_post_meta($post->ID, 'fulltab_title_background', true)) {
			$title_background = $fulltab_title_bg;
		} else {
			$title_background = '#' . $fulltab_set_title_bg;
		}
		
		$active_background = $this->adjustBrightness($title_background, -20);
		$post_number= $post->ID . '-' .$fulltabs_id;	
		$title_count++;
		if($title_count == 1) {
		 printf('<li class="tab tab-%s active"><a href="#tab-%s" data-toggle="tab">',
			$post_number,
			$post_number
			
		);
		 the_title();
		
		?>
	</a></li>
	<?php
		} else {
			 printf('<li class="tab tab-%s"><a href="#tab-%s" data-toggle="tab">',
			$post_number,
			$post_number
			
		);
		 the_title();
		
		?>
	</a></li>
	<?php
		}
		?>
			<style type="text/css">
				.fulltabs.<?php echo $fulltabs_id ?> li.tab-<?php echo $post_number ?>  a {
					background-color: <?php echo $title_background ?>;
					color: <?php echo $title_color ?>;
				}
				.fulltabs.<?php echo $fulltabs_id ?> li.active.tab-<?php echo $post_number ?> a
				 {
					background-color: <?php echo $active_background ?>;
				}
				.fulltabs.<?php echo $fulltabs_id ?> li.tab-<?php echo $post_number ?> a:hover  {
					background-color: <?php echo $active_background ?>;
				}
			</style>
			<?php

	}

	function draw_fulltab_content() {
		global $post; global $pagelines_ID;
		global $content_count;
		$edit_link = get_edit_post_link( $post->ID);
		
		$fulltabs_id = 'tabs-'.$this->get_the_id();
		$fulltab_set_cont = ( $this->opt( 'fulltab_set_cont'  ) ) ? $this->opt( 'fulltab_set_cont'  ) : '000';
		$fulltab_set_cont_bg = ( $this->opt( 'fulltab_set_cont_bg'  ) ) ? $this->opt( 'fulltab_set_cont_bg'  ) : 'ffffff';
		$fulltab_cont = ( get_post_meta($post->ID, 'fulltab_content_color', true ));
		$fulltab_cont_bg = ( get_post_meta( $post->ID, 'fulltab_content_background', true ) );
		$color_override = ( $this->opt( 'color_override'  ) ) ? $this->opt( 'color_override'  ) : null;
		
		if($color_override) {
			$style_color = '#' . $fulltab_set_cont;
		}
		elseif(get_post_meta($post->ID, 'fulltab_content_color', true)) {
			$style_color = $fulltab_cont;
		} else {
			$style_color = '#' . $fulltab_set_cont;
		}
		if($color_override) {
			$style_background = '#' . $fulltab_set_cont_bg;
		}
		elseif(get_post_meta($post->ID, 'fulltab_content_background', true)) {
			$style_background =  $fulltab_cont_bg;
		} else {
			$style_background = '#' . $fulltab_set_cont_bg;
		}

		
		$post_number= $post->ID . '-' .$fulltabs_id;			
		$content_count++;
		if($content_count == 1) {
		printf('<div class="tab-pane fade in well tab-%s active" id="tab-%s">' , $post_number,  $post_number);
					the_content(); 
					if ( current_user_can('edit_post' , $post->ID) ) {       
				    printf('<a href="%s">[edit]</a>' , $edit_link);
				}
				?>
				</div>
			<?php
		} else {
			printf('<div class="tab-pane fade well tab-%s" id="tab-%s">' , $post_number,  $post_number);
					the_content();
					if ( current_user_can('edit_post' , $post->ID) ) {       
				    printf('<a href="%s">[edit]</a>' , $edit_link);
				}
				?>
				</div>
			<?php

		}

		
	
		?>
			<style type="text/css">
				.fulltabs.<?php echo $fulltabs_id ?> .tab-pane.well.tab-<?php echo $post_number ?> {
					background-color: <?php echo $style_background ?>;
					color: <?php echo $style_color ?>;
				}
				
			</style>
			<?php
	}
			

function tabtastic_default_tabs($post_type){

	$d = array_reverse( $this->get_default_tabs() );

	foreach($d as $dp){
		// Create post object
		$default_post = array();
		$default_post['post_title'] = $dp['title'];
		$default_post['post_content'] = $dp['text'];
		$default_post['post_type'] = $post_type;
		$default_post['post_status'] = 'publish';
		if ( defined( 'ICL_LANGUAGE_CODE' ) )
			$default_post['icl_post_language'] = ICL_LANGUAGE_CODE;
		$newPostID = wp_insert_post( $default_post );

		if(isset($dp))
		

		wp_set_object_terms($newPostID, 'default-tabs', $this->taxID );

		// Add other default sets, if applicable.
		if(isset($dp['set']))
			wp_set_object_terms($newPostID, $dp['set'], $this->taxID, true);

	}
}
	
		/**
		*
		* @TODO document
		*
		*/
		function get_default_tabs(){
			$default_tabs[] = array(
			        				'title' => 'Create Tabs',
					        		'text' 	=> 'This is an tab set.'
			    				);
			$default_tabs[] = array(
								       'title' => 'Second Tab',
										'text' 	=> 'This is an tab set.'
								);
			$default_tabs[] = array(
										'title' => 'Third Tab',
										'text' 	=> 'This is an tab set.'
								    				);
			return apply_filters('tabtastic_default_tabs', $default_tabs);
		}

		function adjustBrightness($hex, $steps) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Format the hex color string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Get decimal values
	    $r = hexdec(substr($hex,0,2));
	    $g = hexdec(substr($hex,2,2));
	    $b = hexdec(substr($hex,4,2));

	    // Adjust number of steps and keep it inside 0 to 255
	    $r = max(0,min(255,$r + $steps));
	    $g = max(0,min(255,$g + $steps));  
	    $b = max(0,min(255,$b + $steps));

	    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
	    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
	    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

	    return '#'.$r_hex.$g_hex.$b_hex;
	}
	

	
	

	
} /* End of section class - No closing php tag needed */