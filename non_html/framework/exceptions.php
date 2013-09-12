<?php
/**
 * n30-cms exceptions
 * Version 0.1
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * This is the new and improved error handling in n30-cms 0.6, 
 * totally rewritten, based on the new PHP5 error handling.
 * This class handles all serious exceptions.
 * Other exceptions are handled by the module or other parts.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class exceptions
{
	private $cms;
	private $errors;
	private $mode = 'normal'; // either normal or debug;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
	}
	public function forceDebugMode ()
	{
		$this->mode = 'debug';
	}
	public function addError (&$exception)
	{
		$this->errors[] = &$exception;
	}
	public function gotErrors ()
	{
		if (isset($this->errors[0]))
		{
			return (true);
		} else
		{
			return (false);
		}
	}
	public function showErrors ()
	{
		$eMsg = "<html><head><title>n30-cms: an error has occured</title>\n";
		$eMsg .= '<style type="text/css"><!--';
		$eMsg .= " body { font-family: \"Trebuchet MS\", verdana arial; font-size: 11px;} h1 {padding: 0px; margin-top: 5px; margin-left: 5px;}\n";
		$eMsg .= "p { margin-left: 5px; } h2 {margin-left: 5px;}";
		$eMsg .= "a:link, a:visited {text-decoration: none; color: #666666; } a:hover { text-decoration: underline; color: #000;}";
		$eMsg .= "--></style> ";
		if ($this->mode == 'debug')
		{
			$mode = '(debug)';
		} else
		{
			$mode = '';
		}
		$eMsg .= "</head><body>";
		$eMsg .= "<div style='border: 10px solid #EFEFEF; padding: 0px;'><h1  style=\"background-color: #EFEFEF; border-bottom: 1px solid #666666; margin: 0px; padding-bottom: 5px;display: block; width: 100%;\" >n30-cms " . $mode . " </h1>";
		$eMsg .= "<p>An error has occured during the execution of n30-cms:</p>";
		foreach ($this->errors as $error)
		{
			if (isset($error->title))
			{
				$eMsg .= "<h2>" . $error->title . "</h2>";
			} else
			{
				$eMsg .= "<h2>Exception</h2>";
			}
			$eMsg .= "<p>" . $error->getMessage() . "</p>";
			if (isset($error->debuginfo) and $this->mode == 'debug')
			{
				$eMsg .= $error->debuginfo;
			}
		}
		$eMsg .= '<h2 style="background-color: #EFEFEF; border-top: 1px solid #666666; margin: 0px; padding-top: 5px;display: block; width: 100%; font-size: 12px;">&copy; <a href="http://www.ctstudios.nl">CT.Studios</a> - n30-cms ' . $this->cms->cmsVersion . '</h2>';
		$eMsg .= "</body></html>";
		return ($eMsg);
	}
}
?>