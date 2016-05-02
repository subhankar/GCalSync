<?php
require_once('config.php');
global $sugar_config;
global $db;

$sql = "SELECT * FROM gcalconfig";
$result = $db->query($sql);

$data = $db->fetchByAssoc($result);
if(empty($data)){
	$msg = 'Set Google access details';
}

if($_POST){
	$username = $_POST['username'];
	$pass = base64_encode($_POST['userpass']);
	$query = "UPDATE gcalconfig SET username = '".$username."' ,  userpass = '".$pass."' WHERE id = '1' ";
	$db->query($query,TRUE);
	$msg = 'Account updated successfully!';
}
?>
<form name="frmmodulesetting" action="./index.php?module=Administration&action=guserConfig" method="post">
<table align="center" width="25%" border="1" cellspacing="5" cellpadding="0">
<th colspan="2"><strong><?php echo $msg; ?></strong></th>
<?php 
//if($syncMod[1] == '1'){
?>
<tr>
	<td>User Name </td>
    <td><input type="text" name="username"  value="<?php echo $data['username'];?>" checked=""/></td>
</tr>
<tr>
	<td>Passowrd </td>
    <td><input type="password" name="userpass"  value="<?php echo $data['userpass'];?>"/></td>
</tr>
<?php
//}

?>
<tr>
	<td>&nbsp;</td>
</tr>

<tr>
	<td colspan="2">
	<table align="center" cellpadding="0" cellspacing="0">
    	<tr>
            <td><input type="submit" name="submit" value="Save" /></td>
            <td><input type="button" name="cancel" value="Cancel" /></td>
        </tr>
    </table>
    </td>
</tr>

</table>
</form>