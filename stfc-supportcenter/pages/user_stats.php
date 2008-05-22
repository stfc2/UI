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

$config=$db->queryrow('SELECT * FROM config');

$player_1=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_active=1');
$player_2=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_active=0');
$player_3=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_active=2');

$main_html .= '<span class=header>Spieler bearbeiten</span><br><br>
<span class=header3><a href="index.php?p=user_stats&active">'.$player_1['num'].' Spieler aktiv</a></span><br>
<span class=header3><a href="index.php?p=user_stats&banned">'.$player_2['num'].' Spieler gebannt</a></span><br>
<span class=header3><a href="index.php?p=user_stats&notactive">'.$player_3['num'].' Spieler haben ihren Account noch nicht aktiviert</a></span><br>
';


if (isset($_GET['active']) || isset($_GET['banned']) || isset($_GET['notactive']))
{
$main_html .= '<br>Achtung: <font color=green>GRÜN</font> markierte Spieler stehen unter Angriffsschutz!<br><center><table boder=0 cellpadding=1 cellspacing=1 width=800 class="style_inner">
<tr>
<td width=75>
<b>Platz:</b>
</td>
<td width=200>
<b>Name:</b>
</td>
<td width=100>
<b>Allianz:</b>
</td>
<td width=100>
<b>Planeten:</b>
</td>
<td width=100>
<b>Punkte:</b>
</td>
<td width=100>
<b>Verdienst:</b>
</td>
<td width=100>
<b>Aktiv:</b>
</td>
<td width=100>
<b>Options:</b>
</td>

</tr>
';


if (isset($_GET['active']))
$rankquery=$db->query('SELECT u.*,a.alliance_tag,a.alliance_name FROM user u LEFT JOIN alliance a ON a.alliance_id=u.user_alliance WHERE u.user_active=1 ORDER by u.user_rank_points ASC');
if (isset($_GET['banned']))
$rankquery=$db->query('SELECT u.*,a.alliance_tag,a.alliance_name FROM user u LEFT JOIN alliance a ON a.alliance_id=u.user_alliance WHERE u.user_active=0 ORDER by u.user_rank_points ASC');
if (isset($_GET['notactive']))
$rankquery=$db->query('SELECT u.*,a.alliance_tag,a.alliance_name FROM user u LEFT JOIN alliance a ON a.alliance_id=u.user_alliance WHERE u.user_active=2 ORDER by u.user_rank_points ASC');

while (($player = $db->fetchrow($rankquery)) != false)
{
$tag="-";
if (!empty($player['alliance_tag'])) $tag='['.$player['alliance_tag'].']';

$main_html .= '
'.($player['user_attack_protection']>=$config['tick_id'] ? '<tr bgcolor=green>' : '<tr>').'
<td>
'.$player['user_rank_points'].'
</td>
<td>'.$player['user_name'].'</td>
<td>'.$tag.'</td>
<td>
'.$player['user_planets'].'
</td>
<td>
'.$player['user_points'].'
</td>
<td>
'.$player['user_honor'].'
</td>
<td>
'.($player['user_vacation_start']<=$config['tick_id'] && $player['user_vacation_end']>=$config['tick_id'] ?  'Urlaubsmodus' : gmdate('d.m.y H:i',$player['last_active'])).'
</td>
<td>
<a href="index.php?p=user&name='.$player['user_name'].'">Profil editieren</a>
</td>
</tr>';

}
$main_html .= '</table>';

	
	
	
	
	
}


?>
