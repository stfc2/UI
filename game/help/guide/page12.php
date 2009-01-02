<?PHP

$guide_html = '<span class="caption">LE FLOTTE</span><br>
<span class="sub_caption2">Parte quinta: i comandi dall&#146;orbita</span>
<p align="justify">
Alcuni dei comandi elencati <a href="'.parse_link('a=database&view=guide&page=11').'"><span class="highlight_link">precedentemente</span></a>, possono essere assegnati anche quando la flotta ha raggiunto l&#146;orbita di un pianeta.<br>
Tali istruzioni sono impartibili esclusivamente dalla sezione "<a href="'.parse_link('a=tactical_cartography').'"><span class="highlight_link">Cartografia stellare</span></a>" del men&ugrave; Tattico dopo aver selezionato 
il pianeta interessato.<br>
Infatti se in orbita attorno ad esso ci sono delle flotte del giocatore, oltre alle abituali indicazioni
sar&agrave; visualizzato un ulteriore riquadro contente le seguenti informazioni:
<ul>
<li>icona del pianeta;</li>
<li>icone di eventuali altre navi presenti (un&#146;icona per giocatore);</li>
<li>icona delle proprie navi (un&#146;icona per tutte le flotte);</li>
<li>elenco delle proprie flotte.</li>
</ul>
Accanto alle immagini del pianeta e delle navi, potranno comparire una o pi&ugrave; icone a seconda delle condizioni, vediamole:
</p>
<p align="justify">
<input type="image" src="'.$game->GFX_PATH.'tc_colo.gif" title="Colonizzazione">&nbsp;&nbsp;<b>Colonizzazione</b><br>
Questo comando agisce in maniera analoga al suo corrispettivo dato da uno dei due men&ugrave; descritti precedentemente.<br>
Applicabilit&agrave;: <u>pianeti disabitati</u>.
</p>
<p align="justify">
<input type="image" src="'.$game->GFX_PATH.'tc_transport.gif" title="Trasporto">&nbsp;&nbsp;<b>Trasporto</b><br>
Con questo comando &egrave; possibile teletrasportare il quantitativo desiderato di risorse e unit&agrave; presenti da una propria flotta al pianeta (se del giocatore) <s>o ad un&#146;altra flotta in orbita</s>.<br>
Applicabilit&agrave;: <u><s>navi cargo</s></u> o <u>pianeti colonizzati</u>.
</p>
<p align="justify">
<input type="image" src="'.$game->GFX_PATH.'tc_attack.gif" title="Attacca">&nbsp;&nbsp;<b>Attacco</b><br>
A seconda che sia visualizzata accanto ad una flotta od al pianeta, le opzioni disponibili cambieranno.
Nel primo caso, sar&agrave; possibile attaccare le navi del giocatore selezionato; nel secondo, le navi 
effettueranno un attacco alle difese planetarie quindi sar&agrave; possibile scegliere se:
<ul>
<li>bombardare la superficie (solo con navi dotate di armi planetarie);</li>
<li>tentare la conquista (solo se presente una nave colonizzatrice);</li>
<li>rimanere semplicemente in orbita.</li>
</ul>
Applicabilit&agrave;: <u>tutte le navi eccetto le proprie e quelle del proprietario del pianeta</u> o <u>pianeti colonizzati</u>.
</p>
<p align="justify">
<b>Come si impartiscono i comandi dall&#146;orbita?</b><br>
Dal riquadro che elenca le proprie flotte, scegliere quelle cui si desidera impartire gli ordini, quindi selezionare l&#146;icona appropriata accanto all&#146;oggetto (pianeta/navi) interessato.
</p>
';
?>
