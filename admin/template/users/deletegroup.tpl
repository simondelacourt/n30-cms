<h2>{$lang.adminusers.deletegroup} {$group.title|htmlspecialchars}</h2>
<p>{$lang.adminusers.deletegroupinfo}</p>
<form method="post" action="">
<input type="hidden" name="action" value="deletegroup" />
<input type="hidden" name="id" value="{$group.id}" />
<input type="submit" name="submit" value="{$lang.adminusers.deletegroup}" />
</form>