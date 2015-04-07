
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

<form class="history_form" action="/privcat/entries/historysubmit/{$client->getId()}" method="post">

<input type="submit" value="Dodaj privkaty">
<h4>Dostępnych tekstów: {$client->getNumOfAvailableTexts()}</h4>

{foreach from=$phrases item=phrase}

<div class="phrase_history_wrapper">
	<div class="phrase_description_wrapper">
		<h3>{$phrase->nazwa} ({$phrase->getPrice()})</h3>
		{if $phrase->fraza_link != null}<a href="{$phrase->fraza_link}">{$phrase->fraza_link}</a>{/if}
		<h4>Obecnie {$phrase->getCurrentPrivcatCount()} privkatów</h4>
		<input type="checkbox" value="selected" name="phrases[{$phrase->getID()}][selected]">dodaj privkaty<br>
		<input name="phrases[{$phrase->getID()}][count]" type="number" value="1">
	</div>
	<div class="phrase_results_wrapper">

		{foreach from=$dates item=date}
		<div class="privcat_history_wrapper">
			<div class="privcat_history_bar_wrapper">
				<div class="privcat_history_bar" result="{$histories[$phrase->getID()][$date].results->wynik}">
					<span class="privcat_history_result">{$histories[$phrase->getID()][$date].results->wynik}</span>
				</div>
			</div>
			<div class="privcat_history_date">{substr($date, 8, 2)}</div>
			<div class="privcat_history_link">
				{if count($histories[$phrase->getID()][$date].privcatsfrom) > 0 ||
				count($histories[$phrase->getID()][$date].privcatsto) > 0} <a
					href="/privcat/entries/ajaxgethistory/{$phrase->getID()}/{$date}"
					class="ajaxUpgradeable"
					ajax-target="historydetailstarget{$phrase->getID()}" >(!)</a> {/if}
			</div>
		</div>
		{/foreach}

		<div style="clear: both;"></div>

		<div class="history_details" id="historydetailstarget{$phrase->getID()}"></div>

	</div>
		<div style="clear: both;"></div>
</div>
{/foreach}

<input type="submit" value="Dodaj privkaty">
<h4>Dostępnych {$client->getNumOfAvailableTexts()} tekstów</h4>
</form>
