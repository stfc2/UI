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

$main_html .= '<span class=header>Utenti</span><br><br>';

if (!isset($_REQUEST['order']) || empty($_REQUEST['order'])) $_REQUEST['order']=1;

switch($_REQUEST['order'])
{
	case 2:
		$sql = 'SELECT * FROM user ORDER by user_name ASC';
		$col_id = '<a href="'.parse_link('p=stats&order=1').'">ID</a>';
		$col_name = '<b>Nome</b>';
		$col_regtime = '<a href="'.parse_link('p=stats&order=3').'">Registrazione</a>';
		$col_lastact = '<a href="'.parse_link('p=stats&order=4').'">Attivo il</a>';
		$col_regip = '<a href="'.parse_link('p=stats&order=5').'">IP registrazione</a>';
		$col_lastip = '<a href="'.parse_link('p=stats&order=6').'">Ultimo IP</a>';
		$col_rights = '<a href="'.parse_link('p=stats&order=7').'">Permessi</a>';
	break;
	case 3:
		$sql = 'SELECT * FROM user ORDER by user_registration_time ASC';
		$col_id = '<a href="'.parse_link('p=stats&order=1').'">ID</a>';
		$col_name = '<a href="'.parse_link('p=stats&order=2').'">Nome</a>';
		$col_regtime = '<b>Registrazione</b>';
		$col_lastact = '<a href="'.parse_link('p=stats&order=4').'">Attivo il</a>';
		$col_regip = '<a href="'.parse_link('p=stats&order=5').'">IP registrazione</a>';
		$col_lastip = '<a href="'.parse_link('p=stats&order=6').'">Ultimo IP</a>';
		$col_rights = '<a href="'.parse_link('p=stats&order=7').'">Permessi</a>';
	break;
	case 4:
		$sql = 'SELECT * FROM user ORDER by last_active DESC';
		$col_id = '<a href="'.parse_link('p=stats&order=1').'">ID</a>';
		$col_name = '<a href="'.parse_link('p=stats&order=2').'">Nome</a>';
		$col_regtime = '<a href="'.parse_link('p=stats&order=3').'">Registrazione</a>';
		$col_lastact = '<b>Attivo il</b>';
		$col_regip = '<a href="'.parse_link('p=stats&order=5').'">IP registrazione</a>';
		$col_lastip = '<a href="'.parse_link('p=stats&order=6').'">Ultimo IP</a>';
		$col_rights = '<a href="'.parse_link('p=stats&order=7').'">Permessi</a>';
	break;
	case 5:
		$sql = 'SELECT * FROM user ORDER by user_registration_ip DESC';
		$col_id = '<a href="'.parse_link('p=stats&order=1').'">ID</a>';
		$col_name = '<a href="'.parse_link('p=stats&order=2').'">Nome</a>';
		$col_regtime = '<a href="'.parse_link('p=stats&order=3').'">Registrazione</a>';
		$col_lastact = '<a href="'.parse_link('p=stats&order=4').'">Attivo il</a>';
		$col_regip = '<b>IP registrazione</b>';
		$col_lastip = '<a href="'.parse_link('p=stats&order=6').'">Ultimo IP</a>';
		$col_rights = '<a href="'.parse_link('p=stats&order=7').'">Permessi</a>';
	break;
	case 6:
		$sql = 'SELECT * FROM user ORDER by last_ip ASC';
		$col_id = '<a href="'.parse_link('p=stats&order=1').'">ID</a>';
		$col_name = '<a href="'.parse_link('p=stats&order=2').'">Nome</a>';
		$col_regtime = '<a href="'.parse_link('p=stats&order=3').'">Registrazione</a>';
		$col_lastact = '<a href="'.parse_link('p=stats&order=4').'">Attivo il</a>';
		$col_regip = '<a href="'.parse_link('p=stats&order=5').'">IP registrazione</a>';
		$col_lastip = '<b>Ultimo IP</b>';
		$col_rights = '<a href="'.parse_link('p=stats&order=7').'">Permessi</a>';
	break;
	case 7:
		$sql = 'SELECT * FROM user ORDER by user_auth_level ASC';
		$col_id = '<a href="'.parse_link('p=stats&order=1').'">ID</a>';
		$col_name = '<a href="'.parse_link('p=stats&order=2').'">Nome</a>';
		$col_regtime = '<a href="'.parse_link('p=stats&order=3').'">Registrazione</a>';
		$col_lastact = '<a href="'.parse_link('p=stats&order=4').'">Attivo il</a>';
		$col_regip = '<a href="'.parse_link('p=stats&order=5').'">IP registrazione</a>';
		$col_lastip = '<a href="'.parse_link('p=stats&order=6').'">Ultimo IP</a>';
		$col_rights = '<b>Permessi</b>';
	break;
	default:
		$sql = 'SELECT * FROM user ORDER by user_id ASC';
		$col_id = '<b>ID</b>';
		$col_name = '<a href="'.parse_link('p=stats&order=2').'">Nome</a>';
		$col_regtime = '<a href="'.parse_link('p=stats&order=3').'">Registrazione</a>';
		$col_lastact = '<a href="'.parse_link('p=stats&order=4').'">Attivo il</a>';
		$col_regip = '<a href="'.parse_link('p=stats&order=5').'">IP registrazione</a>';
		$col_lastip = '<a href="'.parse_link('p=stats&order=6').'">Ultimo IP</a>';
		$col_rights = '<a href="'.parse_link('p=stats&order=7').'">Permessi</a>';
	break;
}

    $main_html .= '

<table class="style_outer" border="1" cellpadding="2" cellspacing="2" width="700">
  <tr>
    <td>
      '.$col_id.'
    </td>
    <td>
      '.$col_name.'
    </td>
    <td>
      '.$col_regtime.'
    </td>
    <td>
      '.$col_lastact.'
    </td>
	<td>
      '.$col_regip.'
    </td>
	<td>
      '.$col_lastip.'
    </td>
    <td>
      '.$col_rights.'
    </td>
  </tr>

    ';


$qry=$db->query($sql);

/* Calcolo sette giorni prima di adesso */
$today = time();
$oneWeek = (7 * 24 * 60 * 60);

while($supporter = $db->fetchrow($qry)) 
{

$rights='Utente';
if ($supporter['user_auth_level']==2) $rights='Support';
if ($supporter['user_auth_level']==3) $rights='Multihunter';


/* Utente rimasto attivo pochissimo dopo ia registrazione */
if($supporter['last_active']<=$supporter['user_registration_time']+3600)
	$main_html .= '<tr bgcolor=crimson>';
else if($today - $supporter['last_active'] > $oneWeek)
	$main_html .= '<tr bgcolor=yellow>';
else
	$main_html .= '<tr>';



$main_html .= '
    <td>
      '.$supporter['user_id'].'
    </td>
    <td>
      '.$supporter['user_name'].'
    </td>
    <td>
      '.date('d.m.y H:i:s', $supporter['user_registration_time']).'
    </td>
    <td>
      '.date('d.m.y H:i:s', $supporter['last_active']).'
    </td>
    <td>
      '.$supporter['user_registration_ip'].'
    </td>
    <td>
      '.$supporter['last_ip'].'
    </td>
    <td>
      '.$rights.'
    </td>
    </tr>

    ';
}

$main_html .= '</table><br>';




    $main_html .= '

    </td>

  </tr>

</table>

    ';

?>