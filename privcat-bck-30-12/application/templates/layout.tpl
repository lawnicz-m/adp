<html>
<head>
	<title>{$pageTitle}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	{foreach from=$autoloadedCSS item=filePath}		
		<link rel="stylesheet" type="text/css" href="/privcat/{$filePath}">
	{/foreach}  
	
	<script type="text/javascript" src="/privcat/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="/privcat/js/ajaxSetup.js"></script>
	
</head>

<body>

<div id="header">
	<a href="{$APP_BASE_URL}/klienci/profil/{$smarty.session.privcat.client->getId()}">Powrót do crm</a>
	<a href="/privcat/privcat/list">Privkaty</a>
	<a href="/privcat/clients/list">Klienci</a>
	<div style="clear: both;"></div>
	{if !{$smarty.session.privcat.hideclient} }
		<h1>Wybrany klient: {$smarty.session.privcat.client->adres_strony}</h1>
	{/if}
</div>

{$menu}

<div id="content">
	{$content}
</div>


</body>
</html>
