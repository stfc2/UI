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


include('include/libs/moves.php');
$game->init_player();

function taxes_pagination($start, $n_count, $n_per_page) {
    global $game;
    $page_html = '';

    $n_pages = ceil($n_count / $n_per_page);
    $current_page = ($start > 0) ? ( ($start / $n_per_page) + 1) : 1;
    $next_start = 0;

    if($current_page > 1) {
        $page_html .= '[<a href="'.parse_link('a=alliance_taxes').'">'.constant($game->sprache("TEXT0")).'</a>]&nbsp;';
        $page_html .= '[<a href="'.parse_link('a=alliance_taxes&start='.($start - $n_per_page) ).'">'.constant($game->sprache("TEXT1")).'</a>]<br>&nbsp;';
    }

    if($current_page > 5) {
        $page_html .= '[<a href="'.parse_link('a=alliance_taxes').'">1</a>]&nbsp;...&nbsp;';
    }


    for($i = 1; $i <= $n_pages; ++$i) {
        
        
        if($i == $current_page) {
            $page_html .= '<b><span style="color: #00FF00;">['.$i.']</span></b>&nbsp;';
        }
        elseif ($i >= $current_page-4 && $i <= $current_page+4) {
            $page_html .= '[<a href="'.parse_link('a=alliance_taxes&start='.$next_start).'">'.$i.'</a>]&nbsp;';
        }
       

        $_div = ($i / 25);

        if($_div == (int)$_div && $n_pages<$div) {
            $page_html .= '&nbsp;';
        }

        $next_start = ($next_start + $n_per_page);
    }
    if($current_page < $n_pages-5) {
        $page_html .= '&nbsp;...&nbsp[<a href="'.parse_link('a=alliance_taxes&start='.(($n_pages - 1) * $n_per_page) ).'">'.$n_pages.'</a>]';
    }

    if($current_page < $n_pages) {
        $page_html .= '<br>[<a href="'.parse_link('a=alliance_taxes&start='.($start + $n_per_page) ).'">'.constant($game->sprache("TEXT2")).'</a>]&nbsp;';
        $page_html .= '[<a href="'.parse_link('a=alliance_taxes&start='.(($n_pages - 1) * $n_per_page) ).'">'.constant($game->sprache("TEXT3")).'</a>]';
    }

    return $page_html;
}



    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

  $game->out('<span class="caption">'.constant($game->sprache("TEXT4")).':</span><br><br>');

function GetOwnRess($type,$percent) {
 
    global $db,$game;
 
    if($percent<=0) return (array(0,0,0));
    $percent = $percent / 100;

    $own_ress=$db->queryrow('SELECT SUM( add_1 * '.$percent.' ) AS met, SUM( add_2 * '.$percent.' ) AS min, SUM( add_3 * '.$percent.' ) AS lat FROM planets WHERE planet_owner = '.$game->player['user_id'].'');

    if($type==0){
    $own_ress[0]=round($own_ress['met']);
    $own_ress[1]=round($own_ress['min']);
    $own_ress[2]=round($own_ress['lat']);
    }
    elseif($type==1) {
    $own_ress[0]=round($own_ress['met'])*480;
    $own_ress[1]=round($own_ress['min'])*480;
    $own_ress[2]=round($own_ress['lat'])*480;
    }
    return $own_ress;

}

function GetTaxes($percent,$alliance_id)
{
global $db;

if ($percent<=0) return (array(0,0,0));
$res=$db->queryrow('SELECT SUM(p.add_1/100*'.$percent.') AS r1,SUM(p.add_2/100*'.$percent.') AS r2,SUM(p.add_3/100*'.$percent.') AS r3 FROM user u LEFT join planets p ON p.planet_owner=u.user_id WHERE (u.user_alliance="'.$alliance_id.'") AND (u.user_active=1)');
$res[0]=round($res['r1']);
$res[1]=round($res['r2']);
$res[2]=round($res['r3']);
return $res;
}

function GetTaxesPerDay($percent,$alliance_id)
{
global $db;

if ($percent<=0) return (array(0,0,0));
$res=$db->queryrow('SELECT SUM(p.add_1/100*'.$percent.') AS r1,SUM(p.add_2/100*'.$percent.') AS r2,SUM(p.add_3/100*'.$percent.') AS r3 FROM user u LEFT join planets p ON p.planet_owner=u.user_id WHERE (u.user_alliance="'.$alliance_id.'") AND (u.user_active=1)');
$res[0]=round($res['r1'])*480;
$res[1]=round($res['r2'])*480;
$res[2]=round($res['r3'])*480;
return $res;
}



if(empty($game->player['alliance_name'])) {
    message(NOTICE, constant($game->sprache("TEXT5")));
}

if(isset($_POST['taxes']))
{

if($game->player['user_alliance_rights2'] != 1) {
    message(NOTICE, constant($game->sprache("TEXT6")));
}

$_POST['tax_set']=(int)$_POST['tax_set'];
if ($_POST['tax_set']>=0 && $_POST['tax_set']<=20)
{
    $sql = 'UPDATE alliance SET taxes='.$_POST['tax_set'].' WHERE alliance_id = '.$game->player['user_alliance'];
	$db->query($sql);
}

redirect('a=alliance_taxes');
}
else if(!empty($_POST['details_ress'])) {

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(($adata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

    // Anzeige der Einträge pro Seite
    $LOGS_PER_PAGE = 10;

    $sql = 'SELECT id FROM alliance_taxes WHERE alliance_id='.$adata['alliance_id'].' ORDER BY timestamp DESC';
            
    if(($all_logs = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query all log data');
    }

    $n_logs = count($all_logs);

    for($i = 0; $i < $n_logs; ++$i) {
        if($all_logs[$i]['id'] == $log['id']) {
            $on_i = $i;
            $previous_log = ($i == ($n_logs - 1)) ? 0 : $all_logs[($i + 1)]['id'];
            $next_log = ($i == 0) ? 0 : $all_logs[($i - 1)]['id'];
        }
    }

    if(!isset($on_i) && $on_i>0) {
        message(GENERAL, 'Fehler bei der Seitenberechnung des Logbuchs', 'Unexspected: could not determine $on_i');
    }

    $on_page = ceil( ( ($on_i + 1) / $LOGS_PER_PAGE) );
    $on_page_start = ( ($on_page - 1) * $LOGS_PER_PAGE);


$tax=GetTaxes($adata['taxes'],$adata['alliance_id']);
$taxDay=GetTaxesPerDay($adata['taxes'],$adata['alliance_id']);

$owntax=GetOwnRess(0,$adata['taxes']);
$owntaxDay=GetOwnRess(1,$adata['taxes']);

    $game->out('
      
<table width="430" align="center" border="0" cellpadding="2" cellspacing="4" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$adata['alliance_name'].' ['.$adata['alliance_tag'].']</span><br><br><br>
      

      <table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
		<tr>
			<td width=500>
			<b>'.constant($game->sprache("TEXT7")).'</b><br>
<br><br><b><u>'.constant($game->sprache("TEXT8")).':</u></b><br>
				<table width="500" cellpadding="5">
				<tr><td width=150>'.constant($game->sprache("TEXT9")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$adata['taxes_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$adata['taxes_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$adata['taxes_3'].'&nbsp;&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT10")).':</td><td>'.$adata['taxes'].'%</td></tr>
				<tr><td>'.constant($game->sprache("TEXT11")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$tax[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$tax[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$tax[2].'&nbsp;&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT12")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$taxDay[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$taxDay[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$taxDay[2].'&nbsp;&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT13")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$owntax[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$owntax[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$owntax[2].'&nbsp;&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT14")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$owntaxDay[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$owntaxDay[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$owntaxDay[2].'&nbsp;&nbsp;</td></tr>
				</table>
<br><br><b><u>'.constant($game->sprache("TEXT15")).':</u></b><br>
				<table width="500" cellpadding="2" border="0">
				<tr>
					<td width=75><b>'.constant($game->sprache("TEXT16")).':</b></td>
					<td width=125><b>'.constant($game->sprache("TEXT17")).':</b></td>
					<td width=75><b>'.constant($game->sprache("TEXT18")).':</b></td>
					<td width=50><b>'.constant($game->sprache("TEXT19")).':</b></td>
					<td width=50><b>'.constant($game->sprache("TEXT20")).':</b></td>
				</tr>');

$start = (isset($_GET['start'])) ? $_GET['start'] : 0;
    settype($start, 'int');

    $sql = 'SELECT COUNT(id) AS log_id_count
            FROM alliance_taxes
            WHERE alliance_id = '.$game->player['alliance_id'];
            
    if(($_n_logs = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query logbook count data');
    }

    $n_logs = $_n_logs['log_id_count'];

    $sql = 'SELECT * FROM alliance_taxes WHERE alliance_id='.$adata['alliance_id'].'
            ORDER BY timestamp DESC
            LIMIT '.$start.', '.$LOGS_PER_PAGE;
            
    if($start >= $n_logs) {
        $start = ($n_logs - $LOGS_PER_PAGE);
    }


$payments = $db->query($sql);

while($payment = $db->fetchrow($payments)) {
    $game->out('
				<tr>
					<td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$payment['receiver']).'">'.$game->uc_get($payment['receiver']).'</a></td>
					<td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$payment['resource_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$payment['resource_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$payment['resource_3'].'</td>
					<td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$payment['sender']).'">'.$game->uc_get($payment['sender']).'</a></td>
					<td><a href="javascript:void(0);" onmouseover="return overlib(\''.htmlspecialchars($payment['reason']).'\', CAPTION, \''.constant($game->sprache("TEXT21")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.constant($game->sprache("TEXT22")).'</a></td>
					<td>'.date("j.n.y H:i",$payment['timestamp']).'</td>
				</tr>');

}
    $game->out('</table>');
$game->out('<div align="center">'.taxes_pagination($start, $n_logs, $LOGS_PER_PAGE).'</div>');

if($game->player['user_alliance_rights2'] == 1) {
	
$sql = 'SELECT p.planet_id,p.planet_name,u.user_id,u.user_name
FROM (alliance a)
INNER JOIN (user u) ON u.user_alliance = a.alliance_id
INNER JOIN (planets p) ON p.planet_owner = u.user_id
WHERE a.alliance_id ='.$adata['alliance_id'].' ORDER BY u.user_name ASC, p.planet_name ASC'; 
$plnt = $db->query($sql);

$u_id=-1;
$op_id=-1;

while($planet = $db->fetchrow($plnt)) {
if ($u_id!=$planet['user_id'])
{
$pl_id=0;
$op_id++;
if ($u_id!=-1) {$planet_list.='}

';}
$planet_list.='if (document.resform.userlist.options['.$op_id.'].selected) {
	';
	
$rcv_list.='<option value="'.$planet['user_id'].'">'.$planet['user_name'].'</option>';
$u_id=$planet['user_id'];
}
$planet_list.='
      document.resform.receiver.options['.$pl_id.'] = new Option("'.$planet['planet_name'].'", "'.$planet['planet_id'].'");
';

if ($op_id==0) $start_planet_list.='<option value="'.$planet['planet_id'].'">'.$planet['planet_name'].'</option>';

$pl_id++;

}
if ($u_id!=-1) $planet_list.='}';


for ($t=0; $t<21; $t++) $tax_list.='<option value="'.$t.'" '.( ($t==$adata['taxes']) ? 'selected':'').'>'.$t.'%</option>';

    $game->out('

	<script language="JavaScript">
	function UpdateValues()
	{
	var i;
	    var res_1=document.resform.res_1.value;
	    var res_2=document.resform.res_2.value;
	    var res_3=document.resform.res_3.value;
       for(i = 0; i < document.resform.mode.options.length; i++)
            if(document.resform.mode[i].selected)
				{
                       if (i==3) ttax_set=0;
	                if (i==2) ttax_set=4;
                       if (i==1) ttax_set=8;
	                if (i==0) ttax_set=15;
				}

	    document.getElementById( "tax_1" ).firstChild.nodeValue = res_1/100*ttax_set;
	    document.getElementById( "tax_2" ).firstChild.nodeValue = res_2/100*ttax_set;
	    document.getElementById( "tax_3" ).firstChild.nodeValue = res_3/100*ttax_set;
	    window.setTimeout( \'UpdateValues()\', 500 );

	}

	function UpdatePlanetsList()
	{
		var newOpt;
		document.resform.receiver.options.length = 0;
		'.$planet_list.'
	}
	</script>

<br><br><b><u>'.constant($game->sprache("TEXT23")).':</u></b>
  <form method="post" action="'.parse_link('a=alliance_taxes').'" name="resform">
  <table width="300" border="0" cellpadding="2" cellspacing="2">
  <tr><td width=75>'.constant($game->sprache("TEXT24")).':</td><td><select name="userlist" class="Select" size="1" onChange="UpdatePlanetsList();">'.$rcv_list.'</select></td></tr>
  <tr><td width=75>'.constant($game->sprache("TEXT25")).':</td><td><select name="receiver" class="Select" size="1">'.$start_planet_list.'</select></td></tr>
  <tr><td><img src='.$game->GFX_PATH.'menu_metal_small.gif></td><td><input class="field"  style="width: 60px;" type="text" name="res_1" value="0" onFocus="UpdateValues();">&nbsp&nbsp (+<b id="tax_1">0</b> '.constant($game->sprache("TEXT26")).')</td></tr>
  <tr><td><img src='.$game->GFX_PATH.'menu_mineral_small.gif></td><td><input class="field"  style="width: 60px;" type="text" name="res_2" value="0" onFocus="UpdateValues();">&nbsp&nbsp (+<b id="tax_2">0</b> '.constant($game->sprache("TEXT26")).')</td></tr>
  <tr><td><img src='.$game->GFX_PATH.'menu_latinum_small.gif></td><td><input class="field"  style="width: 60px;" type="text" name="res_3" value="0" onFocus="UpdateValues();">&nbsp&nbsp (+<b id="tax_3">0</b> '.constant($game->sprache("TEXT26")).')</td></tr>
  <tr><td width=75>'.constant($game->sprache("TEXT27")).':</td><td><select name="mode" class="Select" size="1">
	<option value="3">'.constant($game->sprache("TEXT26a")).' - 15% '.constant($game->sprache("TEXT26")).'</option>
	<option value="2">'.constant($game->sprache("TEXT26b")).' - 8% '.constant($game->sprache("TEXT26")).'</option>
	<option value="1">'.constant($game->sprache("TEXT26c")).' - 4% '.constant($game->sprache("TEXT26")).'</option>
	<option value="0">'.constant($game->sprache("TEXT26d")).' - 0% '.constant($game->sprache("TEXT26")).'</option>
	</select></td>
  <tr><td width=75>'.constant($game->sprache("TEXT21")).':</td><td><input class="field" style="width: 200px;" type="text" name="reason" value="-"></td></tr>

  </table><br>
  <input class="button" type="submit" name="payout" value="'.constant($game->sprache("TEXT33")).'">
  </form>');

  $game->out('
  <br><br><b><u>'.constant($game->sprache("TEXT28")).':</u></b>
  <form method="post" action="'.parse_link('a=alliance_taxes').'">
  <table width="300" border="0" cellpadding="2" cellspacing="2">
  <tr><td width=75>'.constant($game->sprache("TEXT10")).':</td><td><select name="tax_set" class="Select" size="1">'.$tax_list.'</select></td></tr>
  </td>
  </tr>
  </table>
  <br>
  <input class="button" type="submit" name="taxes" value="'.constant($game->sprache("TEXT34")).'">
  </form>');




}
   $sql = 'SELECT u.user_id,u.user_name
           FROM (alliance a)
           INNER JOIN (user u) ON u.user_alliance = a.alliance_id
           WHERE a.alliance_id = '.$game->player['user_alliance'].' ORDER BY u.user_name ASC'; 

   $userlist = $db->query($sql);

   while($alluser = $db->fetchrow($userlist)) {

     $user_list.='<option value="'.$alluser['user_id'].'">'.$alluser['user_name'].'</option>';

   }


   $game->out('<br><br><b><u>'.constant($game->sprache("TEXT29")).':</u></b>
   <form method="post" action="'.parse_link('a=alliance_taxes').'">
   <table width="300" border="0" cellpadding="2" cellspacing="2">
   <tr><td>'.constant($game->sprache("TEXT24")).':</td><td><select name="userlist">'.$user_list.'</select></td></tr>
   </table><br>
   <input class="button" type="submit" name="details_ress" value="'.constant($game->sprache("TEXT35")).'">&nbsp;<input class="button" type="submit" name="all_ress" value="'.constant($game->sprache("TEXT36")).'">
   </form><br><br><table width=400><tr><td><b>'.constant($game->sprache("TEXT24")).':</b></td><td><b>'.constant($game->sprache("TEXT30")).'</b></td><td><b>'.constant($game->sprache("TEXT31")).'</b></td><td><b>'.constant($game->sprache("TEXT32")).'</b></td></tr>');
  

   $sql = 'SELECT SUM(t.resource_1) AS Met, SUM(t.resource_2) AS Min, SUM(t.resource_3) AS Lat, t.receiver, t.alliance_id, u.user_id, u.user_name
        FROM (alliance_taxes t)
        INNER JOIN (user u) ON u.user_id = t.receiver
        WHERE t.receiver = '.$_POST['userlist'].' GROUP BY t.receiver';

   //echo $sql;

   $userdata = $db->query($sql);

   while($out_user = $db->fetchrow($userdata)) {

     $game->out('<tr><td>'.$out_user['user_name'].'</td><td>'.number_format($out_user['Met'], 0, '.', '.').'</td><td>'.number_format($out_user['Min'], 0, '.', '.').'</td><td>'.number_format($out_user['Lat'], 0, '.', '.').'</td></tr>');

   }
   $game->out('</table>');
$game->out('</td></tr>
</table></td></tr></table>

    ');

}

else if(isset($_POST['all_ress'])) {

$game->out('
<table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td>'.constant($game->sprache("TEXT37")).'</td><tr><td>
      <table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
        <tr>
          <td><b>'.constant($game->sprache("TEXT24")).':</b></td><td><b>'.constant($game->sprache("TEXT30")).'</b></td><td><b>'.constant($game->sprache("TEXT31")).'</b></td><td><b>'.constant($game->sprache("TEXT32")).'</b></td></tr>
');

$sql = 'SELECT user_id FROM user WHERE user_alliance = '.$game->player['user_alliance'].'';

$user_set = $db->query($sql);

$zahler = 0;
$users = array();

while($list_it = $db->fetchrow($user_set)) {

  $users[$zahler]=$list_it['user_id']; 
  $zahler++;
}

$sql = 'SELECT SUM(t.resource_1) AS Met, SUM(t.resource_2) AS Min, SUM(t.resource_3) AS Lat, t.receiver, t.alliance_id, u.user_id, u.user_name
        FROM (alliance_taxes t)
        INNER JOIN (user u) ON u.user_id = t.receiver
        WHERE t.receiver IN ('.implode(',', $users).') GROUP BY u.user_name ASC';

$allianceuser = $db->query($sql);

while($recv_list = $db->fetchrow($allianceuser)) {

  $game->out('<tr><td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$recv_list['receiver'].'').'">'.$game->uc_get($recv_list['receiver']).'</a></td><td>'.number_format($recv_list['Met'], 0, '.', '.').'</td><td>'.number_format($recv_list['Min'], 0, '.', '.').'</td><td>'.number_format($recv_list['Lat'], 0, '.', '.').'</td></tr>');

}

$game->out('</table></td></tr></table>');

}

else if(isset($_POST['payout']))
{

if($game->player['user_alliance_rights2'] != 1) {
    message(NOTICE, constant($game->sprache("TEXT6")));
}

$_POST['res_1']=(int)$_POST['res_1'];
$_POST['res_2']=(int)$_POST['res_2'];
$_POST['res_3']=(int)$_POST['res_3'];
$_POST['receiver']=(int)$_POST['receiver'];
$_POST['mode']=(int)$_POST['mode'];

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($adata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

if ($_POST['res_1']<0) $_POST['res_1']=0;
if ($_POST['res_2']<0) $_POST['res_2']=0;
if ($_POST['res_3']<0) $_POST['res_3']=0;
if ($_POST['res_1']>$adata['taxes_1']) $_POST['res_1']=$adata['taxes_1'];
if ($_POST['res_2']>$adata['taxes_2']) $_POST['res_2']=$adata['taxes_2'];
if ($_POST['res_3']>$adata['taxes_3']) $_POST['res_3']=$adata['taxes_3'];

//alt: if ($_POST['mode']>2 || $_POST['mode']<0) $_POST['mode']=0;

if ($_POST['mode']>3 || $_POST['mode']<0) $_POST['mode']=0;
if ($_POST['res_1']==0 && $_POST['res_2']==0 && $_POST['res_3']==0) {redirect('a=alliance_taxes'); exit;}
$distance=12*36;
if ($_POST['mode']==0) $distance=20*36;
if ($_POST['mode']==1) $distance=20*24;
if ($_POST['mode']==2) $distance=20*12;
if ($_POST['mode']==3) $distance=10;

$tset=15;
if ($_POST['mode']==0) $tset=0;
if ($_POST['mode']==1) $tset=4;
if ($_POST['mode']==2) $tset=8;

$ftaxes[0]=$_POST['res_1']/100*$tset;
$ftaxes[1]=$_POST['res_2']/100*$tset;
$ftaxes[2]=$_POST['res_3']/100*$tset;

$aaa=0;$bbb=0;$ccc=0;

if (($_POST['res_1']+$ftaxes[0])>$adata['taxes_1']) {$_POST['res_1']=$adata['taxes_1']-$ftaxes[0]; $aaa=1;}
if (($_POST['res_2']+$ftaxes[1])>$adata['taxes_2']) {$_POST['res_2']=$adata['taxes_2']-$ftaxes[1]; $bbb=1;}
if (($_POST['res_3']+$ftaxes[2])>$adata['taxes_3']) {$_POST['res_3']=$adata['taxes_3']-$ftaxes[2]; $ccc=1;}

$sql='SELECT u.*,p.planet_id FROM (user u) LEFT JOIN (planets p) ON p.planet_id='.$_POST['receiver'].' WHERE u.user_id=p.planet_owner AND u.user_alliance='.$game->player['user_alliance'];
if(($user = $db->queryrow($sql)) === false || !isset($user['planet_id'])) {
redirect('a=alliance_taxes');
}
$planet=$user['planet_id'];

account_log($game->player['user_id'],$user['user_id'],3);

if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$planet.'","'.$_POST['res_1'].'","'.$_POST['res_2'].'","'.$_POST['res_3'].'",0,0,0,0,0,0,0,"'.($ACTUAL_TICK+$distance).'")'))==true)
{
$ships=ceil(($_POST['res_1']+$_POST['res_2']+$_POST['res_3'])/MAX_TRANSPORT_RESOURCES);
send_fake_transporter(array(FERENGI_TRADESHIP_ID=>$ships), FERENGI_USERID, 0, $planet,($ACTUAL_TICK+$distance));

if($aaa==0){$wert_1=$_POST['res_1']+$ftaxes[0];}else{$wert_1=$_POST['res_1'];}
if($bbb==0){$wert_2=$_POST['res_2']+$ftaxes[1];}else{$wert_2=$_POST['res_2'];}
if($ccc==0){$wert_3=$_POST['res_3']+$ftaxes[2];}else{$wert_3=$_POST['res_3'];}

$sql = 'UPDATE alliance SET taxes_1=taxes_1-'.$wert_1.',taxes_2=taxes_2-'.$wert_2.',taxes_3=taxes_3-'.$wert_3.' WHERE alliance_id = '.$game->player['user_alliance'];
$db->query($sql);
$sql = 'INSERT INTO alliance_taxes (alliance_id,resource_1,resource_2,resource_3,receiver,sender,mode,reason,timestamp) VALUES('.$game->player['user_alliance'].','.$_POST['res_1'].','.$_POST['res_2'].','.$_POST['res_3'].','.$user['user_id'].','.$game->player['user_id'].','.$_POST['mode'].',"'.addslashes(htmlspecialchars($_POST['reason'])).'",'.time().')';
$db->query($sql);
$sql = 'UPDATE config SET ferengitax_1=ferengitax_1+'.$ftaxes[0].',ferengitax_2=ferengitax_2+'.$ftaxes[1].',ferengitax_3=ferengitax_3+'.$ftaxes[2];
$db->query($sql);

}


redirect('a=alliance_taxes');
}

else {
    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(($adata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

   // Anzeige der Einträge pro Seite
   $LOGS_PER_PAGE = 10;

    $sql = 'SELECT id FROM alliance_taxes WHERE alliance_id='.$adata['alliance_id'].' ORDER BY timestamp DESC';
            
    if(($all_logs = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query all log data');
    }

    $n_logs = count($all_logs);

    for($i = 0; $i < $n_logs; ++$i) {
        if($all_logs[$i]['id'] == $log['id']) {
            $on_i = $i;
            $previous_log = ($i == ($n_logs - 1)) ? 0 : $all_logs[($i + 1)]['id'];
            $next_log = ($i == 0) ? 0 : $all_logs[($i - 1)]['id'];
        }
    }

    if(!isset($on_i) && $on_i>0) {
        message(GENERAL, 'Fehler bei der Seitenberechnung des Logbuchs', 'Unexspected: could not determine $on_i');
    }

    $on_page = ceil( ( ($on_i + 1) / $LOGS_PER_PAGE) );
    $on_page_start = ( ($on_page - 1) * $LOGS_PER_PAGE);


$tax=GetTaxes($adata['taxes'],$adata['alliance_id']);
$taxDay=GetTaxesPerDay($adata['taxes'],$adata['alliance_id']);

$owntax=GetOwnRess(0,$adata['taxes']);
$owntaxDay=GetOwnRess(1,$adata['taxes']);

    $game->out('
      
<table width="430" align="center" border="0" cellpadding="2" cellspacing="4" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$adata['alliance_name'].' ['.$adata['alliance_tag'].']</span><br><br><br>
      

      <table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
		<tr>
			<td width=500>
			<b>'.constant($game->sprache("TEXT7")).'</b><br>
<br><br><b><u>'.constant($game->sprache("TEXT8")).':</u></b><br>
				<table width="500" cellpadding="5">
				<tr><td width=150>'.constant($game->sprache("TEXT9")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$adata['taxes_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$adata['taxes_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$adata['taxes_3'].'&nbsp;&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT10")).':</td><td>'.$adata['taxes'].'%</td></tr>
				<tr><td>'.constant($game->sprache("TEXT11")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$tax[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$tax[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$tax[2].'&nbsp;&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT12")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$taxDay[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$taxDay[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$taxDay[2].'&nbsp;&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT13")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$owntax[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$owntax[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$owntax[2].'&nbsp;&nbsp;</td></tr>
				<tr><td>'.constant($game->sprache("TEXT14")).':</td><td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$owntaxDay[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$owntaxDay[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$owntaxDay[2].'&nbsp;&nbsp;</td></tr>
				</table>
<br><br><b><u>'.constant($game->sprache("TEXT15")).':</u></b><br><br>
				<table width="500" cellpadding="2" border="0">
				<tr>
					<td width=75><b>'.constant($game->sprache("TEXT16")).':</b></td>
					<td width=125><b>'.constant($game->sprache("TEXT17")).':</b></td>
					<td width=75><b>'.constant($game->sprache("TEXT18")).':</b></td>
					<td width=50><b>'.constant($game->sprache("TEXT19")).':</b></td>
					<td width=50><b>'.constant($game->sprache("TEXT27")).':</b></td>
					<td width=50><b>'.constant($game->sprache("TEXT20")).':</b></td>
				</tr>');

$start = (isset($_GET['start'])) ? $_GET['start'] : 0;
    settype($start, 'int');

    $sql = 'SELECT COUNT(id) AS log_id_count
            FROM alliance_taxes
            WHERE alliance_id = '.$game->player['alliance_id'];
            
    if(($_n_logs = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query logbook count data');
    }

    $n_logs = $_n_logs['log_id_count'];

    $sql = 'SELECT * FROM alliance_taxes WHERE alliance_id='.$adata['alliance_id'].'
            ORDER BY timestamp DESC
            LIMIT '.$start.', '.$LOGS_PER_PAGE;
            
    if($start >= $n_logs) {
        $start = ($n_logs - $LOGS_PER_PAGE);
    }


$payments = $db->query($sql);

while($payment = $db->fetchrow($payments)) {
 
    switch($payment['mode']) {

    case 0:
    $mode = constant($game->sprache("TEXT26d"));
    break;

    case 1:
    $mode = constant($game->sprache("TEXT26c"));
    break;
 
    case 2:
    $mode = constant($game->sprache("TEXT26b"));
    break;

    case 3:
    $mode = constant($game->sprache("TEXT26a"));
    break;

    default:
    $mode = constant($game->sprache("TEXT26a"));

    }

    $game->out('
				<tr>
					<td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$payment['receiver']).'">'.$game->uc_get($payment['receiver']).'</a></td>
					<td><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$payment['resource_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$payment['resource_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$payment['resource_3'].'</td>
					<td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$payment['sender']).'">'.$game->uc_get($payment['sender']).'</a></td>
					<td><a href="javascript:void(0);" onmouseover="return overlib(\''.htmlspecialchars($payment['reason']).'\', CAPTION, \''.constant($game->sprache("TEXT21")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.constant($game->sprache("TEXT22")).'</a></td>
					<td>'.$mode.'</td>
					<td>'.date("j.n.y H:i",$payment['timestamp']).'</td>
				</tr>');

}
    $game->out('</table>');
$game->out('<div align="center">'.taxes_pagination($start, $n_logs, $LOGS_PER_PAGE).'</div>');

if($game->player['user_alliance_rights2'] == 1) {
	
$sql = 'SELECT p.planet_id,p.planet_name,u.user_id,u.user_name
FROM (alliance a)
INNER JOIN (user u) ON u.user_alliance = a.alliance_id
INNER JOIN (planets p) ON p.planet_owner = u.user_id
WHERE a.alliance_id ='.$adata['alliance_id'].' ORDER BY u.user_name ASC, p.planet_name ASC'; 
$plnt = $db->query($sql);

$u_id=-1;
$op_id=-1;

while($planet = $db->fetchrow($plnt)) {
if ($u_id!=$planet['user_id'])
{
$pl_id=0;
$op_id++;
if ($u_id!=-1) {$planet_list.='}

';}
$planet_list.='if (document.resform.userlist.options['.$op_id.'].selected) {
	';
	
$rcv_list.='<option value="'.$planet['user_id'].'">'.$planet['user_name'].'</option>';
$u_id=$planet['user_id'];
}
$planet_list.='
      document.resform.receiver.options['.$pl_id.'] = new Option("'.$planet['planet_name'].'", "'.$planet['planet_id'].'");
';

if ($op_id==0) $start_planet_list.='<option value="'.$planet['planet_id'].'">'.$planet['planet_name'].'</option>';

$pl_id++;

}
if ($u_id!=-1) $planet_list.='}';


for ($t=0; $t<21; $t++) $tax_list.='<option value="'.$t.'" '.( ($t==$adata['taxes']) ? 'selected':'').'>'.$t.'%</option>';

    $game->out('

	<script language="JavaScript">
	function UpdateValues()
	{
	var i;
	    var res_1=document.resform.res_1.value;
	    var res_2=document.resform.res_2.value;
	    var res_3=document.resform.res_3.value;
       for(i = 0; i < document.resform.mode.options.length; i++)
            if(document.resform.mode[i].selected)
				{
                       if (i==3) ttax_set=0;
	                if (i==2) ttax_set=4;
                       if (i==1) ttax_set=8;
	                if (i==0) ttax_set=15;
				}

	    document.getElementById( "tax_1" ).firstChild.nodeValue = res_1/100*ttax_set;
	    document.getElementById( "tax_2" ).firstChild.nodeValue = res_2/100*ttax_set;
	    document.getElementById( "tax_3" ).firstChild.nodeValue = res_3/100*ttax_set;
	    window.setTimeout( \'UpdateValues()\', 500 );

	}

	function UpdatePlanetsList()
	{
		var newOpt;
		document.resform.receiver.options.length = 0;
		'.$planet_list.'
	}
	</script>

<br><br><b><u>'.constant($game->sprache("TEXT23")).':</u></b>
  <form method="post" action="'.parse_link('a=alliance_taxes').'" name="resform">
  <table width="300" border="0" cellpadding="2" cellspacing="2">
  <tr><td width=75>'.constant($game->sprache("TEXT24")).':</td><td><select name="userlist" class="Select" size="1" onChange="UpdatePlanetsList();">'.$rcv_list.'</select></td></tr>
  <tr><td width=75>'.constant($game->sprache("TEXT25")).':</td><td><select name="receiver" class="Select" size="1">'.$start_planet_list.'</select></td></tr>
  <tr><td><img src='.$game->GFX_PATH.'menu_metal_small.gif></td><td><input class="field"  style="width: 60px;" type="text" maxlength="6" name="res_1" value="0" onFocus="UpdateValues();">&nbsp&nbsp (+<b id="tax_1">0</b> '.constant($game->sprache("TEXT26")).')</td></tr>
  <tr><td><img src='.$game->GFX_PATH.'menu_mineral_small.gif></td><td><input class="field"  style="width: 60px;" type="text" maxlength="6"  name="res_2" value="0" onFocus="UpdateValues();">&nbsp&nbsp (+<b id="tax_2">0</b> '.constant($game->sprache("TEXT26")).')</td></tr>
  <tr><td><img src='.$game->GFX_PATH.'menu_latinum_small.gif></td><td><input class="field"  style="width: 60px;" type="text" maxlength="6"  name="res_3" value="0" onFocus="UpdateValues();">&nbsp&nbsp (+<b id="tax_3">0</b> '.constant($game->sprache("TEXT26")).')</td></tr>
  <tr><td width=75>'.constant($game->sprache("TEXT27")).':</td><td><select name="mode" class="Select" size="1">
	<option value="3">'.constant($game->sprache("TEXT26a")).' - 15% '.constant($game->sprache("TEXT26")).'</option>
	<option value="2">'.constant($game->sprache("TEXT26b")).' - 8% '.constant($game->sprache("TEXT26")).'</option>
	<option value="1">'.constant($game->sprache("TEXT26c")).' - 4% '.constant($game->sprache("TEXT26")).'</option>
	<option value="0">'.constant($game->sprache("TEXT26d")).' - 0% '.constant($game->sprache("TEXT26")).'</option>
	</select></td>
  <tr><td width=75>'.constant($game->sprache("TEXT21")).':</td><td><input class="field" style="width: 200px;" type="text" name="reason" value="-"></td></tr>

  </table><br>
  <input class="button" type="submit" name="payout" value="'.constant($game->sprache("TEXT33")).'">
  </form>');


  $game->out('
  <br><br><b><u>'.constant($game->sprache("TEXT28")).':</u></b>
  <form method="post" action="'.parse_link('a=alliance_taxes').'">
  <table width="300" border="0" cellpadding="2" cellspacing="2">
  <tr><td width=75>'.constant($game->sprache("TEXT10")).':</td><td><select name="tax_set" class="Select" size="1">'.$tax_list.'</select></td></tr>
  </td>
  </tr>
  </table>
  <br>
  <input class="button" type="submit" name="taxes" value="'.constant($game->sprache("TEXT34")).'">
  </form>');


}


   $sql = 'SELECT u.user_id,u.user_name
           FROM (alliance a)
           INNER JOIN (user u) ON u.user_alliance = a.alliance_id
           WHERE a.alliance_id = '.$game->player['user_alliance'].' ORDER BY u.user_name ASC'; 

   $userlist = $db->query($sql);

   while($alluser = $db->fetchrow($userlist)) {

     $user_list.='<option value="'.$alluser['user_id'].'">'.$alluser['user_name'].'</option>';

   }


   $game->out('<br><br><b><u>'.constant($game->sprache("TEXT29")).':</u></b>
   <form method="post" action="'.parse_link('a=alliance_taxes').'">
   <table width="300" border="0" cellpadding="2" cellspacing="2">
   <tr><td>'.constant($game->sprache("TEXT24")).':</td><td><select name="userlist">'.$user_list.'</select></td></tr>
   </table><br>
   <input class="button" type="submit" name="details_ress" value="'.constant($game->sprache("TEXT35")).'">&nbsp;<input class="button" type="submit" name="all_ress" value="'.constant($game->sprache("TEXT36")).'">
   </form><br><br>
  


   ');
$game->out('</td></tr>
</table></td></tr></table>

    ');
}

?>
