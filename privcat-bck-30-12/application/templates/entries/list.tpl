
{include file='entries/selectprivcat.tpl'}

<h1>Wpisy na {$privcat->name}</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Klient</th>
		<th>Tekst</th>	
		<th>Fraza</th>	
		<th>Publikowany</th>	
		<th>Opublikowany</th>
		<th>Opcje</th>
	</tr>
	
	{foreach from=$entries item=entry}
		<tr>			
			<td>{$entry->getID()}</td>
			<td></td>
			<td>{$entry->text->content}</td>
			<td>{$entry->getPhrase()->nazwa}</td>
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
