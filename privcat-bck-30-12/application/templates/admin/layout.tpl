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
	<img alt="Micromeg" src="/images/logo_micromeg_mlg.gif">
	<div id="user_bar">
		Zalogowany <span class="username">{$smarty.session.user->getName()}</span><a href="/login/logout">wyloguj</a>
	</div>
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