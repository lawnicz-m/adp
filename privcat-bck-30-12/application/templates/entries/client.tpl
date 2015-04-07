
<h1>Wpisy</h1>

<nav>
	<a href="/privcat/entries/new/{$smarty.session.privcat.client->getID()}">Nowe</a>
	<div style="clear: both;"></div>
</nav>

<table>
	<tr>
		<th>ID</th>
		<th>Kategoria</th>
		<th>Fraza</th>
		<th>Privcat</th>
		<th>Tekst</th>
		<th>Publikowany</th>	
		<th>Opublikowany</th>
		<th>Opcje</th>
	</tr>
	
	{foreach from=$entries item=entry}
		<tr>			
			<td>{$entry->getID()}</td>
			<td>{$entry->privcatcategory->name}</td>
			<td>{$entry->getPhrase()->nazwa}</td>
			<td>{$entry->privcat->address}</td>
			<td>{$entry->text->content|substr:0:32} (...)</td>
			<td>{if $entry->uploaded}TAK{else}NIE{/if}</td>
			<td>{if $entry->uploaded}{$entry->uploadedon}{/if}</td>
			<td>
				{if $entry->uploaded}
					<a href="/privcat/entries/unpublish/{$entry->getID()}">Wycofaj</a>
				{else}
					<a href="/privcat/entries/publish/{$entry->getID()}">Publikuj</a>
				{/if}
					<a href="/privcat/entries/remove/{$entry->getID()}">Usuń</a>
			</td>
		</tr>
	{/foreach}

</table>
