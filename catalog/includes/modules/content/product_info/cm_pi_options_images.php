<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2018 osCommerce

  Released under the GNU General Public License
*/

  class cm_pi_options_images {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_PI_OI_TITLE;
      $this->description = MODULE_CONTENT_PI_OI_DESCRIPTION;
      $this->description .= '<div class="secWarning">' . MODULE_CONTENT_BOOTSTRAP_ROW_DESCRIPTION . '</div>';

      if ( defined('MODULE_CONTENT_PI_OI_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_PI_OI_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_PI_OI_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $languages_id, $currencies, $product_info;
      
      $content_width = (int)MODULE_CONTENT_PI_OI_CONTENT_WIDTH;
      $options_images_output = null;
        
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name, popt.products_options_images_enabled from products_options popt, products_attributes patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
	  
      if (tep_db_num_rows($products_options_name_query)) {
        while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
          $products_options_array = array();

          $fr_input = $fr_required = $fr_feedback = null;
          if (MODULE_CONTENT_PI_OI_ENFORCE == 'True') {
            $fr_input    = FORM_REQUIRED_INPUT;
            $fr_required = 'required aria-required="true" '; 
            $fr_feedback = ' has-feedback';
          }
          if ((MODULE_CONTENT_PI_OI_HELPER == 'True') && ($products_options_name['products_options_images_enabled'] == 'false')) {
            $products_options_array[] = array('id' => '', 'text' => MODULE_CONTENT_PI_OI_ENFORCE_SELECTION);            
          }
          
          $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_thumbnail, pa.options_values_price, pa.price_prefix from products_attributes pa, products_options_values pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
          while ($products_options = tep_db_fetch_array($products_options_query)) {
			$products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name'], 'thumbnail' => $products_options['products_options_values_thumbnail']);
            if ($products_options['options_values_price'] != '0') {
              $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
            }
          }

          if (is_string($_GET['products_id']) && isset($cart->contents[$_GET['products_id']]['attributes'][$products_options_name['products_options_id']])) {
            $selected_attribute = $cart->contents[$_GET['products_id']]['attributes'][$products_options_name['products_options_id']];
          } else {
            $selected_attribute = false;
          }
	if ($products_options_name['products_options_images_enabled'] == 'false'){
          $options_images_output .= '<div class="form-group' . $fr_feedback . '">';
          $options_images_output .=   '<label for="input_' . $products_options_name['products_options_id'] . '" class="control-label col-sm-3">' . $products_options_name['products_options_name'] . '</label>'; 
          $options_images_output .=   '<div class="col-sm-9">';
          $options_images_output .=     tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute, $fr_required . 'id="input_' . $products_options_name['products_options_id'] . '"');
          $options_images_output .=     $fr_input;
          $options_images_output .=   '</div>';
          $options_images_output .= '</div>';
	} else {  
		  $options_images_output .=  '<div class="clearfix"></div>';	
		  $options_images_output .=  '<div class="row">';	
		  $options_images_output .=   '<label for="input_' . $products_options_name['products_options_id'] . '" class="control-label col-sm-3">' . $products_options_name['products_options_name'] . '</label>'; 
		  $options_images_output .=   '<div class="col-sm-9">';
			  foreach ($products_options_array as $opti_array) {
				  $options_images_output .= '<label>';
				  $options_images_output .= '<input type="radio" name ="id[' . $products_options_name['products_options_id'] . ']" value="' . $opti_array['id'] . '"  class="sr-only" required>';
				  $options_images_output .= tep_image('images/options/' . $opti_array['thumbnail'], $opti_array['text'], MODULE_CONTENT_PI_OI_WIDTH, MODULE_CONTENT_PI_OI_HEIGHT);
				 // $options_images_output .= '<p class="text-center" style="font-weight:normal;"><small>' . $opti_array['text'] . '</small></p>';
				  $options_images_output .= '</label>';			 
			  }
		   $options_images_output .= '</div>';
		   $options_images_output .= '</div>';
	
	}
        }
      
        ob_start();
        include('includes/modules/content/' . $this->group . '/templates/tpl_' . basename(__FILE__));
        $template = ob_get_clean();

        $oscTemplate->addContent($template, $this->group);
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_PI_OI_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Options & Attributes', 'MODULE_CONTENT_PI_OI_STATUS', 'True', 'Should this module be shown on the product info page?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Width', 'MODULE_CONTENT_PI_OI_CONTENT_WIDTH', '12', 'What width container should the content be shown in?', '6', '1', 'tep_cfg_select_option(array(\'12\', \'11\', \'10\', \'9\', \'8\', \'7\', \'6\', \'5\', \'4\', \'3\', \'2\', \'1\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Add Helper Text', 'MODULE_CONTENT_PI_OI_HELPER', 'True', 'Should first option in dropdown be Helper Text?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enforce Selection', 'MODULE_CONTENT_PI_OI_ENFORCE', 'True', 'Should customer be forced to select option(s)?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");	  
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_PI_OI_SORT_ORDER', '80', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
// Added for Images width and height 
	  tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Options Images Width', 'MODULE_CONTENT_PI_OI_WIDTH', '100', 'Set width of options images', 6, 1, now())");
	  tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Options Images Height', 'MODULE_CONTENT_PI_OI_HEIGHT', '100', 'Set height of options images', 6, 1, now())");
// check if new field exist if not create      
	  $check = tep_db_query("SHOW COLUMNS FROM `products_options_values` LIKE 'products_options_values_thumbnail'");
      $exists = (tep_db_num_rows($check))?TRUE:FALSE;
      if(!$exists) {
        tep_db_query("ALTER TABLE `products_options_values` ADD `products_options_values_thumbnail` VARCHAR(60) NOT NULL");
      }	  
	  $check = tep_db_query("SHOW COLUMNS FROM `products_options` LIKE 'products_options_images_enabled'");
      $exists = (tep_db_num_rows($check))?TRUE:FALSE;
      if(!$exists) {
        tep_db_query("ALTER TABLE `products_options` ADD `products_options_images_enabled` VARCHAR(5) DEFAULT 'false' NOT NULL");
      }	         
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	  tep_db_query("ALTER TABLE `products_options_values` DROP `products_options_values_thumbnail`");
	  tep_db_query("ALTER TABLE `products_options` DROP `products_options_images_enabled`");
    }

    function keys() {
      return array('MODULE_CONTENT_PI_OI_STATUS', 'MODULE_CONTENT_PI_OI_CONTENT_WIDTH', 'MODULE_CONTENT_PI_OI_HELPER', 'MODULE_CONTENT_PI_OI_ENFORCE', 'MODULE_CONTENT_PI_OI_SORT_ORDER', 'MODULE_CONTENT_PI_OI_WIDTH', 'MODULE_CONTENT_PI_OI_HEIGHT');
    }
  }