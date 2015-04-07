<?php /* Smarty version Smarty-3.1.12, created on 2014-11-12 20:56:42
         compiled from "/privcat/application/templates/clients/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2014554105541834a01642f1-04360957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0be454f168b880f18f689b73f203c707028781f0' => 
    array (
      0 => '/privcat/application/templates/clients/list.tpl',
      1 => 1415821879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2014554105541834a01642f1-04360957',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541834a0255642_56578998',
  'variables' => 
  array (
    'sort' => 0,
    'clients' => 0,
    'client' => 0,
    'numOfAvailableTexts' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541834a0255642_56578998')) {function content_541834a0255642_56578998($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/privcat/lib/smarty/plugins/function.counter.php';
?>
<h1>Klienci</h1>

<script type="text/javascript">
	$(document).ready(function() {
		$('input[type=radio]').click(function() {
			$(this).closest("form").submit();
		});
	});
</script>

<form action="/privcat/clients/list" method="POST">

	<table>
		<tr>
		    <th>#</th>
			<th>ID</th>
			<th>Adres</th>
			<th>Liczba wpisów / opublikowanych</th>
			<th>Liczba tekstów / wolnych</th>
		</tr>

		<tr>
		    <td></td>
			<td></td>
			<td></td>
			<td><input <?php if ($_smarty_tpl->tpl_vars['sort']->value=='entries'){?>checked<?php }?> type="radio" name="listsort" value="entries">sortuj</td>
			<td><input <?php if ($_smarty_tpl->tpl_vars['sort']->value=='texts'){?>checked<?php }?>   type="radio" name="listsort" value="texts"  >sortuj</td>
		</tr>

		<?php  $_smarty_tpl->tpl_vars['client'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['client']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['clients']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['client']->key => $_smarty_tpl->tpl_vars['client']->value){
$_smarty_tpl->tpl_vars['client']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars["numOfAvailableTexts"] = new Smarty_variable($_smarty_tpl->tpl_vars['client']->value->getNumOfAvailableTexts(), null, 0);?>
		<tr <?php if ($_smarty_tpl->tpl_vars['numOfAvailableTexts']->value>0){?>class="greenrow"<?php }?>>
			<td><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['client']->value->getID();?>
</td>
			<td><a href="/privcat/index/index/<?php echo $_smarty_tpl->tpl_vars['client']->value->getID();?>
"><?php echo $_smarty_tpl->tpl_vars['client']->value->adres_strony;?>
</a></td>
			<td><?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfEntries();?>
 / <?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfUploadedEntries();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfTexts();?>
 / <?php echo $_smarty_tpl->tpl_vars['numOfAvailableTexts']->value;?>
</td>
		</tr>
		<?php } ?>

	</table>

</form>
<?php }} ?>