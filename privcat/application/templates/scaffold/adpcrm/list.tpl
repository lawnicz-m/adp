<nav>
	<a href="/admin/{$modelName}/show/">Nowy {$modelName|capitalize}</a>
</nav>
<table class="scaffold_list_table">
	<thead>
		<tr>
			{foreach from=$columns key=column item=type}
				<th>{$column|capitalize}</th>
			{/foreach}
			<th>Opcje</th>
		</tr>
	</thead>
	
	<tbody>
		{foreach from=$records item=record}
			<tr>			
			{foreach from=$columns key=column item=type}
				
				{if $record->$column != null}			
					{if $type == 'normal'}
						<td>{$record->$column}</td>
					{elseif $type == 'password_md5'}
						<td>{$record->$column}</td>
					{elseif $type == 'boolean'}
						<td>{if $record->$column == 0} false {else} true {/if}</td>
					{elseif $type == Model::TYPE_RELATION_SIMPLE}
						<td>
								{$record->$column->getName()}
						</td>
					{elseif $type == Model::TYPE_RELATION_SHARED}
						<td>
							<table>
							{foreach from=$record->$column item=related}
								<tr><td>{$related->getName()}</td></tr>
							{/foreach}
							</table>
						</td>
					{elseif $type == Model::TYPE_RELATION_OWN_SINGLE}
						<td>
							{$record->$column->getName() }
						</td>
					{elseif $type == Model::TYPE_RELATION_OWN_MULTIPLE}
						<td>
							<table>
							{foreach from=$record->$column item=related}
								<tr><td>{$related->getName()}</td></tr>
							{/foreach}
							</table>
						</td>
					{elseif $type == Model::TYPE_COMPUTED}
						<td>{$model->$column($record)}</td>
					{else}
						<td>{$record->$column}</td>
					{/if}				
				{else}
					<td>null</td>
				{/if}
			{/foreach}
			
			<td>
				<a href="/admin/{$modelName}/show/{$record->getID()}">Pokaz/Edytuj</a>
				<a href="/admin/{$modelName}/delete/{$record->getID()}">Usuń</a>
			</td>
			
			</tr>
		{/foreach}	
	</tbody>
</table>
