<?php
// Set the version hooks should use, currently Sugar only supports version 1.
$hook_version = 1;

// Initialize the hook array
$hook_array = Array();

// Initialize the hook type
$hook_array['before_save'] = Array();

// Add hook
/*
 * Array Parameters
 * 1 Hook Version
 * 2 Hook Name
 * 3 File Path
 * 4 Class Name
 * 5 Function Name
 * 
 */
$hook_array['before_save'][] = Array(1, 'GoogleSync', 'custom/modules/Meetings/googleSync.php', 'GoogleWrapper', 'addEvent');
?>