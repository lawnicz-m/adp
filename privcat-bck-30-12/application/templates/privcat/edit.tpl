
<h1>Privkat</h1>

<form action="/privcat/privcat/save/" method="POST">
	
	<input type="hidden" name="privcat[id]" value="{$privcat->getID()}">

	<label>Nazwa</label>
	<input type="text" name="privcat[name]" value="{$privcat->name}">
	
	<label>Adres</label>
	<input type="text" name="privcat[address]" value="{$privcat->address}">
	
	<label>FTP - adres</label>
	<input type="text" name="privcat[ftpaddress]" value="{$privcat->ftpaddress}">
	
	<label>FTP - user</label>
	<input type="text" name="privcat[ftpuser]" value="{$privcat->ftpuser}">
	
	<label>FTP - pass</label>
	<input type="text" name="privcat[ftppass]" value="{$privcat->ftppass}">
	
	<label>FTP - hash</label>
	<input type="text" name="privcat[ftphash]" value="{$privcat->ftphash}">
	
	<input type="submit" value="Zapisz">

	<a href="/privcat/privcat/list">Anuluj</a>
</form>
