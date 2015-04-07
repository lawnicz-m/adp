<table>
	<tr>
		<th>ID</th>
		<th>Privkat</th>
		<th>Kategoria</th>
		<th>Data od</th>
		<th>Fraza</th>
		<th>Link</th>
		<th>Data do</th>
	</tr>


	{foreach from=$histories item=history}
	<tr>
		<td>{$history->id}</td>
		<td><a href="http://{$history->privcatentry->privcat->address}">{$history->privcatentry->privcat->name}</a></td>
		<td>{$history->privcatentry->privcatcategory->name}</td>
		<td>{$history->datefrom}</td>
		<td>{$history->phrase->nazwa}</td>
		<td>{$history->link}</td>
		<td>{$history->dateto}</td>
	</tr>
	{/foreach}

</table>