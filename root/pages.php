<?php
/**
*
* @package phpBB3
* @author ellmetha
* @version $Id$
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Grab data 
$page_string_id = $_GET['p'];

// Get the topic id with the fetched page string ID
$sql = 'SELECT page_topic_id
		FROM phpbb_pages
		WHERE page_string_id = \'' . $page_string_id . '\'';
$result = $db->sql_query($sql);
$topic_id = (int) $db->sql_fetchfield('page_topic_id');

// Get the topic title
$sql = 'SELECT topic_title
		FROM ' . TOPICS_TABLE . '
		WHERE topic_id = ' . $topic_id;
$result = $db->sql_query($sql);
$topic_title = $db->sql_fetchfield('topic_title');

// Assign some vars for navlinks
$template->assign_block_vars('navlinks', array(
		'FORUM_NAME'		=> $topic_title,
		'U_VIEW_FORUM'		=> append_sid("pages.$phpEx?p=" . $page_string_id),
	)
);

// Fetch messages of the considered topic
if ($topic_id > 0)
{
	// Select the ID, title and text of messages attached to the considered topic
	$sql = 'SELECT post_id, post_subject, post_text, bbcode_bitfield, bbcode_uid
	FROM ' . POSTS_TABLE . '
	WHERE topic_id = ' . $topic_id . ' ORDER by post_time ASC';
	$result = $db->sql_query($sql);

	// Prepare each post
	while ($row = $db->sql_fetchrow($result))
	{
		// Fetch the content of the considered post
		$content = stripslashes(generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], 7));

		// Asign some vars for the considered post
		$template->assign_block_vars('messages', array(
			'ID'			=> $row['post_id'],
			'TITLE'			=> stripslashes($row['post_subject']),
			'CONTENT'		=> $content,   
		)
		);
	}
}

// Set the title of the page
page_header($topic_title);

// Set the specifiec template
$template->set_filenames(array(
	'body' => 'pages.html',
));

make_jumpbox(append_sid("{$phpbb_root_path}viewforum.$phpEx"));
page_footer();

?>