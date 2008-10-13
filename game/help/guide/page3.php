<?PHP

function building_max_lev($planet) {
	global $game,$BUILDING_NAME,$MAX_BUILDING_LVL;
	$building_level = '<ul>';
	for($blt = 0;$blt < 13;$blt++)
	{
		if($blt < 9)
		{
			$building_level .= '<li>'.$BUILDING_NAME[$game->player['user_race']][$blt].' = <b>'.$MAX_BUILDING_LVL[$planet][$blt].'</b></li>';
		}
		else if ($blt == 9)
		{
			$building_level .= '<li>'.$BUILDING_NAME[$game->player['user_race']][12].' = <b>'.$MAX_BUILDING_LVL[$planet][12].'</b></li>';
		}
		else
		{
			$building_level .= '<li>'.$BUILDING_NAME[$game->player['user_race']][$blt-1].' = <b>'.$MAX_BUILDING_LVL[$planet][$blt-1].'</b></li>';
		}
	}
	$building_level .= '</ul>';
	return $building_level;
}


$guide_html ='<span class="caption">LE STRUTTURE</span>
<p align="justify">
In STFC le strutture costruite sui pianeti rappresentano il modo pi&ugrave; veloce per ottenere punti.<br>
Esse sono principalmente di cinque tipi:
<ul>
<li><a href="'.parse_link('a=headquarter').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][0].'</span></a>: questa
struttura rappresenta, sul pianeta, l&#146;organo di controllo di tutte le restanti strutture; in base al suo livello &egrave; possibile costruire
pi&ugrave; tipologie di strutture;</li>
<li><u>Estrazione</u>: in questa tipologia rientrano le tre varianti di miniere ('.$BUILDING_NAME[$game->player['user_race']][1].',
'.$BUILDING_NAME[$game->player['user_race']][2].' e '.$BUILDING_NAME[$game->player['user_race']][3].') le quali producono risorse
(<img src="'.$game->GFX_PATH.'menu_metal_small.gif"> metalli, <img src="'.$game->GFX_PATH.'menu_mineral_small.gif"> minerali e
<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> dilitio); il loro livello determina la quantit&agrave; di risorse estratte e il numero di
<img src ="'.$game->GFX_PATH.'menu_worker_small.gif"> lavoratori che possono operarvi; si tenga presente che i lavoratori vanno assegnati alle
miniere in lotti di 100; la quantit&agrave; di risorse estratte varia anche in funzione del pianeta sul quale si sta scavando;</li>
<li><u>Produzione</u>: in questa tipologia troviamo le strutture preposte alla costruzione delle navi spaziali o all&#146;addestramento del personale;
ossia <a href="'.parse_link('a=shipyard').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][7].'</span></a> e
<a href="'.parse_link('a=academy').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][5].'</span></a>; come vedremo
pi&ugrave; avanti, costruire una nave spaziale richiede la creazione di un progetto;</li>
<li><u>Supporto</u>: in questa tipologia rientrano <span class="highlight">'.$BUILDING_NAME[$game->player['user_race']][4].'</span> la struttura
adibita all produzione di energia per tutte le altre infrastrutture,
<a href="'.parse_link('a=researchlabs').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][8].'</span></a> dove &egrave;
possibile sviluppare le tecnologie da impiegare nei progetti delle navi oppure le tecnologie planetarie; notare che anche le tecnologie planetarie
forniscono punti e migliorano sensibilmente le capacit&agrave; del pianeta stesso; inoltre, in questa tipologia rientrano i
<span class="highlight">'.$BUILDING_NAME[$game->player['user_race']][11].'</span> ossia le strutture che permettono di immagazzinare su un pianeta un maggior numero di risorse;
esiste inoltre <a href="'.parse_link('a=spacedock').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][6].'</span></a>,
struttura necessaria per la creazione di flotte, la riparazione di navi e l&#146;imbarco di equipaggio sulle navi stesse; per ultimo, ricordiamo il
<a href="'.parse_link('a=trade').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][10].'</span></a>, ossia la struttura
che ci permette di accedere al Centro Commerciale di Ursa Mirror, gestito in automatico dal sistema e di utilizzare il servizio di
trasporti Ferengi, anch&#146;esso gestito dal sistema;</li>
<li><u>Difesa</u>: in questa tipologia rientrano le stazioni orbitali di difesa; sono piattaforme orbitali armate con il compito di difendere
l&#146;orbita del pianeta stesso da astronavi ostili; non &egrave; necessario intervenire per metterle in funzione, basta costruirle ed esse
opereranno ogni qualvolta ce ne sia la necessità;</li>
</ul>
</p>
<p align="justify">
Tutte queste strutture sono organizzate a livelli, pi&ugrave; &egrave; alto il livello e maggiore sono i benefici ottenuti dalla struttura stessa;
da notare che esiste un limite ai livelli delle strutture pari a:
<table width="100%">
<tr><td>'.building_max_lev(1).'</td><td>'.building_max_lev(0).'</td></tr>
<tr><td>per il pianeta capitale</td><td>per tutte le colonie.<br></td></tr>
</table>
Fanno eccezione le piattaforme orbitali, per le quali il limite pu&ograve; essere superato ricercando la tecnologia &quot;Difesa Orbitale&quot;.
</p>
<p align="justify">
<b>Come si costruiscono le strutture?</b><br>
Seguendo il men&ugrave;
<a href="'.parse_link('a=building').'">&quot;<span class="highlight_link">Costruzioni</span>&quot;</a> viene presentato un pannello che elenca tutte
le strutture costruibili sul pianeta e se sono presenti risorse a sufficienza, accanto al nome e al costo in risorse di ogni struttura nonch&eacute;
al tempo necessario per realizzare la struttura stessa, &egrave; possibile trovare un <span style="color: green">link verde</span> che permette di
accodare la costruzione della struttura stessa. La costruzione parte immediatamente, oppure viene accodata se in quel momento c&#146;&egrave;
un&#146;altra costruzione in corso.<br>&Egrave; possibile avere una sola costruzione in coda.</p>
';

?>