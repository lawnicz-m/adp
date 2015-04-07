<?php /* Smarty version Smarty-3.1.12, created on 2014-09-16 15:02:25
         compiled from "/privcat/application/templates/text/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2144275354541834e116c704-01598179%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d3e776a141888439bae6c1587c12bb85f59dd6a' => 
    array (
      0 => '/privcat/application/templates/text/list.tpl',
      1 => 1410872423,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2144275354541834e116c704-01598179',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'texts' => 0,
    'text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541834e12591d7_38330624',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541834e12591d7_38330624')) {function content_541834e12591d7_38330624($_smarty_tpl) {?>
<h1>Teksty</h1>

<nav>
	<a href="/privcat/text/edit/<?php echo $_SESSION['privcat']['client']->getID();?>
/">Nowy</a>
	<div style="clear: both;"></div>
</nav>

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
			<td><?php echo substr($_smarty_tpl->tpl_vars['text']->value->content,0,64);?>
 (...) </td>
			<td>
				<a href="/privcat/text/edit/<?php echo $_SESSION['privcat']['client']->getID();?>
/<?php echo $_smarty_tpl->tpl_vars['text']->value->id;?>
">Edycja</a>
				<?php if ($_smarty_tpl->tpl_vars['text']->value->canBeDeleted()){?>
					<a href="/privcat/text/remove/<?php echo $_SESSION['privcat']['client']->getID();?>
/<?php echo $_smarty_tpl->tpl_vars['text']->value->id;?>
">Usuń</a>
				<?php }else{ ?>		
					<a href="/privcat/text/remove/<?php echo $_SESSION['privcat']['client']->getID();?>
/<?php echo $_smarty_tpl->tpl_vars['text']->value->id;?>
">Wycofaj i usuń</a>
				<?php }?>
			</td>
		</tr>
	<?php } ?>

</table>
<?php }} ?>