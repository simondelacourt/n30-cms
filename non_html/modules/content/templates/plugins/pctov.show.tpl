{if !empty($item.description)}<p>{$item.description}</p>{/if}
<table name="ovpictures">
{section name=ln loop=$pictures}
<tr>
{section name=ls loop=$pictures[ln]}
<td>
<a href="{$pictures[ln][ls].link}"><img src="{$pictures[ln][ls].viewurl}" /><br />
<strong>{$pictures[ln][ls].full_title|substr:0:10}</strong>
</a>
</td>
{/section}
</tr>
{/section}
</table>
