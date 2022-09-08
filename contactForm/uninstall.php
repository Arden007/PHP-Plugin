<?php

/**
 * File gets trigger on uninstallation
 * 
 * @package ContactForm
 */

 if (! defined( 'WP)_UNINSTALL_PLUGIN')){
    die;
 } 

//  Clears the database info that was created by the plugin

// Lets Access the db with SQL- but first we got define the default wpdb variable ,which will allow us to write SQL queries
global $wpdb;
// you need to target the cpt(custom_post_type) we created 
$wpdb->query("DELETE FROM wp_posts Where post_type = 'book'");
// the meta data also needs to be deleted from the db that was created by the plugin 
$wpdb->query("DELETE FROM wp_postmeta Where post_id NOT IN (SELECT id FROM wp_posts)");
// The below deletes the CPT no matter if it is in swamp , achieve etc. regardless where it is , it will be deleted
$wpdb->query("DELETE FROM wp_term_relationships Where object_id Not IN (SELECT id FROM wp_posts)");