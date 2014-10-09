<?php
/*
    This file is part of STFC.it
    Copyright 2008-2013 by Andrea Carolfi (carolfi@stfc.it) and
    Cristiano Delogu (delogu@stfc.it).

    STFC.it is based on STFC,
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


//###########################################################################
//###########################################################################

/* 31. August 2014
  @Author: Carolfi
  @Action: localization of external pages of the game
*/

$loc_strings = array(
    // English strings
    'en' => array(
        // home.php strings
        'nonews' => 'No news available',
        'noreports' => 'No newspaper reports available',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'welcome' => 'Star Trek Frontline Combat, is a multiplayer game set in the Star Trek&trade;
          universe where the only tools needed to play are a web browser and an internet connection.<br><br>
          STFC2 is a tactical and strategic game running in real time to give players the maximum game
          experience possible.<br><br>
          Several races are available between Federation, Romulans, Klingons, Cardassians and
          many other, after the home world is created, the player would need to create new colonies
          in order to increase his power and fleets to expand the commercial routes with other players
          or to fight them with all the starships available. To boldly go where nobody has gone before!',
        'fist_membership' => 'Site member of the Federazione Italiana Siti Trek',

        // login.php strings
        'login_title' => 'Star Trek: Frontline Combat - Login',
        'login_descr' => 'STFC: Pagina per effettuare la login alla galassia di gioco a cui si e` iscritti (galassia Brown Bobby o Fried Egg).',
        'login' => 'Login',
        'user_login' => 'Login:',
        'password' => 'Password:',
        'galaxy' => 'Galaxy:',
        'using_proxy' => 'I am using a <a href="http://en.wikipedia.org/wiki/Proxy_server" target="_blank"><u>proxy server</u></a>',
        'proxy_note' => 'Use only if the images are not loaded.',
        'lost_password' => 'Lost password recovery',
        'submit' => 'Submit',

        // lost_password.php strings
        'lost_password_title' => 'Star Trek: Frontline Combat - Password recovery',
        'lost_password_descr' => 'STFC: Page in which request a new password to the system as a replacement for the forgot one.',
        'password_recovery' => 'Password recovery',
        'error_wrong_name_or_login' => 'The following problem has occurred:<br />Player&#146;s name or login name does not exists.',
        'error_wrong_email' => 'The following problem has occurred:<br>Email address does not exists.',
        'mail_message_lp1' => 'Apparently you have requested a new password.',
        'mail_message_lp2' => 'To try to login now, please use this password:',
        'mail_message_lp3' => 'We recommend you change your password after logging in, using the Settings page.',
        'mail_subject_lp' => 'Star Trek: Frontline Combat - Password recovery',
        'password_recovered' => 'Soon you will receive a new password by email.',
        'lost_password_warning' => 'Warning: you will receive an automatically generated new password.',
        'back_to_login' => 'Back to login',
        'password_request' => 'Password request',

        // register.php strings
        'register_title' => 'Star Trek: Frontline Combat - Registration',
        'register_descr' => 'STFC: Page in which register to the game by providing the details of your account, such as nick, email, gender, race, date of birth and so on.',
        'registration' => 'Registration',
        'galaxy_selection' => '(1/2) Select the galaxy:',
        'version' => 'Version:',
        'running_since' => 'Running since:',
        'days' => 'days',
        'available_places' => 'Available places:',
        'online_players' => 'Online players:',
        'galaxy1_desc' => 'The "'.GALAXY1_NAME.'" galaxy is the basic setup with a tick time of 3 minutes.',
        'galaxy2_desc' => 'The "'.GALAXY2_NAME.'" galaxy is the basic setup with less available races and diplomacy is just a dream.',

        'galaxy_registration' => '(2/2) Registration for the galaxy',
        'player_info' => 'Player information (required)',
        'player_name' => 'Player name:',
        'password_verify' => 'Password verify:',
        'email' => 'Email:',
        'race_selection' => 'Race selection:',
        'race0' => 'Federation',
        'race1' => 'Romulan',
        'race2' => 'Klingon',
        'race3' => 'Cardassian',
        'race4' => 'Dominion',
        'race5' => 'Ferengi',
        'race6' => 'Borg',
        'race7' => 'Q',
        'race8' => 'Breen',
        'race9' => 'Hirogen',
        'race10' => 'Krenim',
        'race11' => 'Kazon',
        'race0_desc' => 'This is the race with the greatest variety of ships.
         The Federation ships have the most resistant shields among all the ships in the galaxy.
         The rate of production of resources is in the media, as well as that of the troops.
         In comparison to other races, the Federation has good technological research tools.<br>
         The players of this race starts out with equal probability from the Alpha, Beta and
         Gamma quadrants, hardly from the Delta quadrant.<br>
         <i>Recommended for novice players.</i>',
        'race1_desc' => 'The Romulans have a strength in being able to build ships and infantry
         quickly and at low cost. They have a very low rate of production of dilithium and their
         ships and soldiers are relatively weak. However, the Romulan ships have a great capacity
         for concealment.<br>
         The players of this race starts most likely from the Beta Quadrant, rather than the
         Gamma and Alpha quadrants.<br>
         <i>Recommended for novice players.</i>',
        'race2_desc' => 'The Klingons are a warrior race with great ships and soldiers.
         However, they are penalized by the very high construction time for troops and planetary
         structures. In addition, technological research is not a point in favor of the Klingons.<br>
         The players of this race starts with a good chance from the Alpha Quadrant and lesser
         chance from the Beta and Gamma quadrants.<br>
         <i>Recommended for novice players.</i>',
        'race3_desc' => 'The Cardassians, the oppressors and exploiters of many populations,
         unfair and false in every situation. They have aggressive soldiers but they not have a
         wide variety of ships. Their ships are rather weak compared to those of other races.
         Among all the races this one is the more aggressive.<br>
         The players of this race starts most likely from Alpha and Gamma quadrants.<br>
         <i>The Cardassians needs good application and aggressiveness to be played successfully.</i>',
        'race4_desc' => 'The Dominion has fast and powerful ships. Their extraction capacity is
         the lowest among all races. The construction time of planetary structures, in comparison
         to other races is quite high.<br>
         The players of this race mainly starts from the Gamma Quadrant.<br>
         <i>One of the hardest races to play, definitely not recommended for novice players.</i>',
        'race5_desc' => 'The Ferengi are the excellence trading race of Star Trek.
         They prefer to do business, they have faster transport and very fast colony ships,
         they have the best rate of resource extraction and are fast to build troops and planetary
         structures, this allows the Ferengi to expand faster than any other race.
         Their weakness lies in their poor battleships, which is why the player should concentrate
         all his skills in the business to buy ships at auctions.<br>The players of this races
         have an equal chance of starting from any of the four quadrants.<br>
         <i>A race extremely easy to play in terms of management. Players must have good
         business sense to take full advantage of the Ferengi.</i>',
        'race6_desc' => 'Borg',
        'race7_desc' => 'Q',
        'race8_desc' => 'The Breen are a very strong race, with powerful but quite expensive
         ships and soldiers. Their resources extraction rate is quite low and this can lead to
         some economic problem. They also have the lowest variety of ships available, however
         the few existing should never be underestimated. The construction time of planetary 
         tructures is relatively high.<br>The players of this race starts with a prevalence
         from the Gamma Quadrant.<br>
         <i>A race pretty hard to play with little variety of ships. Suitable for players with
         a lot of practical sense.</i>',
        'race9_desc' => 'The Hirogen are a race very difficult to play. Their advantage comes
         later in the game, but they must contend with the lack of variety of ships. The Hirogen
         have excellent ground troops with the best defensive capacity of its facilities.<br>
         The players of this race can starts with equal probability from any quadrant of the galaxy.<br>
         <i>Race complex to play, suitable for the more experienced players or for those
         who wants to tackle the most difficult challenge.</i>',
        'race10_desc' => 'Krenim does not have particularly strong troops, but their huge
         advantage is exploitation of the technology. In the field of technological research
         Krenim are above all other races and also the creation of the troops is quite fast.<br>
         The players of this race starts mainly from the Delta Quadrant.<br>
         <i>Race simple to play but not easy. A challenge of average level.</i>',
        'race11_desc' => 'Kazon belongs to the warrior races, especially on ground battlefield.
         They are very quick to produce troops, that it is their strong point. The smaller Kazon
         ships are not a threat to other races, only later they reach their full potential.<br>
         The players of this race starts mainly from the Delta Quadrant.<br>
         <i>Recommended for average players.</i>',
        'personal_info' => 'Personal information (optional)',
        'birthdate' => 'Birthdate:',
        'birthdate_format' => 'Day.Month.Year',
        'gender' => 'Gender:',
        'not_indicated' => 'Not indicated',
        'male' => 'Male',
        'female' => 'Female',
        'zipcode' => 'Zip code:',
        'country' => 'Country:',
        'country_it' => 'Italy',
        'country_en' => 'United Kingdom',
        'country_us' => 'United States of America',
        'country_de' => 'Germany',
        'country_at' => 'Austria',
        'country_ch' => 'Switzerland',
        'country_fr' => 'France',
        'term_of_use' => 'I have read the <a href="JavaScript:void(window.open(\'agb.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));"><b><u>terms and conditions of use</u></b></a> of the game and I declare to accept them.',
        'no_multiaccount' => 'Only one account per IP',
        'multiaccount_desc' => 'This limitation means that any player that will have more than one account \
         running on the same IP for more than 4 days after the registration will be banned or deleted!<br />\
         If this is due to technical reasons such as routers or other, you must immediately notify the \
         Technical Support explaining the reason of the different accounts logged from the same IP.<br /> \
         <u><b>Follow the link below!</b></u>',
        'multiaccount_title' => 'Limitation details',
        'register' => 'Register',
        'stars_explanations' => '* The chosen name will appear in the game.<br>**Login will only be used to access the game.',
        'registration_ok1' => 'Registration for the galaxy',
        'registration_ok2' => 'successful!',
        'registration_successfully' => 'Your registration has been successful!<br \><br \>
         An email has been sent to your address, with which you can activate your account.<br \>
         <b>The message may be marked as spam, please check in case of delay.</b>',
        'registration_disabled' => 'Registration is currently disabled',
        'registration_impossible' => 'Registration is currently not possible',
        'of' => 'of',
        'occupied_places' => 'occupied places',
        'error_missing_name' => '(Player&#146;s name not specified)',
        'error_missing_login' => '(Login not specified)',
        'error_missing_password' => '(Password not specified)',
        'error_missing_email' => '(Email address not specified)',
        'error_existing_name' => '(Player&#146;s name is already in use in this galaxy)',
        'error_existing_login' => '(Login is already in use in this galaxy)',
        'error_existing_email' => '(Email address is already in use in this galaxy)',
        'error_blank_in_name' => '(Player&#146;s name contains spaces)',
        'error_inv_char_in_name' => '(Player&#146;s name contains illegal characters [0-9, a-z, A-Z only])',
        'error_inv_char_in_login' => '(Login contains illegal characters [0-9, a-z, A-Z only])',
        'error_matching_name_login' => '(Player&#146;s name and Login are the same)',
        'error_mismatching_password' => '(Passwords do not match)',
        'error_invalid_race' => '(Selected race does not exists)',
        'error_unaccepted_tou' => '(Terms of use are not accepted)',
        'error_invalid_birthday' => '(Birth date invalid)',
        'error_invalid_birthmonth' => '(Birth month invalid)',
        'error_invalid_birthyear' => '(Birth year invalid)',
        'error_invalid_gender' => '(What <b>are</b> you then?)',

        'mail_message_congrats' => 'Congratulations',
        'mail_message_reg1a' => 'Your registration in Star Trek: Frontline Combat II (',
        'mail_message_reg1b' => 'Galaxy) has been successful!',
        'mail_message_reg2' => 'To activate your account, please click on the following link:',
        'mail_message_reg3' => 'If you did not request the registation to this game, please ignore this email.',
        'mail_message_reg4' => 'After 48 hours, your email address will be automatically removed from our database.',
        'mail_message_sig_line1' => 'Live long and prosper',
        'mail_message_sig_line2' => 'The STFC team',
        'mail_subject_reg' => 'Star Trek: Frontline Combat - Registration completed',
        'there_are' => 'There are',
        'on' => 'on',

        // multis.php stringa
        'multi_account_info' => 'Information about multiple accounts',
        'multi_account_desc' => '<p>The multiaccount (ie the creation of more than one profile game belonging to the same person) is not
         allowed and punishable by the deletion or the expulsion (ban) for a variable period of time of the redundant accounts.</p>
         <p>However, the staff is aware of particular conditions of use that could lead to the creation of a "fake" multi account.<br />
         For example, two brothers who connect from the same computer or two colleagues who have access to a corporate LAN.</p>
         <p>For all these cases, it is sufficient to take timely contact with the staff to explain the situation to them.<br />
         In order to do this you can use a variety of methods such as: 
         <ul>
         <li>from the game, by sending a message to the support by following the "Help" section</li>
         <li>from the forum, by sending an PM (Personal Message) to one or more of the admins and / or moderators</li>
         <li>via email, by sending a detailed description to "admin &lt;at&gt; stfc &lt;dot&gt; it"</li>.
         </ul>',

         // activate.php strings
        'activate_title' => 'ST: Frontline Combat - Account activation',
        'activate_descr' => 'STFC: Account activation confirmation page.',
        'account_activation' => 'Account activation',
        'activate_error_title' => 'Error activating account',
        'error_missing_info' => 'At least one of the following information is missing:<ul><li>Galaxy</li><li>User ID</li><li>Activation code</li></ul>',
        'error_mismatched_code' => 'The activation code provided does not match the one stored in the system (truncated link?).',
        'error_mysql_select' => 'Internal error in SQL SELECT, please Contact Us.',
        'error_account_missing' => 'Unable to retrieve information about the player (user does not exist?).',
        'error_already_activated' => 'The player has already been activated.',
        'error_mysql_update' => 'Internal error in SQL UPDATE, please Contact Us.',
        'activate_ok_title' => 'Your account has been successfully activated!',
        'account_activated' => 'Now you can use your login and password.<br /><br />Before entering the world of STFC, a pearl of wisdom for a successful game:',

        // delete.php strings
        'delete_title' => 'ST: Frontline Combat - Account deletion',
        'delete_descr' => 'STFC: Account deletion confirmation page.',
        'account_deletion' => 'Account deletion',
        'delete_error_title' => 'Error deleting account',
        'delete_ok_title' => 'Your account deletion has been confirmed.',
        'account_deleted' => 'It will be removed with the calculation of the next tick (maximum 3 minutes).',

        // stats.php strings
        'stats_title' => 'Star Trek: Frontline Combat - Statistics',
        'stats_descr' => 'STFC: Pagina in cui vengono mostrate alcune statistiche di uptime del server e ed informazioni sulle galassie di gioco, i punti accumulati, i pianeti presenti, le alleanze e via dicendo.',
        'stats' => 'Statistics',
        'cpu_usage' => 'Usage:',
        'total_ram' => 'Total RAM:',
        'free_ram' => 'Free RAM:',
        'php_version' => 'PHP version:',
        'sql_version' => 'mySQL version:',
        'racial_statistics' => 'Racial statistics',
        'affiliate_planets' => 'Affiliate planets',
        'round_start' => 'Round started the:',
        'round_end' => 'Round ends the:',
        'view_galaxy' => 'View galaxy:',
        'click' => 'Click',
        'active_players' => 'Active players:',
        'registered_today' => 'Registered today:',
        'players_treaties' => 'Players treaties:',
        'founded_alliances' => 'Founded alliances:',
        'alliances_treaties' => 'Alliances treaties:',
        'solar_systems' => 'Solar systems:',
        'planets' => 'Planets:',
        'sum_of_all_points' => 'Sum of all points:',
        'points_by_player' => '&oslash; by player:',
        'points_by_planet' => '&oslash; by planet:',

        // spende.php strings
        'donation_title' => 'Star Trek: Frontline Combat - Support STFC!',
        'donation_descr' => 'STFC: Page where you can make a donation with which to support the game and the work done by the staff.',
        'donation' => 'Supporta Star Trek: Frontline Combat!',
        'donation_statement' => '<p>Cari colleghi e giocatori,<br><br>
         a seguito di alcune defezioni nello staff tecnico che da a tutti la possibilit&agrave;
         di divertirci con <b>Star Trek Frontline Combat</b>,
         le spese di gestione del server stanno diventando poco gestibili.</p>
         <p>Tenteremo per quanto possibile di sostenere la situazione, tuttavia
         il rischio di chiusura del server &egrave; tristemente concreto.</p>
         <p>Dunque ogni contributo spontaneo &egrave; assolutamente benaccetto!
         Visto il numero di utenti, basterebbe davvero poco da ciascuno per
         scongiurare il rischio di chiusura: pensate solo a quanto costano
         normalmente i videogiochi ed eventuali abbonamenti per giocare online,
         credo che di fronte a queste cifre diventi accettabile "<i>offrir da
         bere</i>" a chi senza aver mai chiesto nulla si &egrave; sempre
         prodigato a mantenere attivo il sito per il vostro divertimento.<p>
         <p>Purtroppo non sempre si pu&ograve; solo donare, per quanto bello,
         a volte ci si trova nelle condizioni di dover cortesemente chiedere...
         sperando di avere risposte positive dalle persone presenti dietro ai
         giocatori che si &egrave; iniziato a stimare nel nostro piccolo spazio
         virtuale.</p>
         <p>Se la generosit&agrave; di tutti dovesse superare le aspettative,
         ovviamente un eventuale eccesso verrebbe reinvestito nel potenziamento
         del server, oppure nel pagamento degli anni successivi.</p>
         <p>Grazie a tutti e buon gioco!</p>',

         // success.php strings
        'success_title' => 'Star Trek: Frontline Combat - Donation made',
        'success_descr' => 'STFC: Confirmation page for the donation made successfully.',
        'thank_you' => 'Thank you for your donation!',
        'transaction' => '<p>Thank you for your donation.</p>
         <p>The transaction has been completed and a receipt for your purchase has
         been sent to your email address.</p><p>To view details about the
         transaction log in to your <a href="http://www.paypal.com">Paypal</a>
         account.</p>'
    ),

    // Italian strings
    'it' => array(
        // home.php strings
        'nonews' => 'Nessuna novit&agrave; disponibile',
        'noreports' => 'Nessuna rassegna stampa disponibile',
        'today' => 'Oggi',
        'yesterday' => 'Ieri',
        'welcome' => 'Questo &egrave; un gioco multiplayer ambientato nell&rsquo;universo di Star Trek&trade;
          per il quale non &egrave; necessario altro che un semplice browser web ed una connessione
          ad Internet.<br><br>
          STFC2 &egrave; un gioco strategico e tattico che gira in tempo reale per dare ai giocatori
          la massima esperienza di gioco possibile.<br><br>
          Scegli la tua specie tra Federali, Klingon, Romulani e tanti altri, fonda le tue colonie,
          costruisci la tua flotta ed espandi la tua rete commerciale per arrivare l&agrave; dove
          nessun &egrave; mai giunto prima!',
        'fist_membership' => 'Sito membro della Federazione Italiana Siti Trek',

        // login.php strings
        'login_descr' => 'STFC: Pagina per effettuare la login alla galassia di gioco a cui si e` iscritti (galassia Brown Bobby o Fried Egg).',
        'login' => 'Login',
        'user_login' => 'Login:',
        'password' => 'Password:',
        'galaxy' => 'Galassia:',
        'using_proxy' => 'Sto usando un <a href="http://it.wikipedia.org/wiki/Proxy" target="_blank"><u>server proxy</u></a>',
        'proxy_note' => 'Usare solo se le immagini non vengono caricate.',
        'lost_password' => 'Recupero password dimenticata',
        'submit' => 'Conferma',

        // lost_password.php strings
        'lost_password_title' => 'Star Trek: Frontline Combat - Recupero password',
        'lost_password_descr' => 'STFC: Pagina con cui richiedere al sistema una nuova password in sostituzione a quella dimenticata.',
        'password_recovery' => 'Recupero password',
        'error_wrong_name_or_login' => 'Si &egrave; verificato il seguente problema:<br>Il nome utente o il nome login &egrave; errato.',
        'error_wrong_email' => 'Si &egrave; verificato il seguente problema:<br>L&#146;indirizzo email &egrave; errato.',
        'mail_message_lp1' => 'Apparentemente avete richiesto una nuova password.',
        'mail_message_lp2' => 'Per cercare di effettuare il login adesso, si prega di utilizzare questa password:',
        'mail_message_lp3' => 'Vi consigliamo di cambiare la password dopo aver effettuato l&#146;accesso, usando la pagina delle impostazioni.',
        'mail_subject_lp' => 'Star Trek: Frontline Combat - Recupero password',
        'password_recovered' => 'Presto riceverai la nuova password via e-mail.',
        'lost_password_warning' => 'Attenzione: riceverai una nuova password generata in automatico.',
        'back_to_login' => 'Indietro alla Login',
        'password_request' => 'Richiedi password',

        // register.php strings
        'register_title' => 'Star Trek: Frontline Combat - Registrazione',
        'register_descr' => 'STFC: Pagina in cui effettuare la registrazione ad una galassia di gioco fornendo i dettagli del proprio account, quali nick, email, sesso, razza scelta, data di nascita ecc.',
        'registration' => 'Registrazione',
        'galaxy_selection' => '(1/2) Scegli la galassia:',
        'version' => 'Versione:',
        'running_since' => 'In gioco da:',
        'days' => 'giorni',
        'available_places' => 'Posti disponibili:',
        'online_players' => 'Giocatori online:',
        'galaxy1_desc' => 'La Galassia "'.GALAXY1_NAME.'" &egrave; il setup base con un
         tempo di tick di 3 minuti.',
        'galaxy2_desc' => 'La Galassia "'.GALAXY2_NAME.'" &egrave; il setup in cui ci sono
         meno razze a disposizione e la diplomazia &egrave; solo un sogno.',

        'galaxy_registration' => '(2/2) Registrazione per la galassia',
        'player_info' => 'Informazioni di gioco (necessarie)',
        'player_name' => 'Nome giocatore:',
        'password_verify' => 'Verifica Password:',
        'email' => 'Email:',
        'race_selection' => 'Scelta della razza:',
        'race0' => 'Federazione',
        'race1' => 'Romulani',
        'race2' => 'Klingon',
        'race3' => 'Cardassiani',
        'race4' => 'Dominio',
        'race5' => 'Ferengi',
        'race6' => 'Borg',
        'race7' => 'Q',
        'race8' => 'Breen',
        'race9' => 'Hirogeni',
        'race10' => 'Krenim',
        'race11' => 'Kazon',
        'race0_desc' => 'Federazione. Questa &egrave; la razza con la maggiore
         variet&agrave; di navi. Le navi della Federazione hanno gli scudi pi&ugrave;
         resistenti tra tutte le navi della Galassia. Il tasso di produzione delle
         risorse &egrave; nella media, cosi come quello delle truppe. In paragone alle
         altre specie, la Federazione gode di buoni strumenti di ricerca tecnologica.<br>
         I giocatori di questa specie partono con pari probabilit&agrave; dal Quadrante
         Alfa, Beta e Gamma, difficilmente dal Delta.<br>
         <i>Consigliata ai giocatori alle prime armi.</i>',
        'race1_desc' => 'I Romulani hanno un punto di forza nel poter costruire navi e
         fanti velocemente e a basso costo. Hanno un tasso di produzione di dilitio
         bassissimo e dispongono di vascelli e soldati relativamente deboli. Tuttavia,
         le navi Romulane dispongono di un ottima capacit&agrave; di occultamento.<br>
         I giocatori di questa specie partono con maggior probabilit&agrave; dal Quadrante
         Beta piuttosto che dal Gamma ed Alfa.<br>
         <i>Consigliata ai giocatori alle prime armi.</i>',
        'race2_desc' => 'I Klingon sono una razza guerriera con ottime navi e soldati.
         Tuttavia sono penalizzati da tempi di costruzione per le truppe e per le
         strutture planetarie molto alti. Inoltre, la ricerca tecnologica non rappresenta
         un punto a favore dei Klingon.<br>I giocatori di questa razza partono con buone
         probabilit&agrave; dal Quadrante Alfa, in misura minore dal Beta e Gamma.<br>
         <i>Consigliata ai giocatori alle prime armi.</i>',
        'race3_desc' => 'I Cardassiani, gli oppressori e sfruttatori di tanti popoli,
         sleali e falsi in ogni situazione. Possiedono soldati aggressivi ma non
         dispongono di una grande variet&agrave; di navi. Le loro navi sono piuttosto
         deboli in rapporto a quelle delle altre razze. Tra tutte, &egrave; la razza
         pi&ugrave; aggressiva.<br>I giocatori di questa razza iniziano a giocare con
         maggior probabilit&agrave; dal quadrante Alfa e Gamma.<br>
         <i>I Cardassiani necessitano di buona applicazione ed aggressivit&agrave; per
         essere giocati con successo.</i>',
        'race4_desc' => 'Il Dominio dispone di navi veloci e potenti. La loro
         capacit&agrave; estrattiva &egrave; la pi&ugrave; bassa tra tutte le razze. I
         tempi di costruzione delle strutture planetarie, in paragone alle altre specie,
         &egrave; piuttosto alto.<br>I giocatori di questa razza partono principalmente
         dal Quadrante Gamma.<br>
         <i>Una delle razze pi&ugrave; dure da giocare, decisamente sconsigliata ai
         giocatori alle prime armi.</i>',
        'race5_desc' => 'I Ferengi sono la razza commerciante per eccellenza in Star
         Trek. Preferiscono fare commercio, dispongono dei trasporti pi&ugrave; veloci e
         navi colonia molto rapide, hanno il miglior tasso di estrazione di risorse e sono
         velocissimi nel costruire truppe e strutture planetarie, tutto questo permette al
         Ferengi di espandersi pi&ugrave; velocemente di qualsiasi altra razza. La loro
         debolezza consiste nelle loro scadenti navi da battaglia, motivo per cui il
         giocatore dovrebbe concentrare tutta la sua capacit&agrave; affaristica nel
         comprare navi alle aste.<br>I giocatori di questa razza hanno pari
         possibilit&agrave; di parte da un qualsiasi dei quattro quadranti.<br>
         <i>Una razza estremamente facile da giocare in termini di gestione. Occorre senso
         per gli affari per sfruttare a fondo i Ferengi.</i>',
        'race6_desc' => 'Borg',
        'race7_desc' => 'Q',
        'race8_desc' => 'I Breen sono una specie molto forte, con navi e soldati potenti
         ma piuttosto costosi. Il loro tasso di estrazione risorse &egrave; piuttosto
         basso e questo pu&ograve; portare a qualche problema economico. Dispongono anche
         della minor variet&agrave; di navi a disposizione, tuttavia le poche esistenti
         non vanno assolutamente sottovalutate. Il tempo di costruzione delle strutture
         planetarie &egrave; relativamente alto.<br>I giocatori di questa razza partono
         con prevalenza dal Quadrante Gamma.<br>
         <i>Una razza piuttosto difficile da giocare e con poca variet&agrave; di navi.
         Indicata per i giocatori con molto senso pratico.</i>',
        'race9_desc' => 'Gli Hirogeni sono una razza molto difficile da giocare.
         Il loro vantaggio arriva a gioco avanzato, ma devono lottare con la poca
         variet&agrave; di navi. Gli Hirogeni dispongono di eccellenti truppe di terra
         con la migliore capacit&agrave; difensiva delle proprie strutture.<br>
         I giocatori di questa razza possono iniziare con pari probabilit&agrave; da
         qualsiasi quadrante della galassia.<br>
         <i>Razza complessa da giocare, indicata per i pi&ugrave; esperti o per chi
         vuole affrontare la sfida pi&ugrave; difficile.</i>',
        'race10_desc' => 'I Krenim non possiedono truppe particolarmente forti ma hanno
         come enorme vantaggio lo sfruttamento della tecnologia. Nel campo della ricerca
         tecnologica i Krenim sono al di sopra di tutte le altre razze e anche la creazione
         delle truppe &egrave; piuttosto rapida.<br>I giocatori di questa razza iniziano
         principalmente dal Quadrante Delta.<br>
         <i>Razza semplice da giocare ma non semplicissima. Una sfida di livello medio.</i>',
        'race11_desc' => 'I Kazon appartengono alle razze guerriere, specialmente sul campo
         di battaglia a terra. Sono molto rapidi nel produrre truppe, il loro punto di forza.
         Le navi Kazon pi&ugrave; piccole non sono una minaccia per le altre razze, solo
         successivamente giungono al loro pieno potenziale.<br>I giocatori di questa razza
         iniziano principalmente dal Quadrante Delta.<br>
         <i>Consigliata ai giocatori di livello medio.</i>',
        'personal_info' => 'Informazioni personali (opzionali)',
        'birthdate' => 'Data di nascita:',
        'birthdate_format' => 'Giorno.Mese.Anno',
        'gender' => 'Sesso:',
        'not_indicated' => 'Non indicato',
        'male' => 'Maschio',
        'female' => 'Femmina',
        'zipcode' => 'Cap:',
        'country' => 'Paese:',
        'country_it' => 'Italia',
        'country_en' => 'Inghilterra',
        'country_us' => 'Stati Uniti',
        'country_de' => 'Germania',
        'country_at' => 'Austria',
        'country_ch' => 'Svizzera',
        'country_fr' => 'Francia',
        'term_of_use' => 'Dichiaro in questa sede di aver preso visione dei <a href="JavaScript:void(window.open(\'agb.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));"><b><u>termini e condizioni di utilizzo</u></b></a> del gioco e di accettarli.',
        'no_multiaccount' => 'Solo un account per IP',
        'multiaccount_desc' => 'Questa limitazione significa che ogni giocatore che per\
         pi&ugrave; di 4 giorni successivi alla registrazione avr&agrave; pi&ugrave; di un \
         account in funzione sul proprio IP, se li vedr&agrave; bannati o cancellati!<br /> \
         Se ci&ograve; &egrave; dovuto a motivi tecnici quali router o altro, deve subito \
         comunicare al Supporto le ragione dei diversi account loggati dallo stesso IP.<br /> \
         <u><b>Seguite il link in basso!</b></u>',
        'multiaccount_title' => 'Dettagli sulla limitazione',
        'register' => 'Registrami',
        'stars_explanations' => '* Il nome scelto apparir&agrave; nel gioco<br>** Il Login verr&agrave; usato esclusivamente per accedere al gioco',
        'registration_ok1' => 'Registrazione per la galassia',
        'registration_ok2' => 'avvenuta con successo!',
        'registration_successfully' => 'La tua registrazione ha avuto successo!<br><br>
         Una email &egrave; stata inviata al tuo indirizzo, con la quale potrai attivare il
         tuo account. <br> <b>Il messaggio potrebbe venire marcato come spam, ti preghiamo
         di verificare in caso di ritardo.</b>',
        'registration_disabled' => 'La registrazione attualmente &egrave; disabilitata',
        'registration_impossible' => 'La registrazione attualmente non &egrave; possibile',
        'of' => 'di',
        'occupied_places' => 'posti occupati',
        'error_missing_name' => '(Nome del giocatore non specificato)',
        'error_missing_login' => '(Login non specificato)',
        'error_missing_password' => '(Password non specificata)',
        'error_missing_email' => '(Indirizzo Email non specificato!)',
        'error_existing_name' => '(Il nome del giocatore &egrave; gi&agrave; in uso nella Galassia!)',
        'error_existing_login' => '(Il Login &egrave; gi&agrave; in uso nella Galassia!)',
        'error_existing_email' => '(La Email specificata &egrave; gi&agrave; in uso nella Galassia!)',
        'error_blank_in_name' => '(Il nome del giocatore contiene spazi)',
        'error_inv_char_in_name' => '(Il nome scelto contiene caratteri non consentiti [solo 0-9, a-z, A-Z])',
        'error_inv_char_in_login' => '(Il Login scelto contiene caratteri non consentiti [solo 0-9, a-z, A-Z])',
        'error_matching_name_login' => '(Il nome giocatore e il Login coincidono!)',
        'error_mismatching_password' => '(Le password non coincidono)',
        'error_invalid_race' => '(La razza selezionata non esiste)',
        'error_unaccepted_tou' => '(I termini di utilizzo non sono stati accettati)',
        'error_invalid_birthday' => '(La data di nascita non &egrave; valida)',
        'error_invalid_birthmonth' => '(Il mese di nascita non &egrave; valido)',
        'error_invalid_birthyear' => '(Anno di nascita non valido)',
        'error_invalid_gender' => '(What <b>are</b> you then?)',

        'mail_message_congrats' => 'Congratulazioni',
        'mail_message_reg1a' => 'La tua registrazione a Star Trek: Frontline Combat II (Galassia',
        'mail_message_reg1b' => ') ha avuto successo!',
        'mail_message_reg2' => 'Per attivare il tuo account devi cliccare sul link seguente:',
        'mail_message_reg3' => 'Se non hai eseguito la registrazione, ignora questa email.',
        'mail_message_reg4' => 'Dopo 48 ore, il tuo indirizzo email verrà automaticamente rimosso dal nostro database.',
        'mail_message_sig_line1' => 'Lunga vita e prosperità',
        'mail_message_sig_line2' => 'Il team STFC',
        'mail_subject_reg' => 'Star Trek: Frontline Combat - Registrazione effettuata',
        'there_are' => 'Ci sono',
        'on' => 'su',

        // multis.php strings
        'multi_account_info' => 'Informazioni sugli account multipli',
        'multi_account_desc' => '<p>Il multiaccount (ovvero la creazione di pi&ugrave; di un profilo di gioco appartenenti alla stessa persona) non &egrave;
         consentito e punito con la cancellazione o l&#146;allontanamento (ban) per un periodo di tempo variabile degli account ridondanti.</p>
         <p>Tuttavia lo staff &egrave; a conoscenza di particolari condizioni di utilizzo che potrebbero portare alla creazione di
         un "falso" multi account.<br>Ad esempio, due fratelli che si collegano dallo stesso computer o due colleghi che accedono da una LAN.</p>
         <p>Per tutti questi casi, &egrave; sufficiente prendere tempestivamente contatti con lo Staff per spiegare loro la situazione.<br>
         Per farlo &egrave; possibile avvalersi di diversi metodi quali:
         <ul>
          <li>dal gioco, con l&#146;invio di un messaggio al Supporto seguendo la sezione "Aiuto"</li>
          <li>dal forum, tramite l&#146;invio di un MP (Messaggio Personale) ad uno o pi&ugrave; degli amministratori e/o moderatori</li>
          <li>via email, inviando una descrizione dettagliata ad "admin &lt;at&gt; stfc &lt;dot&gt; it"</li>.
         </ul>',

        // activate.php strings
        'activate_title' => 'ST: Frontline Combat - Attivazione account',
        'activate_descr' => 'STFC: Pagina di conferma attivazione account.',
        'account_activation' => 'Attivazione account',
        'activate_error_title' => 'Errore nell&#146;attivazione dell&#146;account',
        'error_missing_info' => 'Almeno una delle seguenti informazioni risulta mancante:<ul><li>galassia</li><li>ID utente</li><li>codice di conferma</li></ul>',
        'error_mismatched_code' => 'Il codice di attivazione fornito non corrisponde con quello memorizzato nel sistema (link troncato?).',
        'error_mysql_select' => 'Errore interno nella SELECT mySQL, si prega di contattare lo Staff.',
        'error_account_missing' => 'Impossibile recuperare le informazioni relative al giocatore (utente inesistente?).',
        'error_already_activated' => 'Il giocatore &egrave; gi&agrave; stato attivato.',
        'error_mysql_update' => 'Errore interno nella UPDATE mySQL, si prega di contattare lo Staff.',
        'activate_ok_title' => 'Il tuo account &egrave; stato attivato con successo!',
        'account_activated' => 'Ora puoi usare le tue login e password.<br><br>Prima di entrare nel mondo di STFC, una perla di saggezza per un gioco di successo:',
        
        // delete.php strings
        'delete_title' => 'ST: Frontline Combat - Cancellazione account',
        'delete_descr' => 'STFC: Pagina di conferma eliminazione account.',
        'account_deletion' => 'Cancellazione account',
        'delete_error_title' => 'Errore nella cancellazione dell&#146;account',
        'delete_ok_title' => 'La cancellazione del tuo account &egrave; stata confermata.',
        'account_deleted' => 'Sar&agrave; definitivamente rimosso con il calcolo del prossimo tick (massimo in 3 minuti).',

        // stats.php strings
        'stats_title' => 'Star Trek: Frontline Combat - Statistiche',
        'stats_descr' => 'STFC: Pagina in cui vengono mostrate alcune statistiche di uptime del server e ed informazioni sulle galassie di gioco, i punti accumulati, i pianeti presenti, le alleanze e via dicendo.',
        'stats' => 'Statistiche',
        'cpu_usage' => 'Utilizzo:',
        'total_ram' => 'RAM totale:',
        'free_ram' => 'RAM libera:',
        'php_version' => 'Versione PHP:',
        'sql_version' => 'Versione mySQL:',
        'racial_statistics' => 'Statistiche razziali',
        'affiliate_planets' => 'Affiliazione pianeti',
        'round_start' => 'In esecuzione dal:',
        'round_end' => 'Termine turno il:',
        'view_galaxy' => 'Visualizza galassia:',
        'click' => 'Clicca',
        'active_players' => 'Giocatori attivi:',
        'registered_today' => 'Iscritti oggi:',
        'players_treaties' => 'Trattati privati:',
        'founded_alliances' => 'Alleanze fondate:',
        'alliances_treaties' => 'Trattati alleanze:',
        'solar_systems' => 'Sistemi solari:',
        'planets' => 'Pianeti:',
        'sum_of_all_points' => 'Somma di tutti i punti:',
        'points_by_player' => '&oslash; per giocatore:',
        'points_by_planet' => '&oslash; per pianeta:',

        // spende.php strings
        'donation_title' => 'Star Trek: Frontline Combat - Supporta STFC!',
        'donation_descr' => 'STFC: Pagina in cui e` possibile effettuare una donazione ad importo libero con cui supportare il gioco ed il lavoro svolto dallo staff.',
        'donation' => 'Supporta Star Trek: Frontline Combat!',
        'donation_statement' => '<p>Cari colleghi e giocatori,<br><br>
         a seguito di alcune defezioni nello staff tecnico che da a tutti la possibilit&agrave;
         di divertirci con <b>Star Trek Frontline Combat</b>,
         le spese di gestione del server stanno diventando poco gestibili.</p>
         <p>Tenteremo per quanto possibile di sostenere la situazione, tuttavia
         il rischio di chiusura del server &egrave; tristemente concreto.</p>
         <p>Dunque ogni contributo spontaneo &egrave; assolutamente benaccetto!
         Visto il numero di utenti, basterebbe davvero poco da ciascuno per
         scongiurare il rischio di chiusura: pensate solo a quanto costano
         normalmente i videogiochi ed eventuali abbonamenti per giocare online,
         credo che di fronte a queste cifre diventi accettabile "<i>offrir da
         bere</i>" a chi senza aver mai chiesto nulla si &egrave; sempre
         prodigato a mantenere attivo il sito per il vostro divertimento.<p>
         <p>Purtroppo non sempre si pu&ograve; solo donare, per quanto bello,
         a volte ci si trova nelle condizioni di dover cortesemente chiedere...
         sperando di avere risposte positive dalle persone presenti dietro ai
         giocatori che si &egrave; iniziato a stimare nel nostro piccolo spazio
         virtuale.</p>
         <p>Se la generosit&agrave; di tutti dovesse superare le aspettative,
         ovviamente un eventuale eccesso verrebbe reinvestito nel potenziamento
         del server, oppure nel pagamento degli anni successivi.</p>
         <p>Grazie a tutti e buon gioco!</p>',

         // success.php strings
        'success_title' => 'Star Trek: Frontline Combat - Donazione effettuata',
        'success_descr' => 'STFC: Pagina di conferma per la donazione effettuata con successo.',
        'thank_you' => 'Grazie per la tua donazione!',
        'transaction' => '<p>Grazie per aver effettuato la tua donazione.</p>
         <p>La transazione &egrave; stata completata e una ricevuta dell&#146;acquisto
         &egrave; stata inviata al tuo indirizzo email.</p><p>Per visualizzare
         i dettagli sulla transazione effettua l&#146;accesso al tuo conto
         dall&#146;indirizzo <a href="http://www.paypal.com/it">www.paypal.com/it</a>.</p>'
    )
);


$langs = array(
        'en-US',// default
        'it',
);


$locale = $loc_strings[substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)];


?>
