<html>
<head>
<title>N30-CMS | Installer</title>
	<link href="./style/default.css" rel="stylesheet" type="text/css" />

</head>
<body>
<h1>Welcome</h1>
<?php
if (isset($this->errors['writable'])) {
?>
<h2>Make files writable</h2>
These files or directories are not yet writable:
<?php echo $this->showErrors('writable'); }?>
<h2>SQL</h2>
<p>Make sure your hoster has MySQL installed. Currently N30-CMS only works on MySQL</p>
<?php
	if (class_exists('mysqli'))
	{
		?>
			<p class="positive">MySQLi is present</p>		
		<?php
	}
?>

<form method="post">
<h2>SQL Settings</h2>
<table>
<tr>
<td>Username</td>
<td><input type="text" name="sql[username]" /></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="sql[password]" /></td>
</tr>
<tr>
<td>Host</td>
<td><input type="text" name="sql[host]" /></td>
</tr>
<tr>
<td>Database (already created)</td>
<td><input type="text" name="sql[host]" /></td>
</tr>
</table>
<h2>Admin information</h2>
<table>
<tr>
<td>Username</td>
<td><input type="text" name="admin[username]" value="Admin" />
</tr>
<tr>
<td>Password</td>
<td><input type="text" name="admin[password]" />
</tr>
<tr>
<td>E-mail adres</td>
<td><input type="text" name="admin[email]" />
</tr>
</table>
<input type="submit" value="Next >>" />
</form>
</body>
</html>