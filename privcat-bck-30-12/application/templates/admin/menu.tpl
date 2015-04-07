<nav class="menu">
	<ul>
		{foreach from=$models item=model}
			<li><a href="/admin/{$model|lower}">{$model|capitalize}</a></li>
		{/foreach}
	</ul>
	<div class="clear"></div>
</nav>