<?php /* Smarty version Smarty-3.1.12, created on 2014-10-15 13:11:51
         compiled from "/home/WWW/adbcrm.spox.org/public_html/privcat/application/templates/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:129311476543e5677bc4466-68357355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39a3f8ac95a6615ec68685013739260254548d65' => 
    array (
      0 => '/home/WWW/adbcrm.spox.org/public_html/privcat/application/templates/menu.tpl',
      1 => 1410872400,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '129311476543e5677bc4466-68357355',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_543e5677c021e7_58240850',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543e5677c021e7_58240850')) {function content_543e5677c021e7_58240850($_smarty_tpl) {?><nav>
	<a href="/privcat/entries/client/<?php echo $_SESSION['privcat']['client']->getID();?>
">Wpisy</a>
	<a href="/privcat/entries/history/<?php echo $_SESSION['privcat']['client']->getID();?>
">Historia</a>
	<a href="/privcat/text/list/<?php echo $_SESSION['privcat']['client']->getID();?>
">Teksty</a>
	<div style="clear: both;"></div>
</nav><?php }} ?>