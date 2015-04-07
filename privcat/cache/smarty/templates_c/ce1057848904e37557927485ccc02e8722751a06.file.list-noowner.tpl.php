<?php /* Smarty version Smarty-3.1.12, created on 2014-12-04 23:32:29
         compiled from "/privcat/application/templates/text/list-noowner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21277726165480e0fd8cd335-67063827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce1057848904e37557927485ccc02e8722751a06' => 
    array (
      0 => '/privcat/application/templates/text/list-noowner.tpl',
      1 => 1410872423,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21277726165480e0fd8cd335-67063827',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'texts' => 0,
    'text' => 0,
    'client' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5480e0fe05b934_61902956',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5480e0fe05b934_61902956')) {function content_5480e0fe05b934_61902956($_smarty_tpl) {?>
<h1>Teksty bez właścicieli</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Treść</th>
		<th>Opcje</th>
	</tr>
	
	<?php  $_smarty_tpl->tpl_vars['text'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['text']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['texts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['text']->key => $_smarty_tpl->tpl_vars['text']->value){
$_smarty_tpl->tpl_vars['text']->_loop = true;
?>
		<tr>			
			<td><?php echo $_smarty_tpl->tpl_vars['text']->value->getID();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['text']->value->content;?>
</td>
			<td><a href="/privcat/text/edit/<?php echo $_smarty_tpl->tpl_vars['client']->value->getID();?>
/<?php echo $_smarty_tpl->tpl_vars['text']->value->id;?>
">Edycja</a></td>
		</tr>
	<?php } ?>

</table>
<?php }} ?>