<?php
/**
  * @purpose    Admin panel link capture Google access details
  * @author     Subhankar
  * @version    1.0
  * @since      
**/

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

//Creating option array()
$admin_option_defs = array();

//Link for generating XML
$admin_option_defs['Administration']['Administration']= array('Administration','LBL_XML_FILE','LBL_XML_FILE_DESC','./index.php?module=Administration&action=guserConfig');

//Group Header label
$admin_group_header[]= array('LBL_MANAGE_GOOGLE_USER','',false,$admin_option_defs, 'LBL_MANAGE_GOOGLE_USER_DESC');
//End of array
?>
