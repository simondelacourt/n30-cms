<h2>{$lang.adminusers.usernotes} {$user.username|htmlspecialchars}</h2>
<ul id="notes">
{section name=ln loop=$notes}
<li>
<p class="info">{$notes[ln].usernamecreator|htmlspecialchars} - {$notes[ln].crdate}:</p>
<p>{$notes[ln].note|htmlspecialchars|nl2br}</p>
<form method="post">
<input type="hidden" name="action" value="deleteusernote" /> 
<input type="hidden" name="id" value="{$notes[ln].id}" /> 
<input type="submit" name="submit" value="{$lang.adminusers.delete}" />
</form>
</li>
{/section}
</ul>
<form method="post" action="" id="addnote">
<textarea name="note"></textarea>
<input type="submit" name="submit" value="{$lang.adminusers.addusernote}" />
<input type="hidden" name="action" value="addusernote" /> 
<input type="hidden" name="userid" value="{$user.id}" /> 
</form>