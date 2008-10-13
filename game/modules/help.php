<?PHP

$game->init_player();

$game->out('
	<span class="caption">Aiuto</span>
	<br><br>
	<table border=0 cellpadding=2 cellspacing=2 width="600" class="style_outer" align="center">
	<tr>
		<td>
		<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="5">
		<tr>
			<td>
			<span class="sub_caption">File di aiuto disponibili:</span>
			</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/faq.htm\',\'STFC\',\'toolbar=no,width=750,height=600,resizable=no,scrollbars=yes\'));"><span class="sub_caption2">FAQ</span></a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/building_1.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Costruzioni</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/research_catresearch.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Centro Ricerche : Divisione componenti navi</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/research_localresearch.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Centro Ricerche : Divisione ricerche planetarie</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/shipyard_1.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Cantiere Navale</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/shipyard_2.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Cantiere Navale : Equipaggio navi</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/shipyard_3.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Cantiere Navale : Stato costruzione</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/academy_1.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Accademia : Stato accademia</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/academy_2.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Accademia : Lista addestramento</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/planetlist.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Pianeti</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/ships.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">Navi</a>
		</td>
		</tr>
		</table>
		</td>
		<td valign="top">
		<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="5">
		<tr>
			<td>
			<span class="sub_caption">Guida in game:</span>
			</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide').'"><span class="sub_caption2">INDICE</span></a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=1').'">Il gioco</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=2').'">I pianeti</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=3').'">Le strutture</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=4').'">Le ricerche planetarie</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=5').'">TBD</a>
		</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
		<a href="'.parse_link('a=messages&a2=newpost&receiver=STFC-Support&subject=Richiesta%20di%20aiuto').'"><span style="color: #FFFF00; font-weight: bold; font-size: 11pt;"><u>Se ti senti perduto, segui questo link per scrivere al Supporto!</u></a></span>
		</td>
	</tr>
	</table>
	');

?>
