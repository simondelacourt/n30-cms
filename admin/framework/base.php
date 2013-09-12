<?php
/**
 * n30-cms admin: base
 * version 0.2
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * Base for admin
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
/**
/**
 * TODO: create legacy module loading
 */
class admin
{
	//public:
	public $connection; // SQL Connection
	public $rights;
	public $exceptions;
	public $settings;
	public $sessions;
	public $languages;
	public $templates;
	public $filemanagement;
	public $users;
	public $user;
	public $menu;
	public $bPath;
	public $adminTemplate;
	public $module;
	public $moduleloaded = false;
	public $moduleoutput;
	public $mode = 'admin';
	public $pageTitle;
	public $cmsVersion = "0.6 alpha 2";
	
	// private:
	private $javascriptloads = array();
	private $showoutput = true;
	private $blockmodules = false;
	private $debug = false;
	
	public function __construct ($active = "")
	{
		$this->exceptions = new exceptions($this);
		try
		{
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
			 * Now we load the internal settings
			 */
			$this->settings = new settings($this);
			/**
			 * Load the templates and language classes
			 */
			$this->templates = new templates($this);
			$this->languages = new languages($this);
			$this->languages->setLanguage($this->user->udata['lang']);
			$this->languages->getDefaultLanguage();
			/**
			 * load the rights management
			 */
			$this->rights = new adminRights($this);
			if (!$this->rights->xstoAdmin() AND !$this->user->login)
			{
				$this->blockOutput();
				$this->languages->setLanguage($this->languages->defaultlanguage['dir']);
				$this->languages->selectedlanguage = $this->languages->defaultlanguage;
				$this->displayLogin();
			}
			else
			{
				// user is no guest, but might also not be allowed to be here
				if (!$this->rights->xstoAdmin())
				{
					$this->exceptions->addError(new Exception ("You have no access to the admin"));
					$this->blockmodules = true;
					exit();
				}
			}
	
			/**
			 * File management
			 */
			$this->filemanagement = new filemanagement($this);
			
			/**
			 * set up the menu for the admin
			 */
			$this->menu = new menu($this, $active);
			/**
			 * set up the template for the admin
			 */
			$this->adminTemplate = new Smarty();
			$this->adminTemplate->template_dir = $this->bPath . "./template";
			$this->adminTemplate->compile_dir = $this->bPath . "./template/compiled";
		} catch (Exception $e)
		{
			$this->exceptions->addError($e);
		}
	}
	/**
	 * sets base path
	 *
	 * @param unknown_type $path
	 */
	public function setHomePath ($path = 'auto')
	{
		if ($path == 'auto')
		{
			$this->bPath = realpath("./") . DIRECTORY_SEPARATOR;
		} else
		{
			$this->bPath = $path;
		}
	}
	/**
	 * generate a link
	 *
	 * @param string $file
	 * @param string $options
	 * @return string
	 */
	public function generateLink ($file, $options = array(), $mode = 'admin/')
	{
		if (LINK_STYLE == 'multiviews')
		{
			return (BASE_URL . $mode . $file . LINK_EXT . DIRECTORY_SEPARATOR . implode("/", $options));
		} else
		{
			return (null);
		}
	}
	public function isModule ($module)
	{
	}
	public function getWYSIWYGcode($fieldname, $data='', $configurl='', $mode='', $width='', $height='', $toolbarset='Default')
	{
		// locate editor
		// for now we just use fckedit, later others, so now the path should be kinda fixed
		$editorcode = '';
		$editor = 'fckeditor';
		
		
		// create HTML
		switch ($editor)
		{
			case 'fckeditor':
				// admin should add the fckeditor javascript to output
				$this->loadJavascript(BASE_URL . "admin/thirdparty/fckeditor/fckeditor.js");
				// html code
				$editorcode .= '<script type="text/javascript">'. "\n";
  				$editorcode .= 'var oFCKeditor = new FCKeditor( \'' . strip_tags($fieldname) . '\' ) ;'. "\n";
				if (!empty($configurl))
  				{
  					$editorcode .= 'oFCKeditor.Config[\'CustomConfigurationsPath\'] = \'' . $configurl .  '\';' . "\n";
  				}
  				$editorcode	.= 'oFCKeditor.BasePath = "' . BASE_URL . 'admin/thirdparty/fckeditor/" ;' . "\n";
  				$editorcode .= 'oFCKeditor.ToolbarSet = \'' . $toolbarset . '\';' . "\n";
  				if (!empty($height))
  				{
  					 $editorcode .= 'oFCKeditor.Height = \''. $height . '\';' . "\n";
  				}
				if (!empty($width))
  				{
  					 $editorcode .= 'oFCKeditor.Width = \''. $width . '\';' . "\n";
  				}
  				if (!empty($data))
  				{
  					$editorcode .= 'oFCKeditor.Value = \'' . preg_replace("/[\r\t\n]/",'' ,$data) .  '\';' . "\n";
  				}
  				
  			
  				
 				$editorcode .= 'oFCKeditor.Create();' . "\n";
 				$editorcode .= '</script>' . "\n";
			break;
		}
		return ($editorcode);	
	}
	/**
	 * loads an internal module
	 *
	 * @param string $module
	 */
	public function loadAdminModule ($module)
	{
		if (!$this->blockmodules)
		{
			try
			{
				$p = realpath("./internal");
				if (is_file($p . DIRECTORY_SEPARATOR . $module . ".php"))
				{
					require_once ($p . DIRECTORY_SEPARATOR . $module . ".php");
					$class = "admin" . $module;
					if (class_exists($class))
					{
						$this->module = new $class($this);
						$this->moduleloaded = true;
					} else
					{
						throw new Exception("Malformed internal module loaded");
					}
				} else
				{
					throw new Exception("Internal module not found.");
				}
			} catch (Exception $e)
			{
				$this->exceptions->addError($e);
			}
		}
	}
	/**
	 * Loads a module
	 *
	 * @param string $module
	 * @param boolean $legacy
	 */
	public function loadModule ($module, $legacy = false)
	{
		if (!$this->blockmodules)
		{
			try
			{
				if ($this->rights->xstoMod($module))
				{
					if ($legacy)
					{
					/**
					 * legacy module, needs special stuff
					 */
					} else
					{
						/**
						 * normal modern module
						 */
						$p = realpath("../non_html/modules/" . $module);
						if (is_file($p . DIRECTORY_SEPARATOR . "admin.php"))
						{
							$class = $module . "Admin";
							include $p . DIRECTORY_SEPARATOR . "admin.php";
							if (is_file($p . DIRECTORY_SEPARATOR . "config.php"))
							{
								include $p . DIRECTORY_SEPARATOR . "config.php";
							}
							if (class_exists($class))
							{
								$this->module = new $class($this);
								$this->moduleloaded = true;
							} else
							{
								throw new Exception("Malformed admin module loaded");
							}
						} else
						{
							throw new Exception("Admin module not found");
						}
					}
				} else
				{
					throw new Exception("User is trying to access module but has no access rights.");
				}
			} catch (Exception $e)
			{
				$this->exceptions->addError($e);
			}
		}
	}
	/**
	 * shows a module
	 *
	 * @param unknown_type $function
	 * @param unknown_type $opt
	 */
	public function showModule ($function, $opt = array())
	{
		if (!$this->blockmodules)
		{
			try
			{
				if ($this->moduleloaded)
				{
					if (!$this->exceptions->gotErrors())
					{
						$this->adminTemplate->assign('mod', $this->module->show($function, $opt));
				
					}
				} 
				else
				{
					$this->exceptions->addError(new Exception("No module loaded"));
				}
			}
			catch (Exception $e)
			{
				$this->exceptions->addError($e);
			}
		}
	}
	/**
	 * lists all modules
	 *
	 * @return array
	 */
	public function listModules ()
	{
		$modules = array();
		// first check directory for new modules
		$dir = realpath($this->bPath . "../non_html/modules/") . "/";
		if ($dh = opendir($dir))
		{
        	while (($file = readdir($dh)) !== false)
        	{
        		if ($file[0] != "." AND $file != "legacy" AND $file != "ucontrol" AND is_dir($dir . $file))
        		{
            		$modules[] = $file;
        		}
        	}
        }
        closedir($dh);
        // now check legacy
        $dir = realpath($this->bPath . "../non_html/modules/legacy") . "/";
		if ($dh = opendir($dir))
		{
        	while (($file = readdir($dh)) !== false)
        	{
        		if (substr($file, -8) == ".mod.php")
        		{
            		$modules[] = substr($file, 0, -8);
        		}
        	}
        }
        closedir($dh);
     	return ($modules);
	}
	/**
	 * force debug mode
	 *
	 */
	public function forceDebugMode ()
	{
		$this->exceptions->forceDebugMode();
		error_reporting(E_ALL);
		$this->debug = true;
	}
	public function blockOutput ()
	{
		$this->showoutput = false;
	}
	public function loadJavascript($file)
	{
		$this->javascriptloads[] = $file;
	}
	public function displayLogin ()
	{
		$error = false;
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (isset($_POST['nickname']) AND isset($_POST['password']) )
			{
				if ($this->user->loginUser($_POST['nickname'], $_POST['password']))
				{
					$link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					header("Location: " . $link);
				} 
				else
				{
					// login failed
					$error = true;
				}
			} else
			{
				throw new Exception("Admin-login: malformed data");
			}
		}
		$loginform = new Smarty();
		$loginform->template_dir = $this->bPath . "./template";
		$loginform->compile_dir = $this->bPath . "./template/compiled";
		$loginform->assign('baseurl', BASE_URL);
		$loginform->assign('lang', $this->languages->lang);
		$loginform->assign('error', $error);
		$loginform->display('login.tpl');
	}
	/**
	 * finish the admin
	 *
	 */
	public function __destruct ()
	{
		if ($this->exceptions->gotErrors())
		{
			if ($this->user->login)
			{
				/**
				 * Errors have occured and have been caught
				 */
				die($this->exceptions->showErrors());
			}
		} else
		{
			if ($this->showoutput)
			{
				$this->adminTemplate->assign('baseurl', BASE_URL);
				$this->adminTemplate->assign('mainmenu', $this->menu->getMenu('top'));
				$this->adminTemplate->assign('submenu', $this->menu->getMenu('sub'));
				$this->adminTemplate->assign('contextmenutitle', $this->menu->contexttitle);
				$this->adminTemplate->assign('contextmenu', $this->menu->getMenu('context'));
				$this->adminTemplate->assign('javascriptloads', $this->javascriptloads);
				$this->adminTemplate->assign('pagetitle', $this->pageTitle);
				$this->adminTemplate->assign('cmsversion', $this->cmsVersion);
				$this->adminTemplate->display('index.tpl');
			}
		}
		if ($this->debug AND $this->showoutput)
		{
			/**
			 * display some debug data
			 */
			echo "<br /><center>PHP Memory use: " . round((memory_get_usage() / 1024)) . " kb - " . $this->connection->q_count . " queries</center>";
		}
	}
}
?>