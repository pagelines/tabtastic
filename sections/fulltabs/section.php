<?php
/*
	Section: FullTabs
	Author: elSue
	Author URI: http://www.elsue.com
	Description: Creates tabs and tab layouts
	Class Name: FullTabs
	Workswith: main,templates,morefoot,sidebar_wrap,sidebar1,sidebar2
	Cloning: true
	Version: 1.0
	Demo: http://pagelines.ellenjanemoore.com/tabs
*/

/**
 * Tabs Section
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
		wp_enqueue_script( 'tabdrop', $this->base_url.'/js/bootstrap-tabdrop.js',array( 'jquery' ), self::version);
		
		
	}


	
	function section_head(){
		// Initiate Tabdrop
		?>
		<script>
			jQuery(document).ready(function(){
			
				jQuery('.fulltabs .nav-tabs').tabdrop();
					jQuery('.fulltabs .nav-tabs').tabdrop().on("click", function(){
    jQuery('.fulltabs .nav-tabs').tabdrop('layout');
});

			});
			
		
		</script>
		<?php
		 
		}
	

	/**
	* PHP that always loads no matter if section is added or not.
	*/
	function section_persistent(){
		
		 add_shortcode('tabtastic',array(&$this,'tabtastic_shortcode'));	
		
	}
	
	

	// Section Options Method
    function section_opts(){
        $opts = array(
            array(
                'type'		=> 'select_taxonomy',
				'taxonomy_id'	=> $this->taxID,
				'default'		=> 'default-tabs',
                'title'         => 'Select Tab Set',
                'key'           => 'tab_set',
                'label'         => 'Tab Set'
                
            ),
            array(
            'key'           => 'tab_ordering',
            'type'          => 'multi',
            'default'		=> 'ID',
            'title'         => 'Tab Ordering', 
            'opts'=> array(
                array(
	            'key'           => 'tab_orderby',
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
                    'key'           => 'tab_order',
		            'type'          => 'select',
		            'default'		=> 'DESC', 
		            'label'         => 'Descending or Ascending?',
		            'opts'=> array(
		                'DESC' 		=> array('name' => __( 'Descending', 'tabtastic') ),
						'ASC' 		=> array('name' => __( 'Ascending', 'tabtastic') ),
								
                )
		           
            )
                
          )
		),
			array(
	            'key'           => 'tab_set_colors',
	            'type'          => 'multi', 
	            'title'         => 'Tab Colors', 
	            'help'			=> 'You may set individual tab colors when you create or edit a tab. Individual tab colors will override the colors set here unless you select Override Tab Colors below.',
	            'opts'=> array(
	                array(
	                   'key'           => 'tab_set_title_color',
            			'type'          => 'color', 
            			'default'		=> '#000000',
						'label'			=> 'Tab Title Text',
	                ), 
	                array(
	                    'key'           => 'tab_set_title_bg',
           				'type'          => 'color', 
           				'default'		=> '#dddddd',
						'label'			=> 'Tab Title Background',
									
	                ),
	                array(
	                    'key'           => 'tab_set_cont',
           				'type'          => 'color', 
           				'default'		=> '#000000',
						'label'			=> 'Tab Content Text',
	                ),
	                array(
	                    'key'           => 'tab_set_cont_bg',
           				'type'          => 'color', 
           				'default'		=> '#ffffff',
						'label'			=> 'Tab Content BG',
	                ),
	                array(
			            'key'           => 'color_override',
			            'type'          => 'check',  
			            'label'			=> 'Override Individual Tab Colors?',

			        )

	              )
	            ),
				 array(
					'key'			=> 'tab_max_width',
					'type' 			=> 'text',
					
					'label' 	=> __( 'Max Width of Each Title Tab (Optional)', 'tabtastic' ),
				),


        ); 
        return $opts;
    }
	
	
	
	
	/**
	* Section template.
	*/
   function section_template() {    
	
		$fulltabs_id = 'tabs-clone'.$this->get_the_id();
		global $post;

		// Options
			
			$tab_set = ( $this->opt( 'tab_set'  ) ) ? $this->opt( 'tab_set'  ) : null;
			$tab_set = preg_replace('/[^a-zA-Z0-9-]/', '', $tab_set);
			
		// Actions	
			// Set up the query for this page
				$orderby = ( $this->opt('tab_orderby' ) ) ? $this->opt('tab_orderby' ) : 'ID';
				$order = ( $this->opt('tab_order' ) ) ? $this->opt('tab_order' ) : 'DESC';
				$params = array( 'orderby'	=> $orderby, 'order' => $order, 'post_type'	=> $this->ptID, 'posts_per_page' => -1 );
				$params[ $this->taxID ] = ( $this->opt( 'tab_set'  ) ) ? $this->opt( 'tab_set'  ) : null;
				$tabs_query = new WP_Query( $params );
				$title_count = 0;
				$content_count = 0;

				if(empty($tabs_query->posts)){
					echo setup_section_notify( $this, 'Add Tab Posts To Activate.', admin_url('edit.php?post_type='.$this->ptID), 'Add Posts' );
					return;
				}
		

				
		// Begin Template	


			?>

			<div class="fulltabs tabbable hentry <?php echo $fulltabs_id;?>" >
				<ul class="nav nav-tabs ">
					<?php while ( $tabs_query->have_posts() ) : $tabs_query->the_post();
					

						$this->draw_tab_title();
					endwhile; ?>
				</ul>
			<div class="tab-content">
				<?php while ( $tabs_query->have_posts() ) : $tabs_query->the_post(); 
					$this->draw_tab_content();
			 	endwhile; ?>
		</div>
				
		<?php	
	}


				
	function draw_tab_title(){
		global $post; global $pagelines_ID;	
		global $title_count;	
		
		$fulltabs_id = $this->get_the_id();		
		$tab_set_title_color = ( $this->opt( 'tab_set_title_color'  ) ) ? $this->opt( 'tab_set_title_color'  ) : '000';
		$tab_set_title_bg = ( $this->opt( 'tab_set_title_bg'  ) ) ? $this->opt( 'tab_set_title_bg'  ) : 'dddddd';
		$tab_title_color = ( get_post_meta($post->ID, 'tab_title_color', true ));
		$tab_title_bg = ( get_post_meta( $post->ID, 'tab_title_background', true ) );
		$color_override = ( $this->opt( 'color_override'  ) ) ? $this->opt( 'color_override'  ) : null;
		
		if($this->opt( 'color_override'  )) {
			$title_color = '#' . $tab_set_title_color . ';';
		}
		elseif(get_post_meta($post->ID, 'tab_title_color', true)) {
			$title_color = $tab_title_color . ';';
		} else {
			$title_color = '#' . $tab_set_title_color . ';';
		}
		if($this->opt( 'color_override'  )) {
			$title_background = '#' . $tab_set_title_bg . ';';
		}
		elseif(get_post_meta($post->ID, 'tab_title_background', true)) {
			$title_background = $tab_title_bg . ';';
		} else {
			$title_background = '#' . $tab_set_title_bg . ';';
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
				#fulltabs<?php echo $fulltabs_id ?> .tab-<?php echo $post_number ?>  a {
					background-color: <?php echo $title_background ?>;
					color: <?php echo $title_color ?>;
				}
				#fulltabs<?php echo $fulltabs_id ?> .active.tab-<?php echo $post_number ?> a
				 {
					background-color: <?php echo $active_background ?>;
				}
				#fulltabs<?php echo $fulltabs_id ?> .tab-<?php echo $post_number ?> a:hover  {
					background-color: <?php echo $active_background ?>;
				}
			</style>
			<?php

	}

	function draw_tab_content() {
		global $post; global $pagelines_ID;
		global $content_count;
		
		$fulltabs_id = $this->get_the_id();
		$tab_set_cont = ( $this->opt( 'tab_set_cont'  ) ) ? $this->opt( 'tab_set_cont'  ) : '000';
		$tab_set_cont_bg = ( $this->opt( 'tab_set_cont_bg'  ) ) ? $this->opt( 'tab_set_cont_bg'  ) : 'ffffff';
		$tab_cont = ( get_post_meta($post->ID, 'tab_content_color', true ));
		$tab_cont_bg = ( get_post_meta( $post->ID, 'tab_content_background', true ) );
		$color_override = ( $this->opt( 'color_override'  ) ) ? $this->opt( 'color_override'  ) : null;
		
		if($color_override) {
			$style_color = 'color:' . $tab_set_cont . ';';
		}
		elseif(get_post_meta($post->ID, 'tab_content_color', true)) {
			$style_color = 'color:' . $tab_cont . ';';
		} else {
			$style_color = 'color:' . $tab_set_cont . ';';
		}
		if($color_override) {
			$style_background = 'background:' . $tab_set_cont_bg . ';';
		}
		elseif(get_post_meta($post->ID, 'tab_content_background', true)) {
			$style_background = 'background:' . $tab_cont_bg . ';';
		} else {
			$style_background = 'background:' . $tab_set_cont_bg . ';';
		}

		
		$post_number= $post->ID . '-' .$fulltabs_id;			
		$content_count++;
		if($content_count == 1) {
		printf('<div class="tab-pane active well" id="tab-%s" style="%s %s">' , $post_number, $style_color, $style_background);
					the_content() ?>
				</div>
			<?php
		} else {
			printf('<div class="tab-pane well" id="tab-%s" style="%s %s">' , $post_number, $style_color, $style_background);
					the_content() ?>
				</div>
			<?php

		}
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