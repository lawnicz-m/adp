
<h1>Teksty</h1>

<nav>
	<a href="/privcat/text/edit/{$smarty.session.privcat.client->getID()}/">Nowy</a>
	<div style="clear: both;"></div>
</nav>

<table>
	<tr>
		<th>ID</th>
		<th>Treść</th>
		<th>Opcje</th>
	</tr>
	
	{foreach from=$texts item=text}
		<tr>			
			<td>{$text->getID()}</td>
			<td>{$text->content|substr:0:64} (...) </td>
			<td>
				<a href="/privcat/text/edit/{$smarty.session.privcat.client->getID()}/{$text->id}">Edycja</a>
				{if $text->canBeDeleted()}
					<a href="/privcat/text/remove/{$smarty.session.privcat.client->getID()}/{$text->id}">Usuń</a>
				{else}		
					<a href="/privcat/text/remove/{$smarty.session.privcat.client->getID()}/{$text->id}">Wycofaj i usuń</a>
				{/if}
			</td>
		</tr>
	{/foreach}

</table>
