<?php /* Smarty version Smarty-3.1.12, created on 2014-09-16 17:17:42
         compiled from "/privcat/application/templates/entries/ajaxhistory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2076870458541854967e7948-06020670%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '522ec13eb160ea302c520f1d4695d6f99c967a60' => 
    array (
      0 => '/privcat/application/templates/entries/ajaxhistory.tpl',
      1 => 1410872424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2076870458541854967e7948-06020670',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'histories' => 0,
    'history' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541854968db747_25297994',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541854968db747_25297994')) {function content_541854968db747_25297994($_smarty_tpl) {?><table>
	<tr>
		<th>ID</th>
		<th>Privkat</th>
		<th>Kategoria</th>
		<th>Data od</th>
		<th>Fraza</th>
		<th>Link</th>
		<th>Data do</th>
	</tr>


	<?php  $_smarty_tpl->tpl_vars['history'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['history']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['histories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['history']->key => $_smarty_tpl->tpl_vars['history']->value){
$_smarty_tpl->tpl_vars['history']->_loop = true;
?>
	<tr>
		<td><?php echo $_smarty_tpl->tpl_vars['history']->value->id;?>
</td>
		<td><a href="http://<?php echo $_smarty_tpl->tpl_vars['history']->value->privcatentry->privcat->address;?>
"><?php echo $_smarty_tpl->tpl_vars['history']->value->privcatentry->privcat->name;?>
</a></td>
		<td><?php echo $_smarty_tpl->tpl_vars['history']->value->privcatentry->privcatcategory->name;?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['history']->value->datefrom;?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['history']->value->phrase->nazwa;?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['history']->value->link;?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['history']->value->dateto;?>
</td>
	</tr>
	<?php } ?>

</table><?php }} ?>