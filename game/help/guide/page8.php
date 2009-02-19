<?PHP

function spacedock_max_ships($planet) {
	global $game,$TECH_NAME,$MAX_BUILDING_LVL,$MAX_SPACEDOCK_SHIPS;
	$ships_level = '<ul>';
	for($lvl = 1;$lvl <= $MAX_BUILDING_LVL[$planet][6];$lvl++)
	{
		$ships_level .= '<li>Livello '.$lvl.' = <b>'.$MAX_SPACEDOCK_SHIPS[$lvl].'</b></li>';
	}
	$ships_level .= '</ul>';
	return $ships_level;
}

$guide_html = '<span class="caption">LE FLOTTE</span><br>
<span class="sub_caption2">Parte prima: la creazione</span>
<p align="justify">
Ogni volta che una nave in costruzione viene completata, viene spostata automaticamente nello
"<a href="'.parse_link('a=spacedock').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][6].'</span></a>" del pianeta.<br>
Il numero di navi ospitabili all&#145;interno della struttura dipende dal suo livello, ossia:
<table width="100%">
<tr>
  <td valign="top">'.spacedock_max_ships(1).'</td>
  <td valign="top">'.spacedock_max_ships(0).'</td>
</tr>
<tr><td>per il pianeta capitale</td><td>per tutte le colonie.</td></tr>
</table>
</p>
<p align="justify">
Questa struttura consente di effettuare diverse operazioni sulle navi ormeggiate, ovvero:
<ul>
<li>ripararle o smantellarle;</li>
<li>imbarcare o sbarcare equipaggio extra (quello cio&eacute; oltre il livello minimo);</li>
<li>visualizzarne i dettagli in una schermata a parte;</li>
<li>assegnare loro un nome ed un codice contratto;</li>
<li>inserirle in una nuova flotta o</li>
<li>unirle ad una flotta gi&agrave; esistente in orbita presso il pianeta.</li> 
</ul>
</p>
<p align="justify">
Infatti prima di poter esser operativa, una nave deve essere inserita in una flotta che sar&agrave; poi possibile comandare tramite il pannello Flotte o il pannello Tattico. 
</p>
<p align="justify">
<b>Come faccio a creare una flotta?</b><br>
Selezionare il men&ugrave; "<a href="'.parse_link('a=spacedock').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][6].'</span></a>", tramite il mouse e l&#146;aiuto dei tasti <u>Ctrl</u> o <u>Shift</u>, selezionare dalla lista le navi che si desiderano unire in una flotta, quindi inserire il nome che si vuole dare alla flotta nel campo "Metti in servizio:" e premere il bottone <input class="button_nosize" type="submit" value ="Crea nuova flotta">.
</p>

';
?>
