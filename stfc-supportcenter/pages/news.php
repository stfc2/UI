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

$main_html .= '<span class=header>Comunicati news</span><br>';

if(isset($_REQUEST['remove'])) {
    $msg = $db->queryrow('SELECT * FROM portal_news WHERE id="'.((int)$_REQUEST['id']).'"');
    log_action('La news Portale con il titolo "'.$msg['header'].'" &egrave; stata cancellata');


    $sql = 'DELETE FROM portal_news WHERE id="'.((int)$_REQUEST['id']).'" LIMIT 1';
    if(!$db->query($sql)) {
        //message(DATABASE_ERROR, 'Could not remove portal news data');
    }
    $main_html .= '<span class=header3><font color=green>Il messaggio &egrave; stato cancellato</font></span><br>';


}



if(isset($_POST['submit'])) {

    $send_time = time();

    if (!isset($_POST['id']) || empty($_POST['id']))
    {
         $sql = 'INSERT INTO portal_news (type, header, message, date)
                 VALUES ('.$_POST['type'].', "'.$_POST['title'].'", "'.addslashes($_POST['text']).'", '.$send_time.')';

         log_action('La newe Portale con il titolo "'.$_POST['title'].'" &egrave; stata salvata');

         if(!$db->query($sql)) {

             //message(DATABASE_ERROR, 'Could not insert portal news data');

        }

        $main_html .= '<span class=header3><font color=green>L&#146;annuncio &egrave; stato pubblicato</font></span><br>';
    }
    else
    {
        $sql = 'UPDATE portal_news SET type='.((int)$_POST['type']).', header="'.$_POST['title'].'", message="'.addslashes($_POST['text']).'" WHERE id="'.((int)$_POST['id']).'"';

        log_action('La news Portale (nuova?) con il titolo "'.$_POST['title'].'" &egrave; stata modificata');

//echo $sql;


        if(!$db->query($sql)) {

            //message(DATABASE_ERROR, 'Could not update portal news data');

        }
        $main_html .= '<span class=header3><font color=green>L&#146;annuncio &egrave stato pubblicato</font></span><br>';

    }

    // Se e` stata richiesta una copia via messaggio
    if(isset($_POST['message'])) {
        $mes_qry = $db->query('SELECT user_id FROM user WHERE user_auth_level < 2');

        while ($receiver=$db->fetchrow($mes_qry))
        {
            $result = $db->query('INSERT INTO message (sender, receiver, subject, text, time)
                                  VALUES ("'.SUPPORTUSER.'","'.$receiver['user_id'].'","'.$_POST['title'].'","'.addslashes($_POST['text']).'","'.$send_time.'")');

            if (($num=$db->queryrow('SELECT COUNT(id) as unread FROM message WHERE (receiver="'.$receiver['user_id'].'") AND (rread=0)')))
                $db->query('UPDATE user SET unread_messages="'.$num['unread'].'" WHERE user_id="'.$receiver['user_id'].'"');
        }

        log_action('Messaggio con il titolo "'.$_POST['title'].'" inviato a tutta la utenza');
    }
}


$id=0;
$message='';
$header='';
$type=-1;
if(isset($_REQUEST['id'])) {
$sql = 'SELECT * FROM portal_news WHERE id="'.((int)$_REQUEST['id']).'"';
$new=$db->queryrow($sql);
if (isset($new['id']))
{
$message=stripslashes($new['message']);
$header=stripslashes($new['header']);
$type=$new['type'];
$id=(int)$_REQUEST['id'];
$main_html .= '<span class=header3><font color=blue>Modifica il messaggio "'.$header.' ('.$id.')"</font></span><br>';
}
}


if ($type==-1) $main_html .= '<span class=header3><font color=blue>Componi nuovo messaggio</font></span><br>';


    


$main_html .= '

<br>
Attenzione: La News sar&agrave; in formato HTML, usare un &#8249;br&#8250 <br> per inserire una nuova linea (non usare il tasto Enter), <br> i link possono essere inseriti con il tag standard &#8249;a&#8250;.
<br><br>

<form method="post" action="index.php?p=news">

Tipologia:&nbsp;<select name="type" class="select">

  <option value="1" '.($type==1 ? 'selected="selected"' : '').'>Bug</option>

  <option value="2" '.($type==2 ? 'selected="selected"' : '').'>Bugfix</option>

  <option value="3" '.($type==3 ? 'selected="selected"' : '').'>Modifica</option>

  <option value="4" '.($type==4 ? 'selected="selected"' : '').'>Feature</option>

  <option value="5" '.($type==5 ? 'selected="selected"' : '').'>Novit&agrave; gen.</option>

</select>

<br><br>

Invia a tutti gli utenti una copia come messaggio:&nbsp;<input type="checkbox" name="message">

<br><br>

Titolo:&nbsp;<input type="text" name="title" value="'.$header.'" class="field">

<br><br>

Testo:<br><textarea name="text" rows="15" cols="60">'.$message.'</textarea>

<br><br>

<input type=hidden name="id" value="'.$id.'">

<input class="button" type="submit" name="submit" value="Invia">


</form>

';





    $news_types = array(

        1 => array('Bug', '#FF0000'),

        2 => array('Bugfix', '#6256FF'),

        3 => array('Modifica', '#C9CD00'),

        4 => array('Feature', '#23F025'),

        5 => array('News', '#AAAAAA'),

    );

    

    $sql = 'SELECT *

            FROM portal_news

            ORDER by date DESC
            ';

            

    if(($q_news = $db->query($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query portal news data');

    }

            

    $main_html .= '
<span class=header3><font color=blue>Tutte le notizie in un colpo d&#146;occhio</font></span><br>

<table class="style_outer" border="1" cellpadding="2" cellspacing="2" width="250" bgcolor=#666666>

  <tr>

    <td>

      <center><span class="sub_caption">News:</span></center><br>

    ';



    while($news = $db->fetchrow($q_news)) {

        $main_html .= '

      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="style_inner">

        <tr>

          <td valign="top" width="60" bgcolor=#333333><span class="text_large" style="color: '.$news_types[$news['type']][1].'">'.$news_types[$news['type']][0].':</span>
		  
		  <br><br>
		  [<a href="index.php?p=news&id='.$news['id'].'"><font color=white>Modifica</font></a>]<br><br>
		  [<a href="index.php?p=news&id='.$news['id'].'&remove"><font color=white>Cancella</font></a>]<br>
		  
		  </td>

          <td valign="top" width="190">

            <table border="0" cellpadding="0" cellspacing="0">

              <tr>

                <td valign="top" bgcolor=#333333><span class="sub_caption2" style="color: '.$news_types[$news['type']][1].'">'.$news['header'].'</span><span class="text_large" style="color:'.$news_types[$news['type']][1].'"><br>('.date('d.m.y H:i', $news['date']).')</span></td>

              </tr>

              <tr>

                <td valign="top">'.stripslashes($news['message']).'</td>

              </tr>

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

