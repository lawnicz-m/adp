<?php /* Smarty version Smarty-3.1.12, created on 2014-11-21 16:39:23
         compiled from "/privcat/application/templates/layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3295353605418349caed510-63539523%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fad7b4db4d4ab3853dcd3877b5a106d783d8df2b' => 
    array (
      0 => '/privcat/application/templates/layout.tpl',
      1 => 1416584342,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3295353605418349caed510-63539523',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5418349cb43030_86281533',
  'variables' => 
  array (
    'pageTitle' => 0,
    'autoloadedCSS' => 0,
    'filePath' => 0,
    'APP_BASE_URL' => 0,
    'menu' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5418349cb43030_86281533')) {function content_5418349cb43030_86281533($_smarty_tpl) {?><html>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<?php  $_smarty_tpl->tpl_vars['filePath'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['filePath']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['autoloadedCSS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['filePath']->key => $_smarty_tpl->tpl_vars['filePath']->value){
$_smarty_tpl->tpl_vars['filePath']->_loop = true;
?>		
		<link rel="stylesheet" type="text/css" href="/privcat/<?php echo $_smarty_tpl->tpl_vars['filePath']->value;?>
">
	<?php } ?>  
	
	<script type="text/javascript" src="/privcat/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="/privcat/js/ajaxSetup.js"></script>
	
</head>

<body>

<div id="header">
	<a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/klienci/profil/<?php echo $_SESSION['privcat']['client']->getId();?>
">Powrót do crm</a>
	<a href="/privcat/privcat/list">Privkaty</a>
	<a href="/privcat/clients/list">Klienci</a>
	<div style="clear: both;"></div>
	<?php ob_start();?><?php echo $_SESSION['privcat']['hideclient'];?>
<?php $_tmp1=ob_get_clean();?><?php if (!$_tmp1){?>
		<h1>Wybrany klient: <?php echo $_SESSION['privcat']['client']->adres_strony;?>
</h1>
	<?php }?>
</div>

<?php echo $_smarty_tpl->tpl_vars['menu']->value;?>


<div id="content">
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

</div>


</body>
</html>
<?php }} ?>