<?PHP

$game->init_player();

$game->out('
	<span class="caption">'.constant($game->sprache("TEXT0")).'</span>
	<br><br>
	<table border=0 cellpadding=2 cellspacing=2 width="600" class="style_outer" align="center">
	<tr>
		<td>
		<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="5">
		<tr>
			<td>
			<span class="sub_caption">'.constant($game->sprache("TEXT100")).'</span>
			</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/faq.htm\',\'STFC\',\'toolbar=no,width=750,height=600,resizable=no,scrollbars=yes\'));"><span class="sub_caption2">'.constant($game->sprache("TEXT101")).'</span></a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/building_1.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT102")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/research_catresearch.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT103")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/research_localresearch.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT104")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/shipyard_1.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT105")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/shipyard_2.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT106")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/shipyard_3.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT107")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/academy_1.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT108")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/academy_2.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT109")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_viewstatus.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT110")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_buy_truppen.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT111")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_sold_truppen.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT112")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_ress.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT113")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_createauction.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT114")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_viewauction.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT115")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_viewownauction.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT116")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/konto.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT117")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/trade_debts.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT118")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/ship_avis.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT119")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/planetlist.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT120")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="JavaScript:void(window.open(\'help/ships.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("TEXT121")).'</a>
		</td>
		</tr>
		</table>
		</td>
		<td valign="top">
		<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="5">
		<tr>
			<td>
			<span class="sub_caption">'.constant($game->sprache("TEXT200")).'</span>
			</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide').'"><span class="sub_caption2">'.constant($game->sprache("TEXT201")).'</span></a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=1').'">'.constant($game->sprache("TEXT202")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=2').'">'.constant($game->sprache("TEXT203")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=3').'">'.constant($game->sprache("TEXT204")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=4').'">'.constant($game->sprache("TEXT205")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=5').'">'.constant($game->sprache("TEXT206")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=6').'">'.constant($game->sprache("TEXT207")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=7').'">'.constant($game->sprache("TEXT208")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=8').'">'.constant($game->sprache("TEXT209")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=9').'">'.constant($game->sprache("TEXT210")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=10').'">'.constant($game->sprache("TEXT211")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=11').'">'.constant($game->sprache("TEXT212")).'</a>
		</td>
		</tr>
		<tr>
		<td>
			<a href="'.parse_link('a=database&view=guide&page=12').'">'.constant($game->sprache("TEXT213")).'</a>
		</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
		<a href="'.parse_link('a=messages&a2=newpost&receiver=STFC-Support&subject='.constant($game->sprache("TEXT1"))).'"><span style="color: #FFFF00; font-weight: bold; font-size: 11pt;"><u>'.constant($game->sprache("TEXT2")).'</u></a></span>
		</td>
	</tr>
	<tr>
	<td colspan="2">
	<br><br>'.constant($game->sprache("TEXT3")).'
	</td>
	</tr>
	</table>
	');

?>
