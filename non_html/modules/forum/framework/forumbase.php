<?php

class forumbase
{

	private $forum;
	private $sCache = array();
	private $lasttopicid;
	
	private $forSettings;

	private $rCache;

	/* --- anti double post --- */
	private $postPauze = '15';
	private $postPauzeType = ' SECOND'; // DAY - MINUTE - SECOND



	function __construct (&$forum)
	{
		$this->forum = &$forum;
		/**
		
		$this->getPersonalSettings();
		$this->forBaseUrl = $this->forum->classes['base']->createUrl(FOR_BASEFILE);
		$this->r = &new rights($this->cms);
		if ($this->pHandlerActive == true)
			$this->postHandler();
		$this->hShow[] = array('n' => 1 , 't' => 'today' , 'd' => 1);
		$this->hShow[] = array('n' => 2 , 't' => '2days' , 'd' => 2);
		$this->hShow[] = array('n' => 3 , 't' => 'thisweek' , 'd' => 7);
		$this->hShow[] = array('n' => 4 , 't' => '2weeks' , 'd' => 14);
		$this->hShow[] = array('n' => 5 , 't' => 'month' , 'd' => 30);
		$this->hShow[] = array('n' => 6 , 't' => '2moths' , 'd' => 60);
		$this->hShow[] = array('n' => 7 , 't' => '3months' , 'd' => 90);
		$this->hShow[] = array('n' => 8 , 't' => '4months' , 'd' => 120);
		$this->hShow[] = array('n' => 9 , 't' => '8months' , 'd' => 240);
		$this->hShow[] = array('n' => 10 , 't' => 'year' , 'd' => 365);
		
	*/
	}

	/**
	 * retrieve forum from database
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function getForum ($id)
	{
		$QE = $this->forum->connection->query("SELECT 
												f.*,
												u1.username AS username_creation,
												u2.username AS username_lastpost,
												u3.username AS username_lastreply,
												c.cat_title
											FROM 
												" . TAB_FOR_FORA . " f 
											LEFT JOIN " . TAB_USERS . " u1
												ON u1.id = f.user_creation 
											LEFT JOIN " . TAB_USERS . " u2 
												ON u2.id = f.user_lastthread 
											LEFT JOIN " . TAB_USERS . " u3 
												ON u3.id = f.user_lastreply
											LEFT JOIN " . TAB_FOR_CAT . " c
												ON f.cat_id = c.id 
											WHERE
												f.id = '" . intval($id) . "'");
		$res = $this->forum->connection->fetch_assoc($QE);
		if (isset($res[1]))
		{
			$res['for_url'] = $this->forum->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_VIEWTHREADS, $id);
			$res['cat_url'] = $this->forum->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_VIEWCAT, $res['cat_id']);
		}
		return ($res);
	}
	/**
	 * retrieve post from forum
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function getPost ($id)
	{
		$QE = $this->forum->connection->query("SELECT
												r.*,
												u1.username AS username_creation,
												u2.username AS username_lastedit 
											 FROM " . TAB_FOR_REPLIES . " r 
											 LEFT JOIN " . TAB_USERS . " u1
											 	ON u1.id = r. user_creation 
											 LEFT JOIN " . TAB_USERS . " u2 
											 	ON u2.id = r. user_lastedit 
											 WHERE r.id = '" . intval($id) . "'");
		return ($this->forum->connection->fetch_assoc($QE));
	}
	/**
	 * retrieve thread from forum
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function getThread ($id)
	{
		$QE = $this->forum->connection->query("SELECT
												t.*,
												u1.username AS username_creation, 
												u2.username AS username_lastreply, 
												f.for_title, 
												c.cat_title
											 FROM " . TAB_FOR_THREADS . " t 
											 LEFT JOIN " . TAB_USERS . " u1 
											 	ON t.user_creation = u1.id
											 LEFT JOIN " . TAB_USERS . " u2 
											 	ON t.user_lastreply = u2.id 
											 LEFT JOIN " . TAB_FOR_FORA . " f 
											 	ON f.id = t.for_id 
											 LEFT JOIN " . TAB_FOR_CAT . " c 
											 	ON f.id = c.id = t.cat_id 
											 WHERE t.id = '" . intval($id) . "'");
		
		if ($this->forum->connection->num_rows($QE) == 1)
		{
			$rights = $this->whatIsAllowed('topic', $id);
			$res = $this->forum->connection->fetch_assoc($QE);
			$res['for_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREADS, $res['for_id']);
			$res['cat_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWCAT, $res['cat_id']);
			$res['thread_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['id']);
			if ($rights['deletechild'] == 1)
			{
				$res['del_thread_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_DELETETHREAD, $res['id']);
			}
			if ($rights['move'] == 1)
			{
				$res['move_thread_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_MOVETHREAD, $res['id']);
			}
			if ($this->forum->classes['user']->login == true and (($this->forum->classes['user']->uid == $res['user_creation'] and $res['thread_state'] == 'open') or $rights['edit'] == 1))
			{
				$res['edit_thread_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_EDITTHREAD, $res['id']);
			}
			return ($res);
		} else
		{
			return (false);
		}
	}
	/**
	 * retrieve active threads from forum
	 *
	 * @param unknown_type $cid
	 * @param unknown_type $sel
	 * @return unknown
	 */
	function getActiveThreads ($cid = 0, $sel = 0)
	{
		$where = null;
		$fora = $this->getOverviewFlat($cid);
		$i = 0;
		foreach ($fora as $forum)
		{
			if ($i == 0)
			{
				$where = " t.for_id = " . $forum['for_id'];
			} else
			{
				$where = " XOR t.for_id = " . $forum['for_id'];
			}
			if (! empty($where))
			{
				$i ++;
			}
		}
		if ($where != null)
		{
			$where = ' WHERE ' . $where;
		}
		if ($cid == 0)
		{
			$where = '';
		}
		if ($sel == null or $sel == 0)
		{
			$sel = $this->forSettings['pthreads'];
		}
		$days = 1;
		foreach ($this->hShow as $i)
		{
			if ($i['n'] == $sel)
			{
				$days = $i['d'];
				break;
			}
		}
		if (empty($where))
		{
			$where = " WHERE NOW()  - INTERVAL " . $days . " DAY <= t.date_lastreply  ";
		} else
		{
			$where = " AND NOW() - INTERVAL " . $days . " DAY <= t.date_lastreply  ";
		}
		$ret = array();
		$limit = null;
		if (! empty($this->limit))
		{
			$limit = "LIMIT 0, " . $this->limit;
		}
		$QE = $this->forum->connection->query("SELECT 
												t.id AS topic_id,
												t.thread_title,
												t.thread_type,
												t.thread_state,
												t.date_creation,
												t.date_lastreply,
												t.user_creation,
												t.user_lastreply, 
												t.cat_id, 
												t.amount_replies AS treplies, 
												f.for_title, 
												f.for_short, 
												f.id AS for_id,
												u1.username AS username_creation,
												u2.username AS username_lastreply
											FROM " . TAB_FOR_THREADS . " t
											LEFT JOIN " . TAB_USERS . " u1 
												ON t.user_creation = u1.id 
											LEFT JOIN " . TAB_USERS . " u2 
												ON t.user_lastreply = u2.id
											LEFT JOIN " . TAB_FOR_FORA . " f
												ON t.for_id = f.id " . $where . "
											ORDER BY t.date_lastreply DESC " . $limit);
		while ($res = $this->forum->connection->fetch_assoc($QE))
		{
			/* --- checking topic type --- */
			/* first step, old or not? --- */
			if ($res['date_lastreply'] > date('Y-m-d H:i:s', mktime(date("H") - 36, 0, 0, date("m"), date("d") - 0, date("Y"))))
			{
				$res['mode_d'] = 'on';
			} else
			{
				$res['mode_d'] = 'off';
			}
			/* next step, topic type */
			if ($res['thread_type'] == 'announcement')
			{
				$res['mode_t'] = 'sticky';
			} elseif ($res['thread_type'] == 'sticky')
			{
				if ($res['thread_state'] == 'closed')
				{
					$res['mode_t'] = 'closed';
				} else
				{
					$res['mode_t'] = 'sticky';
				}
			} else
			{
				/* none sticky nor announcement, topic status is more important */
				if ($res['thread_state'] == 'closed')
				{
					$res['mode_t'] = 'closed';
				} else
				{
					$res['mode_t'] = 'open';
				}
			}
			$pArr = array();
			$pCount = ceil($res['treplies'] / $this->forSettings['postspp']);
			for ($i = 0; $i < $pCount;)
			{
				$pArr[$i] = array('url' => $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['topic_id'], $i) , 'name' => $i + 1);
				$i ++;
			}
			$res['pages'] = $pArr;
			$this->rCache['topic'][$res['topic_id']]['forumid'] = $res['for_id'];
			$this->rCache['topic'][$res['topic_id']]['catid'] = $res['cat_id'];
			$rtopic = $this->whatIsAllowed('topic', $res['topic_id']);
			if ($rtopic['view'] == 1)
			{
				if ($this->forSettings['golastpage'] == "yes")
				{
					$res['topic_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['topic_id'], ($pCount - 1));
				} else
				{
					$res['topic_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['topic_id']);
				}
				$ret[] = $res;
			}
		}
		return ($ret);
	}
	/**
	 * retrieve threads from forum
	 *
	 * @param unknown_type $type
	 * @param unknown_type $forumid
	 * @param unknown_type $sel
	 * @return unknown
	 */
	function getThreadsFromDB ($type, $forumid, $sel)
	{
		$ret = array();
		if ($sel == null or $sel == 0)
		{
			$sel = $this->forSettings['postspp'];
		}
		$days = 1;
		foreach ($this->hShow as $i)
		{
			if ($i['n'] == $sel)
			{
				$days = $i['d'];
				break;
			}
		}
		$where = " AND NOW()  - INTERVAL " . $days . " DAY <= t.date_lastreply  ";
		if ($type == "first")
		{
			$where = " AND (thread_type = 'announcement' OR thread_type = 'sticky') AND thread_state = 'open' ";
		} else
		{
			$where .= " AND (thread_type = 'normal' XOR ((thread_type = 'announcement' XOR thread_type = 'sticky') AND thread_state = 'closed')) ";
		}
		$QE = $this->forum->connection->query("" . " SELECT " . " t.id AS topic_id, " . " t.thread_title," . " t.thread_type, " . " t.thread_state," . " t.date_creation," . " t.date_lastreply," . " t.user_creation, " . " t.user_lastreply, " . " t.amount_replies AS treplies, " . " t.for_id, " . " t.cat_id, " . " u1.username AS username_creation," . " u2.username AS username_lastreply " . " FROM " . TAB_FOR_THREADS . " t" . " LEFT JOIN " . TAB_USERS . " u1 ON t.user_creation = u1.id " . " LEFT JOIN " . TAB_USERS . " u2 ON t.user_lastreply = u2.id " . " WHERE " . " t.for_id = '" . intval($forumid) . "' " . $where . " ORDER BY  t.date_lastreply DESC");
		while ($res = $this->forum->connection->fetch_assoc($QE))
		{
			/* --- checking topic type --- */
			/* first step, old or not? --- */
			if ($res['date_lastreply'] > date('Y-m-d H:i:s', mktime(date("H") - 36, 0, 0, date("m"), date("d") - 0, date("Y"))))
			{
				$res['mode_d'] = 'on';
			} else
			{
				$res['mode_d'] = 'off';
			}
			/* next step, topic type */
			if ($res['thread_type'] == 'announcement')
			{
				if ($res['thread_state'] == 'closed')
				{
					$res['mode_t'] = 'closed';
				} else
				{
					$res['mode_t'] = 'sticky';
				}
			} elseif ($res['thread_type'] == 'sticky')
			{
				if ($res['thread_state'] == 'closed')
				{
					$res['mode_t'] = 'closed';
				} else
				{
					$res['mode_t'] = 'sticky';
				}
			} else
			{
				/* none sticky nor announcement, topic status is more important */
				if ($res['thread_state'] == 'closed')
				{
					$res['mode_t'] = 'closed';
				} else
				{
					$res['mode_t'] = 'open';
				}
			}
			$pArr = array();
			$pCount = ceil($res['treplies'] / $this->forSettings['postspp']);
			for ($i = 0; $i < $pCount;)
			{
				$pArr[$i] = array('url' => $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['topic_id'], $i) , 'name' => $i + 1);
				$i ++;
			}
			$res['pages'] = $pArr;
			$this->rCache['topic'][$res['topic_id']]['forumid'] = $res['for_id'];
			$this->rCache['topic'][$res['topic_id']]['catid'] = $res['cat_id'];
			//$this->rCache['']
			$rtopic = $this->whatIsAllowed('topic', $res['topic_id']);
			if ($rtopic['view'] == 1)
			{
				if ($this->forSettings['golastpage'] == "yes")
				{
					$res['topic_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['topic_id'], ($pCount - 1));
				} else
				{
					$res['topic_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $res['topic_id']);
				}
				$ret[] = $res;
			}
		}
		return ($ret);
	}
	/**
	 * retrieve threads
	 *
	 * @param unknown_type $forumid
	 * @param unknown_type $sel
	 * @return unknown
	 */
	function getThreads ($forumid, $sel = 0)
	{
		/* message arrays */
		$tHead = array();
		$tNormal = array();
		$tClosed = array();
		$tMain = array();
		$ret = array();
		$tHead = $this->getThreadsFromDB('first', $forumid, $sel);
		$tMain = $this->getThreadsFromDB('second', $forumid, $sel);
		/* bringing back topics in order */
		foreach ($tMain as $t)
		{
			if ($t['thread_state'] == 'closed')
			{
				$tClosed[] = $t;
			} else
			{
				$tNormal[] = $t;
			}
		}
		unset($tMain);
		foreach ($tHead as $t)
		{
			$ret[] = $t;
		}
		foreach ($tNormal as $t)
		{
			$ret[] = $t;
		}
		foreach ($tClosed as $t)
		{
			$ret[] = $t;
		}
		unset($tHead, $tNormal, $tClosed);
		return ($ret);
	}
	/**
	 * retrieve replies
	 *
	 * @param unknown_type $id
	 * @param unknown_type $start
	 * @param unknown_type $end
	 * @return unknown
	 */
	function getReplies ($id, $start = 0, $end = 25)
	{
		$rights = $this->whatIsAllowed('topic', $id);
		$QE = $this->forum->connection->query("SELECT " . "   r.id AS reply_id, " . "	r.*, " . "   t.thread_state, " . "	u1.username AS username_creation, " . " 	u1.avatar, " . " 	u1.signature, " . " 	u1.nickdisplay, " . " 	u1.posts AS user_posts, " . " 	u2.username AS username_lastedit " . " FROM " . " `" . TAB_FOR_REPLIES . "` r " . "   LEFT JOIN " . TAB_USERS . " u1 ON u1.id = r.user_creation " . "   LEFT JOIN " . TAB_USERS . " u2 ON u2.id = r.user_lastedit " . "   LEFT JOIN " . TAB_FOR_THREADS . " t ON r.thread_id = t.id " . " WHERE r.thread_id = " . intval($id) . " ORDER BY r.date_posted ASC " . " LIMIT " . intval($start) . ", " . intval($end));
		$prevPost = 0;
		$posts = array();
		$pid = 0;
		$aId = - 1;
		while ($res = $this->forum->connection->fetch_assoc($QE))
		{
			$res['username_creation'] = htmlspecialchars($res['username_creation']);
			$res['quoteurl'] = $this->forum->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_INSERTREPLY, $res['thread_id'], $res['reply_id']);
			if ($this->forum->classes['user']->login == true and (($this->forum->classes['user']->uid == $res['user_creation'] and $res['thread_state'] == 'open') or $rights['edit'] == 1))
			{
				$res['editurl'] = $this->forum->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_EDITREPLY, $res['reply_id']);
			}
			if ($this->forum->classes['user']->login == true and $rights['deletechild'] == 1 and $res['thread_start'] == 'no')
			{
				$res['deleteurl'] = $this->forum->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_DELETEREPLY, $res['reply_id']);
			}
			$res['profurl'] = $this->forum->classes['base']->createURL("user", "viewprofile", $res['user_creation']);
			if ($prevPost != $res['reply_id'])
			{
				$aId ++;
				$posts[$aId] = $res;
			}
			$prevPost = $res['reply_id'];
		}
		return ($posts);
	}
	/**
	 * get forum overview
	 *
	 * @return unknown
	 */
	function getOverview ()
	{
		$QE = $this->forum->connection->query("SELECT  
												f.for_title,
												f.for_desc,
												f.for_short,
												f.amount_threads,
												f.amount_replies,
												f.user_lastreply,
												f.date_lastreply,
												u1.username AS username_lastreply,
												f.id AS for_id, 
												c.id AS cat_id, 
												c.cat_title " . " FROM " . TAB_FOR_FORA . " f " . " LEFT JOIN " . TAB_FOR_CAT . " c ON c.id = f.cat_id " . " LEFT JOIN " . TAB_USERS . " u1 ON f.user_lastreply = u1.id " . " 
											  ORDER BY f.cat_id
											 ");
		$i = - 1;
		$fArr = array();
		$lastCat = 0;
		while ($res = $this->forum->connection->fetch_assoc($QE))
		{
			$res['for_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREADS, $res['for_id']);
			if ($lastCat != $res['cat_id'])
			{
				$i ++;
				$fArr[$i]['title'] = $res['cat_title'];
				$fArr[$i]['id'] = $res['cat_id'];
			}
			$r_forum = $this->whatIsAllowed('forum', $res['for_id']);
			$this->sCache['forum'][$res['for_id']]['catid'] = $res['cat_id'];
			if ($r_forum['view'] == 1)
			{
				$fArr[$i]['data'][] = $res;
			}
			$lastCat = $res['cat_id'];
		}
		return ($fArr);
	}
	/**
	 * get plain overview
	 *
	 * @param unknown_type $cid
	 * @return unknown
	 */
	function getOverviewFlat ($cid = 0)
	{
		$where = '';
		if ($cid != 0)
		{
			$where = " WHERE f.cat_id = " . $cid;
		}
		$QE = $this->forum->connection->query("SELECT  f.for_title, f.for_desc, f.id AS for_id, c.id AS cat_id, c.cat_title " . " FROM " . TAB_FOR_FORA . " f " . " LEFT JOIN " . TAB_FOR_CAT . " c " . " ON c.id = f.cat_id " . $where . "  ORDER BY f.cat_id");
		$fArr = array();
		while ($res = $this->forum->connection->fetch_assoc($QE))
		{
			$res['for_url'] = $this->forum->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREADS, $res['for_id']);
			$r_forum = $this->whatIsAllowed('forum', $res['for_id']);
			$this->sCache['forum'][$res['for_id']]['catid'] = $res['cat_id'];
			if ($r_forum['view'] == 1)
			{
				$fArr[] = $res;
			}
		}
		return ($fArr);
	}

}
?>