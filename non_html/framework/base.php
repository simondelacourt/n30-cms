<?php
/**
 * n30-cms base
 * 
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * Base for N30-CMS
 * 
 * PHP5 ONLY!
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
/**
 * TODO: Get tracking working
 * FIXME: sglobals links
 * 
 */
function __autoload ($class_name)
{
	$modfile = 'non_html/modules/' . $class_name . '/module.php';
	if (substr($class_name, 1, 7) != "Plugin_")
	{
		if (file_exists($modfile))
		{
			require_once $modfile;
		} else
		{
			die("N30-CMS Fatal Error: Module " . $class_name . " not found!");
		}
	}
}

class n30
{
	public $cmsVersion = "0.6 alpha 2"; // current version
	private $pageTemplate; // main template
	private $errorQ; // error queue
	private $legacy;
	private $moduleData;
	private $debug = false;
	private $showOutput = true;
	public $connection; // SQL Connection
	public $modules = array();
	public $pageTitle;
	public $pageDesc;
	public $sessions;
	public $users;
	public $user;
	public $templates;
	public $exceptions;
	public $languages;
	public $settings;
	public $fulltemplate;
	public $bPath; // basepath
	public $mode = 'normal';
	public function __construct ()
	{
		$this->exceptions = new exceptions($this);
		try
		{
			$this->moduleData = array();
			/**
			 * first we need to set up an SQL connection. At this moment only MySQL is supported
			 */
			$this->connection = new sql();
			$this->connection->connect(SQL_HOST, SQL_USER, SQL_PASS);
			$this->connection->select_db(SQL_DATB);
			$this->setHomePath();
			/**
			 * first we need to set up the session manager, this is not a default PHP sollution
			 * the PHP sollution times out after the browser is closed.
			 */
			$this->sessions = new sessions($this);
			/**
			 * the sessions are set, we can now determin the user and load the user data
			 */
			$this->users = new users($this);
			$this->user = new user($this);
			/**
			 * Now we load the internal registry
			 */
			$this->settings = new settings($this);
			/**
			 * Load the templates and language classes
			 */
			$this->templates = new templates($this);
			$this->languages = new languages($this);
			// in case user has logged in
			if ($this->user->login)
			{
				$this->templates->loadTemplateSet(array('id' => $this->user->udata['templateid'] , 'title' => $this->user->udata['templatetitle'] , 'dir' => $this->user->udata['templatedir']));
				if (isset($this->user->udata['templatetitle']))
				{
					$this->templates->setTemplate($this->user->udata['templatetitle']);
				} else
				{
					$this->templates->getDefaultTemplate();
					$this->templates->setTemplate('default');
				}
				if (isset($this->user->udata['title']))
				{
					$this->languages->setLanguage($this->user->udata['lang']);
					$this->languages->selectedlanguage = array('title' => $this->user->udata['title'] , 'dir' => $this->user->udata['dir']);
				} else
				{
					$this->languages->getDefaultLanguage();
					$this->languages->setLanguage($this->languages->defaultlanguage['dir']);
					$this->languages->selectedlanguage = $this->languages->defaultlanguage;
				}
			} else // or if user is a guest
			{
				$this->templates->getDefaultTemplate();
				$this->templates->setTemplate('default');
				$this->languages->getDefaultLanguage();
				$this->languages->setLanguage($this->languages->defaultlanguage['dir']);
				$this->languages->selectedlanguage = $this->languages->defaultlanguage;
			}
			/**
			 * Now to have support for elder modules from 0.5 we need the legacy class.
			 * The legacy class creates an environment alike the elder initiateCMS class in 0.5, which was kinda
			 * double compared to the base class in 0.5. These disappeared and are now merged into n30, but are
			 * not compatible with new old modules.. this is the workaround
			 */
			$this->legacy = new legacy($this);
			/**
			 * final part, setting up smarty for full layout
			 */
			$this->fulltemplate = new Smarty();
			$this->fulltemplate->template_dir = $this->bPath . $this->templates->templates['set']['dir'];
			$this->fulltemplate->compile_dir = $this->bPath . $this->templates->templates['set']['dir'] . "/compiled/";
		} // catch the exceptions during loading and process them
		catch (Exception $e)
		{
			$this->exceptions->addError($e);
		}
	}
	/**
	 * forces n30-cms to show debug output
	 *
	 */
	public function forceDebugMode ()
	{
		$this->exceptions->forceDebugMode();
		$this->debug = true;
	}
	/**
	 * hide output
	 *
	 */
	public function blockOutput ()
	{
		$this->showOutput = false;
	}
	/**
	 * sets the home path
	 *
	 * @param string $path
	 */
	public function setHomePath ($path = 'auto')
	{
		if ($path == 'auto')
		{
			$pathinfo = pathinfo($_SERVER['SCRIPT_FILENAME']);
			$this->bPath = $pathinfo['dirname'] . DIRECTORY_SEPARATOR;
		} else
		{
			$this->bPath = $path;
		}
	}
	/**
	 * Loads a given module
	 *
	 * @param string $module
	 * @param boolean $legacy
	 */
	public function loadModule ($module, $legacy = false)
	{
		try
		{
			if ($this->connection->connected)
			{
				if ($legacy)
				{
					/**
					 * passing this on to 'legacy', works on it's own.
					 */
					$this->legacy->loadModule($module);
				} else
				{
					/**
					 * depends on autoloading, now includes files outside of base scope
					 */
					if (file_exists(DIR_MODUL . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . "module.php"))
					{
						if (class_exists($module)) {
							$this->modules[$module] = new $module($this);
						} else {
							/**
							* autoload might have failed, why not include
							*/
							include (DIR_MODUL . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . "module.php");
							
							
							/**
							 * no class in file, very very wrong :P
							 */
							if (class_exists($module)) {
								$this->modules[$module] = new $module($this);
							} else {
								throw new Exception("Module (" . $module . ") does not contain required code.");
							}
						}
					} else
					{
						/**
						 * files don't even exist
						 */
						throw new Exception("Module (" . $module . ") directory and/or file not found.");
					}
				}
			}
		} catch (Exception $e)
		{
			$this->exceptions->addError($e);
		}
	}
	/**
	 * Shows a given loaded module
	 *
	 * @param string $module
	 * @param string $to
	 * @param string $function
	 * @param boolean $legacy
	 */
	public function generateLink ($file, $options=array())
	{
		if (LINK_STYLE == 'multiviews')
		{
			$extra = implode("/", $options);
			if (substr($extra, 0, 1) != "/")
			{
				$extra = "/" . $extra;
			}
			return (BASE_URL . $file . LINK_EXT . $extra);
			
		} else
		{
			return (null);
		}
	}
	public function showModule ($module, $to='mod', $function = 'default', $legacy = false)
	{
		if ($this->connection->connected)
		{
			try
			{
				if ($legacy)
				{
					$this->legacy->showModule($module, $to, $function);
				} else
				{
					if (isset($this->modules[$module]))
					{
						$this->addDataToOutput($this->modules[$module]->show($function), $to);
					} else
					{
						throw new Exception('No module ' . $module . ' loaded.');
					}
				}
			} catch (Exception $e)
			{
				$this->exceptions->addError($e, 'module');
			}
		}
	}
	/**
	 * Adds internal output to final array
	 *
	 * @param string $data
	 * @param string $to
	 */
	public function addDataToOutput ($data, $to)
	{
		$this->moduleData[] = array('to' => $to , 'data' => $data);
	}
	public function __destruct ()
	{
		/**
		 * process every loaded module, fill the template
		 */
		if ($this->exceptions->gotErrors())
		{
			/**
			 * Errors have occured and have been caught
			 */
			die($this->exceptions->showErrors());
		} else
		{
			/**
			 * everything works, finishing up, putting things into place
			 */
			foreach ($this->moduleData as $d)
			{
				$this->fulltemplate->assign($d['to'], $d['data']);
			}
			// check if I can show my output
			if ($this->showOutput)
			{
				$this->fulltemplate->assign('baseurl', BASE_URL);
				$this->fulltemplate->assign('pagetitle', $this->pageTitle);
				$this->fulltemplate->assign('pagedesc', $this->pageDesc);
				$this->fulltemplate->assign('version', $this->cmsVersion);
				$this->fulltemplate->display('index.tpl');
			}
			if ($this->debug AND $this->showOutput) 
			{
				/**
				 * display some debug data
				 */
				echo "<br /><center>PHP Memory use: " . round((memory_get_usage() / 1024)) . " kb - " . $this->connection->q_count . " queries</center>";
			}
		}
	}
}
?>