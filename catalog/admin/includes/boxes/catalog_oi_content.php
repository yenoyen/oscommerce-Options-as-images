<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2018 osCommerce

  Released under the GNU General Public License

*/


    foreach ( $cl_box_groups as &$group ) {
    if ( $group['heading'] == BOX_HEADING_CATALOG ) {
      $group['apps'][] = array('code' => 'options_images.php',
                               'title' => BOX_CATALOG_OPTIONS_IMAGES,
                               'link' => tep_href_link('options_images.php'));

      break;
    }
  }
?>