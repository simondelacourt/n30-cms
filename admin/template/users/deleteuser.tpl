<h2>{$lang.adminusers.deleteuser} {$user.username|htmlspecialchars}</h2>
<p>{$lang.adminusers.deleteuserexplain}</p>
<form method="post" action="">
<input type="hidden" name="action" value="deleteuser" /> 
<input type="hidden" name="userid" value="{$user.id}" /> 
<input type="submit" name="submit" value="{$lang.adminusers.deleteuser}" />
</form>