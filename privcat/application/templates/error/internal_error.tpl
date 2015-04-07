<h1>Internal Error</h1>
{if $exception}
	<h3>Exception: </h3>
	<pre>{$exception->getMessage()}</pre>
	<h3>Stack Trace: </h3>
	<table border style="border-collapse: collapse;">
		<tr><th>No.</th><th>File</th><th>Line</th><th>Function</th><th>Class</th><th>Args</th></tr>
		{foreach from=$exception->getTrace() item=trace}
			<tr>
				<td>{$trace@iteration}</td>
				<td>{$trace.file}</td>
				<td>{$trace.line}</td>
				<td>{$trace.function}</td>
				<td>{$trace.class}</td>
				<td>					
					<table border style="border-collapse: collapse;">
					{foreach from=$trace.args item=arg}
						<tr><td>{$arg}</td></tr>
					{/foreach}
					</table>
				</td>
			</tr>
		{/foreach}
	</table>
{/if}

{foreach from=$errorMessages item=m}
	<div class="errorMessage"><p>{$m}</p></div>
{/foreach}