<?php
function post_install()
{
    require_once("modules/Administration/QuickRepairAndRebuild.php");
    require_once 'include/utils/file_utils.php';
    global $db,$sugar_config;
	
	//Create gconfig table
    $query = "CREATE TABLE IF NOT EXISTS `gcalconfig` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`username` varchar(255) NOT NULL,
			`userpass` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
			";
    	$db->query($query,true);
		//INSERT SOME VALUE
		$insertQuery = "INSERT INTO `gcalconfig` (`id`,`username`, `userpass`) VALUES ('1','abc@gmail.com', 'QGtiaW1weTA5')";
		$db->query($insertQuery,true);
	
	
    $randc = new RepairAndClear();
    $randc->repairAndClearAll(array('clearAll'),array(translate('All Modules')), false,true);
}
?>

