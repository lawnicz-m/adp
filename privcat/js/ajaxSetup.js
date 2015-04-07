
function convertAjaxLink(href) {		
	if(href.substring(0,1) == "/") {
		href = href.substring(1,href.length);
	}
	
	var subHrefs = href.split("/");
	
	var resultHref = "";
	for (i = 0; i < subHrefs.length; i++) {
		if(i != 1) {
			resultHref += "/" + subHrefs[i];
		} else {
			if(subHrefs[i].substring(0,4) != "ajax") {
				resultHref += "/ajax" + subHrefs[i];
			} else {
				resultHref += "/" + subHrefs[i];
			}
		}
	}
	
	return resultHref;
}

function snapInAjax() {
	$(".ajaxUpgradeable-history").each(function() {
		var $elem = $(this);
		
		if ($elem.data('ajax-init')) {
            return true;
        }

		$elem.data('ajax-init', true);
		
		$elem.click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var oldUrl = document.URL
			var href = $(this).attr("href");
			var target = "#"+$(this).attr("ajax-target");
			var ajaxHref = convertAjaxLink(href);
			
			$(""+target).load(href, function() {
				snapInAjax();
				
				history.pushState({}, '', href);
			});
        });
	});
	
	$(".ajaxUpgradeable").each(function() {
		var $elem = $(this);
		
		if ($elem.data('ajax-init')) {
            return true;
        }

		$elem.data('ajax-init', true);
		
		$elem.click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var oldUrl = document.URL
			var href = $(this).attr("href");
			var target = "#"+$(this).attr("ajax-target");
			var ajaxHref = convertAjaxLink(href);
			
			$(""+target).load(href, function() {
				snapInAjax();
			});
        });
	});
}

$(document).ready(function(){
	snapInAjax();
});
