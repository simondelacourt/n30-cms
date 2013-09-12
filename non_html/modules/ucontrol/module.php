<?php

/**
 * (c) 2008 CT.Studios
 * version 0.2 (renamed, uconf = old name)
 * 
 * TODO: create retrievepassword
 * TODO: setup mail class
 * TODO: create showViewProfile (not so important)
 * TODO: create showProfile (important)
 */
class ucontrol
{
	private $cms;
	private $moduledir = "ucontrol";
	public function __construct (&$cms)
	{
		try
		{
			$this->cms = &$cms;
			$this->includeLang();
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	/**
	 * includes the lanugage files
	 *
	 */
	private function includeLang ()
	{
		$file = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/locale/" . $this->cms->languages->selectedlanguage['dir'] . ".php";
		if (file_exists($file))
		{
			require $file;
			if (isset($lang))
			{
				$this->lang = $lang;
			} else
			{
				throw new Exception("Module Content: erroneous language file loaded.");
			}
		} else
		{
			$file = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/locale/" . $this->cms->languages->default['dir'] . ".php";
			if (! file_exists($file))
			{
				throw new Exception("Module Content: no language file found.");
			} else
			{
				require $file;
				$this->lang = $lang;
				if (isset($lang))
				{
					$this->lang = $lang;
				} else
				{
					throw new Exception("Module Content: erroneous language file loaded.");
				}
			}
		}
	}
	public function processPost ($to = 'mod')
	{
		try
		{
			if (isset($_POST['action']))
			{
				switch ($_POST['action'])
				{
					case 'logout':
						if ($this->cms->user->login and isset($_POST['mode']))
						{
							if ($_POST['mode'] == "allsessions")
							{
								$this->cms->user->logout();
							} else
							{
								$this->cms->sessions->stopThisSession();
							}
							header("Location: " . BASE_URL);
							exit();
						} else
						{
							throw new Exception("Module ucontrol-login: malformed data");
						}
					break;
					case 'login':
						if (isset($_POST['nickname']) and isset($_POST['password']) and ! $this->cms->user->login)
						{
							if ($this->cms->user->loginUser($_POST['nickname'], $_POST['password']))
							{
								header("Location: " . BASE_URL);
							} else
							{
								// login failed
								$this->cms->pageTitle = $this->lang['LOGIN'];
								$loginform = new Smarty();
								$loginform->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
								$loginform->compile_dir = $this->cms->templates->compileddir;
								$loginform->assign('clang', $this->lang);
								$this->cms->addDataToOutput($loginform->fetch('login.error.tpl'), $to);
							}
						} else
						{
							throw new Exception("Module ucontrol-login: malformed data");
						}
					break;
					default:
						throw new Exception("Module ucontrol: unknown handler requested");
					break;
				}
			}
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	/**
	 * shows the login form
	 *
	 * @param string $to
	 */
	public function showLogin ($to = 'mod')
	{
		if (! $this->cms->user->login)
		{
			/**
			 * user is guest, so can log in
			 */
			// set pagetitle
			$this->cms->pageTitle = $this->lang['LOGIN'];
			$loginform = new Smarty();
			$loginform->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
			$loginform->compile_dir = $this->cms->templates->compileddir;
			$loginform->assign('clang', $this->lang);
			$this->cms->addDataToOutput($loginform->fetch('login.tpl'), $to);
		} else
		{
			//  echo 'you are already logged in';
			$this->cms->pageTitle = $this->lang['LOGIN'];
			$loginform = new Smarty();
			$loginform->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
			$loginform->compile_dir = $this->cms->templates->compileddir;
			$loginform->assign('clang', $this->lang);
			$this->cms->addDataToOutput($loginform->fetch('login.noxs.tpl'), $to);
		}
	}
	public function showLogout ($to = 'mod')
	{
		if (! $this->cms->user->login)
		{
			$this->cms->pageTitle = $this->lang['LOGOUT'];
			$logoutforum = new Smarty();
			$logoutforum->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
			$logoutforum->compile_dir = $this->cms->templates->compileddir;
			$logoutforum->assign('clang', $this->lang);
			$this->cms->addDataToOutput($logoutforum->fetch('logout.noxs.tpl'), $to);
		} else
		{
			$this->cms->pageTitle = $this->lang['LOGOUT'];
			$logoutforum = new Smarty();
			$logoutforum->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
			$logoutforum->compile_dir = $this->cms->templates->compileddir;
			$logoutforum->assign('clang', $this->lang);
			$this->cms->addDataToOutput($logoutforum->fetch('logout.tpl'), $to);
		}
	}
	/**
	 * shows the profile page
	 *
	 * @param string $to
	 */
	public function showProfile ($to = 'mod')
	{
		if ($this->cms->user->login)
		{
			$this->cms->pageTitle = $this->lang['PROFILE'];
			$profile = new Smarty();
			$profile->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
			$profile->compile_dir = $this->cms->templates->compileddir;
			$profile->assign('clang', $this->lang);
			$profile->assign('user', $this->cms->user->udata);
			print_r($this->cms->user->udata);
			$this->cms->addDataToOutput($profile->fetch('profile.tpl'), $to);
		} else
		{
			$this->cms->pageTitle = $this->lang['PROFILE'];
			$logoutforum = new Smarty();
			$logoutforum->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
			$logoutforum->compile_dir = $this->cms->templates->compileddir;
			$logoutforum->assign('clang', $this->lang);
			$this->cms->addDataToOutput($logoutforum->fetch('profile.noxs.tpl'), $to);
		}
	}
	public function showViewProfile ($to = 'mod')
	{
	}
	public function retrievePassword ()
	{
	}
}
?>