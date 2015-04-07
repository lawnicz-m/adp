<?php /* Smarty version Smarty-3.1.12, created on 2014-09-17 09:40:21
         compiled from "/privcat/application/templates/text/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:113737769954193ae58fdd91-15588204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b895c57c056029cd68c42de83cbe2ef28718b648' => 
    array (
      0 => '/privcat/application/templates/text/edit.tpl',
      1 => 1410872423,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113737769954193ae58fdd91-15588204',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54193ae5c92af2_29950354',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54193ae5c92af2_29950354')) {function content_54193ae5c92af2_29950354($_smarty_tpl) {?>
<h1>Tekst</h1>

<form action="/privcat/text/save/" method="POST">
	
	<input type="hidden" name="text[id]" value="<?php echo $_smarty_tpl->tpl_vars['text']->value->getID();?>
">
	<input type="hidden" name="text[client]" value="<?php echo $_SESSION['privcat']['client']->getID();?>
">

	<label>Treść</label>
	<textarea name="text[content]" value="<?php echo $_smarty_tpl->tpl_vars['text']->value->name;?>
"><?php echo $_smarty_tpl->tpl_vars['text']->value->content;?>
</textarea>
	
	<input type="submit" value="Zapisz">
	<a href="/privcat/text/list/<?php echo $_SESSION['privcat']['client']->getID();?>
">Anuluj</a>

</form>
<?php }} ?>