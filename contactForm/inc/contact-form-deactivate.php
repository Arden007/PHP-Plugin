<?php 
/**
 * @package ContactForm
 */

  class ContactFormDeactivate 
 {
    static function deactivate() {
        flush_rewrite_rules();
    }
 }