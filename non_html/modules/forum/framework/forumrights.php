<?php

/**
 * n30-cms forum: rights
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
 * Rights management for forum
 * 
 * PHP5 ONLY!
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */

class forumrights
{

	private $groups = array();
	private $rights = array();
	private $actions = array('view' , 'move' , 'edit' , 'moderate' , 'createchild' , 'deletechild' , 'del');
	private $sql;

	public function __construct(&$cms)
	{
		$this->cms = &$cms;
		$this->get_rights();
	}
	/**
	 * load rights
	 *
	 * @return boolean
	 */
	private function get_rights ()
	{
		if ($this->cms->classes['user']->login == true)
		{
			$query = "   SELECT *
		    	             FROM " . TAB_FOR_RULES . "
		        	         WHERE (    Leveltype = 'group' AND LevelID IN (0, " . implode(',', (array) $this->cms->classes['user']->groups) . ") OR
		           		               (Leveltype = 'user' AND LevelID = '" . $this->cms->classes['user']->uid . "') )
		               		 ORDER BY Leveltype DESC";
		} else
		{
			$query = " SELECT *
		    	            FROM " . TAB_FOR_RULES . "
		        	         WHERE Leveltype = 'guest'
		               		 ORDER BY Leveltype DESC";
		}
		$result = $this->cms->connection->query($query);
		if ($this->cms->connection->num_rows($result) == 0)
		{
			return ("No rules where found for this user");
		}
		while ($row = $this->cms->connection->fetch_assoc($result))
		{
			foreach ($this->actions as $action)
			{
				if ($row['Leveltype'] == 'group')
				{
					if (isset($this->rights[$row['Actionkind']][$row['ActionID']][$action]) and $this->rights[$row['Actionkind']][$row['ActionID']][$action] == 1)
					{
						;
					} elseif ($row[$action] == 1)
					{
						$this->rights[$row['Actionkind']][$row['ActionID']][$action] = 1;
					} else
					{
						$this->rights[$row['Actionkind']][$row['ActionID']][$action] = 0;
					}
				} else
				{
					if ($row[$action] === NULL)
					{
						;
					} elseif ($row[$action] == 1)
					{
						$this->rights[$row['Actionkind']][$row['ActionID']][$action] = 1;
					} else
					{
						$this->rights[$row['Actionkind']][$row['ActionID']][$action] = 0;
					}
				}
			}
		}
		return true;
	}
	/**
	 * return right settings
	 *
	 * @param unknown_type $type
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function returnRights ($type, $id)
	{
		if (isset($this->rights[$type][$id]))
		{
			return ($this->rights[$type][$id]);
		} else
		{
			$r = array();
			foreach ($this->actions as $action)
			{
				$r[$action] = 0;
			}
			return ($r);
		}
	}
	
	function whatIsAllowed ($location, $id)
	{
		switch ($location)
		{
			case 'category':
				if (isset($this->r->rights['category'][$id]))
				{
					return ($this->r->rights['category'][$id]);
				} elseif (isset($this->r->rights['board'][0]))
				{
					return ($this->r->rights['board'][0]);
				} else
				{
					$r = array();
					foreach ($this->r->actions as $action)
					{
						$r[$action] = 0;
					}
					return ($r);
				}
			break;
			case 'forum':
				if (isset($this->r->rights['forum'][$id]))
				{
					return ($this->r->rights['forum'][$id]);
				} else
				{
					if (isset($this->rCache['forum'][$id]))
					{
						$catid = $this->rCache['topic'][$id]['catid'];
						if (isset($this->r->rights['category'][$catid]))
						{
							return ($this->r->rights['category'][$catid]);
						} else
						{
							$r = array();
							foreach ($this->r->actions as $action)
							{
								$r[$action] = 0;
							}
							return ($r);
						}
					} else
					{
						$QE = $this->cms->connection->query("SELECT cat_id FROM " . TAB_FOR_FORA . " where id = " . intval($id));
						$forum = $this->cms->connection->fetch_assoc($QE);
						$this->rCache['topic'][$id]['catid'] = $forum['cat_id'];
						$catid = $this->rCache['topic'][$id]['catid'];
						if (isset($this->r->rights['category'][$catid]))
						{
							return ($this->r->rights['category'][$catid]);
						} else
						{
							if (isset($this->r->rights['board'][0]))
							{
								return ($this->r->rights['board'][0]);
							} else
							{
								$r = array();
								foreach ($this->r->actions as $action)
								{
									$r[$action] = 0;
								}
								return ($r);
							}
						}
					}
				}
			break;
			case 'topic':
				if (isset($this->r->rights['topic'][$id]))
				{
					// * if rights already exist, return them */
					return ($this->r->rights['topic'][$id]);
				} else
				{
					if (isset($this->rCache['topic'][$id]))
					{
						$forumid = $this->rCache['topic'][$id]['forumid'];
						$catid = $this->rCache['topic'][$id]['catid'];
						if (isset($this->r->rights['forum'][$forumid]))
						{
							return ($this->r->rights['forum'][$forumid]);
						} elseif (isset($this->r->rights['category'][$catid]))
						{
							return ($this->r->rights['category'][$catid]);
						} else
						{
							if (isset($this->r->rights['board'][0]))
							{
								return ($this->r->rights['board'][0]);
							} else
							{
								$r = array();
								foreach ($this->r->actions as $action)
								{
									$r[$action] = 0;
								}
								return ($r);
							}
						}
					} else
					{
						$QE = $this->cms->connection->query("SELECT for_id, cat_id FROM " . TAB_FOR_THREADS . " WHERE id  = " . intval($id));
						$topic = $this->cms->connection->fetch_assoc($QE);
						$this->rCache['topic'][$id]['forumid'] = $topic['for_id'];
						$this->rCache['topic'][$id]['catid'] = $topic['cat_id'];
						$forumid = $this->rCache['topic'][$id]['forumid'];
						$catid = $this->rCache['topic'][$id]['catid'];
						if (isset($this->r->rights['forum'][$forumid]))
						{
							return ($this->r->rights['forum'][$forumid]);
						} elseif (isset($this->r->rights['category'][$catid]))
						{
							return ($this->r->rights['category'][$catid]);
						} else
						{
							if (isset($this->r->rights['board'][0]))
							{
								return ($this->r->rights['board'][0]);
							} else
							{
								$r = array();
								foreach ($this->r->actions as $action)
								{
									$r[$action] = 0;
								}
								return ($r);
							}
						}
					}
				}
			break;
			case 'message':
				if (isset($this->r->rights['message'][$id]))
				{
					return ($this->r->rights['message'][$id]);
				} else
				{
					if (isset($this->rCache['message'][$id]))
					{
						$topicid = $this->rCache['message'][$id]['topicid'];
						$forumid = $this->rCache['message'][$id]['forumid'];
						$catid = $this->rCache['message'][$id]['catid'];
						if (isset($this->r->rights['topic'][$topicid]))
						{
							return ($this->r->rights['topic'][$topicid]);
						} elseif (isset($this->r->rights['forum'][$forumid]))
						{
							return ($this->r->rights['forum'][$forumid]);
						} elseif (isset($this->r->rights['category'][$catid]))
						{
							return ($this->r->rights['category'][$catid]);
						} else
						{
							$r = array();
							foreach ($this->r->actions as $action)
							{
								$r[$action] = 0;
							}
							return ($r);
						}
					} elseif (isset($this->r->rights['board'][0]))
					{
						return ($this->r->rights['board'][0]);
					} else
					{
						$r = array();
						foreach ($this->r->actions as $action)
						{
							$r[$action] = 0;
						}
						return ($r);
					}
				}
			break;
			case 'usernotes':
				if (isset($this->r->rights['usernotes'][$id]))
				{
					return ($this->r->rights['usernotes'][$id]);
				} elseif (isset($this->r->rights['usernotes'][0]))
				{
					return ($this->r->rights['usernotes'][0]);
				} else
				{
					$r = array();
					foreach ($this->r->actions as $action)
					{
						$r[$action] = 0;
					}
					return ($r);
				}
			break;
		}
	}
	
}
?>