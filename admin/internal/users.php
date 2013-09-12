<?php
/**
 * n30-cms admin: user
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
 * Admin user management
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class adminusers
{
	private $cms;
	private $url;
	private $messages;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		$this->cms->forceDebugMode();
		$this->cms->menu->addItem('sub', $this->cms->languages->lang['adminusers']['finduser'], $this->cms->generateLink("users", array("finduser")));
		$this->cms->menu->addItem('sub', $this->cms->languages->lang['adminusers']['addnewuser'], $this->cms->generateLink("users", array("addnewuser")));
		$this->cms->menu->addItem('sub', $this->cms->languages->lang['adminusers']['usergroups'], $this->cms->generateLink("users", array("usergroups")));
		if (LINK_STYLE == "multiviews")
		{
			if (isset($_SERVER['PATH_INFO']) and !empty($_SERVER['PATH_INFO']))
			{
				$this->url = explode('/', substr($_SERVER['PATH_INFO'], 1));
			}
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['action']))
		{
			try
			{
				$this->processPost();
			} catch (Exception $e)
			{
				$this->cms->exceptions->addError($e);
			}
		}
	}
	/**
	 * process post input
	 *
	 */
	private function processPost ()
	{
		switch ($_POST['action'])
		{
			case 'addnewgroup':
				if (isset($_POST['title']) AND isset($_POST['default']) AND !empty($_POST['title']))
				{
					$this->cms->users->addGroup($_POST['title'], $_POST['default']);
				}
			break;
			case 'deletegroup':
				if (isset($_POST['id']))
				{
					$this->cms->users->deleteGroup($_POST['id']);
					header("Location: " . admin::generateLink("users", array('action' => 'usergroups')));
				}
				else
				{
					throw new Exception("Erroneous input for edit group");
				}
			break;
			case 'editgroup':
				if (isset($_POST['id']) AND isset($_POST['title']) AND isset($_POST['default']) AND !empty($_POST['title']))
				{
					$this->cms->users->editGroup($_POST['id'], $_POST['title'], $_POST['default']);
				}
				else
				{
					throw new Exception("Erroneous input for edit group");
				}
			break;
			case 'deleterights':
				if (isset($_POST['delete'][0]))
				{
					foreach ($_POST['delete'] AS $did)
					{
						$this->cms->rights->deleteRight($did);
					}
				}
			break;
			case 'addright':
				if (isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['type']) AND ($_POST['type'] == 'admin' OR $_POST['type'] == 'all' OR $_POST['type'] == 'mod') AND isset($_POST['module']))
				{
					if ($_POST['type'] == 'all')
					{
						$accessto = 'mod_all';
					}
					elseif ($_POST['type'] == 'admin')
					{
						$accessto = 'admin';
					}
					else
					{
						$accessto = 'adm_' . $_POST['module'];
					}
					$this->cms->rights->addRight('group', intval($_POST['id']), $accessto);			
				}
			break;
			case 'adduser':
				if (isset($_POST['username']) AND isset($_POST['email']) AND isset($_POST['templates']) AND isset($_POST['languages']) AND isset($_POST['unid']) AND isset($_POST['password']))
				{
					if (!isset($_POST['groups']))
					{
						$groups = array();
					}
					else
					{
						$groups = (array)$_POST['groups'];
					}
					$errors = $this->cms->users->checkAddUser ($_POST['username'], $_POST['email'], $_POST['templates'], $_POST['languages'], $_POST['password']);
					if (isset($errors[0]))
					{
						$this->messages['adduser'] = $errors;
					}
					else
					{
						$uid = $this->cms->users->addUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['unid'], $_POST['templates'], $_POST['languages'],$groups, 'true');
						header("Location: " . admin::generateLink("users", array('action' => 'viewuser', 'id' => intval($uid))));
					}
				}
				else
				{
					throw new Exception("Erroneous input for adduser");
				}
			break;
			case 'deleteusernote':
				if (isset($_POST['id']))
				{
					$unote = $this->cms->users->getUserNote($_POST['id']);
					$this->cms->users->deleteUserNote($_POST['id']);
					header("Location: " . admin::generateLink("users", array('action' => 'usernotes', 'id' => intval($unote['userid']))));
				}
			break;
			case 'addusernote':
				if (isset($_POST['userid']) AND !empty($_POST['note']))
				{
					$this->cms->users->addUserNote($_POST['userid'], $_POST['note']);
					header("Location: " . admin::generateLink("users", array('action' => 'usernotes', 'id' => $_POST['userid'])));
				}
			break;
			case 'deleteuser':
				if (isset($_POST['userid']))
				{
					$this->cms->users->deleteUser($_POST['userid']);
					header("Location: " . admin::generateLink("users"));
					exit();
				}
			break;
			case 'addusertogroup':
				if (isset($_POST['userid']) and isset($_POST['group']))
				{
					$this->cms->users->addUserToGroup($_POST['userid'], $_POST['group']);
				}
			break;
			case 'editusergroups':
				if (isset($_POST['userid']))
				{
					if (isset($_POST['listdefault']))
					{
						$this->cms->users->editUserDefaultGroup($_POST['userid'], $_POST['listdefault']);
					}
					if (isset($_POST['delete']))
					{
						foreach ($_POST['delete'] as $del)
						{
							$this->cms->users->removeUserFromGroup($_POST['userid'], $del);
						}
					}
				}
			break;
			case 'editpassword':
				if (isset($_POST['password1']) and isset($_POST['password2']) and isset($_POST['userid']))
				{
					if ($_POST['password1'] == $_POST['password2'])
					{
						if (strlen($_POST['password1']) > 4)
						{
							$this->cms->users->editPassword($_POST['userid'], $_POST['password1']);
							$this->messages['editpassword'][] = 'passwordok';
						} else
						{
							$this->messages['editpassword'][] = 'passwordshort';
						}
					} else
					{
						$this->messages['editpassword'][] = 'passwordnomatch';
					}
				}
			break;
			case 'edituser':
				if (isset($_POST['userid']) and isset($_POST['email']) and isset($_POST['username']) and isset($_POST['signature']) and isset($_POST['avatar']) and isset($_POST['templates']) and isset($_POST['languages']))
				{
					if (!$this->cms->users->editUser($_POST['userid'], $_POST['username'], $_POST['email'], $_POST['templates'], $_POST['languages'], $_POST['avatar'], $_POST['signature']))
					{
						$this->messages['edituser'] = $this->cms->users->checkEditUser($_POST['userid'], $_POST['username'], $_POST['email'], $_POST['templates'], $_POST['languages'], $_POST['avatar'], $_POST['signature']);
					}
				}
			break;
			default:
				throw new Exception("Illegal post action");
			break;
		}
	}
	/**
	 * display notes for a user
	 *
	 * @param int $id
	 * @return string
	 */
	public function showUserNotes ($id)
	{
		if (!empty($id))
		{
			$user = $this->cms->users->getUser($id);
			if (!isset($user['id']))
			{
				throw new Exception("Erroneous input for user.");
			} else
			{
				// page title
				$this->cms->pageTitle = $user['username'];
				
				// add menu
				$this->cms->menu->contexttitle = $user['username'];
				$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['edituser'], $this->cms->generateLink("users", array("viewuser" , $user['id'])));
				if ($id != $this->cms->user->uid)
				{
					$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['deleteuser'], $this->cms->generateLink("users", array("deleteuser" , $user['id'])));
				}
				$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['usernotes'], $this->cms->generateLink("users", array("usernotes" , $user['id'])));
				// templates
				$usernotes = new Smarty();
				$usernotes->template_dir = $this->cms->bPath . "./template/users";
				$usernotes->compile_dir = $this->cms->bPath . "./template/compiled";
				$usernotes->assign('lang', $this->cms->languages->lang);
				$usernotes->assign('user', $user);
				// notes
				$usernotes->assign('notes', $this->cms->users->getUserNotes($id));
				return ($usernotes->fetch('usernotes.tpl'));
			}
		} else
		{
			throw new Exception("No user defined");
		}
	}
	/**
	 * Views a user delete pane
	 *
	 * @param int $id
	 * @return string
	 */
	public function showDeleteUser ($id)
	{
		if (!empty($id))
		{
			$user = $this->cms->users->getUser($id);
			
			// page title
			$this->cms->pageTitle = $user['username'];

			if (!isset($user['id']))
			{
				throw new Exception("Erroneous input for user.");
			} else
			{
				// add menu
				$this->cms->menu->contexttitle = $user['username'];
				$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['edituser'], $this->cms->generateLink("users", array("viewuser" , $user['id'])));
				if ($id != $this->cms->user->uid)
				{
					$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['deleteuser'], $this->cms->generateLink("users", array("deleteuser" , $user['id'])));
				}
				$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['usernotes'], $this->cms->generateLink("users", array("usernotes" , $user['id'])));
				// templates
				$deleteuser = new Smarty();
				$deleteuser->template_dir = $this->cms->bPath . "./template/users";
				$deleteuser->compile_dir = $this->cms->bPath . "./template/compiled";
				$deleteuser->assign('lang', $this->cms->languages->lang);
				$deleteuser->assign('user', $user);
				return ($deleteuser->fetch('deleteuser.tpl'));
			}
		} else
		{
			throw new Exception("No user defined");
		}
	}
	public function showDeleteUserGroup ($id)
	{
		if (!empty($id))
		{
			$group = $this->cms->users->getGroup($id);
			
			// page title
			$this->cms->pageTitle = $group['title'];
						
			if (!isset($group['id']))
			{
				throw new Exception("Erroneous input for group.");
			}
			else 
			{
				// templates
				$deletegroup = new Smarty();
				$deletegroup->template_dir = $this->cms->bPath . "./template/users";
				$deletegroup->compile_dir = $this->cms->bPath . "./template/compiled";
				$deletegroup->assign('lang', $this->cms->languages->lang);
				$deletegroup->assign('group', $group);
				return ($deletegroup->fetch('deletegroup.tpl'));
			}
		}
	}
	/**
	 * Views a user info pane
	 *
	 * @param int $id
	 * @return string
	 */
	public function showViewUser ($id)
	{
		if (! empty($id))
		{
			$user = $this->cms->users->getUser($id);
			
			// page title
			$this->cms->pageTitle = $user['username'];
						
			if (! isset($user['id']))
			{
				throw new Exception("Erroneous input for user.");
			} else
			{
				// get extra info
				$groups = $this->cms->users->getUserGroups($id);
				$ugroups = $this->cms->users->getUnusedGroups($id);
				$templates = $this->cms->templates->getTemplates();
				$languages = $this->cms->languages->getLanguages();
				// add menu
				$this->cms->menu->contexttitle = $user['username'];
				$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['edituser'], $this->cms->generateLink("users", array("viewuser" , $user['id'])));
				if ($id != $this->cms->user->uid)
				{
					$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['deleteuser'], $this->cms->generateLink("users", array("deleteuser" , $user['id'])));
				}
				$this->cms->menu->addItem('context', $this->cms->languages->lang['adminusers']['usernotes'], $this->cms->generateLink("users", array("usernotes" , $user['id'])));
				// templates
				$viewuser = new Smarty();
				$viewuser->template_dir = $this->cms->bPath . "./template/users";
				$viewuser->compile_dir = $this->cms->bPath . "./template/compiled";
				$viewuser->assign('lang', $this->cms->languages->lang);
				$viewuser->assign('user', $user);
				// user data
				$viewuser->assign('languages', $languages);
				$viewuser->assign('templates', $templates);
				$viewuser->assign('groups', $groups);
				$viewuser->assign('ugroups', $ugroups);
				// possible errors
				$viewuser->assign('messages', $this->messages);
				return ($viewuser->fetch('viewuser.tpl'));
			}
		} else
		{
			throw new Exception("No user defined");
		}
	}
	/**
	 * show add user form
	 *
	 * @return string
	 */
	public function showAddUser()
	{
		// page title
		$this->cms->pageTitle = $this->cms->languages->lang['adminusers']['addnewuser'];
		
		if (isset($this->messages['adduser']))
		{
			// templates
			$adduser = new Smarty();
			$adduser->template_dir = $this->cms->bPath . "./template/users";
			$adduser->compile_dir = $this->cms->bPath . "./template/compiled";
			$adduser->assign('lang', $this->cms->languages->lang);
			$adduser->assign('messages', $this->messages);
			return ($adduser->fetch('adduser.error.tpl'));
		}
		else 
		{
			// get extra info
			$groups = $this->cms->users->getGroups();
			$templates = $this->cms->templates->getTemplates();
			$languages = $this->cms->languages->getLanguages();
			// templates
			$adduser = new Smarty();
			$adduser->template_dir = $this->cms->bPath . "./template/users";
			$adduser->compile_dir = $this->cms->bPath . "./template/compiled";
			$adduser->assign('lang', $this->cms->languages->lang);
			// user data
			$adduser->assign('languages', $languages);
			$adduser->assign('templates', $templates);
			$adduser->assign('groups', $groups);
			$adduser->assign('unid',md5(uniqid('wlalla' . microtime()) . 'woelala') . md5(uniqid('sssss' . microtime())  . 'ssw' . microtime()));
			return ($adduser->fetch('adduser.tpl'));
		}
	}
	/**
	 * show user group form
	 *
	 * @param int $id
	 * @return string
	 */
	public function showUserGroup($id)
	{
		// page title
		$this->cms->pageTitle = $this->cms->languages->lang['adminusers']['usergroups'];
				// templates
		$usergroup = new Smarty();
		$usergroup->template_dir = $this->cms->bPath . "./template/users";
		$usergroup->compile_dir = $this->cms->bPath . "./template/compiled";
		$usergroup->assign('lang', $this->cms->languages->lang);
		$group = $this->cms->users->getGroup($id);
		$usergroup->assign('group', $group);
		$rights = $this->cms->rights->listRights('group', $id);
		$nrights = array();
		
		foreach ($rights AS $right)
		{
			if ($right['accessto'] == 'admin')
			{
				$right['type'] = 'admin';
			}
			elseif ($right['accessto'] == 'mod_all')
			{
				$right['type'] = 'mod';
				$right['mod'] = 'all';
			}
			else
			{
				$right['type'] = 'mod';
				$right['mod'] = substr($right['accessto'], 4); 
			}
			$nrights[] = $right;
		}
		$usergroup->assign('modules', $this->cms->listModules());
		$usergroup->assign('rights', $nrights);
		return ($usergroup->fetch('usergroup.tpl'));
	}
	/**
	 * shows the usergroups
	 *
	 * @return string
	 */
	public function showUserGroups ()
	{
		// page title
		$this->cms->pageTitle = $this->cms->languages->lang['adminusers']['usergroups'];
		
		//templates
		$usergroups = new Smarty();
		$usergroups->template_dir = $this->cms->bPath . "./template/users";
		$usergroups->compile_dir = $this->cms->bPath . "./template/compiled";
		$usergroups->assign('lang', $this->cms->languages->lang);
		$usergroups->assign('baseurl', BASE_URL);
		$groups = $this->cms->users->getGroups();
		$ngroups = array();
		foreach ($groups as $group)
		{
			$group['link'] = admin::generateLink("users", array('action' => "usergroup" , 'id' => $group['id']));
			$group['deletelink'] = admin::generateLink("users", array('action' => "deleteusergroup" , 'id' => $group['id']));
			
			$ngroups[] = $group;
		}
		$usergroups->assign('groups', $ngroups);
		return ($usergroups->fetch('usergroups.tpl'));
	}
	/**
	 * shows the find user form
	 *
	 * @return string
	 */
	public function showFindUser($extfilter="", $page=0)
	{
		// check filter
		if (isset($_POST['filter']))
		{
			$filter = $_POST['filter'];
		}
		elseif ($extfilter != "")
		{
			$filter = $extfilter;
		}
		else
		{
			$filter = "*";
		}
		
		// page title
		$this->cms->pageTitle = $this->cms->languages->lang['adminusers']['users'];
		
		
		// templates
		$finduser = new Smarty();
		$finduser->template_dir = $this->cms->bPath . "./template/users";
		$finduser->compile_dir = $this->cms->bPath . "./template/compiled";
		$finduser->assign('lang', $this->cms->languages->lang);
		$finduser->assign('filter', $filter);
		// page list
		$start = $page * 100;
		$pages = ceil($this->cms->users->countFilteredUsers($filter) / 100);
		$plinks = array();
		for ($i=0;$i < $pages; $i++)
		{
			$plinks[] = array('title' => $i+ 1, 'link' => admin::generateLink('users', array('action' => 'finduser', 'id' => $i, 'page' => $filter)));
		}
		$finduser->assign('plinks', $plinks);
		// replacing * with % for wildcard
		$filter = str_replace('*', '%', $filter);
		// getting users
		$users = $this->cms->users->findUsers($filter, 'asc', 'id', $start, 100);
		$nusers = array();
		foreach ($users as $user)
		{
			$user['link'] = admin::generateLink("users", array('action' => "viewuser" , 'id' => $user['id']));
			$nusers[] = $user;
		}
		$finduser->assign('users', $nusers);
		return ($finduser->fetch('findusers.tpl'));
	}
	/**
	 * shows the user overview
	 *
	 * @return string
	 */
	public function showOverview ($page=0)
	{
		// page title
		$this->cms->pageTitle = $this->cms->languages->lang['adminusers']['users'];
		
		//templates
		$overview = new Smarty();
		$overview->template_dir = $this->cms->bPath . "./template/users";
		$overview->compile_dir = $this->cms->bPath . "./template/compiled";
		$overview->assign('lang', $this->cms->languages->lang);
		// amount of pages
		$start = $page * 100;
		$pages = ceil($this->cms->users->countUsers() / 100);
		$plinks = array();
		for ($i=0;$i < $pages; $i++)
		{
			$plinks[] = array('title' => $i+ 1, 'link' => admin::generateLink('users', array('action' => 'page', 'id' => $i)));
		}
		$overview->assign('plinks', $plinks);
		//user list
		$users = $this->cms->users->listUsers('asc', 'id', $start, 100);
		$nusers = array();
		foreach ($users as $user)
		{
			$user['link'] = admin::generateLink("users", array('action' => "viewuser" , 'id' => $user['id']));
			$nusers[] = $user;
		}
		$overview->assign('users', $nusers);
		return ($overview->fetch('overview.tpl'));
	}
	/**
	 * handle show requests
	 *
	 * @param string $mode
	 * @param array $args
	 * @return string
	 */
	public function show ($mode, $args)
	{
		try
		{
			switch ($mode)
			{
				case 'deleteusergroup':
					if (isset($args['id']) AND !empty($args['id']))
					{
						return ($this->showDeleteUserGroup(intval($args['id'])));
					}
					else
					{
						throw new Exception("Erroneous input");
					}
				break;
				case 'usergroup':
					if (isset($args['id']) AND !empty($args['id']))
					{
						return ($this->showUserGroup(intval($args['id'])));
					}
					else
					{
						throw new Exception("Erroneous input");
					}
				break;
				case 'usergroups':
					return ($this->showUserGroups());
				break;
				case 'page':
					if (isset($args['id']) AND !empty($args['id']))
					{
						return($this->showOverview(intval($args['id'])));
					}
					else
					{
						return($this->showOverview());
					}
				break;
				case 'finduser':
					if (isset($args['id']) AND !isset($args['page']))
					{
						return ($this->showFindUser('', intval($args['id'])));
					}
					elseif (isset($args['id']) AND isset($args['page']))
					{
						return ($this->showFindUser($args['page'], intval($args['id'])));
					}
					else
					{
						return ($this->showFindUser());
					}
				break;
				case 'addnewuser':
					return ($this->showAddUser());
				break;
				case 'usernotes':
					if (isset($args['id']))
					{
						return ($this->showUserNotes($args['id']));
					} else
					{
						throw new Exception("No user defined");
					}
				break;
				case 'deleteuser':
					if (isset($args['id']))
					{
						return ($this->showDeleteUser($args['id']));
					} else
					{
						throw new Exception("No user defined");
					}
				break;
				case 'viewuser':
					if (isset($args['id']))
					{
						return ($this->showViewUser($args['id']));
					} else
					{
						throw new Exception("No user defined");
					}
				break;
				case '':
					return ($this->showOverview());
				break;
				default:
					throw new Exception("Unhandled action");
				break;
			}
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
			return (null);
		}
	}
}
?>