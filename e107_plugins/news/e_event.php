<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * XXX HIGHLY EXPERIMENTAL AND SUBJECT TO CHANGE WITHOUT NOTICE. 
*/

if (!defined('e107_INIT')) { exit; }


class news_event // plugin-folder + '_event'
{

	/**
	 * Configure functions/methods to run when specific e107 events are triggered.
	 * For a list of events, please visit: http://e107.org/developer-manual/classes-and-methods#events
	 * Developers can trigger their own events using: e107::getEvent()->trigger('plugin_event',$array);
	 * Where 'plugin' is the folder of their plugin and 'event' is a unique name of the event.
	 * $array is data which is sent to the triggered function. eg. myfunction($array) in the example below.
	 *
	 * @return array
	 */
	function config()
	{

		$event = array();

		$event[] = array(
			'name'	=> "user_comment_posted", // when this is triggered... (see http://e107.org/developer-manual/classes-and-methods#events)
			'function'	=> "incrementComment", // ..run this function (see below).
		);

		return $event;

	}


	function incrementComment($data) // the method to run.
	{
		if($data['comment_type'] !== 'news' && !empty($data['comment_type']))
		{
			file_put_contents(e_LOG."news.event.log", print_r($data,true));
			return false;
		}

		if(!empty($data['comment_item_id']))
		{
			e107::getDb()->update("news", "news_comment_total=news_comment_total+1 WHERE news_id=".intval($data['comment_item_id']));
		}

	}





} //end class
