<html>
<head>
	<title>{$pageTitle}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	{foreach from=$autoloadedCSS item=filePath}		
		<link rel="stylesheet" type="text/css" href="/{$filePath}">
	{/foreach}  
</head>

<body>

<div id="header">
</div>

{$menu}

<div id="content">
	{$content}
</div>

<div>
	{if isset($smarty.session.user)}<a href="/login/logout">Wyloguj</a>{else}<a href="/login">Zaloguj</a>{/if}
</div>

</body>
</html>
