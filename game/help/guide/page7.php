<?PHP

$guide_html = '<span class="caption">I COMPONENTI NAVI</span>
<p align="justify">
I componenti navi sono speciali tecnologie ricercabili mediante la struttura "<a href="'.parse_link('a=researchlabs').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][8].'</span></a>",
che servono a migliorare il rendimento di una o pi&ugrave; classi di navi rispetto ai loro progetti iniziali, i quali in origine non hanno alcun componente installato.<br>
Essi sono suddivisi in categorie, a seconda dell&#146;area funzionale per cui sono stati progettati e semplificando queste sono: propulsione, armamenti, difese e sistemi supplementari.
</p>
<p align="justify">
Ogni categoria contiene uno o pi&ugrave; componenti che una volta ricercati possono essere utilizzati in un
<a href="'.parse_link('a=database&view=guide&page=6').'"><span class="highlight_link">progetto navale</span></a>. A loro volta, ogni componente
si distingue dagli altri per il costo di realizzazione (sia in termini di risorse, che di equipaggio extra che di tempo di costruzione per la nave),
per l&#146;effetto ottenuto (quale ad esempio un aumento delle armi leggere) e l&#146;eventuale quantitativo di energia consumato e per la possibilit&agrave;
di poter essere o meno installato su determinate classi di navi.
</p>
<p align="justify">
Ecco quindi i parametri di una nave stellare (che verranno approfonditi pi&ugrave; avanti) su cui vanno ad agire i vari componenti:
<ul>
<li>Armi Leggere</li>
<li>Armi Pesanti</li>
<li>Armi Planetarie</li>
<li>Potenza Scudi</li>
<li>Punti Scafo (HP)</li>
<li>Reazione</li>
<li>Prontezza</li>
<li>Agilit&agrave;</li>
<li>Esperienza</li>
<li>Curvatura (Warp)</li>
<li>Sensori</li>
<li>Occultamento</li>
<li>Consumo di Energia</li>
</ul>
</p>
<p align="justify">
<b>Come si sviluppano i componenti navi?</b><br>
Seguendo il men&ugrave;
"<a href="'.parse_link('a=researchlabs').'"><span class="highlight_link">'.$BUILDING_NAME[$game->player['user_race']][8].'</span></a>" viene
presentato un pannello che elenca tutte le ricerche relative ai componenti installabili sulle varie classi di astronavi.
Se la struttura di ricerca non &egrave; occupata e sul pianeta sono presenti risorse a sufficienza, accanto al nome, al costo
in risorse nonch&eacute; al tempo necessario per lo sviluppo, &egrave; possibile trovare un <span style="color: green">link verde</span> che
permette di avviare la ricerca selezionata.<br>
Non &egrave; possibile avere pi&ugrave; di una ricerca in coda.
</p>

';
?>
