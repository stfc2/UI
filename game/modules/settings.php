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


// -----------------------------------------------------------------------------
// ---------------------- Image-Funktionen -------------------------------------
// -----------------------------------------------------------------------------

function getimagesize_remote($image_url) {
}


// -----------------------------------------------------------------------------
// ---------------------- Gallery-Funktionen -----------------------------------
// -----------------------------------------------------------------------------

$uploaddir = $config['uploaddir'];

function GiveThumb($path)
{
 $width=$height=100;

 if (is_file($path)!=1) $path='gallery/no_img.jpg';
 else
 {
 	$size = getimagesize($path);
 	if ($size[0]>$size[1]) {$height = 100 * ($size[1] / $size[0]);}
 	else {$width = 100 * ($size[0] / $size[1]);}
 }



return '<img src="'.$path.'" width="'.$width.'" height="'.$height.'" border=0>';
}

function upload_gallery()
{
global $game,$db,$uploaddir;
if (isset($_FILES['img_file']['name']))
{

if( substr_count( $_FILES['img_file']['type'],"jpeg" ) < 1 && substr_count( $_FILES['img_file']['type'],"jpg" ) < 1 && substr_count( $_FILES['img_file']['type'],"gif" ) < 1 && substr_count( $_FILES['img_file']['type'],"png" ) <1)
{return constant($game->sprache("TEXT1"));
}

if ($_FILES['img_file']['size']<1)
{return constant($game->sprache("TEXT2"));
}

if ($_FILES['img_file']['error']!=0)
{return constant($game->sprache("TEXT3"));
}

if ($_FILES['img_file']['size']>350000)
{	return constant($game->sprache("TEXT4"));
}

if ((int)$_POST['slot']<1 || (int)$_POST['slot']>5)
{	return constant($game->sprache("TEXT5"));
}

$name=$_POST['name'];
if (empty($_POST['name']) || !isset($_POST['name']))
{$name=$_FILES['img_file']['name'];
}
$uploadfile = $uploaddir .'img_'.$game->player['user_id'].'_'.(int)$_POST['slot'].'.img';
if (move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadfile)) {

	$db->query('UPDATE user SET user_gallery_name_'.(int)$_POST['slot'].'="'.htmlspecialchars($name).'", user_gallery_description_'.(int)$_POST['slot'].'="'.htmlspecialchars($_POST['description']).'" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
   return constant($game->sprache("TEXT6"));
} else {
   return constant($game->sprache("TEXT7"));
}


}
else return constant($game->sprache("TEXT8"));
}

// -----------------------------------------------------------------------------
// ---------------------- Gallery-Funktionen -----------------------------------
// -----------------------------------------------------------------------------



function display_general($data = array(), $message = '') {
    global $game, $RACE_DATA, $ACTUAL_TICK;
global $config;

	if(!isset($data['user_avatar'])) $data['user_avatar'] = $game->player['user_avatar'];
   if(!isset($data['user_icq'])) $data['user_icq'] = $game->player['user_icq'];
   if(!isset($data['user_signature'])) $data['user_signature'] = $game->player['user_signature'];
   if(!isset($data['user_gfxpath'])) $data['user_gfxpath'] = $game->player['user_gfxpath'];
   if(!isset($data['user_skinpath'])) $data['user_skinpath'] = $game->player['user_skinpath'];
	if(!isset($data['user_enable_sig']))$data['user_enable_sig'] = $game->player['user_enable_sig'];

	if(!isset($data['plz'])) $data['plz'] = $game->player['plz'];
	if(!isset($data['country'])) $data['country'] = $game->player['country'];


	if ($data['country']!='DE' && $data['country']!='AT' && $data['country']!='CH' &&
		$data['country']!='IT' && $data['country']!='FR' && $data['country']!='EN' &&
		$data['country']!='SP') $data['country']='XX';
	
	$stadt='';
/*
	23/04/08 - AC: Actually we have removed support for geodb localization
	if ($data['country']!='XX' && $data['plz']>0)
	{
	
		$db = new sql($config['server'].":".$config['port'], $config['geodb_database'], $config['user'], $config['password']); // create sql-object for db-connection
		$sql="SELECT * FROM geodb_locations WHERE plz like '%".$data['plz']."%' AND adm0='".$data['country']."'  ORDER BY LENGTH(plz)";  
		$r=$db->queryrow($sql);
		if (isset($r['name'])) $stadt=' ('.$r['name'].')';
              mysql_close($db);
		$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection
	}
*/
	
	
	
    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=general').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">
            '.constant($game->sprache("TEXT9")).' <b>'.$game->player['user_name'].'</b>'.( (!empty($game->player['user_rank'])) ? '&nbsp;(<i>'.$game->player['user_rank'].'</i>)' : '' ).'&nbsp;[<a href="'.parse_link('a=settings&view=delete_account').'">'.constant($game->sprache("TEXT10")).'</a>]<br>
            '.constant($game->sprache("TEXT11")).' <b>'.$RACE_DATA[$game->player['user_race']][0].'</b><br>
            '.constant($game->sprache("TEXT12")).' <b>'.(($game->SITTING_MODE) ? '************' : $game->player['user_email']).'</b><br>
            '.constant($game->sprache("TEXT13")).' <b>'.$game->player['user_id'].'</b> ('.constant($game->sprache("TEXT14")).')<br>
            '.( (!empty($game->player['user_birthday'])) ? ''.constant($game->sprache("TEXT15")).' <b>'.$game->player['user_birthday'].'</b><br>' : '' ).'
            '.( (!empty($game->player['user_identity'])) ? '<i><u>'.constant($game->sprache("TEXT16")).'</u></i><br>' : '' ).'
            
            '.( ($game->player['user_attack_protection'] > $ACTUAL_TICK) ? ''.constant($game->sprache("TEXT17")).' <b>'.format_time( ( ($game->player['user_attack_protection'] - $ACTUAL_TICK) * TICK_DURATION)).'</b>&nbsp;'.( ( 1 || ($game->player['user_attack_protection'] - USER_ATTACK_PROTECTION + USER_MIN_CANCEL_ATKPTC) < $ACTUAL_TICK ) ? '[<a href="'.parse_link('a=settings&view=cancel_atkptc').'">'.constant($game->sprache("TEXT17a")).'</a>]' : '' ).'<br>' : '' ).'
          </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><b>'.constant($game->sprache("TEXT18")).'</b></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td width="100">'.constant($game->sprache("TEXT19")).'</td>
          <td width="300">

        ');
        if ($game->player['language']=="GER")
        {
           $game->out('<select name="user_language"><option value="GER" selected>'.constant($game->sprache("TEXT20")).'</option><option value="ENG">'.constant($game->sprache("TEXT21")).'</option><option value="ITA">'.constant($game->sprache("TEXT22")).'</option><option value="FRA">'.constant($game->sprache("TEXT23")).'</option><option value="SPA">'.constant($game->sprache("TEXT24")).'</option></select></td>'); 
        }
        else if($game->player['language']=="ITA")
        {
           $game->out('<select name="user_language"><option value="GER">'.constant($game->sprache("TEXT20")).'</option><option value="ENG">'.constant($game->sprache("TEXT21")).'</option><option value="ITA" selected>'.constant($game->sprache("TEXT22")).'</option><option value="FRA">'.constant($game->sprache("TEXT23")).'</option><option value="SPA">'.constant($game->sprache("TEXT24")).'</option></select></td>');
        }
        else if($game->player['language']=="FRA")
        {
           $game->out('<select name="user_language"><option value="GER">'.constant($game->sprache("TEXT20")).'</option><option value="ENG">'.constant($game->sprache("TEXT21")).'</option><option value="ITA">'.constant($game->sprache("TEXT22")).'</option><option value="FRA" selected>'.constant($game->sprache("TEXT23")).'</option><option value="SPA">'.constant($game->sprache("TEXT24")).'</option></select></td>');
        }
        else if($game->player['language']=="SPA")
        {
           $game->out('<select name="user_language"><option value="GER">'.constant($game->sprache("TEXT20")).'</option><option value="ENG">'.constant($game->sprache("TEXT21")).'</option><option value="ITA">'.constant($game->sprache("TEXT22")).'</option><option value="FRA">'.constant($game->sprache("TEXT23")).'</option><option value="SPA" selected>'.constant($game->sprache("TEXT24")).'</option></select></td>');
        }
        else { $game->out('<select name="user_language"><option value="GER">'.constant($game->sprache("TEXT20")).'</option><option value="ENG" selected>'.constant($game->sprache("TEXT21")).'</option><option value="ITA">'.constant($game->sprache("TEXT22")).'</option><option value="FRA">'.constant($game->sprache("TEXT23")).'</option><option value="SPA">'.constant($game->sprache("TEXT24")).'</option></select></td>'); }

        $game->out('
        </tr>

        <tr>
	   <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT25")).'</td>
          <td width="300"><input style="width: 200px;" class="field" type="text" name="user_avatar" value="'.$data['user_avatar'].'"></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT26")).'</td>
          <td><input style="width: 100px;" class="field" type="text" name="user_icq" value="'.$data['user_icq'].'"></Td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT27")).'</td>
          <td><textarea name="user_signature" cols="45" rows="4">'.stripslashes($data['user_signature']).'</textarea></td>
        </tr>

        <tr>
	   <td>&nbsp;</td>
        </tr>

        <tr>
          <td valign=top>'.constant($game->sprache("TEXT28")).'</td>
          <td><input type="checkbox" name="user_enable_sig" value="1"'.( ($data['user_enable_sig']) ? ' checked="checked"' : '' ).'> '.constant($game->sprache("TEXT29")).'<br>(<a href="'.$config['game_url'].'/sig_tmp/'.strtolower($game->player['user_name']).'.jpg" target=_blank>'.$config['game_url'].'/sig.php?user='.$game->player['user_name'].'</a>)<br>
	  <i>'.constant($game->sprache("TEXT30")).'</i></td>
        </tr>

        <tr>
	   <td>&nbsp;</td>
        </tr>

        <tr>
          <td valign=top>'.constant($game->sprache("TEXT31")).'</td>
          <td><input type="checkbox" name="user_tutorial" value="1"'.( ($game->player['tutorial']==1) ? ' checked="checked"' : '' ).'> '.constant($game->sprache("TEXT29")).'</td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><b>'.constant($game->sprache("TEXT32")).'</b></td>
        </tr>
        <tr height="10"><td></td></tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT33")).'</td>
          <td width="300"><input style="width: 90px;" class="field" type="text" name="plz" value="'.$data['plz'].'"> '.$stadt.'</td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT34")).'</td>
          <td width="300">
          <select name="country">
              <option value="XX"'.( ($data['country'] == 'XX') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT35")).'</option>
              <option value="DE"'.( ($data['country'] == 'DE') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT36")).'</option>
              <option value="AT"'.( ($data['country'] == 'AT') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT37")).'</option>
              <option value="CH"'.( ($data['country'] == 'CH') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT38")).'</option>
              <option value="IT"'.( ($data['country'] == 'IT') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT39")).'</option>
              <option value="FR"'.( ($data['country'] == 'FR') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT40")).'</option>
              <option value="EN"'.( ($data['country'] == 'EN') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT41")).'</option>
              <option value="SP"'.( ($data['country'] == 'SP') ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT42")).'</option>
          </select>
          </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><b>'.constant($game->sprache("TEXT43")).'</b></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td width="100">'.constant($game->sprache("TEXT44")).'</td>
          <td width="300"><input style="width: 200px;" class="field" type="text" name="user_gfxpath" value="'.$data['user_gfxpath'].'"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT45")).'</td>
          <td width="300"><input style="width: 70px;" class="field" type="text" name="user_skinpath" value="'.$data['user_skinpath'].'"></td>
        </tr>
                <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="100" valign=top>'.constant($game->sprache("TEXT46")).'</td> <!-- HxB -->
          <td width="300" valign=top><input style="width: 70px;" class="field" type="text" name="notepad_cols" value="'.$game->player['notepad_cols'].'"> x <input style="width: 70px;" class="field" type="text" name="notepad_width" value="'.$game->player['notepad_width'].'"><br>(<b>'.constant($game->sprache("TEXT47")).'</b>)</td>
        </tr>
<tr>
          <td width="100" valign=top>'.constant($game->sprache("TEXT48")).'</td>
          <td width="300" valign=top><input size=7 class="field" type="text" name="skin_farbe" value="'.$game->player['skin_farbe'].'"> '.constant($game->sprache("TEXT49")).'</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT50")).'"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}

function display_delete_account($message = '') {
    global $game;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=delete_account').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">'.constant($game->sprache("TEXT51")).'</td>
        </tr>


        <tr height="20"><td></td></tr>

        <tr>
          <td width="140">'.constant($game->sprache("TEXT52")).'</td>
          <td width="260"><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT53")).'</i></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit_del" value="'.constant($game->sprache("TEXT10")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}

function display_cancel_atkptc($message = '') {
    global $game;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=cancel_atkptc').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">'.constant($game->sprache("TEXT55")).'</td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td width="140">'.constant($game->sprache("TEXT52")).'</td>
          <td width="260"><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT53")).'</i></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT56")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}

function display_password($message = '') {
    global $game;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=password').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td>'.constant($game->sprache("TEXT57")).'</td>
          <td><input style="width: 150px;" class="field" type="password" name="user_new_password"></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT58")).'</td>
          <td><input style="width: 150px;" class="field" type="password" name="user_new_password2"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT59")).'</i></td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td>'.constant($game->sprache("TEXT52")).'</td>
          <td><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT53")).'</i></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT50")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}





function display_loginname($message = '') {
    global $game;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=loginname').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td>'.constant($game->sprache("TEXT60")).'</td>
          <td><input style="width: 150px;" class="field" type="text" name="user_loginname" value="'.$game->player['user_loginname'].'"></td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td>'.constant($game->sprache("TEXT52")).'</td>
          <td><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT53")).'</i></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT50")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}



function display_vacation_activation($message = '') {
    global $game,$ACTUAL_TICK;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    // Retrieve last vacation data
    if($game->player['user_last_vacation'] != 0) {
        if($ACTUAL_TICK > $game->player['user_last_vacation'])
            $last_vacation = format_time( ( ($ACTUAL_TICK - $game->player['user_last_vacation']) * TICK_DURATION) );
        else
            $last_vacation = constant($game->sprache("TEXT140"));
    }
    else
        $last_vacation = constant($game->sprache("TEXT141"));

    if($game->player['user_last_vacation'] != 0) {
        $duration = $game->player['user_last_vacation_duration'].' ';
        $duration .= (($game->player['user_last_vacation_duration'] > 1) ? constant($game->sprache("TEXT50g")) : constant($game->sprache("TEXT50f")));
    }
    else
        $duration = constant($game->sprache("TEXT142"));
    //

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=vacation').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">'.constant($game->sprache("TEXT50a")).'</td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td width="140">'.constant($game->sprache("TEXT50b")).'</td>
          <td width="260">
            <select style="width: 100px;" class="select" name="start_time">
              <option value="1">'.constant($game->sprache("TEXT50c")).'</option>
              <option value="2">2 '.constant($game->sprache("TEXT50d")).'</option>
              <option value="3">3 '.constant($game->sprache("TEXT50d")).'</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT50e")).'</td>
          <td>
            <select style="width: 100px;" class="select" name="duration">
              <option value="1">1 '.constant($game->sprache("TEXT50f")).'</option>
              <option value="2">2 '.constant($game->sprache("TEXT50g")).'</option>
              <option value="3">3 '.constant($game->sprache("TEXT50g")).'</option>
            </select>
          </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td width="140">'.constant($game->sprache("TEXT143")).'</td>
          <td width="260">
          '.$last_vacation.'
          </td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT50e")).'</td>
          <td>
          '.$duration.'
          </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td>'.constant($game->sprache("TEXT52")).'</td>
          <td><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT53")).'</i></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT29")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}


function display_iplink($message = '') {
    global $game,$db;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

$linklist='';
$qry=$db->query('SELECT user_1,user_2 FROM ip_link WHERE user_1='.$game->player['user_id'].' OR user_2='.$game->player['user_id']);
while($multi = $db->fetchrow($qry)) 
{
$usr=$db->queryrow('SELECT user_id,user_name FROM user WHERE user_id='.(($game->player['user_id']==$multi['user_1']) ? $multi['user_2'] : $multi['user_1'] ));
$linklist.='<a href="'.parse_link('?a=stats&a2=viewplayer&id='.$usr['user_id']).'">'.$usr['user_name'].'</a><br>';
}

    $game->out('
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">'.constant($game->sprache("TEXT61")).'</i></b><br><br>
          <b>'.$linklist.'</b>
          </td>
        </tr>
</table>
          </td>
        </tr>
</table>
    ');
}

function display_iplog($message = '') {
    global $game,$db;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    $game->out('

    <table border="0" cellpadding="0" cellspacing="4" class="style_outer" width="400">

      <tr><td width="400">

      <table border="0" cellpadding="0" cellspacing="4" class="style_inner" width="400">

      <tr>
        <td>'.constant($game->sprache("TEXT62")).'</td>
      <tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>

        <td align="center"><table border="0" cellpadding="1" cellspacing="1" width="250">

        <tr><td width="125"><b>'.constant($game->sprache("TEXT62a")).'</b></td><td width="125"><b>'.constant($game->sprache("TEXT63")).'</b></td></tr>

      ');



      $qry=$db->query('SELECT * FROM user_iplog WHERE user_id='.$game->player['user_id'].' ORDER BY time DESC LIMIT 10');
 
      while($iplog = $db->fetchrow($qry)) {

      $game->out('<tr><td>'.date('d.m.y H:i', $iplog['time']).'</td><td>'.$iplog['ip'].'</td></tr>');
            
      }

    $game->out('

        </table></td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>'.constant($game->sprache("TEXT138")).'</td>
      <tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>

        <td align="center"><table border="0" cellpadding="1" cellspacing="1" width="250">

        <tr><td width="125"><b>'.constant($game->sprache("TEXT62a")).'</b></td><td width="125"><b>'.constant($game->sprache("TEXT139")).'</b></td></tr>

      ');



      $qry=$db->query('SELECT l.time,u.user_name AS sitter FROM (user_sitter_iplog l) LEFT JOIN (user u) ON u.user_id = l.sitter_id WHERE l.user_id='.$game->player['user_id'].' ORDER BY time DESC LIMIT 10');

      while($iplog = $db->fetchrow($qry)) {
          $game->out('<tr><td>'.date('d.m.y H:i', $iplog['time']).'</td><td>'.$iplog['sitter'].'</td></tr>');
      }


    $game->out('
        </table><td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

    </table>

    </td></tr></table>

    ');

}

function display_surrender_planet($message = '') {
	global $game,$db;

 $ticks_left = $game->planet['planet_surrender'] - $game->config['tick_id'];

 if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

 $system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$game->planet['system_id']);
	$position=$game->get_sector_name($game->planet['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($game->planet['planet_distance_id'] + 1);

 $game->out('

      <table border="0" cellpadding="0" cellspacing="4" class="style_outer" width="400">
 
      <tr><td width="400">

      <table border="0" cellpadding="0" cellspacing="4" class="style_inner" width="400">
 
      <tr>
        <td>'.constant($game->sprache("TEXT64")).'</b></td>
      </tr>

      <tr><td><table border="0" cellpadding="1" cellspacing="10" align="center">

      <tr>
        <td><b>'.constant($game->sprache("TEXT9")).'</b></td><td>'.$game->planet['planet_name'].'</td>
      </tr>

      <tr>
        <td><b>'.constant($game->sprache("TEXT65")).'</b></td><td>'.$position.'</td>
      </tr>

      <tr>
        <td><b>'.constant($game->sprache("TEXT66")).'</b></td><td>'.$game->planet['planet_points'].'</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td><b>'.constant($game->sprache("TEXT67")).'</b></td><td>'.date('d.m.y H:i', $game->planet['planet_owned_date']).'</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      </table></td></tr>
      <tr>
        <td align="center">'.( ($game->planet['planet_surrender']==0) ? '<form method="post" action="'.parse_link('a=surrender_planet').'"><input type="submit" name="exec_surrender_planet" class="button_nosize" width=45 value="'.constant($game->sprache("TEXT68")).'"></form>' : '<span style="color: #FF0000;">'.constant($game->sprache("TEXT69")).' '.format_time( $ticks_left * TICK_DURATION ).' '.constant($game->sprache("TEXT70")).'</span>' ).'</td>
      </tr>
      </table>
      </td></tr>

      </table>

 ');

}



function display_vacation_deactivation($message = '') {
    global $game, $ACTUAL_TICK;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');

    // 60 * 24 * 7 = 10080
    $duration = ( (($game->player['user_vacation_end'] - $game->player['user_vacation_start']) * TICK_DURATION) / 10080 );

    $game->out('
<form method="post" action="'.parse_link('a=settings&view=vacation').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">'.constant($game->sprache("TEXT71")).' <b>'.format_time( ( ($game->player['user_vacation_start'] - $ACTUAL_TICK) * TICK_DURATION) ).'</b> '.constant($game->sprache("TEXT72")).' <b>'.( ($duration == 1) ? ''.constant($game->sprache("TEXT73")).'' : $duration.' '.constant($game->sprache("TEXT74")).'' ).'</b>.</td>
        </tr>


        <tr height="20"><td></td></tr>

        <tr>
          <td width="140">'.constant($game->sprache("TEXT52")).'</td>
          <td width="260"><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT75")).'</i></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT76")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
    ');
}

function display_sitting($message = '') {
    global $game,$db;

    if(!empty($message)) $game->out('<center><span class="sub_caption2">'.$message.'</span></center><br>');


if (!$game->SITTING_MODE)
{

	for ($t=0; $t<5; $t++)
{
	$usr=$db->queryrow('SELECT user_name, user_id FROM user WHERE user_id='.$game->player['user_sitting_id'.($t+1)]);
	if (!isset($usr['user_id'])) {$sitting_list[$t]=constant($game->sprache("TEXT137"));}
	else $sitting_list[$t]=$usr['user_name'];
}



    $game->out('
<form method="post" action="'.parse_link('a=settings&view=sitting').'">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
    <td width="400">
      <table width="400" border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td colspan="2">'.constant($game->sprache("TEXT77")).'</td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td valign=top>'.constant($game->sprache("TEXT78")).'</td>
          <td>
          1. '.constant($game->sprache("TEXT79")).'&nbsp;&nbsp;<input style="width: 150px;" class="field"  name="receiver_1" type="text"  value="'.$sitting_list[0].'"><br>
          2. '.constant($game->sprache("TEXT79")).'&nbsp;&nbsp;<input style="width: 150px;" class="field"  name="receiver_2" type="text"  value="'.$sitting_list[1].'"><br>
          3. '.constant($game->sprache("TEXT79")).'&nbsp;&nbsp;<input style="width: 150px;" class="field"  name="receiver_3" type="text"  value="'.$sitting_list[2].'"><br>
          4. '.constant($game->sprache("TEXT79")).'&nbsp;&nbsp;<input style="width: 150px;" class="field"  name="receiver_4" type="text"  value="'.$sitting_list[3].'"><br>
          5. '.constant($game->sprache("TEXT79")).'&nbsp;&nbsp;<input style="width: 150px;" class="field"  name="receiver_5" type="text"  value="'.$sitting_list[4].'"><br>



		  </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><b>'.constant($game->sprache("TEXT80")).'</b></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>'.constant($game->sprache("TEXT81")).'</td>
          <td><input type="checkbox" name="user_sitting_o1" value="1"'.( ($game->player['user_sitting_o1'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT82")).'</td>
          <td><input type="checkbox" name="user_sitting_o3" value="1"'.( ($game->player['user_sitting_o3'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT83")).'</td>
          <td><input type="checkbox" name="user_sitting_o4" value="1"'.( ($game->player['user_sitting_o4'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT84")).'</td>
          <td><input type="checkbox" name="user_sitting_o5" value="1"'.( ($game->player['user_sitting_o5'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT85")).'</td>
          <td><input type="checkbox" name="user_sitting_o6" value="1"'.( ($game->player['user_sitting_o6'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT86")).'</td>
          <td><input type="checkbox" name="user_sitting_o7" value="1"'.( ($game->player['user_sitting_o7'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT87")).'</td>
          <td><input type="checkbox" name="user_sitting_o8" value="1"'.( ($game->player['user_sitting_o8'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT88")).'</td>
          <td><input type="checkbox" name="user_sitting_o9" value="1"'.( ($game->player['user_sitting_o9'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr>
          <td>'.constant($game->sprache("TEXT89")).'</td>
          <td><input type="checkbox" name="user_sitting_o10" value="1"'.( ($game->player['user_sitting_o10'] == 1) ? ' checked="checked"' : '' ).'></td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td>'.constant($game->sprache("TEXT52")).'</td>
          <td><input style="width: 150px;" class="field" type="password" name="current_password"></td>
        </tr>

        <tr>
          <td colspan="2"><i>'.constant($game->sprache("TEXT53")).'</i></td>
        </tr><tr>
          <td colspan="2">
          </td>
        </tr>


      </table>
    </td>
  </tr>
</table>
<br>');




$game->out('<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td width=400>
      <table border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td>');

$sql = 'SELECT user_id,user_name,num_sitting,user_vacation_start,user_vacation_end FROM user WHERE user_active=1 AND user_auth_level<>'.STGC_BOT.' AND (user_sitting_id1='.$game->player['user_id'].' OR user_sitting_id2='.$game->player['user_id'].' OR user_sitting_id3='.$game->player['user_id'].' OR user_sitting_id4='.$game->player['user_id'].' OR user_sitting_id5='.$game->player['user_id'].')ORDER by user_name ASC';
$usr = $db->query($sql);

while($user = $db->fetchrow($usr)) {

$game->out(''.$user['user_name'].'&nbsp;');

  if($user['num_sitting']==-1) {
    $game->out('<b>-<span style="color: #FFFF00;"> '.constant($game->sprache("TEXT90")).'</span></b><br>');
  }
  elseif ($user['user_vacation_start']<=$game->config['tick_id'] && $user['user_vacation_end']>=$game->config['tick_id']) {
	$game->out('<b>-<span style="color: orange;"> '.constant($game->sprache("TEXT91")).'</span></b><br>');		
  }
  else {
  $game->out('<i>[<a href='.parse_link('a=settings&view=sitting&login_sitting='.$user['user_id']).'><i>'.constant($game->sprache("TEXT92")).'</i></a>]</i><br>');	
  }
}
$game->out('

          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>');





$game->out('<br><table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <input class="button" style="width: 200px;" type="submit" name="submit" value="'.constant($game->sprache("TEXT50")).'">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>


    ');

}
else
{
$game->out('<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td width=400>
      <table border="0" cellpadding="0" cellspacing="0" class="style_inner">
        <tr>
          <td>');
$game->out(''.constant($game->sprache("TEXT93")).' <i>[<a href='.parse_link('a=settings&view=sitting&login_sitting=-1').'><i>'.constant($game->sprache("TEXT94")).'</i></a>]</i><br>');
$game->out('

          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>');
}

}

function display_gallery() {
    global $game, $RACE_DATA, $ACTUAL_TICK;
    if(!empty($message)) $game->out('<center><span class="sub_caption">'.$message.'</span></center><br>');
    if (isset($_REQUEST['mesg'])) { $_REQUEST['mesg']=stripslashes($_REQUEST['mesg']).'<br><br>'; } else { $_REQUEST['mesg']=''; }
    $game->out('<center><table border=0 cellspacing=2 cellpadding=2 width=300 class="style_outer">
    <tr><td>
    <span class="sub_caption2"><center>'.$_REQUEST['mesg'].'</center></span>
    <span class="sub_caption2">'.constant($game->sprache("TEXT95")).'</span><br><br>
    <center><table border=0 cellspacing=0 cellpadding=0 class="style_inner">

	<tr height=15><td width=150><center><b>'.$game->player['user_gallery_name_1'].'</b></td><td width=150><center><b>'.$game->player['user_gallery_name_2'].'</b></td></tr>
	<tr height=100><td width=150><center><a href="gallery.php?f=gallery/img_'.$game->player['user_id'].'_1.img" target=image onmouseover="return overlib(\''.$game->player['user_gallery_description_1'].'\', CAPTION, \''.$game->player['user_gallery_name_1'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.GiveThumb('gallery/img_'.$game->player['user_id'].'_1.img').'</a>
	</td><td width=150><center><a href="gallery.php?f=gallery/img_'.$game->player['user_id'].'_2.img" onmouseover="return overlib(\''.$game->player['user_gallery_description_2'].'\', CAPTION, \''.$game->player['user_gallery_name_2'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.GiveThumb('gallery/img_'.$game->player['user_id'].'_2.img').'</a></td></tr>
	<tr height=15><td width=150><center>[<a href="'.parse_link('a=settings&view=gallery&rm_img=1').'">'.constant($game->sprache("TEXT96")).'</a>]&nbsp; [<a href="'.parse_link('a=settings&view=gallery&avatar_img=1').'">'.constant($game->sprache("TEXT97")).'</a>]</center></td><td width=150><center>[<a href="'.parse_link('a=settings&view=gallery&rm_img=2').'">'.constant($game->sprache("TEXT96")).'</a>]&nbsp; [<a href="'.parse_link('a=settings&view=gallery&avatar_img=2').'">'.constant($game->sprache("TEXT97")).'</a>]</center></td></tr>

	<tr height=20><td>&nbsp;</td><td>&nbsp;</td></tr>

	<tr height=15><td width=150><center><b>'.$game->player['user_gallery_name_3'].'</b></td><td width=150><center><b>'.$game->player['user_gallery_name_4'].'</b></td></tr>
	<tr height=100><td width=150><center><a href="gallery.php?f=gallery/img_'.$game->player['user_id'].'_3.img" onmouseover="return overlib(\''.$game->player['user_gallery_description_3'].'\', CAPTION, \''.$game->player['user_gallery_name_3'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.GiveThumb('gallery/img_'.$game->player['user_id'].'_3.img').'</a></td><td width=150><center><a href="gallery.php?f=gallery/img_'.$game->player['user_id'].'_4.img" onmouseover="return overlib(\''.$game->player['user_gallery_description_4'].'\', CAPTION, \''.$game->player['user_gallery_name_4'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.GiveThumb('gallery/img_'.$game->player['user_id'].'_4.img').'</a></td></tr>
	<tr height=15><td width=150><center>[<a href="'.parse_link('a=settings&view=gallery&rm_img=3').'">'.constant($game->sprache("TEXT96")).'</a>]&nbsp; [<a href="'.parse_link('a=settings&view=gallery&avatar_img=3').'">'.constant($game->sprache("TEXT97")).'</a>]</center></td><td width=150><center>[<a href="'.parse_link('a=settings&view=gallery&rm_img=4').'">'.constant($game->sprache("TEXT96")).'</a>]&nbsp; [<a href="'.parse_link('a=settings&view=gallery&avatar_img=4').'">'.constant($game->sprache("TEXT97")).'</a>]</center></td></tr>

	<tr height=30><td>&nbsp;</td><td>&nbsp;</td></tr>

	</table><table border=0 cellspacing=0 cellpadding=0 class="style_inner">

	<tr height=15><td width=150><center><b>'.$game->player['user_gallery_name_5'].'</b></td></tr>
	<tr height=100><td width=150><center><a href="gallery.php?f=gallery/img_'.$game->player['user_id'].'_5.img" onmouseover="return overlib(\''.$game->player['user_gallery_description_5'].'\', CAPTION, \''.$game->player['user_gallery_name_5'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.GiveThumb('gallery/img_'.$game->player['user_id'].'_5.img').'</a></td></tr>
	<tr height=15><td width=150><center>[<a href="'.parse_link('a=settings&view=gallery&rm_img=5').'">'.constant($game->sprache("TEXT96")).'</a>]&nbsp; [<a href="'.parse_link('a=settings&view=gallery&avatar_img=5').'">'.constant($game->sprache("TEXT97")).'</a>]</center></td></tr>
	</table>
	</center>
	</td></tr></table></center>

	');


    $game->out('
<form enctype="multipart/form-data" action="'.parse_link('a=settings&view=gallery').'" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="400000" />
<table align="center" border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr>
  <td width="400"><span class="sub_caption2">'.constant($game->sprache("TEXT98")).'</span>

		<table border=0 cellpadding=0 cellspacing=0 class="style_inner" width="100%">
			<tr><td>'.constant($game->sprache("TEXT99")).'</td><td><input type="text" name="name" size="16" class="field_nosize" value=""></td></tr>
			<tr><td>'.constant($game->sprache("TEXT100")).'</td><td><input type="text" name="description" size="30" class="field_nosize" value=""></td></tr>
			<tr><td>'.constant($game->sprache("TEXT101")).'</td><td><select name="slot" class="Select" size="1">
			<option value="1">'.$game->player['user_gallery_name_1'].'</option>
			<option value="2">'.$game->player['user_gallery_name_2'].'</option>
			<option value="3">'.$game->player['user_gallery_name_3'].'</option>
			<option value="4">'.$game->player['user_gallery_name_4'].'</option>
			<option value="5">'.$game->player['user_gallery_name_5'].'</option>
			</select>
			</td></tr>
            <tr><td>'.constant($game->sprache("TEXT102")).'</td><td><input class="field_nosize" type="file"  name="img_file" accept="jpg/jpeg" maxlength="400000"></td></tr>
	<tr><td colspan=2><br><center><input class="button" style="width: 100;" type="submit" name="submit" value="'.constant($game->sprache("TEXT103")).'"></center>
	</td></tr>
        </table>
    </td>
  </tr>
</table>
</form>
    ');
}


$game->init_player();

if(!$game->SITTING_MODE) {
    $SETTINGS_MODULES = array(
        'general' => constant($game->sprache("TEXT104")),
        'password' => constant($game->sprache("TEXT105")),
        'loginname' => constant($game->sprache("TEXT106")),
        'vacation' => constant($game->sprache("TEXT107")),
        'sitting' => constant($game->sprache("TEXT108")),
        'gallery' => constant($game->sprache("TEXT109")),
       'iplog' => constant($game->sprache("TEXT110")),
       'colony' => constant($game->sprache("TEXT111"))
//      'iplink' => constant($game->sprache("TEXT112"))
    );
}
else {

    $SETTINGS_MODULES['sitting']=constant($game->sprache("TEXT108"));
    if ($game->player['user_sitting_o10'] == 1) $SETTINGS_MODULES['general']=constant($game->sprache("TEXT104"));
    }

if ($game->SITTING_MODE && $game->player['user_sitting_o10'] != 1) $module = (isset($_GET['view'])) ? $_GET['view'] : 'sitting';
else $module = (isset($_GET['view'])) ? $_GET['view'] : 'general';


$game->out('<center><span class="caption">'.constant($game->sprache("TEXT113")).'</span><br><br>'.display_view_navigation('settings', $module, $SETTINGS_MODULES).'&nbsp;&nbsp;[<a href="template_manager.php" target="_blank">Skin</a>]</center><br>');

switch($module) {
    case 'general':
        if ($game->SITTING_MODE && $game->player['user_sitting_o10'] != 1) exit;

        if(!empty($_POST['submit'])) {
            if(check_forbidden_url($_POST['user_avatar'])) {
                display_general($_POST, constant($game->sprache("TEXT114")));
                return;
            }

            if($_POST['user_avatar'] != $game->player['user_avatar']) {
            	if(!$fp = fopen($_POST['user_avatar'], 'rb')) {
            		display_general($_POST, constant($game->sprache("TEXT115")));
            	}
				$n = 0;

				while($n <= 10) {
					$data = fread($fp, 10240);

					if(strlen($data) == 0) break;

					++$n;
				}

				fclose($fp);

				if($n == 11) {
					display_general($_POST, constant($game->sprache("TEXT116")));
				}
			}

            if(strlen($_POST['user_signature']) > 1000) {
                display_general($_POST, ''.constant($game->sprache("TEXT117")).''.strlen($_POST['user_signature']).' '.constant($game->sprache("TEXT118")).'');
                return;
            }

            if(!empty($_POST['user_icq'])) {
                if(!is_numeric($_POST['user_icq'])) {
                    display_general($_POST, constant($game->sprache("TEXT119")));
                    return;
                }
            }

/* 04/02/08 - AC: Old method, now the game can support other languages.
              Also the fallback language is now english and not german.
            if($_POST['user_language'] != 'GER' && $_POST['user_language'] != 'ENG') { $_POST['user_language'] = 'GER'; }
*/
            if($_POST['user_language'] == '') { $_POST['user_language'] = 'ENG'; }

            if(!empty($_POST['user_gfxpath'])) {
                $_POST['user_gfxpath'] = str_replace('\\', '/', stripslashes($_POST['user_gfxpath']));

                if(substr($_POST['user_gfxpath'], -1, 1) != '/') $_POST['user_gfxpath'] .= '/';
            }
            else {
                $_POST['user_gfxpath'] = FIXED_GFX_PATH;
            }

            if(empty($_POST['user_tutorial'])) $_POST['user_tutorial']==0;
            if($_POST['user_tutorial']<0 && $_POST['user_tutorial']>1) $_POST['user_tutorial']==0;

            if(!empty($_POST['user_skinpath'])) {
                $_POST['user_skinpath'] = str_replace('\\', '/', stripslashes($_POST['user_skinpath']));

                if(substr($_POST['user_skinpath'], -1, 1) != '/') $_POST['user_skinpath'] .= '/';
            }



            if ($_POST['country']!='DE' && $_POST['country']!='AT' && $_POST['country']!='CH' &&
                $_POST['country']!='IT' && $_POST['country']!='FR' && $_POST['country']!='EN' &&
                $_POST['country']!='SP') $_POST['country']='XX';


            $sql = 'UPDATE user
                    SET user_avatar = "'.addslashes($_POST['user_avatar']).'",
                        user_icq = "'.addslashes($_POST['user_icq']).'",
                        user_signature = "'.addslashes($_POST['user_signature']).'",
                        user_gfxpath = "'.str_replace('"',' ',$_POST['user_gfxpath']).'",
                        user_skinpath = "'.str_replace('"',' ',$_POST['user_skinpath']).'",
                        language = "'.$_POST['user_language'].'",
                        tutorial = "'.$_POST['user_tutorial'].'",
                        notepad_cols = "'.(int)$_POST['notepad_cols'].'",
                        notepad_width = "'.(int)$_POST['notepad_width'].'",
                        skin_farbe = "'.htmlspecialchars($_POST['skin_farbe']).'",
                        user_enable_sig = '.(int)$_POST['user_enable_sig'].',
                        plz = "'.addslashes($_POST['plz']).'",
                        country = "'.$_POST['country'].'"
                    WHERE user_id = '.$game->player['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user data');
            }

            redirect('a=settings&view=general');
        }

        display_general();
    break;

    case 'delete_account':
         if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT120")));
        }

        if(!empty($_POST['submit_del'])) {
            if(md5($_POST['current_password']) != $game->player['user_password']) {
                display_delete_account(constant($game->sprache("TEXT121")));
                return;
            }

            $sql = 'UPDATE user
                    SET user_active = 3
                    WHERE user_id = '.$game->player['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user active data');
            }

            include_once('include/libs/email.php');

            $reg_ip_split = explode('.', $game->player['user_registration_ip']);
            $last_ip_split = explode('.', $game->player['last_ip']);

            $confirm_key = md5( ((int)$reg_ip_split[0] + (int)$reg_ip_split[1] + (int)$reg_ip_split[2] + (int)$reg_ip_split[3]) * ((int)$last_ip_split[0] + (int)$last_ip_split[1] + (int)$last_ip_split[2] + (int)$last_ip_split[3]) - (int)$game->uid );

            $confirm_link = $config['site_url'].'/index.php?a=delete&galaxy='.$config['galaxy'].'&user_id='.$game->player['user_id'].'&key='.$confirm_key;

            $mail_message = $game->player['user_name'].',

'.constant($game->sprache("TEXT122")).'

'.$confirm_link.'

Lunga vita e prosperità,
il team STFC.


Credits: '.$config['site_url'].'/index.php?a=imprint';

            stgc_mail('STFC2 Mailer', 'admin@stfc.it', $game->player['user_name'], $game->player['user_email'], 'Star Trek: Frontline Combat - '.constant($game->sprache("TEXT54")), $mail_message);
            header('Location: '.$config['site_url']);
            exit;
        }

        display_delete_account();
    break;

    case 'cancel_atkptc':
        if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT123")));
        }
        
        /*
        if( ( ($game->player['user_attack_protection'] - USER_ATTACK_PROTECTION + USER_MIN_CANCEL_ATKPTC) > $ACTUAL_TICK ) ) {
            message(NOTICE, 'Der Angriffsschutz darf fr&uuml;hstens nach 300 Ticks (15h) abgebrochen werden.');
        }  */

        if(!empty($_POST['submit'])) {
            if(md5($_POST['current_password']) != $game->player['user_password']) {
                display_cancel_atkptc(constant($game->sprache("TEXT121")));
                return;
            }

            $sql = 'UPDATE user
                    SET user_attack_protection = 0
                    WHERE user_id = '.$game->player['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user attack protection data');
            }
            
            //SystemMessage(DATA_UID, 'Angriffsschutz abgebrochen', $game->player['user_race'].' hat den Angriffsschutz abgebrochen.');

            redirect('a=settings&view=general');
        }

        display_cancel_atkptc();
    break;

    case 'password':
        if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT124")));
        }

        if(!empty($_POST['submit'])) {
            if(md5($_POST['current_password']) != $game->player['user_password']) {
                display_password(constant($game->sprache("TEXT121")));
                return;
            }

            if(empty($_POST['user_new_password'])) {
                display_password(constant($game->sprache("TEXT125")));
                return;
            }

            if($_POST['user_new_password'] != $_POST['user_new_password2']) {
                display_password(constant($game->sprache("TEXT126")));
                return;
            }

            $sql = 'UPDATE user
                    SET user_password = "'.md5($_POST['user_new_password']).'"
                    WHERE user_id = '.$game->player['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user password');
            }

            redirect('a=settings&view=password');
        }

        display_password();
    break;

    case 'loginname':
        if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT124")));
        }

        if(!empty($_POST['submit'])) {
            if(md5($_POST['current_password']) != $game->player['user_password']) {
                display_loginname(constant($game->sprache("TEXT121")));
                return;
            }

            if(empty($_POST['user_loginname'])) {
                display_loginname(constant($game->sprache("TEXT127")));
                return;
            }

            if($_POST['user_loginname']==$game->player['user_loginname']) {
                display_loginname(constant($game->sprache("TEXT128")));
                return;
            }

            $sql = 'UPDATE user
                    SET user_loginname = "'.$_POST['user_loginname'].'"
                    WHERE user_id = '.$game->player['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user loginname');
            }

            redirect('a=settings&view=loginname');
        }

        display_loginname();
    break;

    case 'vacation':
        if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT124")));
        }

        if($game->player['user_vacation_start'] > $ACTUAL_TICK) {
            if(!empty($_POST['submit'])) {
                if(md5($_POST['current_password']) != $game->player['user_password']) {
                    display_vacation_deactivation(constant($game->sprache("TEXT121")));
                    return;
                }

                $sql = 'UPDATE user
                        SET user_vacation_start = 0,
                            user_vacation_end = 0
                        WHERE user_id = '.$game->player['user_id'];

                if(!$db->query($sql)) {
                    message(DATABASE_ERROR, 'Could not update user vacation data');
                }

                redirect('a=settings&view=vacation');
            }

            display_vacation_deactivation();
        }
        else {
            if(!empty($_POST['submit'])) {
               if(md5($_POST['current_password']) != $game->player['user_password']) {
                    display_vacation_activation(constant($game->sprache("TEXT121")));
                    return;
                }

                // Let's check if the player can issue a new vacation period
                if($ACTUAL_TICK < ($game->player['user_last_vacation'] +
                                 (($game->player['user_last_vacation_duration'] * 7 * 24 * 60) / TICK_DURATION))) {
                    switch($game->player['user_last_vacation_duration'])
                    {
                        case 1:
                            $message = constant($game->sprache("TEXT144"));
                        break;
                        case 2:
                            $message = constant($game->sprache("TEXT145"));
                        break;
                        case 3:
                            $message = constant($game->sprache("TEXT146"));
                        break;
                    }
                    display_vacation_activation($message);
                    return;
                }

                $start_time = (int)$_POST['start_time'];
                $duration = (int)$_POST['duration'];

                if( ($start_time < 1) || ($start_time > 3) ) {
                    message(NOTICE, constant($game->sprache("TEXT129")));
                }

                if( ($duration < 1) || ($duration > 3) ) {
                    message(NOTICE, constant($game->sprache("TEXT130")));
                }

                $start_tick = ($ACTUAL_TICK + floor( (($start_time * 24 * 60) / TICK_DURATION) ));
                $end_tick = ($start_tick + floor( (($duration * 7 * 24 * 60) / TICK_DURATION) ));

                $sql = 'UPDATE user
                        SET user_vacation_start = '.$start_tick.',
                            user_vacation_end = '.$end_tick.'
                        WHERE user_id = '.$game->player['user_id'];

                if(!$db->query($sql)) {
                    message(DATABASE_ERROR, 'Could not update user vacation data');
                }

                redirect('a=settings&view=vacation');
            }

            display_vacation_activation();
        }
    break;

    case 'sitting':
        //if ($game->player['user_id']>4) {message(NOTICE, 'Der Sitting-Modus wird noch &uuml;berarbeitet und ist deaktiviert');exit;}

        if($game->SITTING_MODE) {
            if(!empty($_GET['login_sitting'])) {
                $cookie_data = array(
                    'user_id' => $game->player['sitting_user_id'],
                    'user_password' => $game->player['sitting_user_password']);

                    if(!setcookie('stgc5_session', base64_encode(serialize($cookie_data)), (time() + (60 * 60 * 24 * 30)) )) {
                        message(GENERAL, constant($game->sprache("TEXT131")), 'setcookie() = false');}

                    redirect('a=settings&view=sitting');
            }
            else display_sitting();
        }
        else
        {
            if(!empty($_GET['login_sitting'])) {
                $_GET['login_sitting']=(int)$_GET['login_sitting'];

                $cookie_data = array(
                    'user_id' => $game->player['user_id'],
                    'user_password' => $game->player['user_password'],
                    'sitting_user_id' => $_GET['login_sitting']
                );

                if(!setcookie('stgc5_session', base64_encode(serialize($cookie_data)), (time() + (60 * 60 * 24 * 30)) )) {
                    message(GENERAL, constant($game->sprache("TEXT131")), 'setcookie() = false');
                }
                 redirect('a=settings&view=sitting');
            }
            else if(!empty($_POST['submit'])) {
                if(md5($_POST['current_password']) != $game->player['user_password']) {
                    display_sitting(constant($game->sprache("TEXT121")));
                    return;
                }

                if(!empty($_POST['user_sitting_password'])) {
                    $game->player['user_sitting_password'] = md5($_POST['user_sitting_password']);
                }

                $receiver_1=$db->queryrow('SELECT user_id FROM user WHERE user_name="'.htmlspecialchars($_POST['receiver_1']).'" AND user_active=1');
                $receiver_2=$db->queryrow('SELECT user_id FROM user WHERE user_name="'.htmlspecialchars($_POST['receiver_2']).'" AND user_active=1');
                $receiver_3=$db->queryrow('SELECT user_id FROM user WHERE user_name="'.htmlspecialchars($_POST['receiver_3']).'" AND user_active=1');
                $receiver_4=$db->queryrow('SELECT user_id FROM user WHERE user_name="'.htmlspecialchars($_POST['receiver_4']).'" AND user_active=1');
                $receiver_5=$db->queryrow('SELECT user_id FROM user WHERE user_name="'.htmlspecialchars($_POST['receiver_5']).'" AND user_active=1');
                if (!isset($receiver_1['user_id'])) $receiver_1['user_id']=-1;
                if (!isset($receiver_2['user_id'])) $receiver_2['user_id']=-1;
                if (!isset($receiver_3['user_id'])) $receiver_3['user_id']=-1;
                if (!isset($receiver_4['user_id'])) $receiver_4['user_id']=-1;
                if (!isset($receiver_5['user_id'])) $receiver_5['user_id']=-1;

                $sql = 'UPDATE user
                        SET user_sitting_password = "'.$game->player['user_sitting_password'].'",
                            user_sitting_o1 = '.(int)$_POST['user_sitting_o1'].',
                            user_sitting_o3 = '.(int)$_POST['user_sitting_o3'].',
                            user_sitting_o4 = '.(int)$_POST['user_sitting_o4'].',
                            user_sitting_o5 = '.(int)$_POST['user_sitting_o5'].',
                            user_sitting_o6 = '.(int)$_POST['user_sitting_o6'].',
                            user_sitting_o7 = '.(int)$_POST['user_sitting_o7'].',
                            user_sitting_o8 = '.(int)$_POST['user_sitting_o8'].',
                            user_sitting_o9 = '.(int)$_POST['user_sitting_o9'].',
                            user_sitting_o10 = '.(int)$_POST['user_sitting_o10'].',
                            user_sitting_id1 = '.(int)$receiver_1['user_id'].',
                            user_sitting_id2 = '.(int)$receiver_2['user_id'].',
                            user_sitting_id3 = '.(int)$receiver_3['user_id'].',
                            user_sitting_id4 = '.(int)$receiver_4['user_id'].',
                            user_sitting_id5 = '.(int)$receiver_5['user_id'].'
                        WHERE user_id = '.$game->player['user_id'];

                if(!$db->query($sql)) {
                    message(DATABASE_ERROR, 'Could not update user sitting data');
                }

                redirect('a=settings&view=sitting');
            }

            display_sitting();
        }
    break;

    case 'gallery':
        if (isset($_FILES['img_file']['name'])) redirect('a=settings&view=gallery&mesg='.upload_gallery());
        if (isset($_REQUEST['rm_img']))
        {
            $nr=(int)$_REQUEST['rm_img'];
            if ($nr<1 || $nr>5) redirect('a=settings&view=gallery&mesg='.constant($game->sprache("TEXT132")));
            $uploadfile = $uploaddir .'img_'.$game->player['user_id'].'_'.(int)$nr.'.img';
            if (!unlink($uploadfile)) redirect('a=settings&view=gallery&mesg='.constant($game->sprache("TEXT132")));
            $db->query('UPDATE user SET user_gallery_name_'.(int)$nr.'="'.constant($game->sprache("TEXT133")).'", user_gallery_description_'.(int)$nr.'="" WHERE user_id='.$game->player['user_id'].' LIMIT 1');
            redirect('a=settings&view=gallery&mesg='.constant($game->sprache("TEXT134")));
        }

        if (isset($_REQUEST['avatar_img']))
        {
            $nr=(int)$_REQUEST['avatar_img'];
            if ($nr<1 || $nr>5) redirect('a=settings&view=gallery&mesg='.constant($game->sprache("TEXT135")));
            if (!is_file('gallery/img_'.$game->player['user_id'].'_'.$nr.'.img')) redirect('a=settings&view=gallery&mesg='.constant($game->sprache("TEXT135")));
            $db->query('UPDATE user SET user_avatar="gallery/img_'.$game->player['user_id'].'_'.$nr.'.img" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
            redirect('a=settings&view=gallery&mesg='.constant($game->sprache("TEXT136")));
        }


        display_gallery();
    break;
    case 'iplink':
        display_iplink();
    break;

    case 'iplog':
        if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT124")));
        }

        display_iplog();
    break;

    case 'colony':
        if($game->SITTING_MODE) {
            message(NOTICE, constant($game->sprache("TEXT124")));
        }

        display_surrender_planet();
    break;
}

?>
