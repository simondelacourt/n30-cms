<?php
class forumhandler
{
	function processPost ($post, $mode = 'bbcode', $param = array())
	{
		switch ($mode)
		{
			case 'bbcode':
				$post = oml_convert(oml_pre_convert($post), false);
				return ($post);
			break;
			case 'quote':
				$npost = eregi_replace("{user}", htmlspecialchars(stripslashes($param['poster'])), $this->cms->classes['base']->lang['forum']['insertreply']['quotetitle']);
				$npost = eregi_replace("{date}", $param['time'], $npost);
				$post = preg_replace("/\[quote\](.+?)\[\/quote\]/is", '[b][...][/b]', htmlspecialchars(stripslashes($post)));
				$npost = eregi_replace("{content}", $post, $npost);
				return ($npost);
			break;
			default:
				return ($post);
			break;
		}
	}
	
	function postHandler ()
	{
		/* --- this function processes the post actions --- */
		if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['action']) and isset($_POST['module']) and $_POST['module'] == 'forum')
		{
			switch ($_POST['action'])
			{
				case 'test':
					echo 'okdieok';
				break;
				case 'move':
					if (isset($_POST['threadid']))
					{
						$thread = $this->getThread($_POST['threadid']);
						$rights = $this->whatIsAllowed('topic', $_POST['threadid']);
						if ($rights['move'] == 1)
						{
							$forum = $this->getForum($_POST['forum']);
							if ($forum['id'] == $_POST['forum'])
							{
								$this->cms->connection->query("UPDATE " . TAB_FOR_THREADS . " SET for_id = " . intval($forum['id']) . ", cat_id = " . intval($forum['cat_id']) . " WHERE id = " . $thread['id']);
								$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_threads = amount_threads - 1 WHERE id = " . $thread['for_id']);
								$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_replies = amount_replies - " . $thread['amount_replies'] . " WHERE id = " . $forum['id']);
								$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_threads = amount_threads + 1 WHERE id = " . $thread['for_id']);
								$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_replies = amount_replies + " . $thread['amount_replies'] . " WHERE id = " . $forum['id']);
							}
						}
						header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $thread['id']));
						exit();
					}
					exit();
				break;
				case 'insertthread':
					$rforum = $rforum = $this->whatIsAllowed('forum', $_POST['forumid']);
					/* --- insert thread post processing --- */
					if ($rforum['createchild'] == 1 and $this->cms->classes['user']->login == true)
					{
						if (isset($_POST['forumid']) and isset($_POST['catid']) and isset($_POST['topictitle']) and isset($_POST['post']) and isset($_POST['type']) and isset($_POST['state']))
						{
							$p = $this->insertThread($_POST['forumid'], $_POST['catid'], $_POST['topictitle'], $_POST['type'], $_POST['state'], $_POST['post']);
							if ($p == true)
							{
								header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $this->lasttopicid));
								exit();
							} else
							{
								$this->cms->classes['base']->showError('forum', 4);
							}
						} elseif (isset($_POST['forumid']) and isset($_POST['catid']) and isset($_POST['topictitle']) and isset($_POST['post']))
						{
							$p = $this->insertThread($_POST['forumid'], $_POST['catid'], $_POST['topictitle'], 'normal', 'open', $_POST['post']);
							if ($p == true)
							{
								header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $this->lasttopicid));
								exit();
							}
						}
					}
				break;
				case 'editthread':
					$thread = $this->getThread(intval($_POST['threadid']));
					$rights = $this->whatIsAllowed('topic', intval($_POST['threadid']));
					if ($rights['view'] == 1 and $this->cms->classes['user']->login == true and ($rights['edit'] == 1 or ($this->cms->classes['user']->uid == $thread['user_creation'] and $thread['thread_state'] == 'open')) and $thread['id'] == intval($_POST['threadid']))
					{
						$reply = $this->getPost($thread['reply_id']);
						if (! empty($_POST['message']) and strlen($_POST['message']) > 2)
						{
							$this->cms->connection->query("UPDATE " . TAB_FOR_REPLIES . " 
																 SET 
																  content_plain  = '" . $this->cms->connection->escape_string($this->processPost($_POST['message'], 'plain')) . "',
																  content_parsed = '" . $this->cms->connection->escape_string($this->processPost($_POST['message'])) . "',
																  user_lastedit  = '" . $this->cms->classes['user']->uid . "',
																  date_lastedit  = now()
																 WHERE id = '" . intval($thread['reply_id']) . "'
																   ");
							if ($rights['moderate'] == 1 and isset($_POST['type']) and isset($_POST['state']) and strlen($_POST['title']) > 2)
							{
								$type = $_POST['type'];
								$state = $_POST['state'];
								if ($type == 'normal' or $type == 'sticky' or $type == 'announcement')
								{
									$t['type'] = $type;
								} else
								{
									$t['type'] = 'normal';
								}
								if ($state == 'open' or $state == 'closed')
								{
									$t['state'] = $state;
								} else
								{
									$t['state'] = 'open';
								}
								$this->cms->connection->query(" UPDATE " . TAB_FOR_THREADS . " SET   " . " thread_type = '" . $type . "'," . " thread_state = '" . $state . "'," . " thread_title = '" . $this->cms->connection->escape_string($_POST['title']) . "'," . " date_lastedit = now(), " . " user_lastedit  = '" . $this->cms->classes['user']->uid . "'" . " WHERE id = " . $thread['id']);
							}
							header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $thread['id']));
							exit();
						} else
						{
							$this->cms->classes['base']->showError('forum', 4);
						}
						exit();
					} else
					{
						$this->cms->classes['base']->showError('forum', 3);
					}
				break;
				case 'deletethread':
					$thread = $this->getThread(intval($_POST['threadid']));
					$rights = $this->whatIsAllowed('topic', intval($_POST['threadid']));
					if ($rights['view'] == 1 and $rights['deletechild'] == 1)
					{
						$this->cms->connection->query("DELETE FROM " . TAB_FOR_THREADS . " WHERE id = " . intval($_POST['threadid']));
						$this->cms->connection->query("DELETE FROM " . TAB_FOR_REPLIES . " WHERE thread_id  = " . intval($_POST['threadid']));
						$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_threads = amount_threads - 1, amount_replies = amount_replies - " . $thread['amount_replies'] . " WHERE id = " . $thread['for_id']);
						header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREADS, $thread['for_id']));
						exit();
					} else
					{
						$this->cms->classes['base']->showError('forum', 3);
					}
				break;
				case 'deletereply':
					$reply = $this->getPost($_POST['replyid']);
					$rights = $this->whatIsAllowed('topic', $reply['thread_id']);
					if ($rights['view'] == 1 and $rights['deletechild'] == 1 and $reply['thread_start'] == 'no')
					{
						$thread = $this->getThread($reply['thread_id']);
						$this->cms->connection->query("DELETE FROM " . TAB_FOR_REPLIES . " WHERE id  = " . intval($_POST['replyid']));
						$this->cms->connection->query("UPDATE  " . TAB_USERS . " SET posts = posts - 1 WHERE id = " . $reply['user_creation']);
						$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_replies = amount_replies -1 WHERE id = " . $thread['for_id']);
						$QR = $this->cms->connection->query("SELECT user_creation, date_posted AS date_creation FROM " . TAB_FOR_REPLIES . " WHERE thread_id = " . $reply['thread_id'] . "  ORDER BY date_posted  DESC LIMIT 0,1");
						$dat = $this->cms->connection->fetch_assoc($QR);
						$this->cms->connection->query("UPDATE " . TAB_FOR_THREADS . " SET amount_replies = amount_replies -1, date_lastreply = '" . $dat['date_creation'] . "', user_lastreply = " . $dat['user_creation'] . " WHERE id = " . $reply['thread_id']);
						header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $thread['id']));
						exit();
					} else
					{
						$this->cms->classes['base']->showError('forum', 3);
					}
				break;
				case 'postreply':
					if (isset($_POST['threadid']) and $_POST['action'] == 'postreply' and isset($_POST['post']))
					{
						$thread = $this->getThread($_POST['threadid']);
						$retopic = $this->whatIsAllowed('topic', $_POST['threadid']);
						if ($retopic['view'] == 1 and $thread['id'] != 0 and $retopic['createchild'] == 1 and (($thread['thread_type'] != 'announcement' and $thread['thread_state'] == 'open') or $retopic['moderate'] == 1))
						{
							if ($this->checkSpam($this->cms->classes['user']->uid, $_POST['post'], $_POST['threadid']))
							{
								$p = $this->insertPost($_POST['threadid'], $this->cms->classes['user']->uid, $_POST['post']);
								if ($p == true)
								{
									$page = ((($thread['amount_replies']) + 1) / $this->forSettings['postspp']);
									$page = ceil($page) - 1;
									if ($page < 0)
									{
										$page = 0;
									}
									header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $_POST['threadid'], $page));
									exit();
								} else
								{
									$this->cms->classes['base']->showError('forum', 4);
								}
							} else
							{
								$this->cms->classes['base']->showError('forum', 5);
							}
						}
					}
				break;
				case 'editreply':
					$reply = $this->getPost($_POST['replyid']);
					$thread = $this->getThread($reply['thread_id']);
					$rights = $this->whatIsAllowed('topic', $reply['thread_id']);
					if ($rights['view'] == 1 and $this->cms->classes['user']->login == true and (($this->cms->classes['user']->uid == $reply['user_creation'] and $thread['thread_state'] == 'open') or $rights['edit'] == 1))
					{
						if (! empty($_POST['message']) and strlen($_POST['message']) > 2)
						{
							$this->cms->connection->query("UPDATE " . TAB_FOR_REPLIES . " 
																 SET 
																  content_plain  = '" . $this->cms->connection->escape_string($this->processPost($_POST['message'], 'plain')) . "',
																  content_parsed = '" . $this->cms->connection->escape_string($this->processPost($_POST['message'])) . "',
																  user_lastedit  = '" . $this->cms->classes['user']->uid . "',
																  date_lastedit  = now()
																 WHERE id = '" . intval($_POST['replyid']) . "'
																   ");
							$QE = $this->cms->connection->query("SELECT count(*) AS total FROM " . TAB_FOR_REPLIES . " WHERE date_posted < '" . $reply['date_posted'] . "' AND thread_id = " . $reply['thread_id']);
							$res = $this->cms->connection->fetch_assoc($QE);
							/* xapian part, only for people with Xapian, if you do not have xapian installed, do not try this
								    will cause serious errors! */
							if ($this->usexapian)
							{
								try
								{
									$xpDatabase = new XapianWritableDatabase($this->xapiandb, Xapian::DB_CREATE_OR_OPEN);
									// connected
									$indexer = new XapianTermGenerator();
									$stemmer = new XapianStem("english"); // this is english stemming, no setting yet, is a todo though
									$indexer->set_stemmer($stemmer);
									$doc = new XapianDocument();
									$doc->set_data($_POST['message']);
									$doc->add_value("messageid", intval($_POST['replyid'])); /* so we can find the post related to the indexed data */
									//$doc->add_term("forumid=1");
									$indexer->set_document($doc);
									$indexer->index_text($_POST['message']);
									// Add the document to the database.
									$docid = $xpDatabase->replace_document(intval($reply['xapian_docid']), $doc);
									$xpDatabase = null;
								} catch (Exception $e)
								{
									$xpDatabase = null;
									die('Xapian Error: trouble connecting to db<br />' . $e->getMessage());
								}
							}
							/* forwarding user to the right page */
							$page = (($res['total'] + 1) / $this->forSettings['postspp']);
							$page = ceil($page) - 1;
							if ($page < 0)
							{
								$page = 0;
							}
							header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $reply['thread_id'], $page));
							exit();
						} else
						{
							$this->cms->classes['base']->showError('forum', 4);
						}
					} else
					{
						$this->cms->classes['base']->showError('forum', 3);
					}
				break;
				case 'settings':
					if ($this->cms->classes['user']->login == true)
					{
						if (isset($_POST['postspp']) and $_POST['postspp'] > 0 and $_POST['postspp'] < 200 and isset($_POST['pthreads']) and $_POST['pthreads'] > 0 and $_POST['pthreads'] < 11 and isset($_POST['golastpage']) and ($_POST['golastpage'] == 'yes' or $_POST['golastpage'] == 'no'))
						{
							$this->cms->connection->query("UPDATE " . TAB_FOR_UPREFS . " SET 
													pref_postsppage = '" . intval($_POST['postspp']) . "',
													pref_pactivethreads = '" . intval($_POST['pthreads']) . "',
													pref_golastpage = '" . $this->cms->connection->escape_string($_POST['golastpage']) . "'
													WHERE uid = '" . $this->cms->classes['user']->uid . "'");
						}
						header("Location: " . $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_FORUMSETTINGS));
						exit();
					} else
					{
						$this->cms->classes['base']->showError('forum', 3);
					}
				break;
				default:
					// should throw some exception
					$this->cms->classes['error']->throwError(__FILE__, __LINE__, 'Unhandeld Exception: ' . $_POST['action']);
				break;
			}
		}
	}	

	function checkSpam ($userid, $message, $threadid)
	{
		$rthread = $this->whatIsAllowed('topic', $threadid);
		if ($rthread['moderate'] == 1)
		{
			return (true);
		} else
		{
			$checkQuery = $this->cms->connection->query("SELECT id FROM  " . TAB_FOR_REPLIES . "  WHERE user_creation  = '" . $userid . "' AND NOW()  - INTERVAL " . $this->postPauze . " " . $this->postPauzeType . " <= date_posted");
			if ($this->cms->connection->num_rows($checkQuery) > 0)
			{
				return (false);
			} else
			{
				return (true);
			}
		}
	}

	function insertPost ($threadid, $ownerid, $message, $tstart = 'no')
	{
		/** 
			 No real checks here, this is an internal function and should not be directly 
			 used before checking. Otherwise it will use twice or more queries.
		 **/
		if (! empty($threadid) and $threadid != 0 and ! empty($ownerid) and $ownerid != 0 and strlen($message) > FOR_MIN_CHARS_POST and ($tstart == 'yes' xor $tstart == 'no'))
		{
			$this->cms->connection->query("INSERT " . "INTO `" . TAB_FOR_REPLIES . "`" . " ( `id` ," . " `user_creation` ," . " `user_lastedit` ," . " `content_plain` ," . " `content_parsed` ," . " `thread_id` ," . " `thread_start` ," . " `date_posted` ) " . " VALUES (" . " NULL," . " '" . $ownerid . "'," . " '0'," . " '" . $this->cms->connection->escape_string($this->processPost($message, 'plain')) . "'," . " '" . $this->cms->connection->escape_string($this->processPost($message)) . "'," . " '" . intval($threadid) . "'," . " '" . $tstart . "'," . " NOW( )" . ");");
			$this->lastPostId = $this->cms->connection->insert_id();
			$this->cms->connection->query("UPDATE " . TAB_USERS . " SET posts = posts + 1 WHERE id = " . intval($ownerid));
			if ($this->lastPostId != 0) /* if adding the post has not failed, script goes on */
			 	{
				$this->cms->connection->query("UPDATE " . TAB_FOR_THREADS . " SET date_lastreply = now(), user_lastreply = " . intval($this->cms->classes['user']->uid) . ", amount_replies = amount_replies + 1 WHERE id = " . intval($threadid));
				$thread = $this->getThread($threadid);
				$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_replies = amount_replies + 1, user_lastreply = '" . intval($ownerid) . "', date_lastreply = now() WHERE id = " . $thread['for_id']);
				/** if xapian is enabled (does not check if installed, something admin is responsible for 
				 */
				if ($this->usexapian)
				{
					try
					{
						$xpDatabase = new XapianWritableDatabase($this->xapiandb, Xapian::DB_CREATE_OR_OPEN);
						// connected
						$indexer = new XapianTermGenerator();
						$stemmer = new XapianStem("english"); // this is english stemming, no setting yet, is a todo though
						$indexer->set_stemmer($stemmer);
						$doc = new XapianDocument();
						$doc->set_data($message);
						$doc->add_value("messageid", $this->lastPostId); /* so we can find the post related to the indexed data */
						$indexer->set_document($doc);
						$indexer->index_text($message);
						// Add the document to the database.
						$docid = $xpDatabase->add_document($doc);
						$this->cms->connection->query("UPDATE " . TAB_FOR_REPLIES . " SET xapian_docid = " . $docid . " WHERE id = " . $this->lastPostId); // this is done in a seperate query to make it easier to maintain 
						$xpDatabase = null;
					} catch (Exception $e)
					{
						$xpDatabase = null;
						die('Xapian Error: trouble connecting to db<br />' . $e->getMessage());
					}
				}
				return (true);
			}
		} else
		{
			return (false);
		}
	}

	function insertThread ($forumid, $catid, $title, $type, $state, $post)
	{
		$rforum = $this->whatIsAllowed('forum', $this->id);
		$forum = $this->getForum($forumid);
		if ($rforum['createchild'] == 1 and $forum['id'] == $forumid and $forum['cat_id'] == $catid and strlen($title) > FOR_MIN_CHARS_TOPICTITLE and strlen($post) > FOR_MIN_CHARS_POST)
		{
			/* creating a thread is now ok, all rights are ok, 
				 * the forum and category exist, the topictitle 
				 * is long enough, let's go on                     */
			if ($rforum['moderate'] == 1)
			{
				if ($type == 'normal' or $type == 'sticky' or $type == 'announcement')
				{
					$t['type'] = $type;
				} else
				{
					$t['type'] = 'normal';
				}
				if ($state == 'open' or $state == 'closed')
				{
					$t['state'] = $state;
				} else
				{
					$t['state'] = 'open';
				}
			} else
			{
				$t['type'] = 'normal';
				$t['state'] = 'open';
			}
			$this->cms->connection->query("INSERT INTO " . TAB_FOR_THREADS . "" . "(id, for_id, cat_id, thread_title, thread_type, thread_state, date_creation, user_creation, amount_replies)" . " VALUES " . " (" . "  null," . "  '" . intval($forumid) . "'," . "  '" . intval($catid) . "', " . "  '" . $this->cms->connection->escape_string($title) . "', " . "  '" . $t['type'] . "', " . "  '" . $t['state'] . "', " . "  now(), " . "  '" . $this->cms->classes['user']->uid . "'," . "  '0'" . " )");
			$topicid = $this->cms->connection->insert_id();
			$p = $this->insertPost($topicid, $this->cms->classes['user']->uid, $post, 'yes');
			$this->lasttopicid = $topicid;
			$this->cms->connection->query("UPDATE " . TAB_FOR_FORA . " SET amount_threads = amount_threads + 1 WHERE id = " . $forumid);
			$this->cms->connection->query("UPDATE " . TAB_FOR_THREADS . " SET reply_id = " . intval($this->lastPostId) . " WHERE id = " . $topicid);
			if ($topicid != 0 and $p == true)
			{
				return (true);
			} else
			{
				return (false);
			}
		}
		return (false);
	}
}
?>