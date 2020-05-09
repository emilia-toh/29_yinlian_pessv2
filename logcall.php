<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Emergency Service System</title>
<link href="pessdb.css" rel="stylesheet" type="text/css">
</head>

<body>
<script>
function LogCall()
	{
		var x = document.forms["frmLogCall"]["ylcallerName"].value;
		if (x == null || x =="")
			{
				alert("Caller Name is required.");
				return false;
			}
		var x = document.forms["frmLogCall"]["ylcontactNo"].value;
		if (x == null || x =="")
			{
				alert("Contact No is required.");
				return false;
			}
		var x = document.forms["frmLogCall"]["Location"].value;
		if (x == null || x =="")
			{
				alert("Location is required.");
				return false;
			}
		var x = document.forms["frmLogCall"]["incidentDesc"].value;
		if (x == null || x =="")
			{
				alert("Description is required.");
				return false;
			}
	}
</script>
<?php require 'nav.php'; ?>
<?php require 'db_config.php';
$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_errno)
{
	die("Unable to connect to Database: ".$mysqli->connect_errno);
}
$sql = "SELECT * FROM incidenttype";
if (!($stmt = $mysqli->prepare($sql)))
{
	die("Command error: ".$mysqli->errno);
}
if (!$stmt->execute())
{
	die("Cannot run SQL command: ".$stmt->errno);
}
if (!($resultset = $stmt->get_result()))
{
	die("No data in resultset: ".$stmt->errno);
}
$incidenttype;
while($row = $resultset->fetch_assoc())
{
	$incidenttype[$row['incidentTypeId']] = $row['incidentTypeDesc'];
}
	$stmt->close();
	$resultset->close();
	$mysqli->close();
?>
<fieldset>
<legend>Log Call</legend>
<form name="frmLogCall" method="post" action="dispatch.php" onSubmit="return LogCall();">
<table width="40%" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
<td width="80%">Name of the Caller :</td>
<td width="50%"><input type="text" name="ylcallerName" id="ylcallerName"></td>
</tr>
<tr>
<td width="80%">Contact No of the Caller :</td>
<td width="50%"><input type="text" name="ylcontactNo" id="ylcontactNo"></td>
</tr>
<tr>
<td width="80%">Location :</td>
<td width="50%"><input type="text" name="Location" id="Location"></td>
</tr>
<tr>
<td width="80%">Incident Type :</td>
<td width="50%"><select name="incidenttype" id="incidenttype">
	<?php foreach($incidenttype as $key=>$value) { ?>
	<option value="<?php echo $key ?>">
		<?php echo $value ?> </option>
	<?php } ?>
	</select></td>
</tr>
<tr>
<td width="80%">Description :</td>
<td width="50%"><textarea name="incidentDesc" id="incidentDesc" cols="45" rows="5"></textarea></td>
</tr>
<tr>
<td><input type="reset" name="cancelProcess" id="cancelProcess" value="Reset"></td>
<td><input type="submit" name="btnProcessCall" id="btnProcessCall" value="Process Call"></td>
</tr>
</table>
</form>
</fieldset>
</body>
</html>