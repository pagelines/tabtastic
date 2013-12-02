<?php
/*
Plugin Name: Tabtastic
Author: elSue
Author URI: http://www.elsue.com
Version: 1.0.0
Description: A simple section that creates text that sizes to fit the container, and is responsive which means it scales with different size browsers.
Tags: extension
*/

class Tabtastic {
	
	/**
	 * Construct
	 */
	function __construct() {
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
	        'name' => _x( 'Tabs', 'tabtastic' ),
	        'singular_name' => _x( 'Tab', 'tabtastic' ),
	        'add_new' => _x( 'Add New', 'tabtastic' ),
	        'add_new_item' => _x( 'Add New Tab', 'tabtastic' ),
	        'edit_item' => _x( 'Edit Tab', 'tabtastic' ),
	        'new_item' => _x( 'New Tab', 'tabtastic' ),
	        'view_item' => _x( 'View Tab', 'tabtastic' ),
	        'search_items' => _x( 'Search Tabs', 'tabtastic' ),
	        'not_found' => _x( 'No tabtastic found', 'tabtastic' ),
	        'not_found_in_trash' => _x( 'No Tabs found in Trash', 'tabtastic' ),
	        'parent_item_colon' => _x( 'Parent Tab:', 'tabtastic' ),
	        'menu_name' => _x( 'Tabs', 'tabtastic' ),
	    );

	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'For Full Tabs in Tabtastic',
	        'supports' => array( 'title', 'editor' ),
	        
	        'public' => false,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'menu_position' => 15,
	        
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
	                'name' => 'Tabs Sets',
	                'add_new_item' => 'Add New Tabs Set',
	                'new_item_name' => "New Tabs Set"
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
	$prefix = 'tab_';  
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



