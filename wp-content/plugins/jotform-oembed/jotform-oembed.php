<?php
/*
    Plugin Name: JotForm oEmbed
    Plugin URI: http://www.jotform.com/labs/wordpress
    Description:
    Version: 1.0
    Author: Ertugrul Emre Ertekin
    Author URI: http://ee.ertek.in
    License: GNU General Public License v3
*/

class JotFormOEmbed {

    public function __construct() {
        wp_oembed_add_provider( '#https?://(secure\.|www\.|form\.)?(my)?jotform(pro|eu|z)?\.(com|net|us|ca|me|co)/form/[0-9]*#i', 'https://www.jotform.com/oembed/', true );
    }

}

$jotformOEmbed = new JotFormOEmbed();

?>