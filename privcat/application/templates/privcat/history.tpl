
<h1>Historia dla {$privcat->name}</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Kategoria</th>
		<th>Data od/do</th>
		<th>Klient</th>
		<th>Fraza</th>
		<th>Link</th>
	</tr>
	
	{foreach from=$histories item=history}
		<tr>			
			<td>{$history->id}</td>
			<td>{$history->privcatentry->privcatcategory->name}</td>
			<td>{$history->datefrom} / {$history->dateto}</td>
			<td>{$history->client->adres_strony}</td>
			<td>{$history->phrase->nazwa}</td>
			<td>{$history->link}</td>
		</tr>
	{/foreach}

</table>
