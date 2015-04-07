
{foreach from=$privcats item=privcat}
	<a class="privcat_select_item" href="/privcat/entries/list/{$privcat->getID()}">{$privcat->name}( {$privcat->address} )</a>
{/foreach}
