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

$main_html .= '<span class=header>Sondaggi</span><br>';

if(isset($_REQUEST['remove'])) {
	$poll = $db->queryrow('SELECT * FROM portal_poll WHERE id="'.((int)$_REQUEST['id']).'"');
	log_action('Il sondaggio con il titolo "'.$poll['question'].'" &egrave; stata cancellata');
	

    $sql = 'DELETE FROM portal_poll WHERE id="'.((int)$_REQUEST['id']).'" LIMIT 1';
    if(!$db->query($sql)) {
        //message(DATABASE_ERROR, 'Could not remove portal news data');
    }

    $sql = 'DELETE FROM portal_poll_voted WHERE poll_id="'.((int)$_REQUEST['id']).'" LIMIT 1';
    if(!$db->query($sql)) {
        //message(DATABASE_ERROR, 'Could not remove portal news data');
    }

    $main_html .= '<span class=header3><font color=green>Il sondaggio &egrave; stato cancellato</font></span><br>';

	
}



if(isset($_POST['submit'])) {

	if (!isset($_POST['id']) || empty($_POST['id']))
	{
    $sql = 'INSERT INTO portal_poll (date, question, choice_1, choice_2, choice_3, choice_4, choice_5, choice_6, choice_7, choice_8, choice_9, choice_10)

            VALUES ('.time().', "'.$_POST['question'].'", "'.addslashes($_POST['choice_1']).'", "'.addslashes($_POST['choice_2']).'", "'.addslashes($_POST['choice_3']).'", "'.addslashes($_POST['choice_4']).'", "'.addslashes($_POST['choice_5']).'", "'.addslashes($_POST['choice_6']).'", "'.addslashes($_POST['choice_7']).'", "'.addslashes($_POST['choice_8']).'", "'.addslashes($_POST['choice_9']).'", "'.addslashes($_POST['choice_10']).'")';

		log_action('Il sondaggio con il titolo "'.$_POST['question'].'" &egrave; stata salvato');

    if(!$db->query($sql)) {

        //message(DATABASE_ERROR, 'Could not insert portal news data');

    }
    $main_html .= '<span class=header3><font color=green>Il sondaggio &egrave; stato pubblicato</font></span><br>';
    
	}
	else
	{
    $sql = 'UPDATE portal_poll SET question="'.$_POST['question'].'", choice_1="'.addslashes($_POST['choice_1']).'" WHERE id="'.((int)$_POST['id']).'"';
	
	log_action('Il sondaggio con il titolo "'.$_POST['question'].'" &egrave; stato modificato');
        
//echo $sql;
            

    if(!$db->query($sql)) {

        //message(DATABASE_ERROR, 'Could not update portal news data');

    }
    $main_html .= '<span class=header3><font color=green>Il sondaggio &egrave stato pubblicato</font></span><br>';
    
	}
	

}


$id=0;
$question=$choice_1=$choice_2=$choice_3=$choice_4=$choice_5=$choice_6=$choice_7=$choice_8=$choice_9=$choice_10='';

if(isset($_REQUEST['id'])) {
$sql = 'SELECT * FROM portal_poll WHERE id="'.((int)$_REQUEST['id']).'"';
$new=$db->queryrow($sql);
if (isset($new['id']))
{
$question=stripslashes($new['question']);
$choice_1=stripslashes($new['choice_1']);
$choice_2=stripslashes($new['choice_2']);
$choice_3=stripslashes($new['choice_3']);
$choice_4=stripslashes($new['choice_4']);
$choice_5=stripslashes($new['choice_5']);
$choice_6=stripslashes($new['choice_6']);
$choice_7=stripslashes($new['choice_7']);
$choice_8=stripslashes($new['choice_8']);
$choice_9=stripslashes($new['choice_9']);
$choice_10=stripslashes($new['choice_10']);

$id=(int)$_REQUEST['id'];
$main_html .= '<span class=header3><font color=blue>Modifica il sondaggio "'.$question.' ('.$id.')"</font></span><br>';
}
}


if ($type==-1) $main_html .= '<span class=header3><font color=blue>Componi nuovo sondaggio</font></span><br>';


    


$main_html .= '

<br>
Attenzione: Le domande nel sondaggio non sono filtrate (i campi opzioni lasciati in bianco, non saranno inseriti al sondaggio).<br><br>


<form method="post" action="index.php?p=polls">

Domanda: <input type="text" name="question" value="'.$question.'" class="field">

<br><br>

1a opzione: <input type="text" name="choice_1" value="'.$choice_1.'" class="field">

<br><br>

2a opzione: <input type="text" name="choice_2" value="'.$choice_2.'" class="field">

<br><br>

3a opzione: <input type="text" name="choice_3" value="'.$choice_3.'" class="field">

<br><br>

4a opzione: <input type="text" name="choice_4" value="'.$choice_4.'" class="field">

<br><br>

5a opzione: <input type="text" name="choice_5" value="'.$choice_5.'" class="field">

<br><br>

6a opzione: <input type="text" name="choice_6" value="'.$choice_6.'" class="field">

<br><br>

7a opzione: <input type="text" name="choice_7" value="'.$choice_7.'" class="field">

<br><br>

8a opzione: <input type="text" name="choice_8" value="'.$choice_8.'" class="field">

<br><br>

9a opzione: <input type="text" name="choice_9" value="'.$choice_9.'" class="field">

<br><br>

10a opzione: <input type="text" name="choice_10" value="'.$choice_10.'" class="field">

<br><br>

<input type=hidden name="id" value="'.$id.'">

<input class="button" type="submit" name="submit" value="Invia">


</form>

';



    $sql = 'SELECT *

            FROM portal_poll

            ORDER by date DESC
            ';

            

    if(($q_polls = $db->query($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query portal polls data');

    }

            

    $main_html .= '
<span class=header3><font color=blue>Tutte i sondaggi in un colpo d&#146;occhio</font></span><br>

<table class="style_outer" border="1" cellpadding="2" cellspacing="2" width="500" bgcolor=#666666>

  <tr>

    <td>

      <center><span class="sub_caption">Sondaggi:</span></center><br>

    ';



    while($poll = $db->fetchrow($q_polls)) {

        $total_votes = ($poll['count_1'] +
                        $poll['count_2'] +
                        $poll['count_3'] +
                        $poll['count_4'] +
                        $poll['count_5'] +
                        $poll['count_6'] +
                        $poll['count_7'] +
                        $poll['count_8'] +
                        $poll['count_9'] +
                        $poll['count_10']);

        if($total_votes == 0) $total_votes = 1;

        $main_html .= '

      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="style_inner">

        <tr>

          <td valign="top" width="60" bgcolor=#333333><span class="sub_caption2" style="color: #23F025">Opzioni:</span>
		  
		  <br><br>
		  [<a href="index.php?p=polls&id='.$poll['id'].'"><font color=white>Modifica</font></a>]<br><br>
		  [<a href="index.php?p=polls&id='.$poll['id'].'&remove"><font color=white>Cancella</font></a>]<br>
		  
		  </td>

          <td valign="top" width="400">

            <table border="0" cellpadding="0" cellspacing="3" width="100%">

              <tr>

                <td valign="top" bgcolor=#333333 colspan=3><span class="sub_caption2" style="color: #23F025">'.$poll['question'].'
                <br>('.date('d.m.y H:i', $poll['date']).')</span></td>

              </tr>';

              for($i = 1;$i < 11;$i++)
                if(!empty($poll['choice_'.$i]))
                {
                   $percent = 100 / $total_votes * $poll['count_'.$i];
                   $main_html .= '<tr><td>'.$i.':</td><td valign="top" width="350">'.stripslashes($poll['choice_'.$i]).'</td><td align="right">'.round($percent, 0).'%</td></tr>';
                }

              $main_html .= '


            </table>

          </td>

        </tr>

      </table><br>

        ';

    }



    $main_html .= '

    </td>

  </tr>

</table>

    ';

