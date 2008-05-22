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


//include('user_diplomacy.sprache.php');
$game->init_player();
$game->out('<center><span class="caption">'.(constant($game->sprache("TEXT1"))).'</span><br><br>');
global $RACE_DATA;
//Tobis spezial, ja mojo reg dich ab a=stats&a2=player_ranking&a3=1
if((!empty($_POST['searcher'])))
{
    $game->out('
<table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="4">
  <form method="post" action="'.parse_link('a=user_diplomacy').'">
  <tr>
    <td align="left">
      <b>'.(constant($game->sprache("TEXT2"))).'</b><br><br>
      '.(constant($game->sprache("TEXT3"))).'&nbsp;&nbsp;<input class="field" type="text" name="user2_name" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" name="searcher" value="'.(constant($game->sprache("TEXT4"))).'">
</td></tr><tr><td align="center"><input class="button" type="button" value="'.(constant($game->sprache("TEXT5"))).'" onClick="return window.history.back();">&nbsp;&nbsp;&nbsp;<input class="button" type="submit" name="new_submit" value="'.(constant($game->sprache("TEXT6"))).'">    </td>  </tr></form></table>');
$game->out('<br><center><table boder=0 cellpadding=2 cellspacing=2 class="style_inner" width=300><tr>
<td width=150><b>'.(constant($game->sprache("TEXT7"))).'</b></td>
</tr>
<tr>
<td width=150>
<b>'.(constant($game->sprache("TEXT8"))).'</b>
</td>
<td width=150>
<b>'.(constant($game->sprache("TEXT9"))).'</b>
</td>
<td width=100>
<b>'.(constant($game->sprache("TEXT10"))).'</b>
</td>
<td width=75>
<b>'.(constant($game->sprache("TEXT11"))).'</b>
</td>
</tr>');
$search_sonder=$db->query('SELECT u.user_name,u.user_race,a.alliance_tag,a.alliance_name,s.id FROM (user u) LEFT JOIN (alliance a) ON a.alliance_id=u.user_alliance LEFT JOIN (spenden s) ON s.name=u.user_name  WHERE u.user_name LIKE "%'.$_POST['user2_name'].'%" ORDER by u.user_name ASC');
while (($user_cc = $db->fetchrow($search_sonder)) != false)
{
$game->out('
<tr>
<td width=150>'.$user_cc['user_name'].'</td>
<td>'.$RACE_DATA[$user_cc['user_race']][0].'</td><td><a href="'.parse_link('a=stats&a2=viewalliance&id='.$user_cc['alliance_name'].'').'">'.$user_cc['alliance_name'].'</a>');
$game->out('</td>
<td>
'.$user_cc['user_points'].'
</td>
<td><form method="post" action="'.parse_link('a=user_diplomacy').'"><input type="hidden" name="user2_name" value="'.$user_cc['user_name'].'"><input class="button" type="submit" name="new_submit" value="'.(constant($game->sprache("TEXT12"))).'"></form></td>
</tr>
');
}
$game->out('</table></center><br>');
}
if( (!empty($_POST['new_submit'])) || (!empty($_GET['suggest'])) ) {
    if(!empty($_GET['suggest'])) {
        $user2_id = (int)$_GET['suggest'];
        
        $sql = 'SELECT user_id
                FROM user
                WHERE user_id = '.$user2_id;
    }
    else {
        $user2_name = addslashes($_POST['user2_name']);
	if($_POST['search']!="")
{

}
      if(empty($user2_name)) {
            message(NOTICE, constant($game->sprache("TEXT13")));
        }
        
        $sql = 'SELECT user_id
                FROM user
                WHERE user_name = "'.$user2_name.'"';
    }
            
    if(($user2 = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user2 data');
    }
    
    if(empty($user2['user_id'])) {
        message(NOTICE, constant($game->sprache("TEXT14")));

    }
    
    if($user2['user_id'] == $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT15")));
    }
    
    $sql = 'SELECT ud_id
            FROM user_diplomacy
            WHERE (user1_id = '.$game->player['user_id'].' AND user2_id = '.$user2['user_id'].') OR
                  (user1_id = '.$user2['user_id'].' AND user2_id = '.$game->player['user_id'].')';
            
    if(($ud_exists = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user diplomacy data');
    }
    
    if(!empty($ud_exists['ud_id'])) {
        message(NOTICE, constant($game->sprache("TEXT16")));
    }
    
    $sql = 'INSERT INTO user_diplomacy (user1_id, user2_id, accepted)
            VALUES ('.$game->player['user_id'].', '.$user2['user_id'].', 0)';
    
    SystemMessage($user2['user_id'], constant($game->sprache("TEXT17")), constant($game->sprache("TEXT18")));
        
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new diplomacy private data');
    }
    
    redirect('a=user_diplomacy');
}
elseif(isset($_GET['new'])) {

    $game->out('
<table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="4">
  <form method="post" action="'.parse_link('a=user_diplomacy').'">
  <tr>
    <td align="left">
      <b>'.constant($game->sprache("TEXT19")).'</b><br><br>
      '.constant($game->sprache("TEXT3")).'&nbsp;&nbsp;<input class="field" type="text" name="user2_name" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" name="searcher" value="'.constant($game->sprache("TEXT4")).'">
</td></tr><tr><td align="center"><input class="button" type="button" value="'.constant($game->sprache("TEXT5")).'" onClick="return window.history.back();">&nbsp;&nbsp;&nbsp;<input class="button" type="submit" name="new_submit" value="'.constant($game->sprache("TEXT6")).'">
    </td>
  </tr>
</form>
</table>
    ');
}
elseif(!empty($_GET['accept'])) {
    $ud_id = (int)$_GET['accept'];
    
    if(empty($ud_id)) {
        message(NOTICE, constant($game->sprache("TEXT20")));
    }

    $sql = 'SELECT user1_id, user2_id, accepted
            FROM user_diplomacy
            WHERE ud_id = '.$ud_id;
            
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query diplomacy private data');
    }
    
    if($diplomacy['user2_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT21")));
    }
    
    if($diplomacy['accepeted'] != 0) {
        message(NOTICE, constant($game->sprache("TEXT22")));
    }
    
    $sql = 'UPDATE user_diplomacy
            SET date = '.$game->TIME.',
                accepted = 1
            WHERE ud_id = '.$ud_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update diplomacy private accepted data');
    }
    
    redirect('a=user_diplomacy');
}
elseif(!empty($_GET['deny'])) {
    $ud_id = (int)$_GET['deny'];

    if(empty($ud_id)) {
        message(NOTICE, constant($game->sprache("TEXT20")));
    }

    $sql = 'SELECT user1_id, user2_id, accepted
            FROM user_diplomacy
            WHERE ud_id = '.$ud_id;

    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query diplomacy private data');
    }

    if($diplomacy['user2_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT21")));
    }

    if($diplomacy['accepeted'] != 0) {
        message(NOTICE, constant($game->sprache("TEXT22")));
    }

    $sql = 'DELETE FROM user_diplomacy
            WHERE ud_id = '.$ud_id;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete diplomacy private data');
    }

    redirect('a=user_diplomacy');
}
elseif(!empty($_GET['cancel'])) {
    $ud_id = (int)$_GET['cancel'];

    if(empty($ud_id)) {
        message(NOTICE, constant($game->sprache("TEXT20")));
    }

    $sql = 'SELECT user1_id, user2_id, accepted
            FROM user_diplomacy
            WHERE ud_id = '.$ud_id;

    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query diplomacy private data');
    }

    if($diplomacy['user1_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT21")));
    }

    if($diplomacy['accepted'] != 0) {
        message(NOTICE, constant($game->sprache("TEXT22")));
    }

    $sql = 'DELETE FROM user_diplomacy
            WHERE ud_id = '.$ud_id;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete diplomacy private data');
    }
    
    redirect('a=user_diplomacy');
}
elseif(!empty($_GET['break'])) {
    $ud_id = (int)$_GET['break'];
    
    if(empty($ud_id)) {
        message(NOTICE, constant($game->sprache("TEXT20")));
    }

    $sql = 'SELECT ud_id, user1_id, user2_id, accepted
            FROM user_diplomacy
            WHERE ud_id = '.$ud_id;
            
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query diplomacy private data');
    }
    
    if(empty($diplomacy['ud_id'])) {
        message(NOTICE, constant($game->sprache("TEXT23")));
    }

    if(empty($diplomacy['user1_id'])) {
        message(NOTICE, constant($game->sprache("TEXT24")));
    }

    if(empty($diplomacy['user2_id'])) {
        message(NOTICE, constant($game->sprache("TEXT25")));
    }
    
    $opid = ($diplomacy['user1_id'] == $game->player['user_id']) ? 2 : 1;
            
    if( ($diplomacy['user1_id'] != $game->player['user_id']) && ($diplomacy['user2_id'] != $game->player['user_id']) ) {
        message(NOTICE, constant($game->sprache("TEXT21")));
    }
    
    if($diplomacy['accepted'] != 1) {
        message(NOTICE, constant($game->sprache("TEXT26")));
    }
    
    $sql = 'DELETE FROM user_diplomacy
            WHERE ud_id = '.$ud_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete diplomacy private data');
    }
    
    add_logbook_entry($diplomacy['user'.$opid.'_id'], LOGBOOK_UDIPLOMACY, constant($game->sprache("TEXT27")), array('what' => 'break', 'who_id' => $game->player['user_id'], 'who_name' => $game->player['user_name']));
    
    redirect('a=user_diplomacy');
}
else {
/*
[05:11:14] <Secius> das macht ann auf dem stgc treffen 2x freigetränke^^
[05:11:18] <TAP> wenn du nen lauf hast, dann passt einfach alles
[05:11:24] <TAP> die übernehm ich gern ;)
*/
if($_REQUEST['sort']==1)
{
if($_REQUEST['member_list']==1) 
{ $order='DESC';}else{$order='ASC';}
$sql='SELECT d.*,IF(d.user1_id!='.$game->player['user_id'].',u1.user_name,u2.user_name) AS user_name_sort,


                   u1.user_name AS user1_name, u1.user_alliance AS user1_aid, a1.alliance_tag AS user1_atag, u1.user_active, 



                   u2.user_name AS user2_name, u2.user_alliance AS user2_aid, a2.alliance_tag AS user2_atag, u2.user_active
            FROM (user_diplomacy d)
            INNER JOIN (user u1) ON u1.user_id = d.user1_id
            LEFT JOIN (alliance a1) ON a1.alliance_id = u1.user_alliance
            INNER JOIN (user u2) ON u2.user_id = d.user2_id
            LEFT JOIN (alliance a2) ON a2.alliance_id = u2.user_alliance
            WHERE (d.user1_id ='.$game->player['user_id'].' OR


                  d.user2_id ='.$game->player['user_id'].') AND  (u1.user_active=1 AND u2.user_active=1) ORDER BY user_name_sort '.$order;
}else if($_REQUEST['sort']==2)
{
if($_REQUEST['member_list']==1) 
{ $order='DESC';}else{$order='ASC';}
$sql='SELECT d.*, IF(d.accepted!=1,0, IF(d.user1_id!='.$game->player['user_id'].',u1.last_active,u2.last_active)) AS sort_status,


                   u1.user_name AS user1_name, u1.user_alliance AS user1_aid, a1.alliance_tag AS user1_atag, u1.user_active, 



                   u2.user_name AS user2_name, u2.user_alliance AS user2_aid, a2.alliance_tag AS user2_atag, u2.user_active
            FROM (user_diplomacy d)
            INNER JOIN (user u1) ON u1.user_id = d.user1_id
            LEFT JOIN (alliance a1) ON a1.alliance_id = u1.user_alliance
            INNER JOIN (user u2) ON u2.user_id = d.user2_id
            LEFT JOIN (alliance a2) ON a2.alliance_id = u2.user_alliance
            WHERE (d.user1_id ='.$game->player['user_id'].' OR


                  d.user2_id ='.$game->player['user_id'].') AND  (u1.user_active=1 AND u2.user_active=1) ORDER BY sort_status '.$order;

}else{
if($_REQUEST['member_list']==1) 
{ $order='DESC';}else{$order='ASC';}
    $sql = 'SELECT d.*,


                   u1.user_name AS user1_name, u1.user_alliance AS user1_aid, a1.alliance_tag AS user1_atag, u1.user_active, 



                   u2.user_name AS user2_name, u2.user_alliance AS user2_aid, a2.alliance_tag AS user2_atag, u2.user_active
            FROM (user_diplomacy d)
            INNER JOIN (user u1) ON u1.user_id = d.user1_id
            LEFT JOIN (alliance a1) ON a1.alliance_id = u1.user_alliance
            INNER JOIN (user u2) ON u2.user_id = d.user2_id
            LEFT JOIN (alliance a2) ON a2.alliance_id = u2.user_alliance
            WHERE (d.user1_id = '.$game->player['user_id'].' OR


                  d.user2_id = '.$game->player['user_id'].') AND (u1.user_active=1 AND u2.user_active=1) ORDER BY d.date '.$order;
                  }
    if(!$q_diplomacy = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query diplomacy private data');
    }
if($_REQUEST['sort']==2 && $_REQUEST['member_list']!=1)
{$art_a=1;}else{$art_a=0;}
if($_REQUEST['sort']==1 && $_REQUEST['member_list']!=1) {$art_b=1;}else{$art_b=0;}
if(empty($_REQUEST['sort']) && $_REQUEST['member_list']!=1) {$art_c=1;}else{$art_c=0;}
    $game->out('
<table class="style_inner" width="500" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="180"><a href="'.parse_link('a=user_diplomacy&sort=1&member_list='.$art_b.'').'"><b>'.constant($game->sprache("TEXT28")).'</b></a></td>
    <td width="170">&nbsp;</td>
    <td width="100"><a href="'.parse_link('a=user_diplomacy&member_list='.$art_c.'').'"><b>'.constant($game->sprache("TEXT29")).'</b></a></td>
    <td width="50"><a href="'.parse_link('a=user_diplomacy&sort=2&member_list='.$art_a.'').'"><b>'.constant($game->sprache("TEXT30")).'</b></a></td>
  </tr>
    ');
    

    while($diplomacy = $db->fetchrow($q_diplomacy)) {

	$opid = ($diplomacy['user1_id'] == $game->player['user_id']) ? 2 : 1;

	$order_by_user = 'ORDER BY last_active ASC';

        $userquery=$db->query('SELECT * FROM user WHERE user_id = "'.$diplomacy['user'.$opid.'_id'].'" AND user_active=1');

        if (($user = $db->fetchrow($userquery))==false) {$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT31")).' (id='.$_REQUEST['id'].'<br>'.constant($game->sprache("TEXT32")).'</span></center>');}
        else {
  
        if($diplomacy['accepted']) {
            $cmd_str = '&nbsp;&nbsp;[<a href="'.parse_link('a=user_diplomacy&break='.$diplomacy['ud_id']).'">'.constant($game->sprache("TEXT33")).'</a>]';
            $date_str = gmdate('d.m.Y', $diplomacy['date']);
	    
	    if ($user['last_active']>(time()-60*3)) $stats_str='<span style="color: green">'.constant($game->sprache("TEXT34")).'</span>';
	    else if ($user['last_active']>(time()-60*9)) $stats_str='<span style="color: orange">'.constant($game->sprache("TEXT35")).'</span>';
            else $stats_str='<span style="color: red">'.constant($game->sprache("TEXT36")).'</span>';
        }
        else {
            if($opid == 1) {
                $cmd_str = '&nbsp;&nbsp;[<a href="'.parse_link('a=user_diplomacy&accept='.$diplomacy['ud_id']).'">'.constant($game->sprache("TEXT37")).'</a>]&nbsp;[<a href="'.parse_link('a=user_diplomacy&deny='.$diplomacy['ud_id']).'">'.constant($game->sprache("TEXT38")).'</a>]';
                $date_str = '<span style="color: #FFFF00;">'.constant($game->sprache("TEXT39")).'</span>';
		$stats_str = 'Unknown';
            }
            else {
                $cmd_str = '&nbsp;&nbsp;[<a href="'.parse_link('a=user_diplomacy&cancel='.$diplomacy['ud_id']).'">'.constant($game->sprache("TEXT40")).'</a>]';
                $date_str = '<span style="color: #FF0000;">Wartet</span>';
		$stats_str = 'Unknown';
            }
        }
}
        $game->out('
  <tr>
    <td width="180"><a href="'.parse_link('a=stats&a2=viewplayer&id='.$diplomacy['user'.$opid.'_id']).'">'.$diplomacy['user'.$opid.'_name'].'</a>'.( ($diplomacy['user'.$opid.'_aid']) ? ' [<a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['user'.$opid.'_aid']).'">'.$diplomacy['user'.$opid.'_atag'].'</a>]' : '' ).'</td>
    <td width="170">'.$cmd_str.'</td>
    <td width="100">'.$date_str.'</td>
    <td width="50"><b>'.$stats_str.'</b></td>
  </tr>
        ');
    }
    
    $game->out('
</table>
<table width="500" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr><td width="500" align="right">[<a href="'.parse_link('a=user_diplomacy&new').'">'.constant($game->sprache("TEXT19")).'</a>]</td></tr>
</table>
');
}
?>
