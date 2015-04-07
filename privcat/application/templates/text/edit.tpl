
<h1>Tekst</h1>

<form action="/privcat/text/save/" method="POST">
	
	<input type="hidden" name="text[id]" value="{$text->getID()}">
	<input type="hidden" name="text[client]" value="{$smarty.session.privcat.client->getID()}">

	<label>Treść</label>
	<textarea name="text[content]" value="{$text->name}">{$text->content}</textarea>
	
	<input type="submit" value="Zapisz">
	<a href="/privcat/text/list/{$smarty.session.privcat.client->getID()}">Anuluj</a>

</form>
