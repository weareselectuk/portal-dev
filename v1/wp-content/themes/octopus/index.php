<?php

/**
 * Plugin Name: Octopus
 * Plugin URI:  https://weareselect.uk/octopus
 * Version:     1.5.1
 * Author:      We Are Select
 * Author URI:  http://www.weareselect.uk/
 * License:     GPL2
 * License URI: http://opensource.org/licenses/GPL-2.0
 * Text Domain: octopus
 *
 * @package Membership2
 */

/**
 * Copyright notice
 *
 * @copyright We Are Select (http://weareselect.uk/)
 *
 *
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */

/**
 * Initializes constants and create the main plugin object MS_Plugin.
 * This function is called *instantly* when this file was loaded.
 *
 * @since  1.0.0
 */
?>

<?php get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	
	 <?php endwhile; else : ?>
	 
	 

     


        </div>
        <!-- /content area -->

          
    <?php endif; ?>


<?php get_footer(); ?>