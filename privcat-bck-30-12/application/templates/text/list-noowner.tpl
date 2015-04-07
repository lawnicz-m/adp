
<h1>Teksty bez właścicieli</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Treść</th>
		<th>Opcje</th>
	</tr>
	
	{foreach from=$texts item=text}
		<tr>			
			<td>{$text->getID()}</td>
			<td>{$text->content}</td>
			<td><a href="/privcat/text/edit/{$client->getID()}/{$text->id}">Edycja</a></td>
		</tr>
	{/foreach}

</table>
