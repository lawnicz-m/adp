function itemActive(division, id){
    preloaderShow();
    $.post(division + '/active/' + id,
        function(data){
            if(data == '1' || data == '0'){
                var iconPath = $(document).find('#itemStatus' + id).attr('src');
                if(data == '1'){ iconPath = iconPath.replace('0','1'); }else{ iconPath = iconPath.replace('1','0'); }
                $(document).find('#itemStatus' + id).attr('src', iconPath);
            }else{
                alert(messages_active_error);
                //$('html').html(data);
            }
            preloaderHide();
            init();
        }
    );
}

function itemDelete(division, id){
    var answer = confirm(messages_delete_confirmation);
    if(answer){
        preloaderShow();
        $.post(division + '/delete/' + id,
            function(data){
                if(data == 'ok'){
                    var item = $(document).find('#content #item_' + id);
                    item.addClass('r3')
    				.animate({backgroundColor: '#FFD9CF'}, 'fast')
    				.animate({backgroundColor: '#FFFFFF'}, 'fast')
    				.animate({backgroundColor: '#FFD9CF'}, 'fast')
    				.animate({backgroundColor: '#FFFFFF'}, 'fast')
    				.animate({backgroundColor: '#FFD9CF'}, 'fast')
    				.animate({backgroundColor: '#FFFFFF'}, 'fast')
    				.animate({backgroundColor: '#FFD9CF'}, 'fast')
    				.animate({backgroundColor: '#FFFFFF'}, 'fast')
    				.slideUp('slow', function(){ item.remove(); });
                }else{
                    alert(messages_delete_error);
                }
                preloaderHide();
                init();
            }
        );
    }else{
        preloaderHide();
    }
}

function itemDeleteInline(target){
    var answer = confirm(messages_delete_confirmation);
    if(answer){
        location.href = target;
    }else{
        preloaderHide();
    }
}
    
function itemMove(){
	$('.items').sortable({cursor: 'move',
	                      opacity: '0.75',
	                      revert: true,
	                      placeholder: 'itemHover',
	                      tolerance: 'pointer',
	                      forcePlaceholderSize: true,
	                      stop: function(event, ui){
	                      $.ajax({url: tfn + '/move',
	                              type: 'POST',
	                              data: $(this).sortable('serialize'),
	                              success: function(responseText){
	                                  if(responseText != 'ok'){
	                                    alert(messages_move_error);
	                                    preloaderShow();
                                        loc(tfn);
	                                  }
	                              }
	                      });
	                      }
	});
}
