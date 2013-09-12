<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms admin - {$pagetitle}</title>
<link href="{$baseurl}/admin/style/default.css" rel="stylesheet"
	type="text/css" />
{section name=ln loop=$javascriptloads}<script type="text/javascript" src="{$javascriptloads[ln]}"></script> {/section}
</head>
<body>
<div id="wrapper">
<div id="top">&nbsp;</div>
<div id="head"><h1><span>N30-CMS</span></h1></div>
<div id="main">
	{if !empty($pagetitle)}<h2>{$pagetitle}</h2>{/if}
	{if $error}<p>{$lang.adminuser.LOGINERROR}</p>{/if}
	<form method="post">
<fieldset><legend>Login form</legend>
<dl>
	<dt><label for="nickname">{$lang.adminuser.USERNAME}</label></dt>
	<dd><input type="text" name="nickname" size="24" /></dd>
	<dt><label for="password">{$lang.adminuser.PASSWORD}</label></dt>
	<dd><input type="password" name="password" size="30" /></dd>
	<dd><input type="submit" name="submit"
		value="{$lang.adminuser.LOGINBUTTON}" /><input type="hidden" name="action"
		value="login" /></dd>
</dl>
</fieldset>
</form>
	
	
</div>
	<div class="copyright">&copy; {$smarty.now|date_format:"%Y"} <a href="http://ctstudios.nl">CT.Studios</a></div>
		
<div id="footer">&nbsp;</div>
</div>
</body>
</html>