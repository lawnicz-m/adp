<?php /* Smarty version Smarty-3.1.12, created on 2014-10-20 21:07:03
         compiled from "/privcat/application/templates/error/internal_error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:129546577354455d579633b8-42375773%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'daa9d36796a35aaf8e5aaaaa32a4be782fa248d0' => 
    array (
      0 => '/privcat/application/templates/error/internal_error.tpl',
      1 => 1410872425,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '129546577354455d579633b8-42375773',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'exception' => 0,
    'trace' => 0,
    'arg' => 0,
    'errorMessages' => 0,
    'm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54455d57d0edb1_94582133',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54455d57d0edb1_94582133')) {function content_54455d57d0edb1_94582133($_smarty_tpl) {?><h1>Internal Error</h1>
<?php if ($_smarty_tpl->tpl_vars['exception']->value){?>
	<h3>Exception: </h3>
	<pre><?php echo $_smarty_tpl->tpl_vars['exception']->value->getMessage();?>
</pre>
	<h3>Stack Trace: </h3>
	<table border style="border-collapse: collapse;">
		<tr><th>No.</th><th>File</th><th>Line</th><th>Function</th><th>Class</th><th>Args</th></tr>
		<?php  $_smarty_tpl->tpl_vars['trace'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['trace']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['exception']->value->getTrace(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['trace']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['trace']->key => $_smarty_tpl->tpl_vars['trace']->value){
$_smarty_tpl->tpl_vars['trace']->_loop = true;
 $_smarty_tpl->tpl_vars['trace']->iteration++;
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['trace']->iteration;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['trace']->value['file'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['trace']->value['line'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['trace']->value['function'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['trace']->value['class'];?>
</td>
				<td>					
					<table border style="border-collapse: collapse;">
					<?php  $_smarty_tpl->tpl_vars['arg'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['arg']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['trace']->value['args']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['arg']->key => $_smarty_tpl->tpl_vars['arg']->value){
$_smarty_tpl->tpl_vars['arg']->_loop = true;
?>
						<tr><td><?php echo $_smarty_tpl->tpl_vars['arg']->value;?>
</td></tr>
					<?php } ?>
					</table>
				</td>
			</tr>
		<?php } ?>
	</table>
<?php }?>

<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errorMessages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
	<div class="errorMessage"><p><?php echo $_smarty_tpl->tpl_vars['m']->value;?>
</p></div>
<?php } ?><?php }} ?>