
<h1>Klienci</h1>

<script type="text/javascript">
	$(document).ready(function() {
		$('input[type=radio]').click(function() {
			$(this).closest("form").submit();
		});
	});
</script>

<form action="/privcat/clients/list" method="POST">

	<table>
		<tr>
		    <th>#</th>
			<th>ID</th>
			<th>Adres</th>
			<th>Liczba wpisów / opublikowanych</th>
			<th>Liczba tekstów / wolnych</th>
		</tr>

		<tr>
		    <td></td>
			<td></td>
			<td></td>
			<td><input {if $sort=='entries'}checked{/if} type="radio" name="listsort" value="entries">sortuj</td>
			<td><input {if $sort=='texts'}checked{/if}   type="radio" name="listsort" value="texts"  >sortuj</td>
		</tr>

		{foreach from=$clients item=client}
			{assign var="numOfAvailableTexts" value=$client->getNumOfAvailableTexts() }
		<tr {if $numOfAvailableTexts > 0}class="greenrow"{/if}>
			<td>{counter}</td>
			<td>{$client->getID()}</td>
			<td><a href="/privcat/index/index/{$client->getID()}">{$client->adres_strony}</a></td>
			<td>{$client->getNumOfEntries()} / {$client->getNumOfUploadedEntries()}</td>
			<td>{$client->getNumOfTexts()} / {$numOfAvailableTexts}</td>
		</tr>
		{/foreach}

	</table>

</form>
