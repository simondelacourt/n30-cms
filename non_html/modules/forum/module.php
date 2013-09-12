<?php
/**
 * n30-cms content forum
 * (C) 2008 CT.Studios
 * version 0.2
 * 
 * This source code is release under the BSD License.
 */

require_once './non_html/modules/forum/framework/forumbase.php';
require_once './non_html/modules/forum/framework/forumhandler.php';
require_once './non_html/modules/forum/framework/forumrights.php';


class forum
{
	/* --- templates --- */
	public $tplViewThread = './forum/forum.showthread.tpl';
	public $tplViewThreads = './forum/forum.showthreads.tpl';
	public $tplInsertThread = './forum/forum.insertthread.tpl';
	public $tplActiveThreads = './forum/forum.activethreads.tpl';
	public $tplEditReply = './forum/forum.editreply.tpl';
	public $tplEditThread = './forum/forum.editthread.tpl';
	public $tplDeleteReply = './forum/forum.deletereply.tpl';
	public $tplMoveThread = './forum/forum.movethread.tpl';
	public $tplDeleteThread = './forum/forum.deletethread.tpl';
	public $tplOverview = './forum/forum.overview.tpl';
	public $tplSettings = './forum/forum.settings.tpl';
	public $pHandlerActive = true;

	public $forumfile = 'forum';
	public $moduledir = 'forum';
	
	private $cms;
	
	public function __construct($cms)
	{
		$this->cms = &$cms;
		/**
		 * forum urls
		 */
		$this->fUrls['forum'] = n30::generateLink($this->forumfile);
		$this->fUrls['activethreads'] = n30::generateLink($this->forumfile, array('action' => 'activethreads'));
		$this->fUrls['forumsettings'] = n30::generateLink($this->forumfile, array('action' => 'settings'));
		
		/**
		 * forum framework
		 */
		$this->forumbase = new forumbase($this);
	}
	
	/**
	 * Feature needs major reworking in next version!
	 *
	 */
	function getPersonalSettings ()
	{
		switch ($this->cms->classes['user']->login)
		{
			case true:
					/* member situation */
					$QE = $this->cms->connection->query("SELECT * FROM " . TAB_FOR_UPREFS . " WHERE uid  = " . $this->cms->classes['user']->uid);
				$res = $this->cms->connection->fetch_assoc($QE);
				if ($this->cms->connection->num_rows($QE) == 0)
				{
					$this->cms->connection->query("INSERT INTO " . TAB_FOR_UPREFS . " (uid, pref_postsppage, pref_pactivethreads) VALUES (" . $this->cms->classes['user']->uid . ", " . intval(FOR_USER_DEF_POSTSPP) . ", " . FOR_USER_DEF_PTHREADS . ")");
					$this->forSettings['postspp'] = FOR_USER_DEF_POSTSPP;
					$this->forSettings['pthreads'] = FOR_USER_DEF_PTHREADS;
					$this->forSettings['golastpage'] = 'yes';
				} else
				{
					$this->forSettings['postspp'] = $res['pref_postsppage'];
					$this->forSettings['pthreads'] = $res['pref_pactivethreads'];
					$this->forSettings['golastpage'] = $res['pref_golastpage'];
				}
			break;
			case false:
					/* guest situation */
					$this->forSettings['postspp'] = FOR_USER_DEF_POSTSPP;
				$this->forSettings['pthreads'] = FOR_USER_DEF_PTHREADS;
				$this->forSettings['golastpage'] = 'yes';
			break;
		}
	}
	
	function show ($function)
	{
		switch ($function)
		{
			case 'latinphrase':
				return ('Aliena nobis, nostra plus aliis placent');
			break;
			case 'translatinphrase':
				return ('Other people\'s things are more pleasing to us, and ours to other people. (Publilius Syrus)');
			break;
			case 'viewthread':
				
					
			break;
			case 'viewthreads':
			break;
			case 'insertthread':
				
			break;
			case 'activethreads':
				
			break;
			case 'insertreply':
					
			break;
			case 'editreply':
					
			break;
			case 'editthread':
					
					
			break;
			case 'deletereply':
					
			break;
			case 'movethread':
					
			break;
			case 'deletethread':
					
			break;
			case 'settings':
			break;
			default:
				//$this->cms->classes['base']->pagetitle = $this->cms->classes['base']->lang['forum']['forum'];
				$template = new Smarty();
				$template->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
				$template->compile_dir = $this->cms->templates->compileddir;
				$template->assign('overview', $this->getOverview());
				$template->assign('baseurl', BASE_URL);
				$template->assign('forbaseurl', n30::generateLink($this->forumfile));
				$template->assign('foractivetopicsurl', $this->fUrls['activethreads']);
				$template->assign('forumsettingsurl', $this->fUrls['forumsettings']);
				$template->assign('login', $this->cms->user->login);
				return ($template->fetch($this->tplOverview));
			break;
		}
	}
}
?>