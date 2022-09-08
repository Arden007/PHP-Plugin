<?php 
/**
 * @package ContactForm
 */

 class ContactFormActivate 
 {
    static function activate() {
        flush_rewrite_rules();
    }
 }