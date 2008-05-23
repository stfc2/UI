<?PHP
/*    
	This file is part of STFC.
	Copyright 2006-2007 by Michael Krauss (info@stfc2.de) and Tobias Gafner
		
	STFC is based on STGC,
	Copyright 2003-2007 by Florian Brede (florian_brede@hotmail.com) and Philipp Schmidt
	
    STFC is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    STFC is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ($user['right']==1) {include('forbidden.php'); return 1;}

$main_html .= '<span class=header><center>Messaggi</center></span><br>';



function output($string)
{
	global $main_html;
	$main_html.=$string;
}

/** Initial Work **/

// set folder
$subAction = (!empty($_GET['a2'])) ? $_GET['a2'] : 'inbox';

// set start page
$perpage	= 100;
$page 	= (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 0;
$start 	= $page * $perpage;




function UpdateUnreadMessages($user_id)
{
global $db;
if (!($num=$db->queryrow('SELECT COUNT(id) as unread FROM message WHERE (receiver="'.$user_id.'") AND (rread=0)'))) return 0;

$db->query('UPDATE user SET unread_messages="'.$num['unread'].'" WHERE user_id="'.$user_id.'"');
}

/** inbox actions **/

if($subAction == 'inbox')
{
	// do 'rremove'
	if(isset($_REQUEST['rremove']))
	{
		for ($i = 0; $i < $perpage; $i++)
		{
			if(isset($_POST['message'.$i.'']))
			{
				$mes=$db->queryrow('SELECT * FROM message WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
				if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');

			}
			
		}
			UpdateUnreadMessages(SUPPORTUSER);
	}
	// do 'rarchiv'
	if(isset($_REQUEST['rarchiv']))
	{
		for ($i = 0; $i < $perpage; $i++)
		{
			if(isset($_POST['message'.$i.'']))
			{
				$mes=$db->queryrow('SELECT * FROM message WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
				if ($db->query('INSERT INTO message_archiv (sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
			}
		}
			UpdateUnreadMessages(SUPPORTUSER);
	}

	// do 'rremoveall'
	else if(isset($_GET['rremoveall']))
	{
		$mes_qry=$db->query('SELECT * FROM message WHERE (rread = "1") AND (receiver = "'.SUPPORTUSER.'")');
		while ($mes=$db->fetchrow($mes_qry))
		{
				if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
		}

	}

	// do 'rmarkall'
	else if(isset($_GET['rmarkall']))
	{
		$db->query('UPDATE message SET rread = "1" WHERE receiver = "'.SUPPORTUSER.'"');
		UpdateUnreadMessages(SUPPORTUSER);
	}
}


/** archiv actions **/

else if($subAction == 'archiv')
{
	// do 'aremove'
	if(isset($_GET['aremove']))
	{
		for ($i = 0; $i < $perpage; $i++)
		{
			if(isset($_POST['message'.$i.'']))
			{
				$mes=$db->queryrow('SELECT * FROM message_archiv WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
				if ($db->query('INSERT INTO message_removed ( sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message_archiv WHERE (id = "'.$mes['id'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
			}
		}
	}

	// do 'aremoveall'
	else if(isset($_GET['aremoveall']))
	{
		$mes_qry=$db->query('SELECT * FROM message_archiv WHERE (receiver = "'.SUPPORTUSER.'")');
		while ($mes=$db->fetchrow($mes_qry))
		{
			if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
							VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.$mes['text'].'", '.$mes['time'].')')!=false)
				$db->query('DELETE FROM message_archiv WHERE (id = "'.$mes['id'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');

		}

	}

	// do 'archiv'
	else if(isset($_POST['archiv']))
	{
		$mes=$db->queryrow('SELECT * FROM message WHERE (id = "'.(int)$_POST['archiv'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
		if ($db->query('INSERT INTO message_archiv (sender, receiver, subject, text, time)
						VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.$mes['text'].'", '.$mes['time'].')'))
			$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.SUPPORTUSER.'") LIMIT 1');
		UpdateUnreadMessages(SUPPORTUSER);
	}
}


/** get stats **/

// inbox
$inStat2= $db->queryrow('SELECT count(id) as "messages" FROM message WHERE (receiver = "'.SUPPORTUSER.'")');
$inStat['messages'] = $inStat2['messages'];
$inStat2= $db->queryrow('SELECT count(id) as "messages" FROM message WHERE (receiver = "'.SUPPORTUSER.'") AND rread=0');
$inStat['unreadMessages'] = $inStat['messages'];

// archiv
$archStatList	= $db->query('SELECT count(id) as "messages" FROM message_archiv WHERE (receiver="'.SUPPORTUSER.'")');
$archStat		= $db->fetchrow($archStatList);



/** main **/

output('<center>L&#146;utente "STFC Support" &egrave; responsabile per queste news.<br>Inoltre pu&ograve; ricevere messaggi di risposta.<br>I messages non possono essere cancellati, perch&eacute; tutti i supporter abbiano la possibilita di leggerli.</center><br><br>');

output('
	<center>
	  <table width="90%" border=0 cellpadding=2 cellspacing=2 class="style_inner">
	   <tr>
		 <td width="25%"><span style="font-family:Arial,serif;font-size:9pt;"><center><a href="'.parse_link('p=messages&a2=inbox').'"><b>Posta in entrata('.$inStat['unreadMessages'].'/'.$inStat['messages'].')</a></span></td>
		 <td width="25%"><span style="font-family:Arial,serif;font-size:9pt;"><center><a href="'.parse_link('p=messages&a2=outbox').'"><b>Posta in uscita</a></span></td>
		 <td width="25%"><span style="font-family:Arial,serif;font-size:9pt;"><center><a href="'.parse_link('p=messages&a2=archiv').'"><b>Archivio ('.$archStat['messages'].')</a></span></td>
		 <td width="25%"><span style="font-family:Arial,serif;font-size:9pt;"><center><a href="'.parse_link('p=messages&a2=newpost').'"><b>Invia messaggio</a></span></td>
		</tr>
	  </table>
	 <br>');

if ($subAction == 'inbox') inbox();
else if ($subAction == 'outbox') outbox();
else if ($subAction == 'archiv') archiv();
else if ($subAction == 'view') view();
else if ($subAction == 'newpost') newMessage();
else if ($subAction == 'submitpost') submitMessage();



/** functions **/

// inbox
function inbox()
{
	global $db;
	global $page, $perpage, $start;
	global $inStat;

	$messageList = $db->query('SELECT m.rread, m.time, m.sender, m.subject, m.id, u.user_name FROM message m LEFT JOIN user u on u.user_id=m.sender WHERE (m.receiver = "'.SUPPORTUSER.'") ORDER BY m.time DESC LIMIT '.$start.', '.$perpage);


	output('<form method="post" action="'.parse_link('p=messages&a2=inbox').'">
	             <center>
	             <table width="90%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($inStat['messages'] == 0)
		output('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>Nessun messaggio</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{
			if ($message['sender'] == 0)
				$userName = '<b>System</b>';
			else if(!isset($message['user_name']))
				$userName = '<i>cancellato</i>';
			else
				$userName = '<a href="../game/index.php?a=stats&a2=viewplayer&id='.$message['sender'].'" target=_blank>'.$message['user_name'].'</a>';

			$bg 		 =	($message['rread'] == 0) ? '#e98b8b' : '#d2d9ff';
			$datum 	 = gmdate('d.m.y H:i', ($message['time'] +TIME_OFFSET));

			output('<tr>
							<td width="2%"></td>
							<td width="30%" bgcolor='.$bg.'>'.$userName.'</td>
							<td width="45%" bgcolor='.$bg.'><a href="'.parse_link('p=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%" bgcolor='.$bg.'>'.$datum.'</td>
							<td width="5%" bgcolor='.$bg.'><input type="checkbox" name="message'.$i.'" value="'.$message['id'].'"></td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $inStat['messages'], 'p=messages&a2=inbox');
	$mark		= '<a href="'.parse_link('p=messages&rmarkall=1').'">Marca tutti come letti</a>';
	$delete	= '';

	if($inStat['unreadMessages'] != 0)
	{
		$links2 = $mark;
		if($inStat['messages'] != 0)
			$links2 .= '<br>'.$delete;
	}
	else if($inStat['messages'] != 0)
		$links2 = $delete;
	else
		$links2 = "";

	output('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');

	if($inStat['messages'] != 0)
		output('<table width="90%" border="0" cellpadding="2" cellspacing="0" class="style_outer">
					  <tr>
					   <td width="2%">&nbsp;</td>
					   <td width="96%" colspan="4">
						 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
                    <tr>
                     <td width="50%" align="left">voci selezionate</td>
                     <td width="50%" align="right"><input style="width: 120px;" type="submit" class="button" name="rarchiv" value="Archivia"></td>
                    </tr>
					    </table>
						<td width="2%">&nbsp;</td>
						</td>
					  </tr>
					  <tr>
					   <td height="5" colspan="6"></td>
					  </tr>
					  <tr>
					   <td width="100%" colspan="6" align="center">'.$links.'</td>
					  </tr>
					  <tr>
					   <td height="5" colspan="6"></td>
					  </tr>
					  <tr>
					   <td width="100%" colspan="6" align="center">'.$links2.'</td>
					  </tr>
					 </table>');

	output(' </center>
					</form>');
}

// outbox
function outbox()
{
	global $db;
	global $page, $perpage, $start;
	global $outStat;
	$messageList = $db->query('SELECT m.rread, m.time, m.receiver, m.subject, m.id,u.user_name FROM message m LEFT JOIN user u on u.user_id=m.receiver WHERE (m.sender = "'.SUPPORTUSER.'") ORDER BY m.time DESC LIMIT '.$start.', '.$perpage);
    $outStat['messages'] = $db->num_rows();
	output('<form method="post" action="'.parse_link('p=messages&a2=outbox&sremove=1').'">
	             <center>
	             <table width="90%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($outStat['messages'] == 0)
		output('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>Nessun messaggio</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{

			if(!isset($message['user_name']))
				$userName = '<i>cancellato<i>';
			else
				$userName = '<a href="../game/index.php?a=stats&a2=viewplayer&id='.$message['receiver'].'" target=_blank>'.$message['user_name'].'</a>';

			$datum 	 = gmdate("d.m.y H:i", $message['time']+TIME_OFFSET);
			$bg 		 =	($message['rread'] == 0) ? '#e98b8b' : '#d2d9ff';

			output('<tr>
							<td width="2%"></td>
							<td width="30%" bgcolor='.$bg.'>'.$userName.'</td>
							<td width="45%" bgcolor='.$bg.'><a href="'.parse_link('p=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%" bgcolor='.$bg.'>'.$datum.'</td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $outStat['messages'], 'p=messages&a2=outbox');
	$links2 = '';

	output('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');

	output(' </center>
					</form>');

}

// archiv
function archiv()
{
	global $db;
	global $page, $perpage, $start;
	global $archStat;

	$messageList = $db->query('SELECT m.time, m.sender, m.subject, m.id,u.user_name FROM message_archiv m LEFT JOIN user u on u.user_id=m.sender WHERE (m.receiver = "'.SUPPORTUSER.'") ORDER BY m.time DESC LIMIT '.$start.', '.$perpage);


	output('<form method="post" action="'.parse_link('p=messages&a2=archiv&aremove=1').'">
	             <center>
	             <table width="90%" border="0" cellpadding="0" cellspacing="0"  class="style_inner">
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($archStat['messages'] == 0)
		output('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>Nessun messaggio</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{

			if ($message['sender'] == 0)
				$userName = '<b>System</b>';
			else if(!isset($message['user_name']))
				$userName = '<i>cancellato</i>';
			else
				$userName = '<a href="../game/index.php?a=stats&a2=viewplayer&id='.$message['sender'].'" target=_blank>'.$message['user_name'].'</a>';

			$datum 	 = gmdate("d.m.y H:i", $message['time']+TIME_OFFSET);

			output('<tr>
							<td width="2%"></td>
							<td width="30%">'.$userName.'</td>
							<td width="45%"><a href="'.parse_link('p=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%">'.$datum.'</td>
							<td width="5%"><input type="checkbox" name="message'.$i.'" value="'.$message['id'].'"></td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $archStat['messages'], 'p=messages&a2=archiv');
	$delete	= '';

	if($archStat['messages'] != 0)
		$links2 = $delete;
	else
		$links2 = "";

	output('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');

	if($archStat['messages'] != 0)
		output('<table width="90%" border="0" cellpadding="2" cellspacing="0"  class="style_inner">
					  <tr>
					   <td width="2%">&nbsp;</td>
					   <td width="96%" colspan="4">
						 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                     <td width="50%" align="left">voci selezionate</td>
                     <td width="50%" align="right"></td>
                    </tr>
					    </table>
						<td width="2%">&nbsp;</td>
						</td>
					  </tr>
					  <tr>
					   <td height="5" colspan="6"></td>
					  </tr>
					  <tr>
					   <td width="100%" colspan="6" align="center">'.$links.'</td>
					  </tr>
					  <tr>
					   <td height="5" colspan="6"></td>
					  </tr>
					  <tr>
					   <td width="100%" colspan="6" align="center">'.$links2.'</td>
					  </tr>
					 </table>');

	output(' </center>
					</form>');
}

// view
function view()
{
	global $db;

	$message = $db->queryrow('SELECT m.*,u.user_name,u2.user_name AS user_name2 FROM message m
	LEFT JOIN user u on u.user_id=m.sender
	LEFT JOIN user u2 on u2.user_id=m.receiver
	WHERE m.id = "'.(int)$_REQUEST['id'].'"');
	if ($message == false ||(($message['sender'] != SUPPORTUSER && $message['receiver'] != SUPPORTUSER))) $message = $db->queryrow('SELECT m.*,u.user_name,u2.user_name AS user_name2 FROM message_archiv m
	LEFT JOIN user u on u.user_id=m.sender
	LEFT JOIN user u2 on u2.user_id=m.receiver
	WHERE m.id = "'.(int)$_REQUEST['id'].'"');
	output('<center>
	             <table width="90%" border="0" cellpadding="0" cellspacing="0" background="'.FIXED_GFX_PATH.'skin1/template_bg3.jpg" class="border_grey">
					  <tr>
					   <td width="100%">');

	if($message == false)
		output('The message does not exist!');
	else if($message['sender'] != SUPPORTUSER && $message['receiver'] != SUPPORTUSER)
	{
		echo $message['sender'].' vs '.$message['receiver'].' vs '.SUPPORTUSER.'<br>';
		output('You don\'t have the permission to view this message!');
	}
	else
	{
		if($message['receiver'] == SUPPORTUSER)
			$db->query('UPDATE message SET rread="1" WHERE id="'.$message['id'].'"');
			UpdateUnreadMessages(SUPPORTUSER);

		if($message['sender'] == 0)
		{
			$sender = '<b>System</b>';
			$noReply = true;
		}
		else
		{
			if(!isset($message['user_name']))
			{
				$sender = '<i>cancellato<i>';
				$noReply = true;
			}
			else
			{
				$sender = '<a href="'.parse_link('p=stats&a2=viewplayer&id='.$message['sender']).'">'.$message['user_name'].'</a>';
				$noReply = false;
			}
		}

		if(!isset($message['user_name']))
			$receiver = '<i>cancellato<i>';
		else
			$receiver = '<a href="../game/index.php?a=stats&a2=viewplayer&id='.$message['receiver'].'" target=_blank>'.$message['user_name2'].'</a>';

		$datum 	= gmdate("d.m.y H:i", $message['time']+TIME_OFFSET);
		$text		= nl2br($message['text']);

		output('<center><p><span class="sub_caption2"><b>Leggi messaggio:</b></p>
						 <table width="50%" border="0" cellpadding="0" cellspacing="0"   class="style_inner">
						  <tr>
						   <td width="25%">Mittente:</td>
							<td width="75%">&nbsp;&nbsp;'.$sender.'</td>
						  </tr>
					     <tr>
						   <td width="25%">Destinatario:</td>
							<td width="75%">&nbsp;&nbsp;'.$receiver.'</td>
						  </tr>
						  <tr>
						   <td width="25%">Data:</td>
							<td width="75%">&nbsp;&nbsp;'.$datum.'</td>
						  </tr>
						  <tr>
						   <td width="25%">Titolo:</td>
							<td width="75%">&nbsp;&nbsp;'.$message['subject'].'</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2"   class="style_inner">
						  <tr>
						   <td width="100%" bgcolor=#bbbbbb>'.$text.'</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2">
						  <tr>
						   <td width="100%" align="center">');

		if(($message['sender'] != SUPPORTUSER) && ($noReply == false))
		{
			output('<table width="100%" border="0"  class="style_inner">
							 <tr>
							  <td width="50%" align="right">
							   <form method="post" action="'.parse_link('p=messages&a2=newpost').'">
							    <input type="hidden" name="id" value="'.$message['id'].'">
							    <input type="submit" style="width: 120px;" class="button" value="Rispondi">&nbsp;
							   </form>
							  </td>
							  <td width="50%" align="left">
						      <form method="post" action="'.parse_link('p=messages&a2=archiv').'">
							    <input type="hidden" name="archiv" value="'.$message['id'].'">&nbsp;
							    <input type="submit" style="width: 120px;" class="button" value="Archivia">
							   </form>
							  </td>
							 </tr>
							</table>');
		}

		output('   </td>
						  </tr>
						 </table>');

	}

	output('   </td>
					  </tr>
					 </table>
					 </center>
					</form>');
}

// newMessage
function newMessage()
{
	global $db;

	$receiver = $subject = $text = "";

	if(isset($_POST['id']))
	{
		$message = $db->queryrow('SELECT * FROM message WHERE id = "'.(int)$_REQUEST['id'].'"');

		if($message != false && $message['receiver'] == SUPPORTUSER)
		{
			$receiver = $db->queryrow('SELECT user_name FROM user WHERE user_id = "'.$message['sender'].'"');

			if($receiver != false)
			{
				$subject  = 'RE:'.$message['subject'];
				$receiver = $receiver['user_name'];
				$text = "\n\n\n---------------\n".$receiver." ha scritto:\n\n".$message['text'];
			}
		}
	}

	else
	{
		if(isset($_POST['text']))
			$text = $_POST['text'];
	 	if(isset($_POST['subject']))
			$subject = $_POST['subject'];
		if(isset($_REQUEST['receiver']))
			$receiver = $_REQUEST['receiver'];
	}

	output('<form method="post" action="'.parse_link('p=messages&a2=submitpost').'">
	             <center>
	             <table width="90%" border="0" cellpadding="1" cellspacing="1"  class="style_outer">
					  <tr>
					   <td width="100%">
						<center><p><span class="sub_caption"><b>Scrivi messaggio:</b></p>
						 <table width="65%" border="0" cellpadding="0" cellspacing="0"  class="style_inner">
					     <tr>
						   <td width="25%">Destinatario *:</td>
							<td width="75%"><input type="text" name="receiver" size="30" class="Field" value="'.$receiver.'" maxlength="900"></td>
						  </tr>
						  <tr>
						   <td width="25%">Titolo:</td>
							<td width="75%"><input type="text" name="subject" size="30" class="Field" value="'.$subject.'" maxlength="30"></td>
						  </tr>
						  <tr>
						   <td width="25%"></td>
							<td width="75%">* destinatari multipli seperati da ;</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2" class="style_inner">
						  <tr>
						   <td width="100%">Messaggio:<br><textarea name="text" class="MessageReadField" cols="75" rows="15">'.$text.'</textarea>

							</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2" class="style_inner">
						  <tr>
						   <td width="100%" align="center">
							 <input type="submit" style="width: 120px;" class="button" value="Invia">
							</td>
						  </tr>
						 </table>
						</td>
					  </tr>
					 </table></form>');
}

// submitMessage
function submitMessage()
{
	global $db;

	if(empty($_POST['text']) || empty($_POST['receiver']))
	{
		output('<center><p><span class="sub_caption">Per favore compila <u>tutti</u> i campi!</span></p></center>');
		newMessage();
	}
	else
	{
		if (empty($_POST['subject'])) $_POST['subject']='...';

		// An mehrere Empf&auml;nger schicken?
		if (strstr($_POST['receiver'],';'))
		{
			$recv_list = explode (";", str_replace(' ','',$_POST['receiver']));
			
			$num=0;
			for ($i=0; $i<count($recv_list); $i++)
			{
				$receiver = $db->queryrow('SELECT user_id FROM user WHERE user_name="'.$recv_list[$i].'"');
				if(($receiver))
				{
					$result = $db->query('INSERT INTO message (sender, receiver, subject, text, time) VALUES ("'.SUPPORTUSER.'","'.$receiver['user_id'].'","'.htmlspecialchars($_POST['subject']).'","'.htmlspecialchars($_POST['text']).'","'.time().'")');
					if($result == false)
					{
							message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
							exit();
					}
					log_action('Messaggio con il titolo "'.$_POST['subject'].'" inviato a '.$recv_list[$i]);
					UpdateUnreadMessages($receiver['user_id']);
				}
				$num++;
			}
 			output('<center><p><span class="sub_caption">Il tuo messaggio &egrave; stato inviato a '.$num.' di '.count($recv_list).' giocatori</span></p></center>');
		} // End multiple Receiver
		// 11/04/08 - AC: Add mass email
		else if ($_POST['receiver'] == '*')
		{
			$mes_qry = $db->query('SELECT user_id FROM user WHERE 1');

			while ($receiver=$db->fetchrow($mes_qry))
			{
				$result = $db->query('INSERT INTO message (sender, receiver, subject, text, time) VALUES ("'.SUPPORTUSER.'","'.$receiver['user_id'].'","'.htmlspecialchars($_POST['subject']).'","'.htmlspecialchars($_POST['text']).'","'.time().'")');
				if($result == false)
				{	
						message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
						exit();
				}
				log_action('Messaggio con il titolo "'.$_POST['subject'].'" inviato a '.$recv_list[$i]);
				UpdateUnreadMessages($receiver['user_id']);
			}
		}
		else
		{
		

		$receiver = $db->queryrow('SELECT user_id FROM user WHERE user_name="'.$_POST['receiver'].'"');
		if(($receiver) == false)
		{
			output('<center><p><span class="sub_caption">Il destinatario non esiste!</span></p></center>');
			newMessage();
		}
		else
		{
			$result = $db->query('INSERT INTO message (sender, receiver, subject, text, time) VALUES ("'.SUPPORTUSER.'","'.$receiver['user_id'].'","'.htmlspecialchars($_POST['subject']).'","'.htmlspecialchars($_POST['text']).'","'.time().'")');
			if($result == false)
			{
				message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
				exit();
			}
			log_action('Messaggio con il titolo "'.$_POST['subject'].'" inviato a '.$_POST['receiver']);
			UpdateUnreadMessages($receiver['user_id']);

			output('<center><p><span class="sub_caption">Messaggio inviato</span></p></center>');
		}

	} // End single receiver

	}
}

// navigation
function navigation_show_pagelinks($page, $perpage, $entries, $link)
{
	$pages	= (ceil($entries / $perpage)) ? ceil($entries / $perpage) : 1;
	$last		= $pages - 1;

	if($pages == 1)
		return '';

	$prev = $page - 1;
	$next = $page + 1;
	$page = $page + 1;

	$return = '<p align="center">[page '.$page.' / '.$pages.']<br>';
	if($page != 1)
	{
		if($page != $pages)
			$return .= '[<a href="'.parse_link($link.'&page=0').'">&lt;&lt;--</a>] - [<a href="'.parse_link($link.'&page='.$prev).'">&lt;-</a>] - [<a href="'.parse_link($link.'&page='.$next).'">-&gt;</a>] - [<a href="'.parse_link($link.'&page='.$last).'">--&gt;&gt;</a>]';
		else
			$return .= '[<a href="'.parse_link($link.'&page=0').'">&lt;&lt;--</a>] - [<a href="'.parse_link($link.'&page='.$prev).'">&lt;-</a>]';
	}
	elseif($page < $pages)
		$return .= '[<a href="'.parse_link($link.'&page='.$next).'">-&gt;</a>] - [<a href="'.parse_link($link.'&page='.$last).'">--&gt;&gt;</a>]';

	return $return.'</p>';
}

?>


