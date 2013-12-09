<?php
/*
Plugin Name: Tabtastic
Author: elSue
Author URI: http://dms.elsue.com
Version: 1.0.2
Description: A simple section that creates text that sizes to fit the container, and is responsive which means it scales with different size browsers.
Tags: extension
PageLines: true
v3: true
Demo: http://dms.elsue.com/tabtastic/
*/

class Tabtastic {
	
	/**
	 * Construct
	 */
	function __construct() {
		$this->dir  = plugin_dir_path( __FILE__ );
        $this->url  = plugins_url( '', __FILE__ );

		add_action( 'init', array($this , 'register_cpt_tabtastic' ));
		add_action( 'init', array($this,'taxonomy_setup' ));
		add_action('add_meta_boxes', array($this,'add_tabtastic_meta_box'));
		add_action( 'admin_enqueue_scripts', array($this,'tabtastic_enqueue_color_picker' ));
		add_action('admin_head', array($this,'add_tabtastic_colorpicker_script')); 
		add_action('save_post', array($this,'save_tabtastic_meta'));
	}


	function tabtastic_enqueue_color_picker( $hook_suffix ) {
	    // first check that $hook_suffix is appropriate for your admin page
	    wp_enqueue_style( 'wp-color-picker' );
	   	wp_enqueue_script( 'wp-color-picker' , false, true );
	}

 
	function add_tabtastic_colorpicker_script() {  
	    global  $post;  
	    $custom_meta_fields = $this->tabtastic_meta_fields();
	      
	    $output = '<script type="text/javascript"> 
	                jQuery(function() {';  
	                  
	    foreach ($custom_meta_fields as $field) { // loop through the fields looking for certain types  
	        if($field['type'] == 'color')  
	            $output .= 'jQuery(".colorpicker").wpColorPicker();';  
	    }  
	      
	    $output .= '}); 
	        </script>';  
	          
	    echo $output;  
	} 

	function register_cpt_tabtastic() {

	    $labels = array( 
	        'name' => _x( 'FullTabs', 'tabtastic' ),
	        'singular_name' => _x( 'FullTab', 'tabtastic' ),
	        'add_new' => _x( 'Add New', 'tabtastic' ),
	        'add_new_item' => _x( 'Add New FullTab', 'tabtastic' ),
	        'edit_item' => _x( 'Edit FullTab', 'tabtastic' ),
	        'new_item' => _x( 'New FullTab', 'tabtastic' ),
	        'view_item' => _x( 'View FullTab', 'tabtastic' ),
	        'search_items' => _x( 'Search FullTabs', 'tabtastic' ),
	        'not_found' => _x( 'No fulltabs found', 'tabtastic' ),
	        'not_found_in_trash' => _x( 'No FullTabs found in Trash', 'tabtastic' ),
	        'parent_item_colon' => _x( 'Parent FullTab:', 'tabtastic' ),
	        'menu_name' => _x( 'FullTabs', 'tabtastic' ),
	    );

	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'For Full Tabs in Tabtastic',
	        'supports' => array( 'title', 'editor' ),
	        'menu_icon' 		  		=> $this->url.'/icon.png',  // Icon Path
	        'public' => false,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'show_in_nav_menus' => false,
	        'publicly_queryable' => false,
	        'exclude_from_search' => false,
	        'has_archive' => false,
	        'query_var' => false,
	        'can_export' => true,
	        
	    );

	    register_post_type( 'tabtastic', $args );
    

	}


 
	
 /**
	*
	* Setup Locations Taxonomy
	*
	*/	

	function taxonomy_setup() {
	    register_taxonomy(
	        'tabs-sets',
	        'tabtastic',
	        array(
	            'labels' => array(
	                'name' => 'FullTabs Sets',
	                'add_new_item' => 'Add New FullTabs Set',
	                'new_item_name' => "New FullTabs Set"
	            ),
	            'show_ui' => true,
	            'show_tagcloud' => false,
	            'hierarchical' => true
	           
	        )
	    );
    
	}

		// Add the Meta Box  
	function add_tabtastic_meta_box() {  
	    add_meta_box(  
	        'tabtastic_meta_box', // $id  
	        'Color Control for Tab', // $title   
	        array(&$this,'show_tabtastic_meta_box'), // $callback  
	        'tabtastic', // $page  
	        'normal', // $context  
	        'high'); // $priority  
	}  
	function tabtastic_meta_fields() {
	// Field Array  
	$prefix = 'fulltab_';  
	$custom_meta_fields = array(  
	    
	    array(  
	        'label'=> 'Tab Title Color',  
	        'desc'  => 'Title Text Color for this tab only.',  
	        'id'    => $prefix.'title_color',  
	        'type'  => 'color'  
	    ),  
	    array(  
	        'label'=> 'Tab Title Background',  
	        'desc'  => 'Title Background for this tab only.',  
	        'id'    => $prefix.'title_background',  
	        'type'  => 'color'  
	    ), 
	    array(  
	        'label'=> 'Tab Content Color',  
	        'desc'  => 'Content Text Color for this tab only.',  
	        'id'    => $prefix.'content_color',  
	        'type'  => 'color'  
	    ),  
	    array(  
	        'label'=> 'Tab Content Background',  
	        'desc'  => 'Title Background for this tab only.',  
	        'id'    => $prefix.'content_background',  
	        'type'  => 'color'  
	    )   
	    
	); 
		return $custom_meta_fields;
	}
	  // The Callback  
	function show_tabtastic_meta_box() {  
	global  $post;  
	$custom_meta_fields = $this->tabtastic_meta_fields();
	// Use nonce for verification  
	wp_nonce_field( basename( __FILE__ ), 'tabtastic_meta_box_nonce' );      
	    // Begin the field table and loop  
	    echo '<table class="form-table">';  
	    foreach ($custom_meta_fields as $field) {  
	        // get value of this field if it exists for this post  
	        $meta = get_post_meta($post->ID, $field['id'], true);  
	        // begin a table row with  
	        echo '<tr> 
	                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
	                <td>';  
	                switch($field['type']) {  
	                    // case items will go here 
	                    // text  
						case 'text':  
						    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /> 
						        <br /><span class="description">'.$field['desc'].'</span>';  
						break;  
						// date
						case 'color':
							echo '<input type="text" class="colorpicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
									<br /><span class="description">'.$field['desc'].'</span>';
						break; 

	                } //end switch  
	        echo '</td></tr>';  
	    } // end foreach  
	    echo '</table>'; // end table  
	}

	// Save the Data  
	function save_tabtastic_meta($post_id) {  
	    $custom_meta_fields = $this->tabtastic_meta_fields();  
	      
	    // verify nonce  
	   if (!isset($_POST['tabtastic_meta_box_nonce']) || !wp_verify_nonce($_POST['tabtastic_meta_box_nonce'], basename(__FILE__)))

     return $post_id;  
	    // check autosave  
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
	        return $post_id;  
	    // check permissions  
	    if ('page' == $_POST['post_type']) {  
	        if (!current_user_can('edit_page', $post_id))  
	            return $post_id;  
	        } elseif (!current_user_can('edit_post', $post_id)) {  
	            return $post_id;  
	    }  
	      
	    // loop through fields and save the data  
	    foreach ($custom_meta_fields as $field) {  
	        $old = get_post_meta($post_id, $field['id'], true);  
	        $new = $_POST[$field['id']];  
	        if ($new && $new != $old) {  
	            update_post_meta($post_id, $field['id'], $new);  
	        } elseif ('' == $new && $old) {  
	            delete_post_meta($post_id, $field['id'], $old);  
	        }  
	    } // end foreach  
	}  




}
// Construct class and store globally for overrides
$GLOBALS['Tabtastic'] = new Tabtastic;



