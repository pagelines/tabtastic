<?php
/*
	Section: Quick Tabs
	Author: elSue
	Author URI: http://www.elsue.com
	Description: Creates tabs using DMS Toolbox and Front End Editing
	Class Name: QuickTabs
	Version: 1.0
	Demo: http://pagelines.ellenjanemoore.com/tabs
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
		wp_enqueue_script( 'tabdrop', $this->base_url.'/js/bootstrap-tabdrop.js',array( 'jquery' ), self::version, true);
		
	}

	
	
	function section_head(){
		$quicktabs_id = $this->get_the_id();
		$quicktabs = ($this->opt('quicktabs_count')) ? $this->opt('quicktabs_count') : $this->default_limit;
		$quicktabs_width = ($this->opt('quicktabs_max_width')) ? $this->opt('quicktabs_max_width') : null;
		
		$count=1;

		// Initiate Tabdrop
		?>
		<script>
			jQuery(document).ready(function(){
				jQuery('.quicktabs .nav-tabs').tabdrop();

			});
			
		
		</script>
		<?php if($quicktabs_width) {
			?>
			<style type="text/css">
				#quicktabs<?php echo $quicktabs_id ?> li.tab {
					width: <?php echo $quicktabs_width ?>px;
				}
		</style>
		<?php
		}

		

		
		
		for($i = 1; $i <= $quicktabs; $i++):
			$quicktab_id = $count++.'-'.$quicktabs_id;
			$active_tabs_id =  $quicktab_id;
			$quicktab_title_color = ( $this->opt('quicktab_title_color_'.$i )) ? $this->opt('quicktab_title_color_'.$i) :'000';
			$quicktab_title_bg = ( $this->opt('quicktab_title_bg_'.$i )) ? $this->opt('quicktab_title_bg_'.$i) :'dddddd';
			$quicktab_active = $this->adjustBrightness($this->opt('quicktab_title_bg_'.$i ), -20);
			$quicktab_hover = $this->adjustBrightness($this->opt('quicktab_title_bg_'.$i ), -20);

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
			
  			 //Set height
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
		endfor;
			
		}
	

	var $default_limit = 4;

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'Tabs Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'quicktabs_count',
					'type' 			=> 'count_select',
					'count_start'	=> 1,
					'count_number'	=> 12,
					'default'		=> 4,
					'label' 	=> __( 'Number of Tabs to Configure', 'pagelines' ),
				),
				array(
					'key'			=> 'quicktabs_max_width',
					'type' 			=> 'text',
					
					'label' 	=> __( 'Max Width of Each Title Tab', 'pagelines' ),
				),
				
			)

		);

		$quicktabs = ($this->opt('quicktabs_count')) ? $this->opt('quicktabs_count') : $this->default_limit;
		
		for($i = 1; $i <= $quicktabs; $i++){

			$opts = array(

				array(
					'key'		=> 'quicktab_icon_'.$i,
					'label'		=> __( 'Tab Icon', 'pagelines' ),
					'type'		=> 'select_icon',
				),
				array(
					'key'		=> 'quicktab_title_'.$i,
					'label'		=> __( 'Tab Title', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'quicktab_text_'.$i,
					'label'	=> __( 'Tab Text', 'pagelines' ),
					'type'	=> 'textarea'
				),
				
                array(
                   'key'           => 'quicktab_title_color_'.$i,
        			'type'          => 'color', 
        			'default'		=> '#000000',
					'label'			=> 'Tab Title Text Color',
                ), 
                array(
                    'key'           => 'quicktab_title_bg_'.$i,
       				'type'          => 'color', 
       				'default'		=> '#dddddd',
					'label'			=> 'Tab Title Background Color',
								
                ),
                array(
                    'key'           => 'quicktab_cont_'.$i,
       				'type'          => 'color', 
       				'default'		=> '#000000',
					'label'			=> 'Tab Content Text Color',
                ),
                array(
                    'key'           => 'quicktab_cont_bg_'.$i,
       				'type'          => 'color', 
       				'default'		=> '#dedede',
					'label'			=> 'Tab Content Background Color',
                ),
	               
				
				
			);

			


			$options[] = array(
				'title' 	=> __( 'Quick Tab ', 'pagelines' ) . $i,
				'type' 		=> 'multi',
				'span' 		=>	2,
				'opts' 		=> $opts,

			);

		}

		return $options;
	}
	

	
	
	
	
	
	/**
	* Section template.
	*/
   function section_template( ) {

   	$quicktabs_id = 'quicktabs-id-'.$this->get_the_id();
   	printf('<div class="tabbable quicktabs %s hentry ">' , $quicktabs_id);
			
   	$this->draw_quicktab_title();
   	$this->draw_quicktab_content();
	
	echo '</div>';	
   	
	}

	function draw_quicktab_title() {
		$quicktabs_id = $this->get_the_id();
		$quicktabs = ($this->opt('quicktabs_count')) ? $this->opt('quicktabs_count') : $this->default_limit;
		$output='';
		$count=1;
		for($i = 1; $i <= $quicktabs; $i++):
			$quicktab_id = $count++.'-'.$quicktabs_id;
			$quicktab_icon = ($this->opt('quicktab_icon_'.$i)) ? $this->opt('quicktab_icon_'.$i) : false;
			$icon_html = sprintf('<i class="icon icon-%s"></i>', $quicktab_icon);
			$quicktab_title = ($this->opt('quicktab_title_'.$i)) ? $this->opt('quicktab_title_'.$i) : __('Quick Tab '. $i .' ', 'pagelines');
			if($quicktab_icon != false)
				$quicktab_title = sprintf('<p data-sync="quicktab_title_%s">%s %s</p>', $i, $icon_html, $quicktab_title.' ' );
			else
				$quicktab_title = sprintf('<p data-sync="quicktab_title_%s">%s</p>', $i, $quicktab_title. ' ' );
				
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

		 endfor;
		
		printf('<ul class="nav nav-tabs ">%s</ul>', $output);
	}


	function draw_quicktab_content() {
		$quicktabs_id = $this->get_the_id();
		$quicktabs = ($this->opt('quicktabs_count')) ? $this->opt('quicktabs_count') : $this->default_limit;
		$output='';
		$count=1;
		for($i = 1; $i <= $quicktabs; $i++):
			$quicktab_id = $count++.'-'.$quicktabs_id;
			$quicktab_text = ($this->opt('quicktab_text_'.$i)) ? $this->opt('quicktab_text_'.$i) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id lectus sem. Cras consequat lorem.';
			$quicktab_text = sprintf('<div data-sync="quicktab_text_%s">%s</div>', $i, $quicktab_text );
			$quicktab_cont_color = ( $this->opt('quicktab_cont_'.$i )) ? $this->opt('quicktab_cont_'.$i) :'000';
			$quicktab_cont_bg = ( $this->opt('quicktab_cont_bg_'.$i )) ? $this->opt('quicktab_cont_bg_'.$i) :'ffffff';
			
			
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

		 endfor;
		
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