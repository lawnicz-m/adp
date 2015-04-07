<?php /* Smarty version Smarty-3.1.12, created on 2014-11-12 17:45:47
         compiled from "/home/WWW/adbcrm.spox.org/public_html/privcat/application/templates/privcat/history.tpl" */ ?>
<?php /*%%SmartyHeaderCode:139518630054638ebb2cb6e1-32924655%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40a64f723206f267c8a730908c14452b6aeaf231' => 
    array (
      0 => '/home/WWW/adbcrm.spox.org/public_html/privcat/application/templates/privcat/history.tpl',
      1 => 1410872400,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139518630054638ebb2cb6e1-32924655',
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
  'unifunc' => 'content_54638ebb366024_61993488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54638ebb366024_61993488')) {function content_54638ebb366024_61993488($_smarty_tpl) {?>
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