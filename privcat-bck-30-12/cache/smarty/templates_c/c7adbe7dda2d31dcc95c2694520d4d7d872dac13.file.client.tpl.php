<?php /* Smarty version Smarty-3.1.12, created on 2014-10-15 13:16:49
         compiled from "/home/WWW/adbcrm.spox.org/public_html/privcat/application/templates/entries/client.tpl" */ ?>
<?php /*%%SmartyHeaderCode:686733894543e57a159c231-56469707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7adbe7dda2d31dcc95c2694520d4d7d872dac13' => 
    array (
      0 => '/home/WWW/adbcrm.spox.org/public_html/privcat/application/templates/entries/client.tpl',
      1 => 1410872400,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '686733894543e57a159c231-56469707',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'entries' => 0,
    'entry' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_543e57a1632c83_83942002',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543e57a1632c83_83942002')) {function content_543e57a1632c83_83942002($_smarty_tpl) {?>
<h1>Wpisy</h1>

<nav>
	<a href="/privcat/entries/new/<?php echo $_SESSION['privcat']['client']->getID();?>
">Nowe</a>
	<div style="clear: both;"></div>
</nav>

<table>
	<tr>
		<th>ID</th>
		<th>Kategoria</th>
		<th>Fraza</th>
		<th>Privcat</th>
		<th>Tekst</th>
		<th>Publikowany</th>	
		<th>Opublikowany</th>
		<th>Opcje</th>
	</tr>
	
	<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['entry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['entries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value){
$_smarty_tpl->tpl_vars['entry']->_loop = true;
?>
		<tr>			
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->getID();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->privcatcategory->name;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->getPhrase()->nazwa;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->privcat->address;?>
</td>
			<td><?php echo substr($_smarty_tpl->tpl_vars['entry']->value->text->content,0,32);?>
 (...)</td>
			<td><?php if ($_smarty_tpl->tpl_vars['entry']->value->uploaded){?>TAK<?php }else{ ?>NIE<?php }?></td>
			<td><?php if ($_smarty_tpl->tpl_vars['entry']->value->uploaded){?><?php echo $_smarty_tpl->tpl_vars['entry']->value->uploadedon;?>
<?php }?></td>
			<td>
				<?php if ($_smarty_tpl->tpl_vars['entry']->value->uploaded){?>
					<a href="/privcat/entries/unpublish/<?php echo $_smarty_tpl->tpl_vars['entry']->value->getID();?>
">Wycofaj</a>
				<?php }else{ ?>
					<a href="/privcat/entries/publish/<?php echo $_smarty_tpl->tpl_vars['entry']->value->getID();?>
">Publikuj</a>
				<?php }?>
					<a href="/privcat/entries/remove/<?php echo $_smarty_tpl->tpl_vars['entry']->value->getID();?>
">Usuń</a>
			</td>
		</tr>
	<?php } ?>

</table>
<?php }} ?>