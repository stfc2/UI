<?PHP

include('include/static/static_components.php');
$filename = 'include/static/static_components_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);

function available_ships() {
	global $game,$SHIP_TORSO,$MAX_RESEARCH_LVL;
	$avail_ships = '<ul>';
	for ($t=0; $t<count($SHIP_TORSO[$game->player['user_race']]); $t++)
	{
		// Skip disabled ships
		if($SHIP_TORSO[$game->player['user_race']][$t][0] == 100000000)
			continue;

		$avail_ships .= '<li>'.$SHIP_TORSO[$game->player['user_race']][$t][29].'</li>';
	}
	$avail_ships .= '</ul>';
	return $avail_ships;
}

function components_categories() {
	global $game, $ship_components;
	$avail_cat = '<ul>';
	for ($c=0; $c < count($ship_components[$game->player['user_race']]); $c++)
	{
		$avail_cat .= '<li>'.$ship_components[$game->player['user_race']][$c]['name'].'</li>';
	}
	$avail_cat .= '</ul>';
	return $avail_cat;
}

$guide_html = '<span class="caption">I PROGETTI NAVALI</span>
<p align="justify">
Tramite questo pannello &egrave; possibile creare i propri progetti navali che potranno poi essere realizzati per mezzo del "<a href="'.parse_link('a=shipyard').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][7].'</span></a>".<br>
La lista di navi visualizzata in questa sezione, varia a seconda del tuo punteggio e del pianeta selezionato: la prima nave disponibile sar&agrave; lo scout.<br>
Ecco la lista massima di navi disponibili:
'.available_ships().'
</p>
<p align="justify">
Una volta selezionata la classe di nave desiderata, &egrave; possibile specificare nel progetto quali
<a href="'.parse_link('a=database&view=guide&page=7').'"><span class="highlight_link">componenti</span></a> dovranno essere installati durante la costruzione della nave.<br>
I componenti navali, che vengono ricercati nel "<a href="'.parse_link('a=researchlabs').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][8].'</span></a>", sono suddivisi nelle seguenti categorie:
'.components_categories().'
</p>
<p align="justify">
Per ogni categoria &egrave; possibile specificare <b>UN</b> solo componente, non tutti possono essere montati su tutte le classi di navi disponibili ed inoltre dev&#146;essere rispettato il limite massimo di consumo energetico, altrimenti non sar&agrave; possibile completare il progetto.
</p>
<p align="justify">
<b>Come si crea un progetto nave?</b><br>
Seguendo il men&ugrave; "<a href="'.parse_link('a=ship_template').'"><span class="highlight_link">Progetti navi</span></a>" viene presentato un pannello con tre voci:
<ul>
<li>Dettagli, che mostra una lista di tutti i progetti gi&agrave; realizzati;</li>
<li>Crea progetto, per creare un nuovo progetto e</li>
<li>Confronta progetti, per poter visualizzare un raffronto tra tre progetti differenti.</li>
</ul>
Selezionare la voce "<a href="'.parse_link('a=ship_template&view=create').'"><span class="highlight_link">Crea Progetto</span></a>" , scegliere, dalla lista disponibile, la classe di nave di cui si desidera creare un progetto e premere il pulsante <input class="button_nosize" type="submit" value ="(2/3) Continua...">.<br>
Verr&agrave; visualizzato l&#146;elenco di tutti i componenti disponibili (<b><u>gi&agrave; ricercati sul pianeta selezionato</u></b>) dal quale scegliere quelli da installare.<br>
Al termine della selezione, premere il bottone <input class="button_nosize" type="submit" value="(3/3) Continua..."> per dare un nome al progetto ed eventualmente una descrizione di esso, quindi selezionare il pulsante <input class="button_nosize" type="submit" value="Finalizzare"> per salvare il progetto.

';
?>
