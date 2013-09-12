<?php

/**
 * n30-cms module
 * module: gbook
 * (C) 2005-2008 CT.Studios / Jackabuzah
 * module version: 0.05
 */
class gbook
{
	var $cms;
	var $version = 0.05;
	function gbook (&$cms)
	{
		$this->cms = &$cms;
	}
	function getMessages ($start, $end)
	{
		return ($this->cms->connection->fetch_array('SELECT g.*, u.username FROM ' . TAB_MGBOOK . ' g LEFT JOIN ' . TAB_USERS . ' u ON u.id = g.poster_id ORDER BY g.message_date ' . SORT_MODE . ' LIMIT ' . $start . ', ' . $end));
	}
	function addMessage ($posterType, $posterName, $posterIp, $posterEmail, $message)
	{
		if ($posterType == 'user' and ! empty($message) and $this->canPost())
		{
			$this->cms->connection->query("INSERT INTO " . TAB_MGBOOK . " 
									(id, poster_type, poster_id, poster_ip, message_normal, message_parsed, message_date) 
									VALUES 
									(null,
									'user', 
									'" . intval($this->cms->classes['user']->uid) . "',
									'" . $this->cms->connection->escape_string($posterIp) . "',
									'" . $this->parseMessage('normal', $message) . "',
									'" . $this->parseMessage('bbcode', $message) . "',
									now()
									)
									");
			return (true);
		} elseif ($posterType == 'guest' and ! empty($message) and $this->canPost())
		{
			$this->cms->connection->query("INSERT INTO " . TAB_MGBOOK . " 
									(id, poster_type, poster_name, poster_email, poster_ip, message_normal, message_parsed, message_date) 
									VALUES 
									(null,
									'guest', 
									'" . $this->cms->connection->escape_string($posterName) . "',
									'" . $this->cms->connection->escape_string($posterEmail) . "',
									'" . $this->cms->connection->escape_string($posterIp) . "',
									'" . $this->parseMessage('normal', $message) . "',
									'" . $this->parseMessage('bbcode', $message) . "',
									now()
									)
									");
			return (true);
		} else
		{
			return (false);
		}
	}
	function canPost ()
	{
		if (! isset($_COOKIE[GBOOK_P_COOK]))
		{
			return (true);
		} else
		{
			return (false);
		}
	}
	function parseMessage ($mode, $message)
	{
		return ($this->cms->connection->escape_string($message));
	}
	function showMessages ()
	{
		$error = false;
		if (! isset($_COOKIE[GBOOK_A_SPAM_COOKIE]))
		{
			setcookie(GBOOK_A_SPAM_COOKIE, substr(md5(rand() . rand() . rand() . 'wtf'), 0, 6));
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['action']))
		{
			switch ($this->cms->classes['user']->login)
			{
				case true:
					if ($this->addMessage('user', '', $_SERVER['REMOTE_ADDR'], '', $_POST['message']))
					{
						setcookie(GBOOK_P_COOK, 'true', time() + GBOOK_SPAM_TIME, '/');
					} else
					{
						$error = true;
					}
					break;
				default:
					if (! empty($_POST['name']) and (GBOOK_A_SPAM_CHECK == true and $_POST['asp'] == $_COOKIE[GBOOK_A_SPAM_COOKIE]))
					{
						if ($this->addMessage('guest', $_POST['name'], $_SERVER['REMOTE_ADDR'], $_POST['email'], $_POST['message']))
						{
							setcookie(GBOOK_U_COOK, $_POST['name'], SESS_COOKIE_STAY, '/');
							setcookie(GBOOK_A_SPAM_COOKIE_REM, $_POST['asp'], SESS_COOKIE_STAY, '/');
							setcookie(GBOOK_E_COOK, $_POST['email'], SESS_COOKIE_STAY, '/');
							setcookie(GBOOK_P_COOK, 'true', time() + GBOOK_SPAM_TIME, '/');
						} else
						{
							$error = true;
						}
					} else
					{
						$error = true;
					}
					break;
			}
			if ($error == false)
			{
				header("Location: " . BASE_URL . GBOOK_FILE . LINK_EXT);
				exit();
			}
		}
		$template = new Smarty();
		$template->template_dir = $this->cms->classes['base']->templates['dir'];
		$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
		$template->assign('lang', $this->cms->classes['base']->lang);
		$template->assign('baseurl', BASE_URL);
		$template->assign('gbook', $this->getMessages(0, 1000000));
		$template->assign('login', $this->cms->classes['user']->login);
		$template->assign('seconds', GBOOK_SPAM_TIME);
		$template->assign('aspm', GBOOK_A_SPAM_CHECK);
		if (isset($_COOKIE[GBOOK_A_SPAM_COOKIE_REM]))
		{
			$template->assign('asp', $_COOKIE[GBOOK_A_SPAM_COOKIE_REM]);
		}
		if (isset($_COOKIE[GBOOK_E_COOK]))
		{
			$template->assign('email', $_COOKIE[GBOOK_E_COOK]);
		}
		if (isset($_COOKIE[GBOOK_U_COOK]))
		{
			$template->assign('user', $_COOKIE[GBOOK_U_COOK]);
		}
		$template->assign('error', $error);
		$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['gbook']['title'];
		return ($template->fetch('gbook.overview.tpl'));
	}
	function show ($function)
	{
		return ($this->showMessages());
	}
}
?>