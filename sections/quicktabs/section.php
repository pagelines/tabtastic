<?php
/*
	Section: Quick Tabs
	Author: elSue
	Author URI: http://dms.elsue.com
	Description: Creates tabs using DMS Toolbox and Front End Editing
	Class Name: QuickTabs
	Version: 1.0
	Demo: http://tabtastic.ellenjanemoore.com/tabs
*/

/**
 * Quick Tabs Section
 *
 * @package PageLines Framework
 * @author PageLines
 */

	
class QuickTabs extends PageLinesSection {

	const version = '1.0';

    // Begin Section Functions 

    function section_styles(){
		wp_enqueue_script( 'tabdrop', $this->base_url.'/../../js/bootstrap-tabdrop.js',array( 'jquery' ), self::version);
		
	}

	
	
	function section_head(){
		// Variables
		$quicktabs_id = $this->get_the_id();
		$quicktabs_width = ($this->opt('quicktabs_max_width')) ? $this->opt('quicktabs_max_width') : null;
		$quicktabs_nav_text = ($this->opt('quicktabs_nav_text')) ? $this->opt('quicktabs_nav_text') : __('<i class="icon-align-justify"></i>', 'tabtastic');
		$quicktabs_nav_color = ( $this->opt( 'quicktabs_nav_color'  ) ) ? $this->opt( 'quicktabs_nav_color'  ) : '000000';
		$quicktabs_nav_bg = ( $this->opt( 'quicktabs_nav_bg'  ) ) ? $this->opt( 'quicktabs_nav_bg'  ) : 'ffffff';
		$quicktabs_nav_hover = $this->adjustBrightness($quicktabs_nav_bg, -20);
		$quicktabs_array = $this->opt('quicktabs_array');
		$count=1;

		// Initiate Tabdrop
		?>
		<script>
			jQuery(document).ready(function(){
				jQuery('.quicktabs .nav-tabs').tabdrop({
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

			foreach( $quicktabs_array as $quicktab ){
				$quicktab_id = $count++.'-'.$quicktabs_id;
				$active_tabs_id =  $quicktab_id;
				$quicktab_icon = pl_array_get( 'quicktab_icon', $quicktab );
				$quicktab_title_color = pl_array_get( 'quicktab_title_color', $quicktab ,'000');
				$quicktab_title_bg = pl_array_get( 'quicktab_title_bg', $quicktab , 'dedede');
				$quicktab_active = $this->adjustBrightness($quicktab_title_bg, -20);
			
			// Styles for Background Colors and Text Color
			
			?>
			<style type="text/css">
				#quicktabs<?php echo $quicktabs_id ?> .tab-<?php echo $active_tabs_id ?>  a {
					background-color: #<?php echo $quicktab_title_bg ?>;
					color: #<?php echo $quicktab_title_color ?>;
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
			//+20 because of the top-offset
			jQuery(".quicktabs-id-<?php echo $quicktabs_id ?> li.tab a").css("height",(height)+"px"); 

				

		});

		</script>
			
		<?php
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
					'label' 	=> __( 'Width of Each Title Tab (Optional)', 'tabtastic' ),
				),
				array(
					'key'			=> 'quicktabs_nav_text',
					'type' 			=> 'text',
					'default'		=> '<i class="icon-align-justify"></i>',
					'label' 	=> __( 'Text for More Tabs Navigation. Icon class can be used here', 'tabtastic' ),
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
		$quicktabs_id = $this->get_the_id();
		$output = '';
		$count = 1; 
		
		if( is_array($quicktabs_array) ){
			
			$quicktabs_tabs = count( $quicktabs_array );
			
			foreach( $quicktabs_array as $quicktab ){

			$quicktab_id = $count++.'-'.$quicktabs_id;
			$quicktab_icon = pl_array_get( 'quicktab_icon', $quicktab );
			$quicktab_title = pl_array_get( 'quicktab_title', $quicktab, __('Quick Tab ', 'tabtastic')); 
			$icon_html = sprintf('<i class="icon icon-%s"></i>', $quicktab_icon);
			if($quicktab_icon != false)
				$quicktab_title = sprintf('<p data-sync="quicktabs_array%s_quicktab_title">%s %s</p>', $count, $icon_html, $quicktab_title.' ' );
			else
				$quicktab_title = sprintf('<p data-sync="quicktabs_array%s_quicktab_title">%s</p>', $count, $quicktab_title. ' ' );
				
			if ($quicktab_id == 1) :
				$output .= sprintf(
				'<li class="tab tab-%s active"><a href="#tab-%s" data-toggle="tab">%s</a></li>',
				$quicktab_id,
				
				$quicktab_id,
				$quicktab_title
				
				
			);
			else :
				
				$output .= sprintf(
					'<li class="tab tab-%s"><a href="#tab-%s" data-toggle="tab">%s</a></li>',
					$quicktab_id,
					
					$quicktab_id,
					$quicktab_title
					
				
			);

			endif;
	
			}
		}	
		
		printf('<ul class="nav nav-tabs ">%s</ul>', $output);
	}


	function draw_quicktab_content() {
		$quicktabs_array = $this->opt('quicktabs_array');
		$quicktabs_id = $this->get_the_id();
		$output = '';
		$count = 1; 
		
		if( is_array($quicktabs_array) ){
			
			$quicktabs_tabs = count( $quicktabs_array );
			
			foreach( $quicktabs_array as $quicktab ){
			$quicktab_id = $count++.'-'.$quicktabs_id;
			$quicktab_text = pl_array_get( 'quicktab_text', $quicktab, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id lectus sem. Cras consequat lorem.');	
			$quicktab_text = sprintf('<div data-sync="quicktabs_array%s_quicktab_text">%s</div>', $count, $quicktab_text );
			$quicktab_title_color = pl_array_get( 'quicktab_title_color', $quicktab ,'000');
				
			$quicktab_cont_color = pl_array_get( 'quicktab_cont_color', $quicktab ,'000');
			$quicktab_cont_bg = pl_array_get( 'quicktab_cont_bg', $quicktab , 'ffffff');
			
			
			if ($quicktab_id == 1) :	

			$output .= sprintf(
				'<div class="tab-pane fade in active well" id="tab-%s" style="color: #%s; background: #%s;">%s</div>',
				$quicktab_id,
				$quicktab_cont_color,
				$quicktab_cont_bg,
				$quicktab_text
				
				
			);

			else :
				$output .= sprintf(
				'<div class="tab-pane fade well" id="tab-%s" style="color: #%s; background: #%s;">%s</div>',
				$quicktab_id,
				$quicktab_cont_color,
				$quicktab_cont_bg,
				$quicktab_text
				
				
			);

			endif;

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