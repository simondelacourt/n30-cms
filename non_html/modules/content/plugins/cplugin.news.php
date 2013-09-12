<?php
/**
 * n30-cms content plugin: page
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
 * Plugin for content module.
 * 
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
define('TAB_CNT_PNEWS', T_PREFIX . 'cnt_pnews');
define('TAB_CNT_PNEWS_REPLIES', T_PREFIX . 'cnt_pnews_replies');


class cPlugin_news
{
	private $cms;
	private $itemid;
	private $news;
	private $replyok;
	private $replymode;
	
	
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PNEWS . " WHERE itemid = " . intval($itemid) . " LIMIT 0,1 ");
		$res = $this->cms->connection->fetch_assoc($QE);
		if (isset($res['news_full']))
		{
			$this->news = $res;
		} else
		{
			throw new Exception("Module content, plugin link: no related news message found.");
		}
		
		if ($this->news['replies_on'] == 'true')
		{
			// check if user can reply
			if($this->cms->user->login)
			{
				$this->replyok = false;
				$this->replymode = 'user';
				// check if usergroup is right
				$ngroups = explode (',', $this->news['replies_groups']);
				foreach ($this->cms->user->groups AS $group)
				{
					if (in_array($group, $ngroups))
					{
						$this->replyok = true;
						break;
					}
				}
			}
			else
			{
				if ($this->news['replies_guests'] == 'true')
				{
					$this->replyok = true;
					$this->replymode = 'guest';
				}
				else
				{
					$this->replyok = false;
					$this->replymode = 'guest';
				}
			}
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($this->replymode == 'user' AND isset($_POST['message']) AND !empty($_POST['message']))
			{
				$this->insertReply($_POST['message']);
			}
			elseif ($this->replymode == 'guest' AND !empty($_POST['message'])  AND !empty($_POST['name']) AND isset($_POST['message']) AND isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['url']))
			{
				$this->insertReply($_POST['message'], $_POST['name'], $_POST['email'], $_POST['url']);
			}
			$item = $this->cms->modules['content']->getItemById($this->itemid);
			header ("Location: " . $this->cms->generateLink($this->cms->modules['content']->file, array('path' => $item['full_location'])));
			exit();
		}
	}
	/**
	 * insert a reply for a news thread
	 *
	 * @param unknown_type $message
	 * @param unknown_type $name
	 * @param unknown_type $email
	 * @param unknown_type $url
	 */
	private function insertReply ($message, $name='', $email='', $url='')
	{
		$spam = 'false';
		if ($this->cms->user->login)
		{
			$posterid = $this->cms->user->uid;
			$postername = '';
			$posterurl = '';
			$posteremail = '';
		}
		else
		{
			$posterid = 0;
			$postername = $this->cms->connection->escape_string($name);
			$posterurl =  $this->cms->connection->escape_string($url);
			$posteremail =  $this->cms->connection->escape_string($email);
			$akkey = $this->cms->settings->getSetting('news', 'akismet_key');
			if ($this->cms->settings->getSetting('news', 'akismet_on') AND !empty($akkey))
			{ 
				$akismet = new Akismet(BASE_URL, $akkey);
				$akismet->setCommentAuthor($postername);
				$akismet->setCommentAuthorEmail($posteremail);
				$akismet->setCommentAuthorURL($posterurl);
				$akismet->setCommentContent($message);
				$akismet->setPermalink('http://www.example.com/blog/alex/someurl/');
				if($akismet->isCommentSpam())
				{
					$spam = 'true';		
				}
			}
		}
		$this->cms->connection->query("INSERT INTO " . TAB_CNT_PNEWS_REPLIES . " 
										(id, itemid, poster_id, poster_ip, poster_name, poster_email, poster_url, message_raw, message_processed, message_crdate, message_spam) 
									   VALUES (
									   		null,
									   		" . $this->itemid . ",
									   		" . intval($posterid) . ",
									   		'" . $this->cms->connection->escape_string($_SERVER['REMOTE_ADDR']) . "',
									   		'" . $this->cms->connection->escape_string($postername) . "',
									   		'" . $this->cms->connection->escape_string($posteremail) . "',
									   		'" . $this->cms->connection->escape_string($posterurl) . "',
									   		'" . $this->cms->connection->escape_string($message) . "',
									   		'" . $this->cms->connection->escape_string($this->processMessage($message)) . "',
									   		now(),
									   		'" . $this->cms->connection->escape_string($spam) . "'
									   )");
	}
	private function processMessage ($message)
	{
		// will be different in the future!
		return (htmlspecialchars($message));
	}
	private function getReplies ()
	{
		$replies = array();
		$QE = $this->cms->connection->query("SELECT r.*, u.username FROM " . TAB_CNT_PNEWS_REPLIES . " r LEFT JOIN " . TAB_USERS . " u ON u.id = r.poster_id WHERE message_spam = 'false' AND r.itemid = " . $this->itemid . " ORDER BY message_crdate ASC");
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			if (!empty($res['poster_id']))
			{
				$res['poster_name'] = $res['username'];
				$res['mode'] = 'user';
			}
			else
			{
				$res['mode'] = 'guest';
			}
			$replies[] = $res;
		}
		return ($replies);
	}
	public function getOutput ($viewmode = '')
	{
		switch ($viewmode)
		{
			default:
				$newsmessage = new Smarty();
				$newsmessage->template_dir = $this->cms->bPath . "/non_html/modules/content/templates/plugins/";
				$newsmessage->compile_dir = $this->cms->templates->compileddir;
				$newsmessage->assign('lang', $this->cms->languages->lang);
				$newsmessage->assign('mlang', $this->cms->modules['content']->getLang());
				$newsmessage->assign('baseurl', BASE_URL);
				$newsmessage->assign('news', $this->news);
				if ($this->news['replies_on'] == 'true')
				{
					$newsmessage->assign('replies', $this->getReplies());
					$newsmessage->assign('replyok', $this->replyok);
					$newsmessage->assign('replymode', $this->replymode);
				}
				return ($newsmessage->fetch($this->cms->modules['content']->getTemplateFile('plugin','news.show.tpl')));
			break;
		}
	}
	
}
class cAPlugin_news
{
	private $cms;
	private $id;
	public function __construct (&$cms, $id, $admin)
	{
		$this->cms = &$cms;
		$this->id = intval($id);
	}
	/**
	 * required function for every plugin to check data
	 *
	 * @param array $data
	 */
	public function check ($data)
	{
		return (true);
	}
	/**
	 * required function for every plugin to edit the data
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function edit ($data)
	{
		/**
		 * check reply groups
		 */
		if (isset($data['rgroups'][0]))
		{
			$rgroups = implode(',', $data['rgroups']);
		}
		else
		{
			$rgroups = '';
		}
		/**
		 * check if replies are on
		 */
		if (isset($data['allowreplies']) AND $data['allowreplies'] == 'true')
		{
			$ron = 'true';
		}
		else
		{
			$ron = 'false';
		}
		/**
		 * check if guest replies are on
		 */
		if (isset($data['allowguestreplies']) AND $data['allowguestreplies'] == 'true')
		{
			$rguests = 'true';
		}
		else
		{
			$rguests = 'false';
		}
		if ($this->id == 'new')
		{
			$q = "INSERT INTO  " . TAB_CNT_PNEWS . " 
						(`id`, `itemid`, `news_short`, `news_full`, `news_tags`, `replies_on`, `replies_guests`, `replies_groups`, `replies_count`)
						VALUES 
						(
							NULL ,  '" . intval($data['iid']) . "',  '" . $this->cms->connection->escape_string($data['short']) . "',  '" . $this->cms->connection->escape_string($data['full']) . "',  '',  '" . $ron .  "',  '" . $rguests . "',  '" . $rgroups . "',  '0'
						);";
			$this->cms->connection->query($q);
		}
		else
		{
			$rcount = 0;
			$q = "UPDATE  " . TAB_CNT_PNEWS . " SET 
							news_short = '" . $this->cms->connection->escape_string($data['short']) . "',
							news_full = '" . $this->cms->connection->escape_string($data['full']) . "',
							replies_on = '" . $ron .  "',
							replies_guests = '" . $rguests . "',
							replies_groups = '" . $rgroups . "',
							replies_count = '" . $rcount . "'
							
				 WHERE itemid = '" . $this->id . "'";
			$this->cms->connection->query($q);
		}
		return (true);
	}
	private function getReplies ()
	{
		$replies = array();
		$QE = $this->cms->connection->query("SELECT r.*, u.username FROM " . TAB_CNT_PNEWS_REPLIES . " r LEFT JOIN " . TAB_USERS . " u ON u.id = r.poster_id WHERE r.itemid = " . $this->id . " ORDER BY message_crdate ASC");
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			if (!empty($res['poster_id']))
			{
				$res['poster_name'] = $res['username'];
				$res['mode'] = 'user';
			}
			else
			{
				$res['mode'] = 'guest';
			}
			$replies[] = $res;
		}
		return ($replies);
	}
	/**
	 * deletes an instance of news
	 * 
	 */
	public function delete ()
	{
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PNEWS . " WHERE itemid = " . intval($this->id));
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PNEWS_REPLIES . " WHERE itemid = " . intval($this->id));
	}
	public function deleteReplies ()
	{
		
	}
	public function getForm ()
	{
		if ($this->id == 'new')
		{
			$form_short = $this->cms->getWYSIWYGcode('pdata[short]', '', admin::generateLink('m', array('module' => 'content', 'action' => 'fckconfig')), '', '100%', '200px', 'Basic');
			$form_full = $this->cms->getWYSIWYGcode('pdata[full]', '', admin::generateLink('m', array('module' => 'content', 'action' => 'fckconfig')), '', '100%', '350px');
			
			$newsform = new Smarty();
			$newsform->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/templates/plugins";
			$newsform->compile_dir = $this->cms->templates->compileddir;
			$newsform->assign('lang', $this->cms->languages->lang);
			$newsform->assign('mlang', $this->cms->module->lang);
			$newsform->assign('baseurl', BASE_URL);
			$newsform->assign('w_short', $form_short);
			$newsform->assign('w_full', $form_full);
			$newsform->assign('groups', $this->cms->users->getGroups());
			return ($newsform->fetch('adm.news.new.tpl'));
		}
		else
		{
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PNEWS . " WHERE itemid = " . intval($this->id));
			$news = $this->cms->connection->fetch_assoc($QE);
			
			$form_short = $this->cms->getWYSIWYGcode('pdata[short]', $news['news_short'], admin::generateLink('m', array('module' => 'content', 'action' => 'fckconfig')), '', '100%', '200px', 'Basic');
			$form_full = $this->cms->getWYSIWYGcode('pdata[full]', $news['news_full'], admin::generateLink('m', array('module' => 'content', 'action' => 'fckconfig')), '', '100%', '350px');
			
			$newsform = new Smarty();
			$newsform->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/templates/plugins";
			$newsform->compile_dir = $this->cms->templates->compileddir;
			$newsform->assign('lang', $this->cms->languages->lang);
			$newsform->assign('mlang', $this->cms->module->lang);
			$newsform->assign('baseurl', BASE_URL);
			$newsform->assign('w_short', $form_short);
			$newsform->assign('w_full', $form_full);
			$newsform->assign('news', $news);
			$newsform->assign('replies', $this->getReplies());
			$groups = $this->cms->users->getGroups();
			$ngroups = array();
			$agroups = explode(',', $news['replies_groups']);
			foreach ($groups AS $group)
			{
				$group['checked'] = false;
				if (in_array($group['id'], $agroups))
				{
					$group['checked'] = true;
				}
				$ngroups[] = $group;
			}
			$newsform->assign('groups', $ngroups);
			return ($newsform->fetch('adm.news.edit.tpl'));		
		}
	}
	public function getExtension ()
	{
		return ('.nws');
	}
}
?>