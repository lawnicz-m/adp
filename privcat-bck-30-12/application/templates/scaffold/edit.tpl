

<form method="post" action="/admin/{$modelName}/save">

	<input type="hidden" name="record[id]" value="{$record->id}">

	<div class="model_form_columns">
	{foreach from=$columns key=column item=type}
		<label>{$column}</label>
			
		{if $type == Model::TYPE_NORMAL}			
			<input name="record[{$column}]" value="{$record->$column}">
		{elseif $type == Model::TYPE_PASSWORD_MD5}
			<input name="record[{$column}]" value="" type="password">
		{elseif $type == Model::TYPE_BOOLEAN}
			<select name="record[{$column}]">
				<option {if $record->$column}selected="selected"{/if} value="true">true</option>
				<option {if !$record->$column}selected="selected"{/if}value="false">false</option>
			</select>
		{elseif $type == Model::TYPE_RELATION_SIMPLE}
			{html_options name="record[$column]" options=$model->relationOptions($column) selected=$record->relationSelected($column)}
		{elseif $type == Model::TYPE_RELATION_SHARED}
			<select name="record[{$column}][]" multiple="multiple">
				{html_options options=$model->relationOptions($column) selected=$record->relationSelected($column)}
			</select>			
		{elseif $type == Model::TYPE_RELATION_OWN_SINGLE}
			{html_options name="record[$column]" options=$model->relationOptions($column) selected=$record->relationSelected($column)}			
		{elseif $type == Model::TYPE_RELATION_OWN_MULTIPLE}			
			<select name="record[{$column}][]" multiple="multiple">
				{html_options options=$model->relationOptions($column) selected=$record->relationSelected($column)}
			</select>			
		{elseif $type == Model::TYPE_COMPUTED}
		{else}			
			<input name="record[{$column}]" value="{$record->$column}">
		{/if}
		
		{if isset($validation[$column])}
			<span class="validation_error">{$validation[$column]}</span>
		{/if}
	{/foreach}
	</div>
		
	<div class="model_form_buttons">
		<input type="submit" value="Zapisz">
		<input type="submit" value="Anuluj" name="cancelSave">
	</div>
	
</form>
