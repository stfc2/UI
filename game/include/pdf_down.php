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
include('functions.php');
$game = new game();

// #############################################################################
// SQL-Object for Database access
include('global.php');
include('sql.php');
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection

if(isset($_GET['sql_debug'])) $db->debug = true;

// #############################################################################
// Session-System
include('session.php');

// #############################################################################
//Generation
define('FPDF_FONTPATH','fpdf17/font/');
require('fpdf17/fpdf.php');
require('myPDF.php');

$user = $game->player['user_id'];
$id = $_POST['id'];

$sql = 'SELECT id, sender, receiver, subject, text, time FROM message WHERE id = '.$id;

if(($messagedata = $db->queryrow($sql)) == false) {
    /* 12/06/08 - AC: Look also into archived message */
    $sql = 'SELECT id, sender, receiver, subject, text, time FROM message_archiv WHERE id = '.$id;
    if(($messagedata = $db->queryrow($sql)) == false) {
        message(DATABASE_ERROR, 'Could not query message data');
    }
}

$sender = $messagedata['sender'];
$receiver = $messagedata['receiver'];
$subject = $messagedata['subject'];
$text = html_entity_decode($messagedata['text']);
$time = date('d.m.y H:i', $messagedata['time']);

if($user!=$receiver) {
    redirect('../index.php?a=messages');
}

//Sender data

// 26/05/12 - AC: Check if it's a message from the support system
if ($sender == SUPPORTUSER) {
    $sendername['user_name'] = 'STFC-Support';
}
else {
    $sql = 'SELECT user_name FROM user WHERE user_id = '.$sender;

    if(($sendername = $db->queryrow($sql)) == false) {
        message(DATABASE_ERROR, 'Could not query sender data');
    }
}

/* 12/06/08 - AC: Translate also this! */
switch($game->player['language'])
{
    case 'GER':
        $created = 'Erstellt am ';
        $sender = 'Absender:					';
        $recipient = 'Empfänger:			';
        $date =  'Datum:										';
        $title = 'Titel:														';
        $page = 'Seite';
    break;
    case 'ITA':
        $created = 'Creato il ';
        $sender = 'Mittente:								';
        $recipient = 'Destinatario:	';
        $date =  'Data:														';
        $title = 'Titolo:												';
        $page = 'Pagina';
    break;
    default:
        $created = 'Created on ';
        $sender = 'Sender:							';
        $recipient = 'Recipient:			';
        $date =  'Date:											';
        $title = 'Title:												';
        $page = 'Page';
    break;
}

$pdf=new myPDF();
$pdf->SetFooterData($config['site_url'],$page);
$pdf->Open();
$pdf->SetAuthor($game->player['user_name']);
$pdf->SetTitle($config['site_url']);
$pdf->SetAutoPageBreak(on, 15.0);
$pdf->AddPage();
$pdf->SetFont('Arial','I',8);
$pdf->MultiCell(0,7,$created.date('d.m.y H:i', time()).'', 0, R);
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(0,7,''.$pdf->MultiCell(0,7,$sender.$sendername['user_name']),$pdf->MultiCell(0,7,$recipient.$game->player['user_name']),$pdf->MultiCell(0,7,$date.$time),$pdf->MultiCell(0,7,$title.$subject));
$pdf->Ln();
$pdf->MultiCell(0,7,$text, 1);
$pdf->Output(''.$game->player['user_name'].'_'.$id.'_Message.pdf', D);


?>
