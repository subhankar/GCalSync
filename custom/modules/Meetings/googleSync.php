<?php
error_reporting(E_ALL);
require_once('Zend/Loader.php');

class GoogleWrapper{	
	function addEvent(&$bean, $event, $arguments){
		global $sugar_config;
		$db = $GLOBALS['db'];
		//Connect Sugar DB
		$host2 = $sugar_config['dbconfig']['db_host_name'];
		$user2 = $sugar_config['dbconfig']['db_user_name'];
		$pass2 = $sugar_config['dbconfig']['db_password'];
		$dbname2 = $sugar_config['dbconfig']['db_name'];
		
		$connString2 = mysql_connect($host2,$user2,$pass2);
		mysql_select_db($dbname2,$connString2);
				
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Calendar');
		
		//Get access details
		$sql = "SELECT * FROM gcalconfig";
		$result = mysql_query($sql);
		$data = mysql_fetch_array($result);
		
		$user = $data['username'];
		$pass = base64_decode($data['userpass']);
		
		$serviceName = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
		$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);
		$service = new Zend_Gdata_Calendar($client);
		
		//Check for existing Meetings
		$sql = "SELECT * FROM meetings WHERE id = '".$bean->id."' ";
		$rs = mysql_query($sql,$connString2);
		$data = mysql_fetch_array($rs);
		
		$name = $data['name'];
		$location = $data['location'];
		$description = $data['description'];
		
		if(mysql_num_rows($rs) > 0){
			//Edit existing record
			//URI of the event which we got after creating it.
			echo $eventUri = $data['gcal_cal_id'];
			echo '<BR>'.'Edit Block';
			$event = $service->getCalendarEventEntry($eventUri);
						
			//echo $bean->name;
			// Change the title
			$event->title = $service->newTitle("New Title!");
			
			//$event->where = $service->newWhere($bean->location);
			//echo 'Update'.$bean->location;		
			// Save the event
			$event->save();
			//$event->delete();
			echo '<BR>'.'Event updated';	
		}
		else{
			//New record
			$title = $bean->name;
			$location = $bean->location;
			$description = $bean->description;
			$startTime = $bean->date_start;
			$endTime = $bean->date_end;
			//Set Timezone
			$tzOffset = '-05'; // timezone offset
			$startTime = str_replace(' ', 'T', $startTime);
			$endTime = str_replace(' ', 'T', $endTime);
			
			// Create a new event object using calendar service's factory method.
			// We will then set different attributes of event in this object.
			$event= $service->newEventEntry();
			
			// Create a new title instance and set it in the event
			$event->title = $service->newTitle($title);
			
			// Where attribute can have multiple values and hence passing an array of where objects
			$event->where = array($service->newWhere($location));
			$event->content = $service->newContent($description);
			
			// Create an object of When and set start and end datetime for the event
			$when = $service->newWhen();
			
			// Set start and end times in RFC3339 (http://www.ietf.org/rfc/rfc3339.txt)
			$when->startTime = "{$startTime}.000{$tzOffset}:00";
			$when->endTime = "{$endTime}.000{$tzOffset}:00";
			
			//$when->startTime = "2013-02-25T16:30:00.000+05:30"; // 8th July 2010, 4:30 pm (+5:30 GMT)
			//$when->endTime = "2013-02-25T17:30:00.000+05:30"; // 8th July 2010, 5:30 pm (+5:30 GMT)
			
			// Set the when attribute for the event
			$event->when = array($when);
			
			// Create the event on google server
			$newEvent = $service->insertEvent($event);
			
			// URI of the new event which can be saved locally for later use
			$eventUri = $newEvent->id->text.PHP_EOL;
			
			//Saving GCAL ID
			$bean->gcal_cal_id = $eventUri; 
		}
		
	}
}
?>
