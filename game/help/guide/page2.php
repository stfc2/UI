<?PHP

$guide_html = '<span class="caption">I PIANETI</span>
<p align="justify">
In STFC i pianeti rappresentano il fulcro del gioco in senso stretto. Essi, infatti, producono risorse
(<img src="'.$game->GFX_PATH.'menu_metal_small.gif"> metalli, <img src="'.$game->GFX_PATH.'menu_mineral_small.gif"> minerali e
<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> dilitio) con le quali si realizzano diverse strutture (cantieri navali, accademie, centri di
ricerca, centri commerciali etc) e ricerche tecnologiche.<br>
I pianeti vengono catalogati secondo uno schema consultabile alla voce <a href="'.parse_link('a=database').'">&quot;<u>Generale</u>&quot;</a> del
Database a disposizione di ogni giocatore.</p>
<p>
In linea di principio, esistono due categorie di pianeti:
<ul>
<li>pianeti &quot;<u>miniera</u>&quot;: di questa categoria fanno parte i pianeti di classe
<img src="'.FIXED_GFX_PATH.'planet_type_a.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=A#A').'">A</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_b.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=B#B').'">B</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_g.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=G#G').'">G</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_i.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=I#I').'">I</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_j.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=J#J').'">J</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_l.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=L#L').'">L</a> e
<img src="'.FIXED_GFX_PATH.'planet_type_y.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=Y#Y').'">Y</a>;</li><br>
<li>pianeti &quot;<u>lavoratori</u>&quot;: di questa categoria fanno parte i pianeti simili alla Terra, ossia principalmente le classi
<img src="'.FIXED_GFX_PATH.'planet_type_m.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=M#M').'">M</a> ed
<img src="'.FIXED_GFX_PATH.'planet_type_n.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=N#N').'">N</a> seguiti
dalle classi <img src="'.FIXED_GFX_PATH.'planet_type_e.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=E#E').'">E</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_f.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=F#F').'">F</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_k.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=K#K').'">K</a>,
<img src="'.FIXED_GFX_PATH.'planet_type_h.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=H#H').'">H</a> e
in minor misura dalle classi
<img src="'.FIXED_GFX_PATH.'planet_type_c.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=C#C').'">C</a> e
<img src="'.FIXED_GFX_PATH.'planet_type_d.png" width="20" height="20" border="0"> <a href="'.parse_link('a=database&planet_type=D#D').'">D</a>;
questi pianeti hanno miniere che fruttano una quantit&agrave; media di risorse ma permettono di ottenere un gran numero di
<img src ="'.$game->GFX_PATH.'menu_worker_small.gif"> lavoratori, specialmente
se &quot;terraformati&quot; (si discuter&agrave; pi&ugrave; avanti di cosa sia il &quot;terraforming&quot;;</li>
</ul>
</p>
<p align="justify">
I pianeti &quot;lavoratori&quot; costituiscono un buon compromesso tra le risorse ottenute ed il tempo impiegato per ottenerle (anche se le classi
C e D sono piuttosto lenti nel progredire, ossia nel costruire strutture e ricercare sviluppi tecnologici), tuttavia da soli non sono in grado di
produrre le ingenti quantit&agrave; di risorse necessarie a sviluppare le tecnologie migliori o le navi pi&ugrave; potenti in breve tempo.<br>
Per questo &egrave; bene ricorrere ai pianeti &quot;miniera&quot;, molto lenti nello sviluppare tecnologie e strutture ma fenomenali nel produrre
un determinato tipo di risorsa (ad eccezione della classe Y che fornisce una grande quantit&agrave; di tutte le risorse, anche se &egrave;
la pi&ugrave; lenta a svilupparsi).</p>
<p align="justify">
I pianeti &quot;miniera&quot; solitamente producono pochissimi lavoratori, il che rende necessario nelle prime
fasi di sviluppo l&#146;apporto di lavoratori da altri pianeti.</p>';

?>