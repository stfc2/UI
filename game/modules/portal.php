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



function display_shoutbox() {

    global $db, $game, $portal_action;



    $count = ($portal_action == 'full_shoutbox') ? 15 : 5;



    $sql = 'SELECT *

            FROM shoutbox

            ORDER BY timestamp DESC

            LIMIT 0, '.$count;



    if(($sb_posts = $db->queryrowset($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query shoutbox data');

    }



    $game->out('

<table class="style_outer" border="0" cellpadding="2" cellspacing="2" width="250">

  <tr>

    <td align="center">

      <span class="sub_caption">Shoutbox:</span><br><br>

      <table width="200" border="0" cellpadding="2" cellspacing="2" class="style_inner">

        <tr>

          <td width="100%">

    ');



    $count = (count($sb_posts) - 1);



    

for($i = $count; $i >= 0; --$i) {

        $game->out('<i>'.$sb_posts[$i]['player_name'].' ('.gmdate('H:i', $sb_posts[$i]['timestamp']+TIME_OFFSET).')</i>:<br>'.wordwrap($sb_posts[$i]['message'], 25, '<br>', 1).'<br>');

    }



    $game->out('

          </td>

        </tr>

      </table>

      <br>

      <table width="200" border="0" cellpadding="1" cellspacing="1">

        <tr>

          <form name="shoutbox" method="post" action="'.parse_link('a=portal&do=post_shoutbox').'" onSubmit="return this.submit_post.disabled = true;">

          <td width="100%">

            <input type="text" name="shoutbox_msg" size="16" class="field_nosize" maxlength="100" style="background-image:url('.$game->GFX_PATH.'template_bg4.jpg);">&nbsp;

            <input type="submit" name="submit_post" class="button_nosize" width="45" value="Senden" style="background-image:url('.$game->GFX_PATH.'template_bg4.jpg);">

          </td>

          </form>

        </tr>

        <tr>

          <td>

            '.( ($portal_action == 'full_shoutbox') ? '<a href="'.parse_link('a=portal').'">Weniger Posts zeigen</a>' : '<a href="'.parse_link('a=portal&do=full_shoutbox').'">Mehr Posts zeigen</a>' ).'

          </td>

        </tr>

      </table>

    </td>

  </tr>

</table>

    ');



    return;

}




function display_spenden() {

    global $db, $game;
	
	$spendenquery=$db->query('SELECT SUM(betrag) AS total FROM spenden WHERE id>161');
	$spende = $db->fetchrow($spendenquery);

        $game->out('<table class="border_grey" border="0" cellpadding="2" cellspacing="2" width="250" background="'.$game->GFX_PATH.'template_bg3.jpg">
	  <tr>
	    <td valign="top" width="100%">
	      <b>Serverupgrade</b><br>
		<b>Vielen Dank an alle Spender!</b><br><br>
		Wir haben die neue Hardware heute bestellt, sie wird in der 2. Aprilwoche installiert:<br>
		1x Asus K8N-DL DualCPU<br>
		2x Opteron 265 (Dualcore)<br>
		4x Corsair 1GB DDR 400<br>
		1x Seasonic (430 Watt)<br>
		<b>Kosten: 1525,18 Euro</b><br><br>
		
		<a href="http://stgcforum.de/thread.php?threadid=15585&goto=lastpost" target=_blank><u>Diskussionsthread</u></a>
	   </td>
	  </tr>
	</table>
	<br>
        ');

}



function display_poll() {

    global $db, $game;

    $sql = 'SELECT *

            FROM portal_poll

            ORDER BY date DESC

            LIMIT 0, 1';


    if(($poll_data = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query poll data');

    }

    if(empty($poll_data['id'])) {

        return;

    }



    $sql = 'SELECT poll_id

            FROM portal_poll_voted

            WHERE player_id = '.$game->player['user_id'].' AND

                  poll_id = '.$poll_data['id'];



    if(($already_voted = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query poll voted data');

    }



    if(empty($already_voted['poll_id'])) {

        $game->out('

<table class="border_grey" border="0" cellpadding="2" cellspacing="2" width="250" background="'.$game->GFX_PATH.'template_bg3.jpg">

  <tr>

    <form name="poll" method="post" action="'.parse_link('a=portal&do=vote').'" onSubmit="return this.submit_vote.disabled = true;">

    <td valign="top" width="100%">

      <b>'.$poll_data['question'].'</b><br>

        ');



        for($i = 1; $i <= 10; ++$i) {

            if(empty($poll_data['choice_'.$i])) break;



            $game->out('<input type="radio" name="choice" value="'.$i.'"><b>'.$poll_data['choice_'.$i].'</b><br>');

        }



        $game->out('

      <center><input type="submit" name="submit_vote" class="button_nosize" value="Vote"></center>

      <input type="hidden" name="poll_id" value="'.$poll_data['id'].'">

    </td>

    </form>

  </tr>

</table><br>

        ');

    }

    else {

        $game->out('

<table class="border_grey" border="0" cellpadding="2" cellspacing="2" width="250" background="'.$game->GFX_PATH.'template_bg3.jpg">

  <tr>

    <td valign="top" width="100%">

      '.$poll_data['question'].'<br><br>

        ');



        $total_votes = ($poll_data['count_1'] +

                        $poll_data['count_2'] +

                        $poll_data['count_3'] +

                        $poll_data['count_4'] +

                        $poll_data['count_5'] +

                        $poll_data['count_6'] +

                        $poll_data['count_7'] +

                        $poll_data['count_8'] +

                        $poll_data['count_9'] +

                        $poll_data['count_10']);



        if($total_votes == 0) $total_votes = 1;



        for($i = 1; $i <= 10; ++$i) {

            if(empty($poll_data['choice_'.$i])) break;



            $percent = 100 / $total_votes * $poll_data['count_'.$i];



            $game->out('

      <table border="0" cellpadding="0" cellspacing="0">

        <tr>

          <td width="100">'.$poll_data['choice_'.$i].'</a>:&nbsp;</td>

          <td width="'.round($percent / 1.5 + 1).'" bgcolor="#50d500"></td>

          <td width="50">&nbsp;'.round($percent, 0).'%&nbsp;('.$poll_data['count_'.$i].')</td>

        </tr>

        <tr><td></td></tr>

        <tr><td></td></tr>

        <tr><td></td></tr>

      </table>

            ');

        }



        $game->out('

      <br><b>Stimmen gesamt: '.$total_votes.' Spieler

    </td>

  </tr>

</table><br>

        ');

    }



    return;

}



function display_news() {

    global $db, $game;



    $news_types = array(

        1 => array('Bug', '#FF0000'),

        2 => array('Bugfix', '#6256FF'),

        3 => array('Change', '#C9CD00'),

        4 => array('Feature', '#23F025'),

        5 => array('News', '#AAAAAA'),

    );

    

    $sql = 'SELECT *

            FROM portal_news

            ORDER by date DESC

            LIMIT 0, 10';

            

    if(($q_news = $db->query($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query portal news data');

    }

            

    $game->out('

<table class="style_outer" border="0" cellpadding="2" cellspacing="2" width="250">

  <tr>

    <td>

      <center><span class="sub_caption">News:</span></center><br>

    ');



    while($news = $db->fetchrow($q_news)) {

        $game->out('

      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="style_inner">

        <tr>

          <td valign="top" width="60"><span class="text_large" style="color: '.$news_types[$news['type']][1].'">'.$news_types[$news['type']][0].':</span></td>

          <td valign="top" width="190">

            <table border="0" cellpadding="0" cellspacing="0">

              <tr>

                <td valign="top"><span class="sub_caption2" style="color: '.$news_types[$news['type']][1].'">'.$news['header'].'</span><span class="text_large" style="color:'.$news_types[$news['type']][0].'"><br>('.gmdate('d.m.y H:i', $news['date']+TIME_OFFSET).')</span></td>

              </tr>

              <tr>

                <td valign="top">'.stripslashes($news['message']).'</td>

              </tr>

            </table>

          </td>

        </tr>

      </table><br>

        ');

    }



    $game->out('

    </td>

  </tr>

</table>

    ');

    

    return;

}









function display_galaxymap() {

    global $db, $game;
    $game->out('

  <table class="style_outer" border="0" cellpadding="2" cellspacing="2" width="250">
  <tr>
    <td><center><span class="sub_caption">Galaxiekarte:</span></center><br>
    <center><a href="maps/images/galaxy_detail.png" target=_blank><img src="maps/images/galaxy_detail_small.png" border=0></a></center>
    </td>
  </tr>
  </table>
    ');

}


function display_usermap() {

    global $db, $game;
    $game->out('

  <table class="style_outer" border="0" cellpadding="2" cellspacing="2" width="250">
  <tr>
    <td><center><span class="sub_caption">Userkarte:</span></center><br>
    <center><a href="|game_url|/index.php?a=bb_karte" target=_blank><img src="|game_url|/bbkarte_thumb.png" border=0></a></center>
    </td>
  </tr>
  </table>
    ');

}

function display_skins() {

    global $db, $game;

    

    $sql = 'SELECT skin_id, skin_name, gfxpack_link, skinpreview_link, skin_portal_desc

            FROM skins

            ORDER BY skin_id DESC

            LIMIT 4';

            

    if(($q_skins = $db->query($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query recent skin data');

    }



    $game->out('

<table class="style_outer" border="0" cellpadding="2" cellspacing="2" width="250">

  <tr>

    <td><center><span class="sub_caption">Neuste Skins:</span></center><br>

    ');



    while($skin = $db->fetchrow($q_skins)) {



        $game->out('

    <table border="0" cellpadding="0" cellspacing="0" class="style_inner">

      <tr>

        <td width="100%" valign="top">

          <table border="0" cellpadding="0" cellspacing="0">

            <tr>

              <td valign="top"><span class="sub_caption2"><b>'.$skin['skin_name'].'</b></span></td>

            </tr>

            <tr>

              <td valign="top">'.$skin['skin_portal_desc'].'<br><a href="template_manager.php?change_skin='.$skin['skin_id'].'" target="_blank"><img src="'.$skin['skinpreview_link'].'" border="0"></a><br><a href="'.$skin['gfxpack_link'].'">GFX-Pack</a></span></td>

            </tr>

          </table>

        </td>

      </tr>

    </table><br>

        ');

    }



    $game->out('

    <center><a href="template_manager.php?skin_summary=1" target="_blank">Übersicht aller Skins</a></center>

    </td>

  </tr>

</table>

    ');



    return;

}





$portal_action = (!empty($_GET['do'])) ? $_GET['do'] : 'index';



switch($portal_action) {

    case 'post_shoutbox':

        if(empty($_POST['shoutbox_msg'])) break;

        

        if((time() - 15) < $game->player['last_shoutbox_post']) {

            $sql = 'UPDATE user

                    SET last_shoutbox_post = '.time().',

                        shoutbox_flood_error = shoutbox_flood_error + 1

                    WHERE user_id = '.$game->player['user_id'];

                    

            if(!$db->query($sql)) {

                message(DATABASE_ERROR, 'Could not update user shoutbox flood protection data');

            }

            

            message(NOTICE, 'Du darfst nur alle 15 Sekunden in der Shoutbox etwas posten. In 15 Sekunden <b>ab jetzt</b> wird diese Sperre aufgehoben sein.');

        }



        $sql = 'INSERT INTO shoutbox (player_name, message, timestamp)

                VALUES ("'.$game->player['user_name'].'", "'.htmlspecialchars($_POST['shoutbox_msg']).'", '.time().')';

                

        if(!$db->query($sql)) {

            message(DATABASE_ERROR, 'Could not insert new shoutbox text data');

        }

        

        $sql = 'UPDATE user

                SET shoutbox_posts = shoutbox_posts + 1,

                    last_shoutbox_post = '.time().'

                WHERE user_id = '.$game->player['user_id'];

                

        if(!$db->query($sql)) {

            message(DATABASE_ERROR, 'Could not update user shoutbox data');

        }

        

        redirect('a=portal');

    break;

    

    case 'vote':

        if(empty($_POST['poll_id'])) break;

        if(empty($_POST['choice'])) break;

        

        $poll_id = (int)$_POST['poll_id'];

        $choice = (int)$_POST['choice'];

        

        if($choice > 10) break;

        

        $sql = 'SELECT id, choice_'.$choice.' AS chosen_choice

                FROM portal_poll

                WHERE id = '.$poll_id;

                

        if(($poll_data = $db->queryrow($sql)) === false) {

            message(DATABASE_ERROR, 'Could not query poll data');

        }

        

        if(empty($poll_data['id'])) {

            message(NOTICE, 'Die Umfrage, zu der abgestimmt wurde, existiert nicht');

        }

        

        if(empty($poll_data['chosen_choice'])) {

            message(NOTICE, 'Die gewählte Antwortmöglichkeit existiert nicht');

        }

        

        $sql = 'SELECT poll_id

                FROM portal_poll_voted

                WHERE player_id = '.$game->player['user_id'].' AND

                      poll_id = '.$poll_id;

                      

        if(($voted_check = $db->queryrow($sql)) === false) {

            message(DATABASE_ERROR, 'Could not query poll voted data');

        }

        

        if(!empty($voted_check['poll_id'])) {

            message(NOTICE, 'Du hast bei dieser Umfrage bereits deine Stimme abgegegen');

        }

        

        $sql = 'INSERT INTO portal_poll_voted (player_id, poll_id)

                VALUES ('.$game->player['user_id'].', '.$poll_id.')';

                

        if(!$db->query($sql)) {

            message(NOTICE, 'Could not insert new poll voted data');

        }

        

        $sql = 'UPDATE portal_poll

                SET count_'.$choice.' = count_'.$choice.' + 1

                WHERE id = '.$poll_id;

                

        if(!$db->query($sql)) {

            message(DATABASE_ERROR, 'Could not update poll data');

        }

        

        redirect('a=portal');

    break;

    

    case 'index':

    default:

        $game->out('

<center>

<span class="caption">Portal:</span><br><br>



</center>

<center>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="510">

  <tr valign="top">

    <td width="250">

        ');

        

        //display_poll();
//	display_spenden();

	$game->out("<a href='http://www.galaxy-news.de/?page=charts&op=vote&game_id=1666' target='_blank'><img src='http://www.galaxy-news.de/images/vote.gif' border=0 alt='Die besten Browsergames in den Galaxy-News MMOG-Charts!'></a><br>Bitte votet f&uuml;r STFC<br><br><b>IRC-Chat: #stfc2 @ Quakenet</b><br><br>");

       display_news();

        

        $game->out('

    </td>



    <td width="10">&nbsp;</td>



    <td width="250" valign="top" align="center">

		<center>

        ');

        

        display_shoutbox();

        $game->out('<br>');


        display_galaxymap();
                $game->out('<br>');
        display_usermap();
                $game->out('<br>');
        display_skins();

        

        $game->out('

		</center>

    </td>

  </tr>

</table>

</center>

        ');

    break;

}



?>

