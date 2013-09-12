<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms - {$version} - {$pagetitle}</title>
<link href="{$baseurl}/templates/n30_06/style/default.css"
	rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<h1>n30 cms - {$version} - {$pagetitle}</h1>
<ul id="mainmenu">
	{section name=ln loop=$mainmenu}
	<li {if $mainmenu[ln].active== 'true'} class="opened"{/if}><a
		href="{$mainmenu[ln].link}"><span>{$mainmenu[ln].full_title}</span></a></li>
	{/section}
</ul>
{if isset($submenu[0])}
<ul id="submenu">
	{section name=ln loop=$submenu}
	<li {if $submenu[ln].active== 'true'} class="opened"{/if}><a
		href="{$submenu[ln].link}"><span>{$submenu[ln].full_title}</span></a></li>
	{/section}
</ul>
{/if}
<div id="content">
<h2>{$pagetitle}</h2>
{if isset($contextmenu[0])}
<ul id="contentmenu">
	<li class="head">menu</li>
	{section name=ln loop=$contextmenu}
	<li {if $context[ln].active== 'true'} class="opened"{/if}><a
		href="{$contextmenu[ln].link}"><span>{$contextmenu[ln].full_title}</span></a></li>
	{/section}
</ul>
{/if} {$mod} <span style="clear: both;" /></div>
</div>
</body>
</html>