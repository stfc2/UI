<?PHP

$guide_html = '<span class="caption">LE RICERCHE TECNOLOGICHE</span>
<p align="justify">
Il secondo metodo per ottenere punti &egrave; portare avanti delle ricerche tecnologiche planetarie. Per poter accedere a questa funzione
tuttavia &egrave; necessario che la struttura di comando sia al livello 9 (il massimo possibile) e che la struttura di ricerca sia almeno al livello 1.
</p>
<p align="justify">
Le ricerche planetarie sono di cinque tipi:
<ul>
<li><u>'.$TECH_NAME[$game->player['user_race']][0].'</u>: la prima delle cinque tipologie riguarda il &quot;terraforming&quot;, ossia intervenire sul pianeta per renderlo pi&ugrave;
abitabile; sviluppare tale tecnologia aumenta il numero massimo di lavoratori e soldati ospitabili su un pianeta e la velocit&agrave; di costruzione
dei lavoratori;</li>
<li><u>'.$TECH_NAME[$game->player['user_race']][1].'</u>: la seconda tipologia riguarda l&#146;incremento della produzione di lavoratori sul pianeta; questa tecnologia
offre un incremento doppio a parit&agrave; di livello rispetto alla tecnologia di precedente, ma non aumenta la capacit&agrave; massima del pianeta
stesso;</li>
<li><u>'.$TECH_NAME[$game->player['user_race']][2].'</u>: aumenta il numero di piattaforme orbitali difensive costruibili sul pianeta e contemporaneamente
ne riduce i costi di costruzione;<li>
<li><u>'.$TECH_NAME[$game->player['user_race']][3].'</u>: questa tecnologia rende pi&ugrave; veloce la costruzione delle strutture sul pianeta (per alcune
classi &egrave; una tecnologia importantissima);</li>
<li><u>'.$TECH_NAME[$game->player['user_race']][4].'</u>: questa tecnologia aumenta l&#146;efficienza delle miniere. <b>ATTENZIONE</b>: per poter ottenere
questa tecnologia devono verificarsi queste condizioni: livello di tutte e tre le miniere sul pianeta ALMENO a 5 e livello del Centro di Ricerca
almeno a 3.</li>
</ul>
</p>
<p align="justify">
&Egrave; possibile anche sviluppare tecnologie da utilizzare poi durante la creazione di un progetto navale per la realizzazione di una nave
spaziale; le tecnologie aumentano i costi in risorse e personale delle navi ma le rendono generalmente più performanti.</p>
<p align="justify">
<b>Come si sviluppano le ricerche planetarie?</b><br>
Seguendo il men&ugrave;
"<a href="'.parse_link('a=researchlabs').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][8].'</span></a>" viene
presentato un pannello che elenca tutte le ricerche relative ai componenti installabili sulle varie classi di astronavi e sotto le cinque tipologie
di ricerca planetaria. Se la struttura di ricerca non &egrave; occupata e sul pianeta sono presenti risorse a sufficienza, accanto al nome, al costo
in risorse nonch&eacute; al tempo necessario per lo sviluppo, &egrave; possibile trovare un <span style="color: green">link verde</span> che
permette di avviare la ricerca selezionata.<br>
Non &egrave; possibile pi&ugrave; di una ricerca in coda.

';
?>
