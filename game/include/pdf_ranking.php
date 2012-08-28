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

// #############################################################################

// Game-Object
//include('functions.php');
//$game = new game();

// #############################################################################
// SQL-Object for Database access
include('global.php');
include('sql.php');
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection

if(isset($_GET['sql_debug'])) $db->debug = true;

// #############################################################################
// Session-System
//include('session.php');

// #############################################################################
//Generation

require('html2fpdf/html2fpdf.php'); 

class PDF extends HTML2FPDF {
}

function get_alliance_tag($alliance_id) {
  global $db;

    $sql ='SELECT alliance_tag FROM alliance WHERE alliance_id = '.$alliance_id;

    if(($alliance_tag = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

    $name = $alliance_tag['alliance_tag'];

    return $name;

}


/* 12/06/08 - AC: Translate also this! 
switch($game->player['language'])
{
  case 'GER':
    $place = 'Platz:';
    $name = 'Name:';
    $alliance = 'Allianz:';
    $planets = 'Planeten:';
    $points = 'Punkte:';
    $honor = 'Verdienst:';
    $member = 'Member:';
    $pointsavg ='Punkte Ø :';

    $userrank = 'Aktuelles STFC2 User-Ranking';
    $allyrank = 'Aktuelles STFC2 Allianz-Ranking';

    $created = 'Erstellt am ';
  break;
  case 'ITA':
    $place = 'Posizione:';
    $name = 'Nome:';
    $alliance = 'Alleanza:';
    $planets = 'Pianeti:';
    $points = 'Punti:';
    $honor = 'Onore:';
    $members = 'Membri:';
    $pointsavg ='Media punti:';

    $userrank = 'Classifica attuale utenti STFC2';
    $allyrank = 'Classifica attuale alleanze STFC2';

    $created = 'Creata il ';
  break;
  default:*/
    $place = 'Place:';
    $name = 'Name:';
    $alliance = 'Alliance:';
    $planets = 'Planets:';
    $points = 'Points:';
    $honor = 'Honor:';
    $members = 'Members:';
    $pointsavg ='Points Ø:';

    $userrank = 'Actual STFC2 User Ranking';
    $allyrank = 'Actual STFC Alliance Ranking';

    $created = 'Created on ';
/*  break;
}
**/

if(isset($_GET['action'])) {

  $rang_user=1;
  $rang_alliance=1;

  $order = $_GET['order'];

  if($_GET['action']=='user') {

    $order_str = 'user_points DESC';

    if($order=='points') $order_str = 'user_points DESC';
    elseif($order=='planets') $order_str = 'user_planets DESC';
    elseif($order=='honor') $order_str = 'user_honor DESC';


    $listquery=$db->query('SELECT user_name, user_alliance, user_planets, user_points, user_honor FROM user WHERE user_active = 1 ORDER BY '.$order_str); 


    $anfang = '<table><tr><td width="75">'.$place.'</td><td width="175">'.$name.'</td><td width="125">'.$alliance.'</td><td width="125">'.$planets.'</td><td width="100">'.$points.'</td><td width="100">'.$honor.'</td></tr>';
    $ende = '</table>';

    $pdf = new PDF(); 

    //$pdf->SetAuthor($game->player['user_name']);
    $pdf->SetAuthor('http://www.stfc.it');

    $pdf->SetTitle($config['site_url']);

    $pdf->AddPage(); 

    $pdf->SetFont( 'arial', '', 16); 

    $pdf->SetTextColor(250,0,0); 

    $pdf->Cell(0, 10, $userrank, 'B', 1);

    $pdf->Ln(0.15); 

    $pdf->SetFont('Arial','I',8);

    $pdf->SetTextColor(0,0,0); 

    $pdf->MultiCell(0,7,$created.date('d.m.y H:i', time()).'', 0, 'R');

    $pdf->SetAutoPageBreak(true, 15.0);

    $pdf->SetFont('arial','',12); 

    $pdf->WriteHTML( $anfang ); 

    while (($user = $db->fetchrow($listquery)) != false) {

      $gen = '<tr><td>'.$rang_user.'.</td><td>'.$user['user_name'].'</td><td>'.( (!empty($user['user_alliance'])) ? ''.get_alliance_tag($user['user_alliance']).'' : '').'</td><td>'.$user['user_planets'].'</td><td>'.$user['user_points'].'</td><td>'.( ($user['user_honor']<1) ? '-' : $user['user_honor'] ).'</td></tr>';
      $pdf->WriteHTML( $gen );

      $rang_user++;

    }


    $pdf->WriteHTML( $ende ); 

    $pdf->Output(); 

  }

  if($_GET['action']=='alliance') {

    $order_str = 'alliance_points DESC';

    if($order=='points') $order_str = 'alliance_points DESC';
    elseif($order=='planets') $order_str = 'alliance_planets DESC';
    elseif($order=='honor') $order_str = 'alliance_honor DESC';
    elseif($order=='points_avg') $order_str = 'alliance_rank_points_avg ASC';


    $listquery=$db->query('SELECT alliance_tag, alliance_name, alliance_member, alliance_planets, alliance_honor, alliance_points FROM alliance ORDER BY '.$order_str); 


    $anfang = '<table><tr><td width="75">'.$place.'</td><td width="100">Tag:</td><td width="250">'.$name.'</td><td width="100">'.$members.'</td><td width="100">'.$planets.'</td><td width="85">'.$honor.'</td><td width="85">'.$points.'</td><td width="85">'.$pointsavg.'</td></tr>'; 
    $ende = '</table>';

    $pdf = new PDF(); 

    //$pdf->SetAuthor($game->player['user_name']);
    $pdf->SetAuthor('http://www.stfc.it');

    $pdf->SetTitle($config['site_url']);

    $pdf->AddPage(L); 

    $pdf->SetFont( 'arial', '', 16); 

    $pdf->SetTextColor(250,0,0); 

    $pdf->Cell(0, 10, $allyrank, 'B', 1); 

    $pdf->Ln(0.15); 

    $pdf->SetFont('Arial','I',8);

    $pdf->SetTextColor(0,0,0); 

    $pdf->MultiCell(0,7,$created.date('d.m.y H:i', time()).'', 0, 'R');

    $pdf->SetAutoPageBreak(true, 15.0);

    $pdf->SetFont('Arial','',12); 

    $pdf->WriteHTML( $anfang ); 

    while (($alliance = $db->fetchrow($listquery)) != false) {

      $gen = '<tr><td>'.$rang_alliance.'.</td><td>'.$alliance['alliance_tag'].'</td><td>'.$alliance['alliance_name'].'</td><td>'.$alliance['alliance_member'].'</td><td>'.$alliance['alliance_planets'].'</td><td>'.( ($alliance['alliance_honor']<1) ? '-' : ''.$user['alliance_honor'].'' ).'</td><td>'.$alliance['alliance_points'].'</td><td>'.round($alliance['alliance_points']/$alliance['alliance_member']).'</td></tr>';
      $pdf->WriteHTML( $gen );

      $rang_alliance++;

    }


    $pdf->WriteHTML( $ende ); 

    $pdf->Output(); 

  }

}

?>
