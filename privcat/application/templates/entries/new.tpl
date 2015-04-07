
<h1>Nowe wpisy</h1>

<form action="/privcat/entries/save/{$smarty.session.privcat.client->getID()}" method="POST">

	<h2>Dostępne teksty: {$client->getNumOfAvailableTexts()}/{$client->getNumOfTexts()}</h2>
	{if $notEnoughTexts}<h2 style="color: red;">Niewystarczająca liczba tekstów, zmniejsz ilość wybranych.</h2>{/if}
	
	<label>Kategoria</label><br>
	<select name="entry[privcatcategory]">	
	{foreach from=$categories item=category}
		<option value="{$category->getId()}" {if $category->getId() == $preselectedCtegoryId}selected="selected"{/if}>{$category->name}<br>
	{/foreach}
	</select><br><br>
	
	<label>Frazy</label><br>
	{foreach from=$phrases item=phrase}
		<input name="phrases[{$phrase->getID()}][count]" type="number" value="{$preselectionData[$phrase->getID()]['count']}">
		<input name="phrases[{$phrase->getID()}][selected]" type="checkbox" value="selected" {if $preselectionData[$phrase->getID()]['selected']}checked="checked"{/if}>{$phrase->nazwa}<br>
	{/foreach}
	
	<input name="entry[save]" value="Zapisz" type="submit">

</form>

