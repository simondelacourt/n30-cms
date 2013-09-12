<?php
/**
 * n30-cms admin: cms
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
 * CMS pages for admin, settings like templates, languages etc
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class admincms
{
	private $cms;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		$this->cms->menu->addItem('sub', $this->cms->languages->lang['admincms']['templates'], $this->cms->generateLink("cms", array('view' => "templates")));
		$this->cms->menu->addItem('sub', $this->cms->languages->lang['admincms']['languages'], $this->cms->generateLink("cms", array('view' => "languages")));
		$this->cms->menu->addItem('sub', $this->cms->languages->lang['admincms']['othersettings'], $this->cms->generateLink("cms", array('view' => "settings")));
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->processPost();
		}
	}
	private function processPost ()
	{
		if (isset($_POST['action']))
		{
			switch ($_POST['action'])
			{
				case 'uninstalltemplate':
					if (isset($_POST['id']))
					{
						$this->cms->templates->unInstallTemplate($_POST['id']);
						header ("Location: " . $this->cms->generateLink("cms", array('view' => "templates")));
						exit();
					}
				break;
				case 'uninstalllanguage':
					if (isset($_POST['id']))
					{
						$this->cms->languages->unInstallLanguage($_POST['id']);
						header ("Location: " . $this->cms->generateLink("cms", array('view' => "languages")));
						exit();
					}
				break;
			}
		}
	}
	private function installTemplate ($dir)
	{
		$QE = $this->cms->connection->query("SELECT id FROM " . TAB_TEMPLATES . " WHERE dir = '" . $this->cms->connection->escape_string($dir) . "'");
		if ($this->cms->connection->num_rows($QE) == 0)
		{
			if ($this->cms->templates->isTemplateDir($dir))
			{
				$this->cms->templates->installTemplate($dir, $dir);
				header ("Location: " . $this->cms->generateLink("cms", array('view' => "templates")));
				exit();
			}
		}
		else
		{
			header ("Location: " . $this->cms->generateLink("cms", array('view' => "templates")));
			exit();
		}
	}
	private function installLanguage ($dir)
	{
		$QE = $this->cms->connection->query("SELECT id FROM " . TAB_LANG . " WHERE dir = '" . $this->cms->connection->escape_string($dir) . "'");
		if ($this->cms->connection->num_rows($QE) == 0)
		{
			if ($this->cms->languages->isLanguageDir($dir))
			{
				$this->cms->languages->installLanguage($dir, $dir);
				header ("Location: " . $this->cms->generateLink("cms", array('view' => "languages")));
				exit();
			}
		}
		else
		{
			header ("Location: " . $this->cms->generateLink("cms", array('view' => "languages")));
			exit();
		}
	}
	private function getTemplates ()
	{
		$tlist = $this->cms->templates->getTemplatesFromDir();
		$tinstalled = $this->cms->templates->getTemplates();
		$tnlist = array();
		foreach ($tlist AS $t)
		{
			$found = false;
			foreach ($tinstalled AS $ti)
			{
				if ($ti['dir'] == $t) // installed
				{
					$n['id'] = $ti['id'];
					$n['title'] = $ti['title'];
					$n['dir'] = $ti['dir'];
					$n['default'] = $ti['def'];
					$n['installed'] = 1;
					$n['uninstallurl'] = $this->cms->generateLink("cms", array('action' => "uninstalltemplate", 'template' => $n['id']));
					$n['setdefaulturl']= $this->cms->generateLink("cms", array('action' => "setdefaulttemplate", 'template' => $n['id']));
					$found = true;
					break;
				}
			}
			if (!$found) // not installed
			{
				$n['id'] = "-";
				$n['title'] = $t;
				$n['dir'] = $t;
				$n['default'] = 'false';
				$n['installed'] = 0;
				$n['installurl'] = $this->cms->generateLink("cms", array('action' => "installtemplate", 'template' => $n['dir']));
			}

			$tnlist[] = $n;
		}
		return ($tnlist);
	}
	private function getLanguages ()
	{
		$tlist = $this->cms->languages->getLanguagesFromDir();
		$tinstalled = $this->cms->languages->getLanguages();
		$tnlist = array();
		foreach ($tlist AS $t)
		{
			$found = false;
			foreach ($tinstalled AS $ti)
			{
				if ($ti['dir'] == $t) // installed
				{
					$n['id'] = $ti['id'];
					$n['title'] = $ti['title'];
					$n['dir'] = $ti['dir'];
					$n['default'] = $ti['def'];
					$n['installed'] = 1;
					$n['uninstallurl'] = $this->cms->generateLink("cms", array('action' => "uninstalllanguage", 'template' => $n['id']));
					$n['setdefaulturl']= $this->cms->generateLink("cms", array('action' => "setdefaultlanguage", 'template' => $n['id']));
					$found = true;
					break;
				}
			}
			if (!$found) // not installed
			{
				$n['id'] = "-";
				$n['title'] = $t;
				$n['dir'] = $t;
				$n['default'] = 'false';
				$n['installed'] = 0;
				$n['installurl'] = $this->cms->generateLink("cms", array('action' => "installlanguage", 'template' => $n['dir']));
			}

			$tnlist[] = $n;
		}
		return ($tnlist);
	}
	public function show ($mode, $args)
	{
		switch ($mode)
		{
			/**
			 * templates
			 */
			case 'setdefaulttemplate':
				if (isset($args['id']))
				{
					$this->cms->templates->setDefault($args['id']);
					header ("Location: " . $this->cms->generateLink("cms", array('view' => "templates")));
					exit();
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			case 'installtemplate':
				if (isset($args['id']))
				{
					$this->installTemplate($args['id']);
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			case 'uninstalltemplate':
				if (isset($args['id']) AND !empty($args['id']))
				{
					$templates = new Smarty();
					$templates->template_dir = $this->cms->bPath . "./template/cms";
					$templates->compile_dir = $this->cms->bPath . "./template/compiled";
					$templates->assign('lang', $this->cms->languages->lang);
					$templates->assign('baseurl', BASE_URL);
					$templates->assign('id', $args['id']);
					$this->cms->pageTitle = $this->cms->languages->lang['admincms']['templates'];
					return ($templates->fetch('uninstalltemplate.tpl'));
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			/**
			 * languages
			 */
			case 'setdefaultlanguage':
				if (isset($args['id']))
				{
					$this->cms->languages->setDefault($args['id']);
					header ("Location: " . $this->cms->generateLink("cms", array('view' => "languages")));
					exit();
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			case 'installlanguage':
				if (isset($args['id']))
				{
					$this->installLanguage($args['id']);
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			case 'uninstalllanguage':
				if (isset($args['id']) AND !empty($args['id']))
				{
					$languages = new Smarty();
					$languages->template_dir = $this->cms->bPath . "./template/cms";
					$languages->compile_dir = $this->cms->bPath . "./template/compiled";
					$languages->assign('lang', $this->cms->languages->lang);
					$languages->assign('baseurl', BASE_URL);
					$languages->assign('id', $args['id']);
					$this->cms->pageTitle = $this->cms->languages->lang['admincms']['language'];
					return ($languages->fetch('uninstalllanguage.tpl'));
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			/**
			 * overviews
			 */
			case 'templates':
				$templates = new Smarty();
				$templates->template_dir = $this->cms->bPath . "./template/cms";
				$templates->compile_dir = $this->cms->bPath . "./template/compiled";
				$templates->assign('lang', $this->cms->languages->lang);
				$templates->assign('templates', $this->getTemplates());
				$templates->assign('baseurl', BASE_URL);
				$this->cms->pageTitle = $this->cms->languages->lang['admincms']['templates'];
				return ($templates->fetch('templates.tpl'));
			break;
			case 'languages':
				$languages = new Smarty();
				$languages->template_dir = $this->cms->bPath . "./template/cms";
				$languages->compile_dir = $this->cms->bPath . "./template/compiled";
				$languages->assign('lang', $this->cms->languages->lang);
				$languages->assign('languages', $this->getLanguages());
				$languages->assign('baseurl', BASE_URL);
				$this->cms->pageTitle = $this->cms->languages->lang['admincms']['languages'];
				return ($languages->fetch('languages.tpl'));
			break;
			/**
			 * settings
			 */
			case 'settings':
				$settings = new Smarty();
				$settings->template_dir = $this->cms->bPath . "./template/cms";
				$settings->compile_dir = $this->cms->bPath . "./template/compiled";
				$settings->assign('lang', $this->cms->languages->lang);
				$settings->assign('languages', $this->getLanguages());
				$settings->assign('baseurl', BASE_URL);
				
				// process settings for links
				$settingsdata = $this->cms->settings->getCategories();
				$newsettings = array();
				
				if (isset($settingsdata[0]))
				{
					foreach ($settingsdata AS $setting)
					{
						$setting['link'] =  $this->cms->generateLink("cms", array('action' => "viewsettingscategory", 'setting' => $setting['category_name']));
						$newsettings[] = $setting;
					}
				}
				
				$settings->assign('settings', $newsettings);
				$this->cms->pageTitle = $this->cms->languages->lang['admincms']['othersettings'];
				return ($settings->fetch('settings.tpl'));
			break;
			case 'viewsettingscategory':
				if (isset($args['id']))
				{
					$settings = new Smarty();
					$settings->template_dir = $this->cms->bPath . "./template/cms";
					$settings->compile_dir = $this->cms->bPath . "./template/compiled";
					$settings->assign('lang', $this->cms->languages->lang);
					$settings->assign('languages', $this->getLanguages());
					$settings->assign('baseurl', BASE_URL);
					
					// process settings for links
					$settingsdata = $this->cms->settings->getSettings($args['id']);
					$newsettings = array();
					
					if (isset($settingsdata[0]))
					{
						foreach ($settingsdata AS $setting)
						{
							$setting['link'] =  $this->cms->generateLink("cms", array('action' => "viewsetting", 'setting' => $setting['id']));
							$newsettings[] = $setting;
						}
					}
					
					$settings->assign('settings', $newsettings);
					return ($settings->fetch('settingslist.tpl'));
				}
				else
				{
					throw new Exception ('Admin Module: CMS: Malformed input, ID missing');
				}
			break;
			default:
				// page title
				$this->cms->pageTitle = $this->cms->languages->lang['admincms']['hometitle'];
				return ("<p>" . $this->cms->languages->lang['admincms']['home'] . "</p>");
			break;
		}
	}
}
?>