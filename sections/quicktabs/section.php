<?php
/*
	Section: Quick Tabs
	Author: elSue
	Author URI: http://dms.elsue.com
	Description: Creates tabs using DMS Toolbox and Front End Editing
	Class Name: QuickTabs
	Version: 1.0.4
	Filter: component
	PageLines: true
	v3: true
	Demo: http://dms.elsue.com/tabtastic/
*/

/**
 * Quick Tabs Section
 *
 * @package PageLines Framework
 * @author PageLines
 */

	
class QuickTabs extends PageLinesSection {

	const version = '1.0.4';

    // Begin Section Functions 

    function section_styles(){
		wp_enqueue_script( 'tabdrop', $this->base_url.'/../../js/bootstrap-tabdrop.js',array( 'jquery' ), self::version);
		
	}

	
	
	function section_head(){
		// Variables
		$quicktabs_id = $this->get_the_id();
		$quicktabs_width = ($this->opt('quicktabs_max_width')) ? $this->opt('quicktabs_max_width') : null;
		$quicktabs_height = ($this->opt('quicktabs_min_height')) ? $this->opt('quicktabs_min_height') : null;
		$quicktabs_nav_text = ($this->opt('quicktabs_nav_text')) ? $this->opt('quicktabs_nav_text') : __('<i class="icon-align-justify"></i>', 'tabtastic');
		$quicktabs_nav_color = ( $this->opt( 'quicktabs_nav_color'  ) ) ? $this->opt( 'quicktabs_nav_color'  ) : '000000';
		$quicktabs_nav_bg = ( $this->opt( 'quicktabs_nav_bg'  ) ) ? $this->opt( 'quicktabs_nav_bg'  ) : 'ffffff';
		$quicktabs_nav_hover = $this->adjustBrightness($quicktabs_nav_bg, -20);
		$quicktabs_array = $this->opt('quicktabs_array');
		$count=1;
		if( !$quicktabs_array || $quicktabs_array == 'false' || !is_array($quicktabs_array) ){
			$quicktabs_array = array( array(), array(), array() );
		}

		
		?>
		<script>

		
			jQuery(document).ready(function(){
			

				// Javascript to enable link to tab
				var url = document.location.toString();
				if (url.match('#quicktab-<?php echo $quicktabs_id ?>')) {
				    jQuery('#quicktabs<?php echo $quicktabs_id ?> .nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
				    if (location.hash) { 
				    	
					    var quicktabtab_height = jQuery('#quicktabs<?php echo $quicktabs_id ?> .nav-tabs').height();  
					    
					    jQuery('body').animate({
					   		scrollTop: jQuery("#quicktabs<?php echo $quicktabs_id ?> .nav-tabs").offset().top + -(quicktabtab_height)
						});
				   }
				    
				} 

				jQuery('a').click(function(e){
					// Javascript to enable link to tab
				var url = jQuery(e.target).attr("href");
				if(url) {
				if (url.match('#quicktab-<?php echo $quicktabs_id ?>')) {
					
						jQuery('#quicktabs<?php echo $quicktabs_id ?> .nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
				    
				    if (location.hash) { 
				    var fulltab_height = jQuery('#quicktabs<?php echo $quicktabs_id ?> .nav-tabs').height();  
				     
				    	jQuery('body').animate({
				   			scrollTop: jQuery('#quicktabs<?php echo $quicktabs_id;?> .nav-tabs').offset().top + -(fulltab_height * 2)
					});
				   }
				    
				} 	
			}

				});



				// Initiate Tabdrop
				jQuery('#quicktabs<?php echo $quicktabs_id ?> .quicktabs .nav-tabs').tabdrop({
					text: '<?php echo $quicktabs_nav_text ?>'
				});

			});
			
		
		</script>

		<?php 
		// Apply Width
		if($quicktabs_width) {
			?>
			<style type="text/css">
				#quicktabs<?php echo $quicktabs_id ?> li.tab a{
					width: <?php echo $quicktabs_width ?>px;
				}

		</style>
		<?php
	}
		// Apply Height
		if($quicktabs_height) {
			?>
			<style type="text/css">
				#quicktabs<?php echo $quicktabs_id ?>  .tab-content > .tab-pane {
					min-height: <?php echo $quicktabs_height ?>px;
				}

		</style>
		<?php
		}
		// Styling for Tabdrop Dropdown
		?>
			<style>
				#quicktabs<?php echo $quicktabs_id ?> .tabdrop .dropdown-toggle {
					color: #<?php echo $quicktabs_nav_color ?>;
					background: #<?php echo $quicktabs_nav_bg ?>;
				}
				#quicktabs<?php echo $quicktabs_id ?> .tabdrop .caret{
					border-top-color: #<?php echo $quicktabs_nav_color ?>;
					border-bottom-color: #<?php echo $quicktabs_nav_color ?>;
					
				}
				#quicktabs<?php echo $quicktabs_id ?> .tabdrop .dropdown-toggle:hover {
					background: <?php echo $quicktabs_nav_hover ?>;
				}
				
			</style>
		<?php
			if( is_array($quicktabs_array) ){
			foreach( $quicktabs_array as $quicktab ){
				$quicktab_id = $quicktabs_id.'-'.$count;
				$active_tabs_id =  $quicktab_id;
				$quicktab_icon = pl_array_get( 'quicktab_icon', $quicktab );
				$quicktab_set_title_color = ( $this->opt( 'quicktab_set_title_color'  ) ) ? $this->opt( 'quicktab_set_title_color'  ) : '000';
				$quicktab_set_title_bg = ( $this->opt( 'quicktab_set_title_bg'  ) ) ? $this->opt( 'quicktab_set_title_bg'  ) : 'dddddd';
				$color_override = ( $this->opt( 'color_override'  ) ) ? $this->opt( 'color_override'  ) : null;
				$quicktab_title_color = pl_array_get( 'quicktab_title_color', $quicktab ,'000');
				$quicktab_title_bg = pl_array_get( 'quicktab_title_bg', $quicktab , 'dedede');
				if($this->opt( 'color_override'  )) {
					$title_color = '#' . $quicktab_set_title_color;
				}
				else {
					$title_color = '#' . $quicktab_title_color;
				}
				if($this->opt( 'color_override'  )) {
					$title_background = '#' . $quicktab_set_title_bg ;
				}
				else {
					$title_background = '#' . $quicktab_title_bg;
				}
				$quicktab_active = $this->adjustBrightness($title_background, -20);
			
			// Styles for Background Colors and Text Color
			
			?>
			<style type="text/css">
				#quicktabs<?php echo $quicktabs_id ?> .tab-<?php echo $active_tabs_id ?>  a {
					background-color: <?php echo $title_background ?>;
					color: <?php echo $title_color ?>;
				}

				#quicktabs<?php echo $quicktabs_id ?> .dropdown .tab-<?php echo $active_tabs_id ?>  a {
					min-width: 120px;

				}
				#quicktabs<?php echo $quicktabs_id ?> .active.tab-<?php echo $active_tabs_id ?> a
				 {
					background-color: <?php echo $quicktab_active ?>;
				}
				#quicktabs<?php echo $quicktabs_id ?> .tab-<?php echo $active_tabs_id ?> a:hover  {
					background-color: <?php echo $quicktab_active ?>;
				}
		
		</style>

		<script>
			
		jQuery(document).ready(function(){
			
  			 //Set height equally for all tabs
			var height = 0;
			jQuery('.quicktabs-id-<?php echo $quicktabs_id ?> li.tab a').each(function(){
			    if(height < jQuery(this).height())
			        height = jQuery(this).height();    
			});
			
			jQuery(".quicktabs-id-<?php echo $quicktabs_id ?> li.tab a").css("height",(height)+"px"); 
			jQuery(".quicktabs-id-<?php echo $quicktabs_id ?> ul.dropdown-menu li.tab a").css("height", "auto"); 

				

		});

		</script>
			
		<?php
		$count++;
		}
	}
			
	}
	

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'Tabs Configuration', 'tabtastic' ),
			'type'	=> 'multi',
			'col'		=> 2,
			'opts'	=> array(
				array(
					'key'			=> 'quicktabs_max_width',
					'type' 			=> 'text',
					'label' 		=> __( 'Width of Each Title Tab (Optional). Enter number (like 150), px will be added automatically.', 'tabtastic' ),
				),
				array(
					'key'			=> 'quicktabs_min_height',
					'type' 			=> 'text',
					'label' 		=> __( 'Minimum Height for Tab Content (Optional). Enter number (like 200), px will be added automatically.', 'tabtastic' ),
				),
				array(
					'key'			=> 'quicktabs_nav_text',
					'type' 			=> 'text',
					'default'		=> '<i class="icon-align-justify"></i>',
					'label' 		=> __( 'Text for More Tabs Navigation. Icon class can be used here', 'tabtastic' ),
				),
				array(
                   'key'           => 'quicktabs_nav_color',
        			'type'          => 'color', 
        			'default'		=> '#000000',
					'label'			=> __( 'More Tabs Navigation Text Color', 'tabtastic' ),
                ), 
                array(
                    'key'           => 'quicktabs_nav_bg',
       				'type'          => 'color', 
       				'default'		=> '#ffffff',
					'label'			=> __( 'More Tabs Navigation Background Color', 'tabtastic' ),
								
                ),
				
			)

		);

		$options[] = array(
			'key'		=> 'quicktabs_array',
	    	'type'		=> 'accordion', 
			'col'		=> 1,
			'title'		=> __('Quicktabs Tabs', 'tabtastic'), 
			'post_type'	=> __('Quicktabs', 'tabtastic'), 
			'opts'	=> array(
				array(
					'key'		=> 'quicktab_icon',
					'label'		=> __( 'Tab Icon', 'tabtastic' ),
					'type'		=> 'select_icon',
				),
				array(
					'key'		=> 'quicktab_title',
					'label'		=> __( 'Tab Title', 'tabtastic' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'quicktab_text',
					'label'	=> __( 'Tab Text', 'tabtastic' ),
					'type'	=> 'textarea'
				),
				
                array(
                   'key'           => 'quicktab_title_color',
        			'type'          => 'color', 
        			'default'		=> '#000000',
					'label'			=> __( 'Tab Title Text Color', 'tabtastic' ),
                ), 
                array(
                    'key'           => 'quicktab_title_bg',
       				'type'          => 'color', 
       				'default'		=> '#dedede',
					'label'			=> __( 'Tab Title Background Color', 'tabtastic' ),
								
                ),
                array(
                    'key'           => 'quicktab_cont_color',
       				'type'          => 'color', 
       				'default'		=> '#000000',
					'label'			=> __( 'Tab Content Text Color', 'tabtastic' ),
                ),
                array(
                    'key'           => 'quicktab_cont_bg',
       				'type'          => 'color', 
       				'default'		=> '#ffffff',
					'label'			=> __( 'Tab Content Background Color', 'tabtastic' ),
                ),
				

			)
	    );

		$options[] = array(
	            'key'           => 'quicktab_set_colors',
	            'type'          => 'multi', 
	            'title'         => 'QuickTab Set Colors (Optional)', 
	            'col'			=> 1,
	            'help'			=> 'If you want all QuickTabs to be the same color, check Color Override and enter your colors below.',
	            'opts'=> array(
	            	array(
			            'key'           => 'color_override',
			            'type'          => 'check',  
			            'label'			=>  __( 'Override Individual Tab Colors?','tabtastic' ),

			        ),
	                array(
	                   'key'           => 'quicktab_set_title_color',
            			'type'          => 'color', 
            			'default'		=> '#000000',
						'label'			=>  __( 'Tab Title Text','tabtastic' ),
	                ), 
	                array(
	                    'key'           => 'quicktab_set_title_bg',
           				'type'          => 'color', 
           				'default'		=> '#dddddd',
						'label'			=>  __( 'Tab Title Background','tabtastic' ),
									
	                ),
	                array(
	                    'key'           => 'quicktab_set_cont',
           				'type'          => 'color', 
           				'default'		=> '#000000',
						'label'			=>  __( 'Tab Content Text','tabtastic' ),
	                ),
	                array(
	                    'key'           => 'quicktab_set_cont_bg',
           				'type'          => 'color', 
           				'default'		=> '#ffffff',
						'label'			=>  __( 'Tab Content BG','tabtastic' ),
	                ),

	            )
	        );

		return $options;

	}
	
		
	/**
	* Section template.
	*/
   function section_template( ) {
   	$dir = plugin_dir_path( __FILE__ );
   	
   	$quicktabs_id = 'quicktabs-id-'.$this->get_the_id();
   	printf('<div class="tabbable quicktabs %s hentry ">' , $quicktabs_id);
			
   	$this->draw_quicktab_title();
  	$this->draw_quicktab_content();
	
	echo '</div>';	
   	
	}

	function draw_quicktab_title() {
		$quicktabs_array = $this->opt('quicktabs_array');
		if( !$quicktabs_array || $quicktabs_array == 'false' || !is_array($quicktabs_array) ){
			$quicktabs_array = array( array(), array(), array() );
		}
		$quicktabs_id = $this->get_the_id();
		$output = '';
		$count = 1; 
		
		if( is_array($quicktabs_array) ){
			
			$quicktabs_tabs = count( $quicktabs_array );
			
			foreach( $quicktabs_array as $quicktab ){

			$quicktab_id = $quicktabs_id.'-'.$count;
			$quicktab_icon = pl_array_get( 'quicktab_icon', $quicktab );
			$quicktab_title = pl_array_get( 'quicktab_title', $quicktab, __('Quick Tab ', 'tabtastic')); 
			$icon_html = sprintf('<i class="icon icon-%s"></i>', $quicktab_icon);
			if($quicktab_icon != false)
				$quicktab_title = sprintf('<p data-sync="quicktabs_array%s_quicktab_title">%s %s</p>', $count, $icon_html, $quicktab_title.' ' );
			else
				$quicktab_title = sprintf('<p data-sync="quicktabs_array%s_quicktab_title">%s</p>', $count, $quicktab_title. ' ' );
				
			if ($count == 1) :
				$output .= sprintf(
				'<li class="tab tab-%s active"><a href="#quicktab-%s" data-toggle="tab">%s</a></li>',
				$quicktab_id,
				
				$quicktab_id,
				$quicktab_title
				
				
			);
			else :
				
				$output .= sprintf(
					'<li class="tab tab-%s"><a href="#quicktab-%s" data-toggle="tab">%s</a></li>',
					$quicktab_id,
					
					$quicktab_id,
					$quicktab_title
					
				
			);

			endif;

			$count++;
	
			}
		}	
		
		printf('<ul class="nav nav-tabs ">%s</ul>', $output);
	}


	function draw_quicktab_content() {
		$quicktabs_array = $this->opt('quicktabs_array');
		if( !$quicktabs_array || $quicktabs_array == 'false' || !is_array($quicktabs_array) ){
			$quicktabs_array = array( array(), array(), array() );
		}
		$quicktabs_id = $this->get_the_id();
		$output = '';
		$count = 1; 
		
		if( is_array($quicktabs_array) ){
			
			$quicktabs_tabs = count( $quicktabs_array );
			
			foreach( $quicktabs_array as $quicktab ){
			$quicktab_id = $quicktabs_id.'-'.$count;
			$quicktab_text = pl_array_get( 'quicktab_text', $quicktab, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id lectus sem. Cras consequat lorem.');	
			$quicktab_text = sprintf('<div data-sync="quicktabs_array%s_quicktab_text">%s</div>', $count, $quicktab_text );
			$quicktab_set_cont = ( $this->opt( 'quicktab_set_cont'  ) ) ? $this->opt( 'quicktab_set_cont'  ) : '000';
			$quicktab_set_cont_bg = ( $this->opt( 'quicktab_set_cont_bg'  ) ) ? $this->opt( 'quicktab_set_cont_bg'  ) : 'ffffff';	
			$quicktab_cont_color = pl_array_get( 'quicktab_cont_color', $quicktab ,'000');
			$quicktab_cont_bg = pl_array_get( 'quicktab_cont_bg', $quicktab , 'ffffff');
			$color_override = ( $this->opt( 'color_override'  ) ) ? $this->opt( 'color_override'  ) : null;
					
					if($color_override) {
						$style_color = '#' . $quicktab_set_cont;
					} else {
						$style_color = '#' . $quicktab_cont_color;
					}
					if($color_override) {
						$style_background = '#' . $quicktab_set_cont_bg;
					}
					else {
						$style_background = '#' . $quicktab_cont_bg;
					}
			
			if ($count == 1) :	

			$output .= sprintf(
				'<div class="tab-pane fade in active well" id="quicktab-%s" style="color: %s; background: %s;">%s</div>',
				$quicktab_id,
				$style_color,
				$style_background,
				$quicktab_text
				
				
			);

			else :
				$output .= sprintf(
				'<div class="tab-pane fade well" id="quicktab-%s" style="color: %s; background: %s;">%s</div>',
				$quicktab_id,
				$style_color,
				$style_background,
				$quicktab_text
				
				
			);

			endif;

			$count++;

			}
		}
		
		printf('<div class="tab-content ">%s</div>', $output);

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