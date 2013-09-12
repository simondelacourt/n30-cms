<h2 class="ttitle">{$mlang.delete} {$item.full_title|htmlspecialchars}</h2>
{include file="breadcrumbs.tpl"}
<form method="post">
<p>{$mlang.deleteexpl}</p>
<input type="submit" name="submit" value="{$mlang.delete}" />
<input type="hidden" name="action" value="delete" />
<input type="hidden" name="id" value="{$item.id}" />
</form>