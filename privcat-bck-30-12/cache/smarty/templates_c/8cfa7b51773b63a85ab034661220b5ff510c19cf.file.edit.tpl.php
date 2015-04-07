<?php /* Smarty version Smarty-3.1.12, created on 2014-09-30 14:41:13
         compiled from "/privcat/application/templates/privcat/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:85296780054197f718d91f6-51299308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8cfa7b51773b63a85ab034661220b5ff510c19cf' => 
    array (
      0 => '/privcat/application/templates/privcat/edit.tpl',
      1 => 1412063945,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '85296780054197f718d91f6-51299308',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54197f71a96975_48548504',
  'variables' => 
  array (
    'privcat' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54197f71a96975_48548504')) {function content_54197f71a96975_48548504($_smarty_tpl) {?>
<h1>Privkat</h1>

<form action="/privcat/privcat/save/" method="POST">
	
	<input type="hidden" name="privcat[id]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
">

	<label>Nazwa</label>
	<input type="text" name="privcat[name]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->name;?>
">
	
	<label>Adres</label>
	<input type="text" name="privcat[address]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->address;?>
">
	
	<label>FTP - adres</label>
	<input type="text" name="privcat[ftpaddress]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftpaddress;?>
">
	
	<label>FTP - user</label>
	<input type="text" name="privcat[ftpuser]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftpuser;?>
">
	
	<label>FTP - pass</label>
	<input type="text" name="privcat[ftppass]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftppass;?>
">
	
	<label>FTP - hash</label>
	<input type="text" name="privcat[ftphash]" value="<?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftphash;?>
">
	
	<input type="submit" value="Zapisz">

	<a href="/privcat/privcat/list">Anuluj</a>
</form>
<?php }} ?>