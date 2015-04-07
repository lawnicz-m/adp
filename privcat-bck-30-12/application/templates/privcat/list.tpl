
<h1>Privkaty</h1>

<nav>
	<a href="/privcat/privcat/edit">Nowy</a>
	<div style="clear: both;"></div>
</nav>

<table>
	<tr>
		<th>ID</th>
		<th>Nazwa</th>
		<th>Adres</th>
		<th>FTP - adres</th>
		<th>FTP - user</th>
		<th>FTP - pass</th>
		<th>Liczba wpisów opublikowanych / wszystkich</th>
		<th>Opcje</th>
	</tr>
	
	{foreach from=$privcats item=privcat}
		<tr>			
			<td>{$privcat->getID()}</td>
			<td>{$privcat->name}</td>
			<td>{$privcat->address}</td>
			<td>{$privcat->ftpaddress}</td>
			<td>{$privcat->ftpuser}</td>
			<td>{$privcat->ftppass}</td>
			<td>{$privcat->getNumberOfPublishedEntries()}/{$privcat->getNumberOfEntries()}</td>
			<td>
				<a href="/privcat/privcat/history/{$privcat->getID()}">Historia</a>
				<a href="/privcat/privcat/edit/{$privcat->getID()}">Edycja</a>
				<a class="ajaxUpgradeable" ajax-target="ftptestresult{$privcat->getID()}" href="/privcat/privcat/testftp/{$privcat->getID()}">Test połączenia</a>
				<div id="ftptestresult{$privcat->getID()}"></div>
			</td>
		</tr>
	{/foreach}

</table>
