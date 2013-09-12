<?php
class adminuser
{
	private $cms;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['action']))
		{
			$this->processPost();
		}
	}
	/**
	 * process post data
	 *
	 */
	public function processPost ()
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
				}
			}
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}	
	}
	/**
	 * show page
	 *
	 * @param string $mode
	 * @param array $args
	 * @return string
	 */
	public function show ($mode, $args)
	{
		switch ($mode)
		{
			case 'logout':
				// page title
				$this->cms->pageTitle = $this->cms->languages->lang['adminuser']['LOGOUT'];
				
				$logout = new Smarty();
				$logout->template_dir = $this->cms->bPath . "./template/user";
				$logout->compile_dir = $this->cms->bPath . "./template/compiled";
				$logout->assign('lang', $this->cms->languages->lang);
				return ($logout->fetch('logout.tpl'));
			break;
		}
	}
}
?>