<?php /* Smarty version Smarty-3.1.12, created on 2014-09-16 15:01:44
         compiled from "/privcat/application/templates/privcat/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:556230024541834b856c9c1-13890508%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdf3d7e5d896bb8b7e4c4ed9fccdf80ce61aa7b6' => 
    array (
      0 => '/privcat/application/templates/privcat/list.tpl',
      1 => 1410872424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '556230024541834b856c9c1-13890508',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'privcats' => 0,
    'privcat' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541834b8666517_76153268',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541834b8666517_76153268')) {function content_541834b8666517_76153268($_smarty_tpl) {?>
<h1>Privkaty</h1>

<nav>
	<a href="/privcat/privcat/edit">Nowy</a>
	<div style="clear: both;"></div>
</nav>

<table>
	<tr>
		<th>ID</th>
		<th>Nazwa</th>
		<th>Adres</th>
		<th>FTP - adres</th>
		<th>FTP - user</th>
		<th>FTP - pass</th>
		<th>Liczba wpisów opublikowanych / wszystkich</th>
		<th>Opcje</th>
	</tr>
	
	<?php  $_smarty_tpl->tpl_vars['privcat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['privcat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['privcats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['privcat']->key => $_smarty_tpl->tpl_vars['privcat']->value){
$_smarty_tpl->tpl_vars['privcat']->_loop = true;
?>
		<tr>			
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->name;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->address;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftpaddress;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftpuser;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->ftppass;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['privcat']->value->getNumberOfPublishedEntries();?>
/<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getNumberOfEntries();?>
</td>
			<td>
				<a href="/privcat/privcat/history/<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
">Historia</a>
				<a href="/privcat/privcat/edit/<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
">Edycja</a>
				<a class="ajaxUpgradeable" ajax-target="ftptestresult<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
" href="/privcat/privcat/testftp/<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
">Test połączenia</a>
				<div id="ftptestresult<?php echo $_smarty_tpl->tpl_vars['privcat']->value->getID();?>
"></div>
			</td>
		</tr>
	<?php } ?>

</table>
<?php }} ?>