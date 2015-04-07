<?php /* Smarty version Smarty-3.1.12, created on 2014-09-16 17:10:39
         compiled from "/privcat/application/templates/entries/new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:939487164541852ef0e7967-55886962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6178b3a36cd23e2a68cd2538e5f1dc8acd81abe3' => 
    array (
      0 => '/privcat/application/templates/entries/new.tpl',
      1 => 1410872424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '939487164541852ef0e7967-55886962',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'client' => 0,
    'notEnoughTexts' => 0,
    'categories' => 0,
    'category' => 0,
    'preselectedCtegoryId' => 0,
    'phrases' => 0,
    'phrase' => 0,
    'preselectionData' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541852ef1fdc81_58347156',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541852ef1fdc81_58347156')) {function content_541852ef1fdc81_58347156($_smarty_tpl) {?>
<h1>Nowe wpisy</h1>

<form action="/privcat/entries/save/<?php echo $_SESSION['privcat']['client']->getID();?>
" method="POST">

	<h2>Dostępne teksty: <?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfAvailableTexts();?>
/<?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfTexts();?>
</h2>
	<?php if ($_smarty_tpl->tpl_vars['notEnoughTexts']->value){?><h2 style="color: red;">Niewystarczająca liczba tekstów, zmniejsz ilość wybranych.</h2><?php }?>
	
	<label>Kategoria</label><br>
	<select name="entry[privcatcategory]">	
	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->getId();?>
" <?php if ($_smarty_tpl->tpl_vars['category']->value->getId()==$_smarty_tpl->tpl_vars['preselectedCtegoryId']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['category']->value->name;?>
<br>
	<?php } ?>
	</select><br><br>
	
	<label>Frazy</label><br>
	<?php  $_smarty_tpl->tpl_vars['phrase'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['phrase']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['phrases']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['phrase']->key => $_smarty_tpl->tpl_vars['phrase']->value){
$_smarty_tpl->tpl_vars['phrase']->_loop = true;
?>
		<input name="phrases[<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
][count]" type="number" value="<?php echo $_smarty_tpl->tpl_vars['preselectionData']->value[$_smarty_tpl->tpl_vars['phrase']->value->getID()]['count'];?>
">
		<input name="phrases[<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
][selected]" type="checkbox" value="selected" <?php if ($_smarty_tpl->tpl_vars['preselectionData']->value[$_smarty_tpl->tpl_vars['phrase']->value->getID()]['selected']){?>checked="checked"<?php }?>><?php echo $_smarty_tpl->tpl_vars['phrase']->value->nazwa;?>
<br>
	<?php } ?>
	
	<input name="entry[save]" value="Zapisz" type="submit">

</form>

<?php }} ?>