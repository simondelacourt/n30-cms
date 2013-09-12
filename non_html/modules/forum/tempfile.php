<?php
/**
 * view thread
 */
$rtopic = $this->whatIsAllowed('topic', $this->id);
					$template = new Smarty();
					$template->template_dir = $this->cms->classes['base']->templates['dir'];
					$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
					$template->assign('lang', $this->cms->classes['base']->lang);
					$template->assign('rights', $rtopic);
					$template->assign('forbaseurl', $this->forBaseUrl);
					$template->assign('baseurl', BASE_URL);
					$template->assign('tempurl', BASE_URL . $this->cms->classes['base']->templates['dir'] . "/");
					$template->assign('loginstate', $this->cms->classes['user']->login);
					$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
					$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
					$template->assign('login', $this->cms->classes['user']->login);
					$thread = $this->getThread($this->id);
					$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . htmlspecialchars($thread['thread_title']);
					if (is_array($thread))
					{
						if ($rtopic['view'] == 0)
						{
							$this->cms->classes['base']->showError('forum', 3);
						}
						else
						{
							if ($rtopic['createchild'] == 1 AND (($thread['thread_type'] != 'announcement' AND $thread['thread_state'] == 'open') OR $rtopic['moderate'] == 1))
							{
								$template->assign('reply', true);
							}
							else 
							{
								$template->assign('reply', false);
							}
							$pArr = array();
							$pCount = ceil(($thread['amount_replies']) / $this->forSettings['postspp'])  ;
							for ($i =0; $i < $pCount;)
							{
								$pArr[$i] = array('url' => $this->cms->classes['base']->createUrl(FOR_BASEFILE, FOR_TITLE_VIEWTHREAD, $thread['id'], $i), 'name' => $i + 1);
								$i++;
							}
							$template->assign('pages', $pArr);
							$template->assign('thread', $thread);
							$replies = $this->getReplies($this->id, ($this->forSettings['postspp'] * intval($this->page)), $this->forSettings['postspp']);
							$template->assign('replies', $replies);
							$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
							$this->cms->classes['tracker']->addTrack('forum', 'viewthread', $this->id);
							return ($template->fetch($this->tplViewThread));
						}
					}
					else
					{
						$this->cms->classes['base']->showError('forum', 1, $to);
					}
					/**
					 * viewthreads
					 */
						$rforum = $this->whatIsAllowed('forum', $this->id);
					if ($rforum['view'] == 1)
					{
						$template = new Smarty();
						$template->template_dir = $this->cms->classes['base']->templates['dir'];
						$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
						$template->assign('lang', $this->cms->classes['base']->lang);
						if ($this->page > 0)
						{
							$template->assign('dlistsel', $this->page);
							$pSys = $this->page;
						}
						else
						{
							$template->assign('dlistsel', $this->forSettings['pthreads']);
							$pSys = $this->forSettings['pthreads'];
						}
						$template->assign('threads', $this->getThreads($this->id, $pSys));
						$template->assign('baseurl', BASE_URL);
						$template->assign('forbaseurl', $this->forBaseUrl);
						$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
						$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
						$template->assign('login', $this->cms->classes['user']->login);
						if ($rforum['createchild'] == 1)
						{
							$template->assign('urlposttopic', $this->cms->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_INSERTTHREAD, $this->id));
						}
						$forum = $this->getForum($this->id);
						$template->assign('forum', $forum);
						$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . htmlspecialchars($forum['for_title']);
						$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
						$template->assign('tempurl', BASE_URL . $this->cms->classes['base']->templates['dir'] . "/");
						$dList = array();
						foreach ($this->hShow AS $item)
						{
							$dList[] = array('url' =>  $this->cms->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_VIEWTHREADS, $this->id, $item['n']), 'title' => $this->cms->classes['base']->lang['forum']['hshow'][$item['t']], 'i' => $item['n']);
						}
						$template->assign('dlist', $dList);
							
						$this->cms->classes['tracker']->addTrack('forum', 'viewthreads', $this->id);
						return ($template->fetch($this->tplViewThreads));
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 3, $to);
					}
					/**
					 * insert thread
					 */
						if (!empty($this->id) AND $this->id != 0)
					{
						$rforum = $this->whatIsAllowed('forum', $this->id);
						if ($rforum['createchild'] == 1)
						{
							$template = new Smarty();
							$template->template_dir = $this->cms->classes['base']->templates['dir'];
							$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
							$template->assign('lang', $this->cms->classes['base']->lang);
							$template->assign('rights', $rforum);
							$forum = $this->getForum($this->id);
							$template->assign('forumid', $this->id);
							$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
							$template->assign('forum', $forum);
							$template->assign('baseurl', BASE_URL);
							$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['insertthread']['title'];
							$template->assign('forbaseurl', $this->forBaseUrl);
							$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
							$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
							$template->assign('login', $this->cms->classes['user']->login);
							$this->cms->classes['tracker']->addTrack('forum', 'insertthread', $this->id);
							return ($template->fetch($this->tplInsertThread));
						}
						else 
						{
							$this->cms->classes['base']->showError('forum', 3, $to);
						}
					}
				/**
				 * active threads
				 */
						$template = new Smarty();
					$template->template_dir = $this->cms->classes['base']->templates['dir'];
					$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
					$template->assign('lang', $this->cms->classes['base']->lang);
					$template->assign('baseurl', BASE_URL);
					$template->assign('forbaseurl', $this->forBaseUrl);
					$template->assign('threads', $this->getActiveThreads($this->page, $this->id));
					$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
					$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
					$template->assign('login', $this->cms->classes['user']->login);
					$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['activethreads']['title'];
					$template->assign('tempurl', BASE_URL . $this->cms->classes['base']->templates['dir'] . "/");
					$dList = array();
					foreach ($this->hShow AS $item)
					{
						$dList[] = array('url' =>  $this->cms->classes['base']->createURL(FOR_BASEFILE, FOR_TITLE_ACTIVETHREADS, $item['n'], $this->page), 'title' => $this->cms->classes['base']->lang['forum']['hshow'][$item['t']], 'i' => $item['n']);
					}
					$template->assign('dlist', $dList);
					if ($this->id > 0)
					{
						$template->assign('dlistsel', $this->id);
					}
					else
					{
						$template->assign('dlistsel', $this->forSettings['pthreads']);
					}
					$this->cms->classes['tracker']->addTrack('forum', 'activethreads', 0);
					return ($template->fetch($this->tplActiveThreads));
					
				/**
				 * insert reply
				 */
					$template = new Smarty();
					$template->template_dir = $this->cms->classes['base']->templates['dir'];
					$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
					$template->assign('lang', $this->cms->classes['base']->lang);
					$template->assign('forbaseurl', $this->forBaseUrl);
					$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
					$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
					$template->assign('baseurl', BASE_URL);
					$template->assign('login', $this->cms->classes['user']->login);
					$this->cms->classes['tracker']->addTrack('forum', 'insertreply', $this->id);
					$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['insertreply']['title'];
					if ((!empty($this->id) OR $this->id != 0) AND $this->cms->classes['user']->login == true)
					{
						$thread = $this->getThread($this->id);
						$retopic = $this->whatIsAllowed('topic', $this->id);
						if ($retopic['createchild'] == 1 AND (($thread['thread_type'] != 'annoucement' AND $thread['thread_state'] == 'open') OR $retopic['moderate'] == 1))
						{
							// insert reply allowed, not sure if real topic though
							if ($thread)
							{
								$template->assign('thread', $thread);
								if (!empty($this->quoteid) AND $this->quoteid != 0)
								{
									$post = $this->getPost(intval($this->quoteid));
									$post['newmessage'] = $this->processPost($post['content_plain'], 'quote', array('time' => $post['date_posted'], 'poster' => $post['username_creation']));
									$template->assign('quote', $post);
								}
								return ($template->fetch('./forum/forum.insertreply.tpl'));
							}
							else
							{
								$this->cms->classes['base']->showError('forum', 1, $to);
							}
						}
						else
						{
							$this->cms->classes['base']->showError('forum', 3, $to);
						}
					}
					/**
					 * edit reply
					 */
					if (!empty($this->id) AND $this->id != 0)
					{
						$reply = $this->getPost($this->id);
						$thread = $this->getThread($reply['thread_id']);
						$rights = $this->whatIsAllowed('topic', $reply['thread_id']);
						if ($rights['view'] == 1 AND $this->cms->classes['user']->login == true AND (($this->cms->classes['user']->uid == $reply['user_creation'] AND $thread['thread_state'] == 'open') OR $rights['edit'] == 1))
						{
							$template = new Smarty();
							$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['editreply']['title'];
							$template->template_dir = $this->cms->classes['base']->templates['dir'];
							$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
							$template->assign('lang', $this->cms->classes['base']->lang);
							$template->assign('forbaseurl', $this->forBaseUrl);
							$template->assign('baseurl', BASE_URL);
							$template->assign('foractivetopicsurl', $this->fUrls['forumsettings']);
							$template->assign('login', $this->cms->classes['user']->login);
							$thread = $this->getThread($reply['thread_id']);
							$template->assign('thread', $thread);
							$template->assign('reply', $reply);
							$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
							$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
							$template->assign('login', $this->cms->classes['user']->login);
							$this->cms->classes['tracker']->addTrack('forum', 'editreply', $this->id);
							return ($template->fetch($this->tplEditReply));
						}
						else
						{
							$this->cms->classes['base']->showError('forum', 3, $to);
						}
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 1, $to);
					}
					
					/**
					 * edit thread
					 */
					if (!empty($this->id) AND $this->id != 0)
					{
						$thread = $this->getThread($this->id);
						$rights = $this->whatIsAllowed('topic', $this->id);
						if ($rights['view'] == 1 AND $this->cms->classes['user']->login == true AND (($this->cms->classes['user']->uid == $thread['user_creation'] AND $thread['thread_state'] == 'open') OR $rights['edit'] == 1))
						{
							$reply = $this->getPost($thread['reply_id']);
							$template = new Smarty();
							$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['editthread']['title'];
							$template->template_dir = $this->cms->classes['base']->templates['dir'];
							$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
							$template->assign('lang', $this->cms->classes['base']->lang);
							$template->assign('forbaseurl', $this->forBaseUrl);
							$template->assign('thread', $thread);
							$template->assign('baseurl', BASE_URL);
							$template->assign('rights', $rights);
							$template->assign('reply', $reply);
							$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
							$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
							$template->assign('login', $this->cms->classes['user']->login);
							$this->cms->classes['tracker']->addTrack('forum', 'editthread', $this->id);
							return ($template->fetch($this->tplEditThread));
						}
						else
						{
							$this->cms->classes['base']->showError('forum', 3, $to);
						}
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 1, $to);
					}
					/**
					 * delete reply
					 */
					$reply = $this->getPost($this->id);
					$rights = $this->whatIsAllowed('topic', $reply['thread_id']);
					if ($rights['deletechild'] == 1 AND $reply['thread_start'] == 'no')
					{
						$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['deletereply']['title'];
						$thread = $this->getThread($reply['thread_id']);
						$template = new Smarty();
						$template->template_dir = $this->cms->classes['base']->templates['dir'];
						$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
						$template->assign('lang', $this->cms->classes['base']->lang);
						$template->assign('forbaseurl', $this->forBaseUrl);
						$template->assign('baseurl', BASE_URL);
						$template->assign('thread', $thread);
						$template->assign('reply', $reply);
						$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
						$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
						$template->assign('login', $this->cms->classes['user']->login);
						$this->cms->classes['tracker']->addTrack('forum', 'deletereply', $this->id);
						return ($template->fetch($this->tplDeleteReply));
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 3, $to);
					}
					/**
					 * move thread
					 */
					$thread = $this->getThread($this->id);
					$rights = $this->whatIsAllowed('topic', $this->id);
					if ($rights['move'] == 1)
					{
						$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['movethread']['title'];
						$template = new Smarty();
						$template->template_dir = $this->cms->classes['base']->templates['dir'];
						$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
						$template->assign('lang', $this->cms->classes['base']->lang);
						$template->assign('forbaseurl', $this->forBaseUrl);
						$template->assign('baseurl', BASE_URL);
						$template->assign('thread', $thread);
						$template->assign('overview', $this->getOverview());
						$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
						$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
						$template->assign('login', $this->cms->classes['user']->login);
						$this->cms->classes['tracker']->addTrack('forum', 'movethread', $this->id);
						return ($template->fetch($this->tplMoveThread));
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 3, $to);
					}
				/**
				 * delete thread
				 */
			$thread = $this->getThread($this->id);
					$rights = $this->whatIsAllowed('topic', $this->id);
					if ($rights['deletechild'] == 1)
					{
						$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['deletethread']['title'];
						$template = new Smarty();
						$template->template_dir = $this->cms->classes['base']->templates['dir'];
						$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
						$template->assign('lang', $this->cms->classes['base']->lang);
						$template->assign('forbaseurl', $this->forBaseUrl);
						$template->assign('baseurl', BASE_URL);
						$template->assign('thread', $thread);
						$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
						$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
						$template->assign('login', $this->cms->classes['user']->login);
						$this->cms->classes['tracker']->addTrack('forum', 'deletethread', $this->id);
						return ($template->fetch($this->tplDeleteThread));
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 3, $to);
					}
					/**
					 * settings
					 */
										if ( $this->cms->classes['user']->login)
					{
						$template = new Smarty();
						$template->template_dir = $this->cms->classes['base']->templates['dir'];
						$template->compile_dir = $this->cms->classes['base']->templates['dir'] . "/compiled/";
						$template->assign('lang', $this->cms->classes['base']->lang);
						$template->assign('forbaseurl', $this->forBaseUrl);
						$template->assign('baseurl', BASE_URL);
						$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
						$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
						$template->assign('login', $this->cms->classes['user']->login);
						$template->assign('settings', $this->forSettings);

						
						$dList = array();
						foreach ($this->hShow AS $item)
						{
							$dList[] = array('title' => $this->cms->classes['base']->lang['forum']['hshow'][$item['t']], 'i' => $item['n']);
						}
						$template->assign('dlist', $dList);

						$this->cms->classes['tracker']->addTrack('forum', 'settings', 0);
						$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'] . " - "  . $this->cms->classes['base']->lang['forum']['settings']['title'];
						return ($template->fetch($this->tplSettings));
						
						
					}
					else 
					{
						$this->cms->classes['base']->showError('forum', 3, $to);
					}
?>