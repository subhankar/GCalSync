<?php
 require_once("modules/Administration/QuickRepairAndRebuild.php");
 require_once 'include/utils/file_utils.php';
  global $db;
 if(!empty($_REQUEST['remove_tables']) && $_REQUEST['remove_tables'] != "false"){
    
    $dropStaffTable = "DROP TABLE IF EXISTS `gcalconfig`;";
    $db->query($dropStaffTable,true);
	
	//Remove Opportunity custom fields
	$custom_opportunity_fields = array('gcal_cal_id');
	for($i = 0; $i < count($custom_opportunity_fields); $i++){
		$alterSQL = "ALTER TABLE meetings DROP ".$custom_opportunity_fields[$i]."; ";
		$db->query($alterSQL,true);
		$GLOBALS['log']->info('Query ' . $alterSQL ); 
	}
	
}

	$oRepair = new RepairAndClear();
    $oRepair->clearSmarty();
    $oRepair->clearTpls();
    LanguageManager::clearLanguageCache("Administration"); 

?>

