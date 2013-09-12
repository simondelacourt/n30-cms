<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms admin - {$cmsversion} - {$pagetitle}</title>
<link href="{$baseurl}/admin/style/default.css" rel="stylesheet"
	type="text/css" />
{literal}	
<!--[if IE]>
<style type="text/css" media="screen">
body {behavior: url({/literal}{$baseurl}{literal}/admin/style/csshover2.htc);} 
</style>
<![endif]-->{/literal}
{section name=ln loop=$javascriptloads}<script type="text/javascript" src="{$javascriptloads[ln]}"></script> {/section}
</head>
<body>
<div id="wrapper">
<div id="top">&nbsp;</div>
<div id="head"><h1><span>N30-CMS</span></h1></div>
<ul id="headmenu">
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
<div id="main">
	{if isset($contextmenu[0])}
	<ul id="contentmenu">
		<li class="head">{$contextmenutitle|htmlspecialchars}</li>
		{section name=ln loop=$contextmenu}
		<li {if $context[ln].active== 'true'} class="opened"{/if}><a
			href="{$contextmenu[ln].link}"><span>{$contextmenu[ln].full_title}</span></a></li>
		{/section}
	</ul>
	<div id="right">
	{/if}
	{$mod} 
	{if isset($contextmenu[0])}
	</div>
	<br style="clear: both;" />
	{/if}

</div>
	<div class="copyright">&copy; {$smarty.now|date_format:"%Y"} <a href="http://ctstudios.nl">CT.Studios</a></div>
		
<div id="footer">&nbsp;</div>
</div>
</body>
</html>