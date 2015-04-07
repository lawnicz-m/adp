<?php /* Smarty version Smarty-3.1.12, created on 2015-01-20 15:37:25
         compiled from "/privcat/application/templates/entries/history.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1840951567541834dfb74729-19609513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c91e11f7db85604eaea9a57756c2b1f6fa1755d4' => 
    array (
      0 => '/privcat/application/templates/entries/history.tpl',
      1 => 1421764622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1840951567541834dfb74729-19609513',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_541834dfd1ac35_91408533',
  'variables' => 
  array (
    'client' => 0,
    'phrases' => 0,
    'phrase' => 0,
    'dates' => 0,
    'date' => 0,
    'histories' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541834dfd1ac35_91408533')) {function content_541834dfd1ac35_91408533($_smarty_tpl) {?>
<script type="text/javascript">

$(document).ready(function() {
	
	$('.privcat_history_bar').each(function() {
		
		var heightMin = 16;
		var heightMax = 150;
		
		var freedom = heightMax-heightMin;
		var posMax = 150;
		var heightPerPos = (freedom) / posMax;
		
		var result = $(this).attr('result');
		
		var resultHeight = heightMin + (freedom - (result*heightPerPos));
		
		if(resultHeight > heightMax) {
			resultHeight = heightMax;
		}
		

		if(resultHeight < heightMin) {
			resultHeight = heightMin;
		}
		
		$(this).css('height', resultHeight);	
		
		// #f00
		// #0f0
		
		var resultRev = posMax - result;
		var gradientFreedom = 200;
		var gradPerPos = gradientFreedom / posMax;
		
		var resultGradient = resultRev * gradPerPos;
		
		resultGradient = Math.round(resultGradient);
		
		if(resultGradient < 0) {
			resultGradient = 1;
		}
		
		if(resultGradient > gradientFreedom) {
			resultGradient = gradientFreedom;
		}
		
		resultGradientRev = (gradientFreedom+1) - resultGradient;
		
		var red = ("0000" + resultGradientRev.toString(16));
		red = red.substr(-2);

		var green = ("0000" + resultGradient.toString(16));
		green = green.substr(-2);
		
		var color = "#"+red+green+"00";
		
		//alert(color);
		
		$(this).css('background-color', color);
	});
	
});

</script>

<h1>Historia</h1>

<form class="history_form" action="/privcat/entries/historysubmit/<?php echo $_smarty_tpl->tpl_vars['client']->value->getId();?>
" method="post">

<input type="submit" value="Dodaj privkaty">
<h4>Dostępnych tekstów: <?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfAvailableTexts();?>
</h4>

<?php  $_smarty_tpl->tpl_vars['phrase'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['phrase']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['phrases']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['phrase']->key => $_smarty_tpl->tpl_vars['phrase']->value){
$_smarty_tpl->tpl_vars['phrase']->_loop = true;
?>

<div class="phrase_history_wrapper">
	<div class="phrase_description_wrapper">
		<h3><?php echo $_smarty_tpl->tpl_vars['phrase']->value->nazwa;?>
 (<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getPrice();?>
)</h3>
		<?php if ($_smarty_tpl->tpl_vars['phrase']->value->fraza_link!=null){?><a href="<?php echo $_smarty_tpl->tpl_vars['phrase']->value->fraza_link;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['phrase']->value->fraza_link;?>
</a><?php }?>
		<h4>Obecnie <?php echo $_smarty_tpl->tpl_vars['phrase']->value->getCurrentPrivcatCount();?>
 privkatów</h4>
		<input type="checkbox" value="selected" name="phrases[<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
][selected]">dodaj privkaty<br>
		<input name="phrases[<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
][count]" type="number" value="1">
	</div>
	<div class="phrase_results_wrapper">

		<?php  $_smarty_tpl->tpl_vars['date'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['date']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['date']->key => $_smarty_tpl->tpl_vars['date']->value){
$_smarty_tpl->tpl_vars['date']->_loop = true;
?>
		<div class="privcat_history_wrapper">
			<div class="privcat_history_bar_wrapper">
				<div class="privcat_history_bar" result="<?php echo $_smarty_tpl->tpl_vars['histories']->value[$_smarty_tpl->tpl_vars['phrase']->value->getID()][$_smarty_tpl->tpl_vars['date']->value]['results']->wynik;?>
">
					<span class="privcat_history_result"><?php echo $_smarty_tpl->tpl_vars['histories']->value[$_smarty_tpl->tpl_vars['phrase']->value->getID()][$_smarty_tpl->tpl_vars['date']->value]['results']->wynik;?>
</span>
				</div>
			</div>
			<div class="privcat_history_date"><?php echo substr($_smarty_tpl->tpl_vars['date']->value,8,2);?>
</div>
			<div class="privcat_history_link">
				<?php if (count($_smarty_tpl->tpl_vars['histories']->value[$_smarty_tpl->tpl_vars['phrase']->value->getID()][$_smarty_tpl->tpl_vars['date']->value]['privcatsfrom'])>0||count($_smarty_tpl->tpl_vars['histories']->value[$_smarty_tpl->tpl_vars['phrase']->value->getID()][$_smarty_tpl->tpl_vars['date']->value]['privcatsto'])>0){?> <a
					href="/privcat/entries/ajaxgethistory/<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
/<?php echo $_smarty_tpl->tpl_vars['date']->value;?>
"
					class="ajaxUpgradeable"
					ajax-target="historydetailstarget<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
" >(!)</a> <?php }?>
			</div>
		</div>
		<?php } ?>

		<div style="clear: both;"></div>

		<div class="history_details" id="historydetailstarget<?php echo $_smarty_tpl->tpl_vars['phrase']->value->getID();?>
"></div>

	</div>
		<div style="clear: both;"></div>
</div>
<?php } ?>

<input type="submit" value="Dodaj privkaty">
<h4>Dostępnych <?php echo $_smarty_tpl->tpl_vars['client']->value->getNumOfAvailableTexts();?>
 tekstów</h4>
</form>
<?php }} ?>