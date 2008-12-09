<?php
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



$game->init_player();


/** Initial Work **/

// set folder
$subAction = (!empty($_GET['a2'])) ? $_GET['a2'] : 'inbox';

// set start page
$perpage	= 20;
$page 	= (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 0;
$start 	= $page * $perpage;


if (isset($_POST['receiver'])) $_POST['receiver']=htmlspecialchars($_POST['receiver']);
if (isset($_REQUEST['receiver'])) $_REQUEST['receiver']=htmlspecialchars($_REQUEST['receiver']);


function UpdateUnreadMessages($user_id)
{
global $game, $db;
if (!($num=$db->queryrow('SELECT COUNT(id) as unread FROM message WHERE (receiver="'.$user_id.'") AND (rread=0)'))) return 0;

$db->query('UPDATE user SET unread_messages="'.$num['unread'].'" WHERE user_id="'.$user_id.'"');
if ($game->player['user_id']==$user_id) $game->player['unread_messages']=$num['unread'];
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
				$mes=$db->queryrow('SELECT * FROM message WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
				if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
			}
		}
		UpdateUnreadMessages($game->player['user_id']);
	}
	// do 'rarchiv'
	if(isset($_REQUEST['rarchiv']))
	{
		for ($i = 0; $i < $perpage; $i++)
		{
			if(isset($_POST['message'.$i.'']))
			{
				$mes=$db->queryrow('SELECT * FROM message WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
				if ($db->query('INSERT INTO message_archiv (sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
			}
		}
		UpdateUnreadMessages($game->player['user_id']);
	}

	// do 'rremoveall'
	else if(isset($_GET['rremoveall']))
	{
		$mes_qry=$db->query('SELECT * FROM message WHERE (rread = "1") AND (receiver = "'.$game->player['user_id'].'") AND sender!=0');
		while ($mes=$db->fetchrow($mes_qry))
		{
			if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
							VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
				$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
		}
	}

	// do 'rremoverequest'
	else if(isset($_GET['srremoverequest'])) {
		$game->out('<div align="center"><b>'.constant($game->sprache("TEXT3")).'</b><br><br>[<a href="'.parse_link('a=messages&srremoveall=1').'"><b>'.constant($game->sprache("TEXT1")).'</b></a>]&nbsp;&nbsp;[<a href="'.parse_link('a=messages').'"><b>'.constant($game->sprache("TEXT2")).'</b></a>]</div><br><br>');

	} 
 
	// do 'srremoveall'
	else if(isset($_GET['srremoveall']))
	{
		$mes_qry=$db->query('SELECT * FROM message WHERE (rread = "1") AND (receiver = "'.$game->player['user_id'].'") AND sender=0');
		while ($mes=$db->fetchrow($mes_qry))
		{
			if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
							VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
				$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
		}
	}

	// do 'srremoverequest'
	else if(isset($_GET['rremoverequest'])) {
		$game->out('<div align="center"><b>'.constant($game->sprache("TEXT0")).'</b><br><br>[<a href="'.parse_link('a=messages&rremoveall=1').'"><b>'.constant($game->sprache("TEXT1")).'</b></a>]&nbsp;&nbsp;[<a href="'.parse_link('a=messages').'"><b>'.constant($game->sprache("TEXT2")).'</b></a>]</div><br><br>');

	}

	// do 'rmarkall'
	else if(isset($_GET['rmarkall']))
	{
		$db->query('UPDATE message SET rread = "1" WHERE receiver = "'.$game->player['user_id'].'"');
		UpdateUnreadMessages($game->player['user_id']);
	}
}


/** outbox actions ARE NOT SUPPORTED ANYMORE DUE TO OVERHEAD**/
/*
else if($subAction == 'outbox')
{
	// do 'sremove'
	if(isset($_GET['sremove']))
	{
		for ($i = 0; $i < $perpage; $i++)
		{
			if(isset($_POST['message'.$i.'']))
				$db->query('UPDATE message SET sdelete = "1" WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (sender = "'.$game->player->data['user_id'].'")');
		}
	}

	// do 'sremoveall'
	else if(isset($_GET['sremoveall']))
	{
		$db->query('UPDATE message SET sdelete = "1" WHERE (sdelete= "0") AND (sender = "'.$game->player->data['user_id'].'")');
	}
}

*/
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
				$mes=$db->queryrow('SELECT * FROM message_archiv WHERE (id = "'.(int)$_POST['message'.$i.''].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
				if ($db->query('INSERT INTO message_removed ( sender, receiver, subject, text, time)
								VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.addslashes($mes['text']).'", '.$mes['time'].')'))
					$db->queryrow('DELETE FROM message_archiv WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
			}
		}
	}

	// do 'aremoveall'
	else if(isset($_GET['aremoveall']))
	{
		$mes_qry=$db->query('SELECT * FROM message_archiv WHERE (receiver = "'.$game->player['user_id'].'")');
		while ($mes=$db->fetchrow($mes_qry))
		{
			if ($db->query('INSERT INTO message_removed (sender, receiver, subject, text, time)
							VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.$mes['text'].'", '.$mes['time'].')')!=false)
				$db->query('DELETE FROM message_archiv WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
		}
	}

	// do 'arremoverequest'
	else if(isset($_GET['aremoverequest'])) {

		$game->out('<div align="center"><b>'.constant($game->sprache("TEXT43")).'</b><br><br>[<a href="'.parse_link('a=messages&aremoveall=1').'"><b>'.constant($game->sprache("TEXT1")).'</b></a>]&nbsp;&nbsp;[<a href="'.parse_link('a=messages').'"><b>'.constant($game->sprache("TEXT2")).'</b></a>]</div><br><br>');

	}

	// do 'archiv'
	else if(isset($_POST['archiv']))
	{
		$mes=$db->queryrow('SELECT * FROM message WHERE (id = "'.(int)$_POST['archiv'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
		if ($db->query('INSERT INTO message_archiv (sender, receiver, subject, text, time)
						VALUES ('.$mes['sender'].', '.$mes['receiver'].', "'.$mes['subject'].'", "'.$mes['text'].'", '.$mes['time'].')'))
			$db->queryrow('DELETE FROM message WHERE (id = "'.$mes['id'].'") AND (receiver = "'.$game->player['user_id'].'") LIMIT 1');
		UpdateUnreadMessages($game->player['user_id']);
	}
}


/** get stats **/

// inbox
//$inStat['unreadMessages'] = $game->player['unread_messages'];

$inStatList= $db->query('SELECT count(id) as "unreadMessages" FROM message WHERE (receiver = "'.$game->player['user_id'].'") AND 
sender != 0 AND rread = 0');
$inStat		= $db->fetchrow($inStatList);

$inStat2List= $db->query('SELECT count(id) as "messages" FROM message WHERE (receiver = "'.$game->player['user_id'].'") AND 
sender != 0');
$inStat2		= $db->fetchrow($inStat2List);
$inStat['messages'] = $inStat2['messages'];

//systembox
$sysStatListunr	= $db->query('SELECT count(id) as "messages" FROM message WHERE (receiver="'.$game->player['user_id'].'") AND sender = 0 AND rread = 0');
$sysStatunr		= $db->fetchrow($sysStatListunr);

$sysStatList	= $db->query('SELECT count(id) as "messages" FROM message WHERE (receiver="'.$game->player['user_id'].'") AND sender = 0');
$sysStat		= $db->fetchrow($sysStatList);

// archiv
$archStatList	= $db->query('SELECT count(id) as "messages" FROM message_archiv WHERE (receiver="'.$game->player['user_id'].'")');
$archStat		= $db->fetchrow($archStatList);

// outbox
$outStatList	= $db->query('SELECT count(id) as "messages" FROM message WHERE (sender="'.$game->player['user_id'].'")');
$outStat		= $db->fetchrow($outStatList);


/* Javascript for multiselection */

$game->out('
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function flevToggleCheckboxes() { // v1.1
	// Copyright 2002, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
	var sF = arguments[0], bT = arguments[1], bC = arguments[2], oF = MM_findObj(sF);
    for (var i=0; i<oF.length; i++) {
		if (oF[i].type == "checkbox") {if (bT) {oF[i].checked = !oF[i].checked;} else {oF[i].checked = bC;}}} 
}
//-->
</script>
');


/** main **/

$game->out('<span class="caption">'.constant($game->sprache("TEXT4")).'</span><br><br>');

$game->out('
	  <table width="90%" border=0 cellpadding=2 cellspacing=2 class="style_inner">
	   <tr>
		 <td width="20%" align="center"><span style="font-family:Arial,serif;font-size:9pt;"><a 
href="'.parse_link('a=messages&a2=inbox').'"><b>'.constant($game->sprache("TEXT5")).( ($inStat['unreadMessages']>0) ? '<span style="color: #FF0000; font-weight: bold;"> ('.$inStat['unreadMessages'].'/'.$inStat['messages'].')</span>' : ' ('.$inStat['unreadMessages'].'/'.$inStat['messages'].')' ).'</a></span></td>
		 <td width="20%" align="center"><span style="font-family:Arial,serif;font-size:9pt;"><a 
href="'.parse_link('a=messages&a2=systembox').'"><b>'.constant($game->sprache("TEXT6")).( ($sysStatunr['messages']>0) ? '<span style="color: #FF0000; font-weight: bold;"> ('.$sysStatunr['messages'].'/'.$sysStat['messages'].')</span>' : ' ('.$sysStatunr['messages'].'/'.$sysStat['messages'].')' ).'</b></a></span></td>
		 <td width="20%" align="center"><span style="font-family:Arial,serif;font-size:9pt;"><a 
href="'.parse_link('a=messages&a2=outbox').'"><b>'.constant($game->sprache("TEXT7")).'</a></span></td>
		 <td width="20%" align="center"><span style="font-family:Arial,serif;font-size:9pt;"><a 
href="'.parse_link('a=messages&a2=archiv').'"><b>'.constant($game->sprache("TEXT8")).'('.$archStat['messages'].')</a></span></td>
		 <td width="20%" align="center"><span style="font-family:Arial,serif;font-size:9pt;"><a 
href="'.parse_link('a=messages&a2=newpost').'"><b>'.constant($game->sprache("TEXT9")).'</a></span></td>
		</tr>
	  </table>

	 <br>');

if ($subAction == 'inbox') inbox();
else if ($subAction == 'systembox') systembox();
else if ($subAction == 'outbox') outbox();
else if ($subAction == 'archiv') archiv();
else if ($subAction == 'view') view();
else if ($subAction == 'newpost') newMessage();
else if ($subAction == 'submitpost') submitMessage();
else if ($subAction == 'remove_message') remove_message();



/** functions **/

// inbox
function inbox()
{
	global $db, $game;
	global $page, $perpage, $start;
	global $inStat;

	$messageList = $db->query('SELECT m.rread, m.time, m.sender, m.subject, m.id, u.user_name FROM (message m) LEFT JOIN (user 
u) on u.user_id=m.sender WHERE (m.receiver = "'.$game->player['user_id'].'") AND sender != 0 ORDER BY m.time DESC LIMIT '.$start.', 
'.$perpage);


	$game->out('<form method="post" action="'.parse_link('a=messages&a2=inbox').'" name="messages">
	             <table width="90%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
					  <tr>
							<td width="2%"></td>
							<td width="30%"><b>'.constant($game->sprache("TEXT24")).'</b></td>
							<td width="45%"><b>'.constant($game->sprache("TEXT27")).'</b></td>
							<td width="19%"><b>'.constant($game->sprache("TEXT26")).'</b></td>
							<td width="5%"><input name="check1" type="checkbox" onClick="flevToggleCheckboxes(\'messages\',true,false)"></td>
							<td width="2%"></td>
					  <tr>
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($inStat['messages'] == 0)
		$game->out('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>'.constant($game->sprache("TEXT10")).'</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{
			if ($message['sender'] == 0)
				$userName = '<b><font color="yellow">'.constant($game->sprache("TEXT11")).'</font></b>';
			else
			if($message['sender'] == SUPPORTUSER)
				$userName = '<b><font color="yellow">'.constant($game->sprache("TEXT12")).'</font></b>';
			else if(!isset($message['user_name']))
				$userName = '<i>'.constant($game->sprache("TEXT18")).'</i>';
			else
				$userName = '<a href="'.parse_link('a=stats&a2=viewplayer&id='.$message['sender']).'">'.$message['user_name'].'</a>';

			$bg 		 =	($message['rread'] == 0) ? '#aa1c47' : '#131c47';
			$datum 	 = date('d.m.y H:i', ($message['time']));

			$game->out('<tr>
							<td width="2%"></td>
							<td width="30%" bgcolor='.$bg.'>'.$userName.'</td>
							<td width="45%" bgcolor='.$bg.'><a href="'.parse_link('a=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%" bgcolor='.$bg.'>'.$datum.'</td>
							<td width="5%" bgcolor='.$bg.'><input type="checkbox" name="message'.$i.'" value="'.$message['id'].'"></td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $inStat['messages'], 'a=messages&a2=inbox');
	$mark		= '<a href="'.parse_link('a=messages&rmarkall=1').'">'.constant($game->sprache("TEXT13")).'</a>';
	$delete	= '<a href="'.parse_link('a=messages&rremoverequest=1').'">'.constant($game->sprache("TEXT14")).'</a>';

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

	$game->out('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');

	if($inStat['messages'] != 0)
		$game->out('<table width="90%" border="0" cellpadding="2" cellspacing="0" class="style_outer">
					  <tr>
					   <td width="2%">&nbsp;</td>
					   <td width="96%" colspan="4">
						 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
                    <tr>
                     <td width="50%" align="left">'.constant($game->sprache("TEXT15")).'</td>
                     <td width="50%" align="right"><input style="width: 120px;" type="submit" name="rremove" class="button" value="'.constant($game->sprache("TEXT16")).'"><br><input style="width: 120px;" type="submit" class="button" name="rarchiv" value="'.constant($game->sprache("TEXT17")).'"></td>
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

	$game->out('	</form>');
}

//systembox
function systembox()
{

	global $db, $game;
	global $page, $perpage, $start;
	global $sysStat, $sysStatunr;

	$messageList = $db->query('SELECT m.rread, m.time, m.sender, m.subject, m.id, u.user_name FROM (message m) LEFT JOIN (user 
u) on u.user_id=m.sender WHERE (m.receiver = "'.$game->player['user_id'].'") AND sender=0 ORDER BY m.time DESC');


	$game->out('<form method="post" action="'.parse_link('a=messages&a2=inbox').'" name="sysmessages">
	             <table width="90%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
					  <tr>
							<td width="2%"></td>
							<td width="30%"><b>'.constant($game->sprache("TEXT24")).'</b></td>
							<td width="45%"><b>'.constant($game->sprache("TEXT27")).'</b></td>
							<td width="19%"><b>'.constant($game->sprache("TEXT26")).'</b></td>
							<td width="5%"><input name="check1" type="checkbox" onClick="flevToggleCheckboxes(\'sysmessages\',true,false)"></td>
							<td width="2%"></td>
					  <tr>
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($sysStat['messages'] == 0)
		$game->out('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>'.constant($game->sprache("TEXT10")).'</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{
			if ($message['sender'] == 0)
				$userName = '<b><font color="yellow">'.constant($game->sprache("TEXT11")).'</font></b>';
			else
			if($message['sender'] == SUPPORTUSER)
				$userName = '<b><font color="yellow">'.constant($game->sprache("TEXT12")).'</font></b>';
			else if(!isset($message['user_name']))
				$userName = '<i>'.constant($game->sprache("TEXT18")).'</i>';
			else
				$userName = '<a 
href="'.parse_link('a=stats&a2=viewplayer&id='.$message['sender']).'">'.$message['user_name'].'</a>';

			$bg 		 =	($message['rread'] == 0) ? '#aa1c47' : '#131c47';
			$datum 	 = date('d.m.y H:i', ($message['time']));

			$game->out('<tr>
							<td width="2%"></td>
							<td width="30%" bgcolor='.$bg.'>'.$userName.'</td>
							<td width="45%" bgcolor='.$bg.'><a 
href="'.parse_link('a=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%" bgcolor='.$bg.'>'.$datum.'</td>
							<td width="5%" bgcolor='.$bg.'><input type="checkbox" name="message'.$i.'" 
value="'.$message['id'].'"></td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $inStat['messages'], 'a=messages&a2=inbox');
	$mark		= '<a href="'.parse_link('a=messages&rmarkall=1').'">'.constant($game->sprache("TEXT13")).'</a>';
	$delete	= '<a href="'.parse_link('a=messages&srremoverequest=1').'">'.constant($game->sprache("TEXT19")).'</a>';

	if($sysStatunr['unreadMessages'] != 0)
	{
		$links2 = $mark;
		if($sysStat['messages'] != 0)
			$links2 .= '<br>'.$delete;
	}
	else if($sysStat['messages'] != 0)
		$links2 = $delete;
	else
		$links2 = "";

	$game->out('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');

	if($sysStat['messages'] != 0)
		$game->out('<table width="90%" border="0" cellpadding="2" cellspacing="0" class="style_outer">
					  <tr>
					   <td width="2%">&nbsp;</td>
					   <td width="96%" colspan="4">
						 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
                    <tr>
                     <td width="50%" align="left">'.constant($game->sprache("TEXT15")).'</td>
                     <td width="50%" align="right"><input style="width: 120px;" type="submit" name="rremove" class="button" 
value="'.constant($game->sprache("TEXT16")).'"><br><input style="width: 120px;" type="submit" class="button" name="rarchiv" value="'.constant($game->sprache("TEXT17")).'"></td>
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

	$game->out('	</form>');

}


// outbox
function outbox()
{
	global $db, $game;
	global $page, $perpage, $start;
	global $outStat;
	$messageList = $db->query('SELECT m.rread, m.time, m.receiver, m.subject, m.id, m.sender, u.user_name FROM (message m) LEFT JOIN (user u) on u.user_id=m.receiver WHERE (m.sender = "'.$game->player['user_id'].'") ORDER BY m.time DESC LIMIT '.$start.', '.$perpage);
//    $outStat['messages'] = $db->num_rows();
	$game->out('<form method="post" action="'.parse_link('a=messages&a2=outbox&sremove=1').'">
	             <table width="90%" border="0" cellpadding="0" cellspacing="0" class="style_inner">
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($outStat['messages'] == 0)
		$game->out('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>'.constant($game->sprache("TEXT10")).'</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{
			if ($message['receiver'] == SUPPORTUSER)
				$userName = '<b><font color=yellow>'.constant($game->sprache("TEXT12")).'</font></b>';
			else if(!isset($message['user_name']))
				$userName = '<i>'.constant($game->sprache("TEXT18")).'<i>';
			else
				$userName = '<a href="'.parse_link('a=stats&a2=viewplayer&id='.$message['receiver']).'">'.$message['user_name'].'</a>';

			$datum 	 = date("d.m.y H:i", $message['time']);
			$bg 		 =	($message['rread'] == 0) ? '#aa1c47' : '#131c47';

			$game->out('<tr>
							<td width="2%"></td>
							<td width="30%" bgcolor='.$bg.'>'.$userName.'</td>
							<td width="45%" bgcolor='.$bg.'><a href="'.parse_link('a=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%" bgcolor='.$bg.'>'.$datum.'</td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $outStat['messages'], 'a=messages&a2=outbox');
	$links2 = '';

	$game->out('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');



	if($outStat['messages'] != 0)
		$game->out('<table width="90%" border="0" cellpadding="2" cellspacing="0" class="style_outer">
					  <tr>
					   <td width="100%" align="center">'.$links.'</td>
					  </tr>
					 </table>');


	$game->out('	</form>');

}

// archiv
function archiv()
{
	global $db, $game;
	global $page, $perpage, $start;
	global $archStat;

	$messageList = $db->query('SELECT m.time, m.sender, m.subject, m.id,u.user_name FROM (message_archiv m) LEFT JOIN (user u) on u.user_id=m.sender WHERE (m.receiver = "'.$game->player['user_id'].'") ORDER BY m.time DESC LIMIT '.$start.', '.$perpage);


	$game->out('<form method="post" action="'.parse_link('a=messages&a2=archiv&aremove=1').'" name="archmessages">
	             <table width="90%" border="0" cellpadding="0" cellspacing="0"  class="style_inner">
					  <tr>
							<td width="2%"></td>
							<td width="30%"><b>'.constant($game->sprache("TEXT24")).'</b></td>
							<td width="45%"><b>'.constant($game->sprache("TEXT27")).'</b></td>
							<td width="19%"><b>'.constant($game->sprache("TEXT26")).'</b></td>
							<td width="5%"><input name="check1" type="checkbox" onClick="flevToggleCheckboxes(\'archmessages\',true,false)"></td>
							<td width="2%"></td>
					  <tr>
					  <tr>
					   <td height="6" colspan="6"></td>
					  </tr>');

	if($archStat['messages'] == 0)
		$game->out('<tr>
						 <td width="2%"></td>
					    <td colspan="4"><i>'.constant($game->sprache("TEXT10")).'</i></td>
						 <td width="2%"></td>
					   </tr>');
	else
		for($i = 0; ($message = $db->fetchrow($messageList)) == true; $i++)
		{

			if ($message['sender'] == 0)
				$userName = '<b>'.constant($game->sprache("TEXT11")).'</b>';
			else if ($message['sender'] == SUPPORTUSER)
				$userName = '<b><font color=yellow>'.constant($game->sprache("TEXT12")).'</font></b>';
			else if(!isset($message['user_name']))
				$userName = '<i>'.constant($game->sprache("TEXT18")).'</i>';
			else
				$userName = '<a href="'.parse_link('a=stats&a2=viewplayer&id='.$message['sender']).'">'.$message['user_name'].'</a>';

			$datum 	 = date("d.m.y H:i", $message['time']);

			$game->out('<tr>
							<td width="2%"></td>
							<td width="30%">'.$userName.'</td>
							<td width="45%"><a href="'.parse_link('a=messages&a2=view&id='.$message['id']).'">'.$message['subject'].'</a></td>
							<td width="19%">'.$datum.'</td>
							<td width="5%"><input type="checkbox" name="message'.$i.'" value="'.$message['id'].'"></td>
							<td width="2%"></td>
							</tr>
							<tr>
							<td height="2" colspan="6"></td>
							</tr>');
		}

	$links 	= navigation_show_pagelinks($page, $perpage, $archStat['messages'], 'a=messages&a2=archiv');
	$delete	= '<a href="'.parse_link('a=messages&a2=archiv&aremoverequest=1').'">'.constant($game->sprache("TEXT20")).'</a>';

	if($archStat['messages'] != 0)
		$links2 = $delete;
	else
		$links2 = "";

	$game->out('  <tr>
					   <td height="3" colspan="6"></td>
					  </tr>
				    </table>
					 <br>');

	if($archStat['messages'] != 0)
		$game->out('<table width="90%" border="0" cellpadding="2" cellspacing="0"  class="style_inner">
					  <tr>
					   <td width="2%">&nbsp;</td>
					   <td width="96%" colspan="4">
						 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                     <td width="50%" align="left">'.constant($game->sprache("TEXT15")).'</td>
                     <td width="50%" align="right"><input style="width: 120px;" type="submit" class="button" value="'.constant($game->sprache("TEXT16")).'"></td>
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

	$game->out('	</form>');
}
function remove_message(){
       global $db, $game;

       if($_POST['check']==1) {

       $remove_id = $_POST['id'];

       $sql = 'DELETE FROM message WHERE id = '.$remove_id.' AND receiver = '.$game->player['user_id'];

         if(!$db->query($sql)) {
         message(DATABASE_ERROR, 'Could not delete message');
       }
       redirect('a=messages&a2=inbox');
       }

       else {
       $remove_id = $_POST['id'];

       $game->out(constant($game->sprache("TEXT21")).'<br><br><form action="'.parse_link('a=messages&a2=remove_message').'" method="post"><input type="hidden" name="id" value="'.$remove_id.'">&nbsp;
                                                  <input class="button" name="cancel" value="&lt;&lt; '.constant($game->sprache("TEXT22")).'" onclick="return window.history.back();" type="button">&nbsp;<input type="hidden" name="check" value="1"><input type="submit" class="button" value="'.constant($game->sprache("TEXT1")).'"></form>');

       }
}

// view
function view()
{
	global $db, $game, $config;

	$message = $db->queryrow('SELECT m.*,u.user_name,u2.user_name AS user_name2 FROM (message m)
	LEFT JOIN (user u) on u.user_id=m.sender
	LEFT JOIN (user u2) on u2.user_id=m.receiver
	WHERE m.id = "'.(int)$_REQUEST['id'].'"');
	if ($message == false ||(($message['sender'] != $game->player['user_id'] && $message['receiver'] != $game->player['user_id']))) $message = $db->queryrow('SELECT m.*,u.user_name,u2.user_name AS user_name2 FROM (message_archiv m)
	LEFT JOIN (user u) on u.user_id=m.sender
	LEFT JOIN (user u2) on u2.user_id=m.receiver
	WHERE m.id = "'.(int)$_REQUEST['id'].'"');
	$game->out('<table width="90%" border="0" cellpadding="0" cellspacing="0" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
					  <tr>
					   <td width="100%" align="center">');

	if($message == false)
		$game->out('The message does not exist!');
	else if($message['sender'] != $game->player['user_id'] && $message['receiver'] != $game->player['user_id'])
	{
		echo $message['sender'].' vs '.$message['receiver'].' vs '.$game->player['user_id'].'<br>';
		$game->out('You don\'t have the permission to view this message!');
	}
	else
	{
		if($message['receiver'] == $game->player['user_id'])
			$db->query('UPDATE message SET rread="1" WHERE id="'.$message['id'].'"');
			UpdateUnreadMessages($game->player['user_id']);

		if($message['sender'] == 0)
		{
			$sender = '<b><font color="yellow">'.constant($game->sprache("TEXT11")).'</font></b>';
			$noReply = true;
		}
		else
		if($message['sender'] == SUPPORTUSER)
		{
			$sender = '<b><font color="yellow">'.constant($game->sprache("TEXT12")).'</font></b>';
		}
		else
		{
			if(!isset($message['user_name']))
			{
				$sender = '<i>'.constant($game->sprache("TEXT18")).'<i>';
				$noReply = true;
			}
			else
			{
				$sender = '<a href="'.parse_link('a=stats&a2=viewplayer&id='.$message['sender']).'">'.$message['user_name'].'</a>';
				$noReply = false;
			}
		}

		if(!isset($message['user_name2']))
			$receiver = '<i>'.constant($game->sprache("TEXT18")).'<i>';
		else
			$receiver = '<a href="'.parse_link('a=stats&a2=viewplayer&id='.$message['receiver']).'">'.$message['user_name2'].'</a>';

		$datum 	= date("d.m.y H:i", $message['time']);
		$text		= nl2br($message['text']);

		$game->out('<p><span class="sub_caption2"><b>'.constant($game->sprache("TEXT23")).' [<a href="'.$config['game_url'].'/game2/include/pdf_gen.php?id='.(int)$_REQUEST['id'].'" target="_blank"> PDF </a>]:</b></p>
						 <table width="50%" border="0" cellpadding="0" cellspacing="0"   class="style_inner">
						  <tr>
						   <td width="25%">'.constant($game->sprache("TEXT24")).':</td>
							<td width="75%">&nbsp;&nbsp;'.$sender.'</td>
						  </tr>
						  <tr>
						   <td width="25%">'.constant($game->sprache("TEXT25")).'</td>
							<td width="75%">&nbsp;&nbsp;'.$receiver.'</td>
						  </tr>
						  <tr>
						   <td width="25%">'.constant($game->sprache("TEXT26")).':</td>
							<td width="75%">&nbsp;&nbsp;'.$datum.'</td>
						  </tr>
						  <tr>
						   <td width="25%">'.constant($game->sprache("TEXT27")).':</td>
							<td width="75%">&nbsp;&nbsp;'.$message['subject'].'</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2"   class="style_inner">
						  <tr>
						   <td width="100%">'.$text.'</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2">
						  <tr>
						   <td width="100%" align="center">');

		if(($message['sender'] != $game->player['user_id']) && ($noReply == false))
		{
			$game->out('<table width="100%" border="0"  class="style_inner">
							 <tr>
							  <td width="33%" align="left">
							   <form method="post" action="'.parse_link('a=messages&a2=newpost').'">
							    <input type="hidden" name="id" value="'.$message['id'].'">
							    <input type="submit" style="width: 120px;" class="button" value="'.constant($game->sprache("TEXT28")).'">&nbsp;
							   </form>
							  </td>
							  <td width="33%" align="center">
						      <form method="post" action="'.parse_link('a=messages&a2=archiv').'">
							    <input type="hidden" name="archiv" value="'.$message['id'].'">&nbsp;
							    <input type="submit" style="width: 120px;" class="button" value="'.constant($game->sprache("TEXT17")).'">
							   </form>
                                                   <td width="33%" align="right">
                                                   <form method="post" action="'.$config['game_url'].'/game2/include/pdf_down.php">
                                                   <input type="hidden" name="id" value="'.$message['id'].'">&nbsp;
                                                   <input type="hidden" name="check" value="0">&nbsp;
                                                   <input type="submit" style="width: 120px;" class="button" value="'.constant($game->sprache("TEXT29")).'">
                                                   </form>
							  </td>
							 </tr>
                                                 <tr><td>&nbsp;</td><td width="33%" align="center">
                                                   <form method="post" action="'.parse_link('a=messages&a2=remove_message').'">
                                                   <input type="hidden" name="id" value="'.$message['id'].'">&nbsp;
                                                   <input type="submit" style="width: 120px;" class="button" value="'.constant($game->sprache("TEXT30")).'">
                                                   </form>
							  </td></tr>
							</table>');
		}

		$game->out('   </td>
						  </tr>
						 </table>');

	}

	$game->out('   </td>
					  </tr>
					 </table>
					</form>');


}

// newMessage
function newMessage()
{
	global $db, $game;

	$receiver = $subject = $text = "";

	if(isset($_POST['id']))
	{
		$message = $db->queryrow('SELECT * FROM message WHERE id = "'.(int)$_REQUEST['id'].'"');

		if($message != false && $message['receiver'] == $game->player['user_id'])
		{
			if ($message['sender']==SUPPORTUSER)
				$receiver['user_name']='STFC-Support';
			else
				$receiver = $db->queryrow('SELECT user_name FROM user WHERE user_id = "'.$message['sender'].'"');
			
			if($receiver != false)
			{
				$subject  = 'RE:'.$message['subject'];
				$receiver = $receiver['user_name'];
				$text = "\n\n\n---------------\n".$receiver." wrote:\n\n".$message['text'];
			}
		}
	}

	else
	{
		if(isset($_POST['text']))
			$text = $_POST['text'];
	 	if(isset($_REQUEST['subject']))
			$subject = $_REQUEST['subject'];
		if(isset($_REQUEST['receiver']))
			$receiver = $_REQUEST['receiver'];
	}

	$game->out('<form method="post" action="'.parse_link('a=messages&a2=submitpost').'">
	             <table width="90%" border="0" cellpadding="1" cellspacing="1"  class="style_outer">
					  <tr>
					   <td width="100%" align="center">
						<p><span class="sub_caption"><b>'.constant($game->sprache("TEXT31")).'</b></p>
						 <table width="65%" border="0" cellpadding="0" cellspacing="0"  class="style_inner">
					     <tr>
						   <td width="25%">'.constant($game->sprache("TEXT32")).'</td>
							<td width="75%"><input type="text" name="receiver" size="30" class="Field" value="'.$receiver.'" maxlength="900"></td>
						  </tr>
						  <tr>
						   <td width="25%">'.constant($game->sprache("TEXT27")).':</td>
							<td width="75%"><input type="text" name="subject" size="30" class="Field" value="'.$subject.'" maxlength="30"></td>
						  </tr>
						  <tr>
						   <td width="25%"></td>
							<td width="75%">'.constant($game->sprache("TEXT33")).'</td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2" class="style_inner">
						  <tr>
						   <td width="100%">'.constant($game->sprache("TEXT34")).'<br><textarea name="text" class="MessageReadField" cols="75" rows="15">'.$text.'</textarea>

						 <br>
						   '.constant($game->sprache("TEXT35")).'<br><textarea name="message_sig" class="MessageReadField" cols="75" rows="3">'.$game->player['user_signature'].'</textarea></td>
						  </tr>
						 </table>
						 <br>
						 <table width="75%" border="0" cellpadding="2" cellspacing="2" class="style_inner">
						  <tr>
						   <td width="100%" align="center">
							 <input type="submit" style="width: 120px;" class="button" value="'.constant($game->sprache("TEXT36")).'">
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
	global $db, $game;

	if(empty($_POST['text']) || empty($_POST['receiver']))
	{
		$game->out('<p><span class="sub_caption">'.constant($game->sprache("TEXT37")).'</span></p>');
		newMessage();
	}
	else
	{
		if (empty($_POST['subject'])) $_POST['subject']='...';

		// Send to multiple recipients?
		if (strstr($_POST['receiver'],';'))
		{
			$result = $db->query('UPDATE user SET user_message_sig="'.htmlspecialchars($_POST['message_sig']).'" WHERE user_id='.$game->player['user_id']);
			
 			$game->player['user_message_sig']=htmlspecialchars($_POST['message_sig']);
			if($result == false)
			{
				message(DATABASE_ERROR, 'message_query: Could not call update user sig');
				exit();
			}


			$recv_list = explode (";", str_replace(' ','',$_POST['receiver']));
			//echo $_POST['receiver'].'<br><br>';
			//print_r($recv_list);
			
			$num=0;
			for ($i=0; $i<count($recv_list); $i++)
			{
			if (strtolower($recv_list[$i])==strtolower('STFC-Support'))
				$receiver['user_id']=SUPPORTUSER;
			else
				$receiver = $db->queryrow('SELECT user_id FROM user WHERE user_name="'.$recv_list[$i].'"');
			if(($receiver))
			{
				$result = $db->query('INSERT INTO message (sender, receiver, subject, text, time) VALUES ("'.$game->player['user_id'].'","'.$receiver['user_id'].'","'.htmlspecialchars($_POST['subject']).'","'.htmlspecialchars($_POST['text']).'\n\n'.$game->player['user_message_sig'].'","'.time().'")');
				if($result == false)
				{	
						message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
						exit();
				}
				
			UpdateUnreadMessages($receiver['user_id']);

			
			}
			$num++;
			}
 			$game->out('<p><span class="sub_caption">'.constant($game->sprache("TEXT38")).' '.$num.' '.constant($game->sprache("TEXT39")).' '.count($recv_list).' '.constant($game->sprache("TEXT40")).'</span></p>');
			
			
		} // End multiple Receiver
		else
		{
		
				$result = $db->query('UPDATE user SET user_message_sig="'.htmlspecialchars($_POST['message_sig']).'" WHERE user_id='.$game->player['user_id']);
   			$game->player['user_message_sig']=htmlspecialchars($_POST['message_sig']);
			if($result == false)
			{
				message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
				exit();
			}
  		if (strtolower($_POST['receiver'])==strtolower('STFC-Support'))
			$receiver['user_id']=SUPPORTUSER;
		else
			$receiver = $db->queryrow('SELECT user_id FROM user WHERE user_name="'.htmlspecialchars($_POST['receiver']).'"');
		if(($receiver) == false)
		{
			$game->out('<p><span class="sub_caption">'.constant($game->sprache("TEXT41")).'</span></p>');
			newMessage();
		}
		else
		{
			$result = $db->query('INSERT INTO message (sender, receiver, subject, text, time) VALUES ("'.$game->player['user_id'].'","'.$receiver['user_id'].'","'.htmlspecialchars($_POST['subject']).'","'.htmlspecialchars($_POST['text']).'\n\n'.$game->player['user_message_sig'].'","'.time().'")');
			if($result == false)
			{
				message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
				exit();
			}
			UpdateUnreadMessages($receiver['user_id']);

  			$game->out('<p><span class="sub_caption">'.constant($game->sprache("TEXT42")).'</span></p>');
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

