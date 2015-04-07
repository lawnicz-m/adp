<?php /* Smarty version Smarty-3.1.12, created on 2014-09-18 14:16:16
         compiled from "/privcat/application/templates/privcat/history.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1917551857541acd107bdd43-46170063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96023df72d2fcc0b7a02fe4bd514f280bd7b7e4a' => 
    array (
      0 => '/privcat/application/templates/privcat/history.tpl',
      1 => 1410872423,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1917551857541acd107bdd43-46170063',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'privcat' => 0,
    'histories' => 0,
    'history' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541acd10be5e04_45363171',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541acd10be5e04_45363171')) {function content_541acd10be5e04_45363171($_smarty_tpl) {?>
<h1>Historia dla <?php echo $_smarty_tpl->tpl_vars['privcat']->value->name;?>
</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Kategoria</th>
		<th>Data od/do</th>
		<th>Klient</th>
		<th>Fraza</th>
		<th>Link</th>
	</tr>
	
	<?php  $_smarty_tpl->tpl_vars['history'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['history']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['histories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['history']->key => $_smarty_tpl->tpl_vars['history']->value){
$_smarty_tpl->tpl_vars['history']->_loop = true;
?>
		<tr>			
			<td><?php echo $_smarty_tpl->tpl_vars['history']->value->id;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['history']->value->privcatentry->privcatcategory->name;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['history']->value->datefrom;?>
 / <?php echo $_smarty_tpl->tpl_vars['history']->value->dateto;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['history']->value->client->adres_strony;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['history']->value->phrase->nazwa;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['history']->value->link;?>
</td>
		</tr>
	<?php } ?>

</table>
<?php }} ?>