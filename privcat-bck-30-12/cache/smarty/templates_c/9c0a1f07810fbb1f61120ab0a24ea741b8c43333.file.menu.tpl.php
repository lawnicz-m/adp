<?php /* Smarty version Smarty-3.1.12, created on 2014-09-16 15:01:16
         compiled from "/privcat/application/templates/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21367194565418349c9a6dc6-93241353%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c0a1f07810fbb1f61120ab0a24ea741b8c43333' => 
    array (
      0 => '/privcat/application/templates/menu.tpl',
      1 => 1410872421,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21367194565418349c9a6dc6-93241353',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5418349ca31248_67834388',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5418349ca31248_67834388')) {function content_5418349ca31248_67834388($_smarty_tpl) {?><nav>
	<a href="/privcat/entries/client/<?php echo $_SESSION['privcat']['client']->getID();?>
">Wpisy</a>
	<a href="/privcat/entries/history/<?php echo $_SESSION['privcat']['client']->getID();?>
">Historia</a>
	<a href="/privcat/text/list/<?php echo $_SESSION['privcat']['client']->getID();?>
">Teksty</a>
	<div style="clear: both;"></div>
</nav><?php }} ?>