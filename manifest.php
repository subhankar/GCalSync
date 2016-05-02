<?php
global $sugar_config;

$manifest = array(
    'acceptable_sugar_flavors' => array(
        'PRO', 'ENT','ULT','CE','CORP'
    ),
    'acceptable_sugar_versions' => array ( "exact_matches" => array (),
                                          "regex_matches" => array ( 0=>"6\\.*\\.*"),
                                        ),
    
    'author' => 'Deb Arnab',
    'description' => 'GCAL SYNC',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Google Calendar Sync',
    'published_date' => '2012-08-24 12:00:00',
    'type' => 'module',
    'version' => '1.0',
    'remove_tables' => 'prompt',
    'readme' => '',
);

$installdefs = array(
    'id' => 'gcalsync',
    'post_uninstall' => array(
            0    => '<basepath>/scripts/post_uninstall.php',
    ),     
     
        'copy' =>
        array(
            	//copy custom files
				array(
					'from' => '<basepath>/custom/Extension/modules/Administration/',
					'to'   => 'custom/Extension/modules/Administration/',
				),
				array(
					'from' => '<basepath>/custom/Extension/modules/Meetings/',
					'to'   => 'custom/Extension/modules/Meetings/',
				),
				array(
					'from' => '<basepath>/custom/modules/Administration/guserConfig.php',
					'to'   => 'custom/modules/Administration/guserConfig.php',
				),
				array(
					'from' => '<basepath>/custom/modules/Meetings/googleSync.php',
					'to'   => 'custom/modules/Meetings/googleSync.php',
				),
             ),
		'logic_hooks' =>
            array(
                array(
                    'module' => 'Meetings',
                    'hook' => 'before_save',
                    'order' => 1,
                    'description' => 'Google Calendar Sync',
                    'file' => 'custom/modules/Meetings/googleSync.php',
                    'class' => 'GoogleWrapper',
                    'function' => 'addEvent',
                ),
            ),
		
        );