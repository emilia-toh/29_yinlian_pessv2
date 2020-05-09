<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Emergency Service System</title>
<link href="pessdb.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require 'nav.php'; ?>
<?php 
if (isset($_POST["btnDispatch"]))
{
	require_once 'db_config.php';
	$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	if ($mysqli->connect_errno)
	{
		die("Failed to connect to MySQL: ".$mysqli->connect_errno);
	}
	$patrolcarDispatched = $_POST["chkPatrolcar"];
	$numofPatrolcarDispatched = count($patrolcarDispatched);
	
	$incidentStatus;
	if ($numofPatrolcarDispatched > 0)
	{
		$incidentStatus='2';
	}
	else
	{
		$incidentStatus='1';
	}
	
	$sql = "INSERT INTO incident (callerName, phoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) VALUES (?, ?, ?, ?, ?, ?)";
	
	if (!($stmt = $mysqli->prepare($sql)))
	{
		die("Prepare failed: ".$mysqli->errno);
	}
	if (!$stmt->bind_param('ssssss', $_POST['ylcallerName'], $_POST['ylcontactNo'],  $_POST['incidenttype'], $_POST['ylLocation'], $_POST['incidentDesc'], $incidentStatus))
	{
		die("Binding parameters failed: ".$stmt->errno);
	}
	if (!$stmt->execute())
	{
		die("Insert incident failed: ".$stmt->errno);
	}
	for($i=0; $i < $numofPatrolcarDispatched; $i++)
	{
		$sql = "UPDATE patrolcar SET patrolcarStatusId='1' WHERE patrolcarId = ?";
		
		if (!($stmt = $mysqli->prepare($sql)))
		{
			die("Prepare failed: ".$mysqli->errno);
		}
		if (!$stmt->bind_param('s', $patrolcarDispatched[$i]))
		{
			die("Binding parameters failed: ".$stmt->errno);
		}
		if (!$stmt->execute())
		{
			die("Update patrolcar_status table failed: ".$stmt->errno);
		}
		
		$sql = "INSERT INTO dispatch (incidentld , patrolcarId, timeDispatched) VALUES (?, ?, NOW())";
		
		if (!($stmt = $mysqli->prepare($sql)))
		{
			die("Prepare failed: ".$mysqli->errno);
		}
		
		if (!$stmt->bind_param('ss', $incidentId, $patrolcarDispatched[$i])){
			die("Binding paramters failed: ".$stmt->errno);
		}
		
		if (!$stmt->execute()){
			die("Insert dispatch table failed: ".$stmt->errno);
		}
	}
$stmt->close();
$mysqli->close();
}
?>
<form name="from1" method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>"> 
<table align="center" border="0">
<tr>
<td colspan="2">Incident Detail</td>
</tr>
<tr>
<td>Name of the Caller :</td>
<td><?php echo $_POST['ylcallerName']?>
	<input type="hidden" name="ylcallerName" id="ylcallerName" value="<?php echo $_POST['ylcallerName'] ?>"></td>
</tr>
<tr>
<td>Contact No of the Caller :</td>
<td><?php echo $_POST['ylcontactNo']?>
		<input type="hidden" name="ylcontactNo" id="ylcontactNo" value="<?php echo $_POST['ylcontactNo'] ?>"></td>
</tr>
<tr>
<td>Location :</td>
<td><?php echo $_POST['ylLocation']?>
	<input type="hidden" name="ylLocation" id="ylLocation" value="<?php echo $_POST['ylLocation'] ?>"></td>
</tr>
<tr>
<td>Incident Type :</td>
<td><?php echo $_POST['incidenttype']?>
	<input type="hidden" name="incidenttype" id="incidenttype" value="<?php echo $_POST['incidenttype'] ?>"></td>
</tr>
<tr>
<td>Description :</td>
<td><textarea name="incidentDesc" cols="45" rows="5" readonly id="incidentDesc"><?php echo $_POST['incidentDesc']?></textarea>
	<input type="hidden" name="incidentDesc" id="incidentDesc" value="<?php echo $_POST['incidentDesc'] ?>"></td>
</tr>
</table>
<?php 
	require_once 'db_config.php';
	
	$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	if ($mysqli->connect_errno)
	{
		die("Failed to connect to MySQL: ".$mysqli->connect_errno);
	}
	
	$sql = "SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status ON patrolcar.patrolcarStatusId=patrolcar_status.StatusId WHERE patrolcar.patrolcarStatusId='2' OR patrolcar.patrolcarStatusId='3'";
	
	if(!($stmt = $mysqli->prepare($sql)))
	{
		die("Prepare failed: ".$mysqli->errno);
	}
	if(!$stmt->execute())
	{
		die("Execute failed: ".$stmt->errno);
	}
	if (!($resultset = $stmt->get_result()))
	{
		die("Getting result set failed: ".$stmt->errno);
	}
	
	$patrolcarArray;
	
	while($row = $resultset->fetch_assoc())
	{
		$patrolcarArray[$row['patrolcarId']] = $row['statusDesc'];
	}
	$stmt->close();
	$resultset->close();
	$mysqli->close();
?>
<br><br><table border="1" align="center">
<tr>
<td colspan="3">Dispatch Patrolcar Panel</td>
</tr>
<?php 
foreach($patrolcarArray as $key=>$value) {
?>
<tr>
<td><input type="checkbox" name="chkPatrolcar[]" value="<?php echo $key ?>"></td>
<td><?php echo $key ?></td>
<td><?php echo $value ?></td>
</tr>
<?php } ?>
<tr>
<td><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnDispatch" id="btnDispatch" value="Dispatch"></td>
</tr>
</table>
</form>
</body>
</html>