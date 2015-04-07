function init(){

    $("a[rel='potwierdzenie']").click(function(){
        $(this).addClass('noCover');
        var answer = confirm('Czy na pewno wykonać tą akcję?');
        if(answer){
            location.href = $(this).attr('href');
            return false;
        }else{
            return false;
        }
    });


    $("a[rel='modal']").click(function(){
        $.blockUI({ message: '<div id="modal_content"><p></p></div>',
                    css: {
                        '-webkit-border-radius': '5px', 
                        '-moz-border-radius': '5px', 
                        border: 'none',
                        top:  ($(window).height() - 400) /2 + 'px', 
                        left: ($(window).width() - 700) /2 + 'px', 
                        height: '400px',
                        padding: '5px',
                        width: '700px'
                    }
        });
        $('.blockOverlay, #modal_content p').attr('title', 'Kliknij, aby zamknąć').click($.unblockUI);
        $.post($(this).attr('href'),
            function(data){
                $('#modal_content').html(data);
                $('a[href="#close_modal"]').click(function(){
                    $.unblockUI();
                    return false;
                });
            }
        );
        return false;
    });

    /*$("a, .formButton").click(function(){
        if($(this).attr('href') != '#' && !$(this).hasClass('noCover') && $(this).attr('rel') != 'modal' ){
            preloader();
        }
    });*/

    // CALENDAR
	$('#data_top10_odId, #data_top10_doId, #data_rozpoczecia_pozycjonowaniaId, #data_wystawieniaId, #data_sprzedazyId, #termin_zaplatyId, #data_utworzeniaId, #data_pierwszego_kontaktuId, #data_nastepnego_kontaktuId, #data_zaplatyId, #data_wezwaniaId, #data_rozpoczeciaId, #umowa_czas_okreslony_odId, #umowa_czas_okreslony_doId').datepicker({
	    dateFormat: 'yy-mm-dd',
        dayNamesMin: ['nd', 'pn', 'wt', 'śr', 'cz', 'pt', 'sb'],
        firstDay: 1,
        monthNames: ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień']
    });


    // EXTERNAL LINKS OPEN IN NEW WINDOW
    $('a[rel="external"]').addClass('noCover').attr('target', '_blank');


    // ITEM HOVER
    $('.item, .imageItem').hover(
        function(){
            $(this).addClass('itemHover');
        },
        function(){
            $(this).removeClass('itemHover');
        }
    );


    // TREE MENU CONTEXT ACTIONS
    $('#menu li').click(
        function(e){
            e.stopPropagation();
            $(document).find('#menu .actions').hide();
            //$(this).find('.actions:first').show().css('left', $(this).width() + 'px');
            $(this).find('.actions:first').show().css('left', '200px');
        }
    );
    $(document).click(
        function(e){
            e.stopPropagation();
            $(document).find('#menu .actions').hide();
        }
    );


    // GRID STYLE CONTEXT MENU
    $('.grid .image').click(
        function(e){
            e.stopPropagation();
            $(document).find('.grid .actions').hide();
	        var elementPosition = $(this).offset();
            $(this).parent()
                   .find('.actions')
                   .show(150)
                   .css('top', elementPosition.top + ($(this).height() / 2) + 'px')
                   .css('left', elementPosition.left + ($(this).width() / 2) + 'px');
        }
    );
    $(document).click(
        function(e){
            e.stopPropagation();
            $(document).find('.grid .actions').hide();
        }
    );


    // FIRST INPUT FOCUS
    //$("form :input:visible:enabled:first").focus();


    // MENU
	$('ul#navigation li').hover(
	    function(){
	        var element = $(this).find('ul');
	        var elementLink = $(this).find('a');
	        var elementPosition = elementLink.offset();

	        element.show().css('top', elementPosition.top + 35 + 'px').css('left', (elementPosition.left) + 'px');
	        elementLink.addClass('hardActive');
	    },
	    function(){
	        var element = $(this).find('ul');
	        var elementLink = $(this).find('a');

	        element.hide();
	        elementLink.removeClass('hardActive');
	    }
	);


    // KEEP EDITION BUTTON
    $('#keepEditingButton').click(function(){
        $(document).find('#redirectBackId').val('1');
    });

}


function loc(a){
    top.location.href = a;
}


function preloader(){
    $.blockUI({ message: '<div id="preloader"></div>',
                css: { border: 'none', 
                       padding: '5px',
                       '-webkit-border-radius': '5px', 
                       '-moz-border-radius': '5px', 
                       top:  ($(window).height() - 30) /2 + 'px', 
                       left: ($(window).width() - 30) /2 + 'px', 
                       height: '30px',
                       width: '30px' }
             });
}
function wylacz_preloader(){
    $.unblockUI();
}

function set_image_id(id, value){
    //alert('dee: ' + id + ', val: ' + value);
    $('#' + id).val(value).focus();
}