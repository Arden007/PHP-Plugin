<?php 
/**
 * @package ContactForm
 */

/**
 * Plugin Name:       Contact Form
 * Description:       Set-up.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Arden Jacobs
 */

//  we are checking if the Gobal constant variable which is defined by wordpress is there , if it is not defined we gonna die
defined( 'ABSPATH' ) or die( 'Access denied!');

// we define a class in php by saying the word class
// class ContactForm
// { // we will be placing our methods inside classes
    // the default method that gets called in wordpress is know as the contruct function, it is also used to pass in the argument of the new instance variable we declare to INITIALIZE the class
    // function __construct($arg)
    // {
        // echo $arg;
    // }

// }
// if we want to use the class above we have to create a new instance of this class and store the new instance in a variable.
// to create a variable we use the $ like we would with let & const in J.S. THIS IS HOW WE INITIALIZE a class , but most importantly we need to check if the class exist
// if(class_exists('ContactForm')){
//     $contactPlugin = new ContactForm( 'Arden Plugin Initialized! '); 
// }


if( !class_exists('ContactForm')){
// Create a class that will initialize when the web page is loaded, when the plugin is actived
class ContactForm 
// lets speak about 3 methods know in Object Orientated Programming(OOP)
// 1st-Public- which can be accessed everywhere, note that if we don't define a class as private etc. it will automatically be public
// 2nd-Protected- can only be accessed in the class itself and a class that extends the class itself show by SecondClass
// 3rd-Private- which can be accessed only by the class itself not even an extend class can access the private method
// 4th-Static-this can be added to all 3 the above , this allows you to use a class without initializing the class as we been doing before/ so there will be no new instance of the class, but you will have to make the method you referring to static as well(the enqueue method for the CPT)
{
    // to use the custom_post_type function we need a construct function as we can't use procedural code as is, note that $this refers to the class itself
    // function __construct() {
    // after creating a protected function we call it in the constructor function show below
    // $this->custom_post_type();
        //  }

    // Lets create a variable that will store our plugin name 
    public $PluginName;

    function __construct() {
        $this->PluginName = plugin_basename(__FILE__);
    }

    // The Register method that will trigger the enqueue method 
     function register() {
        // to reference a class within a stactic method we now longer ref it with but call the class directly, but we also need to make the second method (enqueue)we call is stactic to
        add_action('admin_enqueue_scripts', array( $this, 'enqueue'));
        // now we need to call the register method we need to use the new instance of the class we cretaed at the bottom

// Now that we have our plugin set up, we will be working on creating the look and feel of the plugin on the Admin Page of WordPress.
        // lets use the add_action hook to tap into the wordpress admin section to create our admin page
        add_action('admin_menu', array( $this, 'add_admin_pages')); 
        // now we have to create add_admin_page function we are ref to above

        // echo $this->PluginName;
        // Lets create our settings_link with a worpress function 
        add_filter("plugin_action_links_$this->PluginName", array($this,'settings_link'));
    }
// Lets create our settings_links function
    public function settings_link( $links){
        $settings_link = '<a href="admin.php?page=contact_form">Settings</a>';
        // now we need to push the link to wordpress array of links with the push method and return the links
        array_push($links, $settings_link);
        return $links;
    }


    function add_admin_pages() {
        add_menu_page(' Contact Form','Arden', 'manage_options', 'contact_form', array( $this,'admin_index'), 'dashicons-store', 110 );
        // now we need to create the admin_index function we are ref to above
    }
    function admin_index() {
        // require Template
            require_once plugin_dir_path( __FILE__). 'templates/admin.php';

    }


    // this protected function can only be accessed by the class 
    protected function custom_post_type(){
        add_action('init', array( $this, 'custom_post_type' ));
    }


    // lets create functions with built in wordpress methods/actions ACTIVATION , DEACTIVATION ,UNISTALL(Plugin lifecyle)
    // Note that the function below is inside a class that has a unque name so it cant be accessed by other classes and won,t cause any conflict if they are declared in other classes
    // to call this function we will be using built-in hooks that wordpress assign to default plug-in (methods/actions)  
    // Activation
    //  function activate() {
        // generate a CPT(CUSTOM POST SITE)
        // to call the CPT inside another function we need to reference the class and then call the CPT-shown below
        // $this->custom_post_type();

        // Flush Rewrite Rules: this just refresh the db/website so the current data show being show (plugin changes)
        // flush_rewrite_rules();

    // }
    // Deactivation
    // function deactivate() {
        // Flush Rewrite Rules
        // flush_rewrite_rules();

    // }

    // Lets create a function that will generate a CPT
    // function custom_post_type() {
    //     register_post_type( 'contact', ['public' => true, 'label' => 'Contacts'] );
    // }

    // Enqueue Allow us to use our normal JS,SCRIPTS etc. in our plugin, we need to first create a assets folder to store our scripts in 
    function enqueue() {
    // we gonna use build in wordpress function 1st will be wp_enqueue_style(with this enque we need to specify the exact purpose of the enqueue , so the last value depends on what we are referencing)
    // the param will be the name or describ, 2nd we'll reference the url with another build in method(plugin_url()) and in thatmethodwe will reference the file it is in, the final param is to tell the function where to start looking     
    wp_enqueue_style( 'mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
    wp_enqueue_script( 'mypluginscript', plugins_url('/assets/myscript.js', __FILE__));
    // now that we have the enqueue set up we need to create a register functions to dynmically call the enqueue
    }
}

// THE SECOND CLASS THAT EXTENDS THE ContactForm Class
// since we extending the class we can access all the methods inside the first class but this is nit true for when a methods has been set to private
// class secondClass extends ContactForm {
    // the below is commented out because we cant initiate a method twice at the same time 
    // $this->custom_post_type();
// }
// EXAMPLE OF EXTENDING CLASSES ABOVE

// the new instance of the class we created to store our methods/actions in 
// if(class_exists('ContactForm')){
    $contactPlugin = new ContactForm(); 
    $contactPlugin->register();

    // With Static methods we do not have to initialize like above instead we just call the class itself and the method we want to use
    // ContactForm::register();
    
    // Remeber to always create a new instance of a class to call it 
    // $secondClass = new SecondClass();
    // $secondClass->register();
    
    // Activation
    // NOW THAT WE HAVE SPILT OUR De/Activation Hooks we need TO REQUIRE the FILES
    require_once plugin_dir_path( __FILE__). 'inc/contact-form-activate.php';
    // the first hook is called the register hook, but the method we using is in a class so we need to pass in an array, 
    // the 1st argument we past in the array is the class instance the 2nd is the method we calling
    // the below functions must be called in the constructor function cause we will be using procedural code to call the function
    register_activation_hook( __FILE__, array( 'ContactFormActivate','activate') );
    
    // Deactivation
    // NOW THAT WE HAVE SPILT OUR De/Activation Hooks we need TO REQUIRE the FILES
    require_once plugin_dir_path( __FILE__). 'inc/contact-form-deactivate.php';
    
    register_deactivation_hook( __FILE__, array( 'ContactFormDeactivate','deactivate') );
    
    // Uninstall- php gives us the ability to create a file to handle unistall ,but it must be named unistall.php
}

