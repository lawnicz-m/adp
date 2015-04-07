<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER.'/wszystkie/'.PARAM_2)));

    forms::title(array('title' => !PARAM ? 'Dodaj frazę ' : 'Edytuj frazę'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM.'/'.PARAM_2)));

    $read_only = 0;

    if($uzytkownik['typ'] == 'partner'){
        $read_only = 1;
        if($klient['etap'] == 1) $read_only = 0; // rozmowy - pozwalaj
        if($klient['etap'] == 2) $read_only = 1; // oczekiwanie na wycenę - nie pozwalaj
        if($klient['etap'] == 3 && !PARAM) $read_only = 0; // oczekiwanie na umowę - nie pozwalaj
        if($klient['etap'] == 4) $read_only = 1; // oczekiwanie rozpoczęcie - nie pozwalaj
        if($klient['etap'] == 5) $read_only = 1; // pozycjonowanie - nie pozwalaj
        if($klient['etap'] == 6) $read_only = 1; // zawieszony - nie pozwalaj
    }

    forms::text(array('fieldClass' => 'width_25',
                      'label' => 'Fraza',
                      'name' => 'nazwa',
                      'required' => 1,
                      'subLabel' => 'Np: nowojorska taksówka',
                      'value' => $fraza['nazwa']));

    forms::select(array('fieldClass' => 'width_25',
                        'data' => $this -> load -> model('frazy') -> typy($dla_selecta = 1),
                        'label' => 'Typ pozycjonowania',
                        'labels' => 'nazwa',
                        'name' => 'typ',
                        'required' => 1,
                        'subLabel' => 'Ryczałt - taniej za wszystkie zryczałtowane frazy<br />TOP 10 - nieco drożej, ale dużo szybciej',
                        'value' => $fraza['typ'],
                        'values' => 'wartosc'));

    if($uzytkownik['typ'] == 'partner') $read_only = 1;
    else $read_only = 0;

    if($uzytkownik['typ'] == 'partner') $sub_label = 'Pole wypełnia pozycjoner w czasie wyceny';
    else $sub_label = '<a href="#" id="wylicz">Wylicz kwotę</a>';
    
    forms::select(array(
    		'fieldClass' => 'width_25',
    		'data' => $this -> load -> model('frazy') -> typy_top10($dla_selecta = 1),
    		'label' => 'Sposób rozliczania',
    		'labels' => 'nazwa',
    		'name' => 'top10_procentowo',
    		'readOnly' => $read_only,
    		'required' => 1,
    		'subLabel' => 'procentowo = kwota dla klienta * wartość procentowa w danym przedziale<br />kwotowo = kwota w danym przedziale',
    		'value' => $fraza['top10_procentowo'],
    		'values' => 'wartosc'));
    
    forms::text(array('fieldClass' => 'width_25',
                      'label' => 'Link dla frazy',
                      'name' => 'link',
                      'subLabel' => '<span style="color:red;">http://adresstrony.pl.</span> Tylko sprawdzić 2 razy, czy jest poprawnie.',
                      'value' => $fraza['fraza_link']));

    echo '<div style="clear:both;"></div>';

    forms::text(array('fieldClass' => 'width_20',
                      'label' => 'Kwota minimalna',
                      'name' => 'minimalna_kwota_za_fraze',
                      
                      'subLabel' => $sub_label,
                      'value' => $fraza ? $fraza['minimalna_kwota_za_fraze'] : 0));

    forms::text(array('fieldClass' => 'width_20',
                      'label' => 'Kwota dla klienta',
                      'name' => 'kwota_za_fraze',
                      'subLabel' => 'Nie może być niższa niż kwota minimalna',
                      'value' => $fraza ? $fraza['kwota_za_fraze'] : 0));


    $p1_label = $klient['top_10_1_od'].'-'.$klient['top_10_1_do'];
    $p2_label = $klient['top_10_2_od'].'-'.$klient['top_10_2_do'];
    $p3_label = $klient['top_10_3_od'].'-'.$klient['top_10_3_do'];
    

        forms::text(array('fieldClass' => 'width_20',
                          'label' => 'za przedział '.$p1_label,
                          'name' => 'top10_1_kwota',
                          
                      	  'subLabel' => '=',
                          'value' => $fraza ? $fraza['top10_1_kwota'] : 150));

        forms::text(array('fieldClass' => 'width_20',
                          'label' => 'za przedział '.$p2_label,
                          'name' => 'top10_2_kwota',
                          
                      	  'subLabel' => '=',
                          'value' => $fraza ? $fraza['top10_2_kwota'] : 100));

        forms::text(array('fieldClass' => 'width_20',
                          'label' => 'za przedział '.$p3_label,
                          'name' => 'top10_3_kwota',
                          
                      	  'subLabel' => '=',
                          'value' => $fraza ? $fraza['top10_3_kwota'] : 50));
    
    forms::checkbox(array(
    	'fieldClass' => 'width_25',
    	'data' => $this -> load -> model('frazy') -> typy_top10($dla_selecta = 1),
    	'label' => 'Pierwsza strona',
    	'labels' => 'nazwa',
    	'name' => 'top10_pierwsza_strona',
    	
    	'value' => 1,
    	'checked' => $fraza['top10_pierwsza_strona']
    ));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    ?><script type="text/javascript">

    		function przeliczPrzedzialy() {
				var typ = $('#typId').val();
				if(typ == 1) {

					var t1 = 0;
					var t2 = 0;
					var t3 = 0;

					var mul = t1 = $('#kwota_za_frazeId').val();
					
					var typ = $('#top10_procentowoId').val();
	                if(typ == 0){ // kwotowo
	                	t1 = $('#top10_1_kwotaId').val();
	                	t2 = $('#top10_2_kwotaId').val();
	                	t3 = $('#top10_3_kwotaId').val();
	                }else{ // procentowo
	                	t1 = mul * $('#top10_1_kwotaId').val() / 100.0;
	                	t2 = mul * $('#top10_2_kwotaId').val() / 100.0;
	                	t3 = mul * $('#top10_3_kwotaId').val() / 100.0;
	                }
					$('#field_top10_1_kwotaId').find('.subLabel').html(t1+'zl');
					$('#field_top10_2_kwotaId').find('.subLabel').html(t2+'zl');
					$('#field_top10_3_kwotaId').find('.subLabel').html(t3+'zl');
				} else {
					$('#field_top10_1_kwotaId').find('.subLabel').html('');
					$('#field_top10_2_kwotaId').find('.subLabel').html('');
					$('#field_top10_3_kwotaId').find('.subLabel').html('');
				}
    		}

			function toggle_top10() {
				var typ = $('#typId').val();
				if(typ == 1){
                    $('#field_top10_procentowoId').show();
                    $('#field_minimalna_kwota_za_frazeId').show();
                    $('#field_kwota_za_frazeId').show();
                    $('#field_top10_1_kwotaId').show();
                    $('#field_top10_2_kwotaId').show();
                    $('#field_top10_3_kwotaId').show();
                }else{
                    $('#field_top10_procentowoId').hide();
                    $('#field_minimalna_kwota_za_frazeId').hide();
                    $('#field_kwota_za_frazeId').hide();
                    $('#field_top10_1_kwotaId').hide();
                    $('#field_top10_2_kwotaId').hide();
                    $('#field_top10_3_kwotaId').hide();
                }
			}

            function toggle_rozliczanie(){
                var typ = $('#top10_procentowoId').val();
                if(typ == 0){ // kwotowo
                    $('#top10_1_kwotaId_label').html('zł za przedział <?php echo $p1_label?>');
                    $('#top10_2_kwotaId_label').html('zł za przedział <?php echo $p2_label?>');
                    $('#top10_3_kwotaId_label').html('zł za przedział <?php echo $p3_label?>');
                }else{ // procentowoPrev
                    $('#top10_1_kwotaId_label').html('% za przedział <?php echo $p1_label?>');
                    $('#top10_2_kwotaId_label').html('% za przedział <?php echo $p2_label?>');
                    $('#top10_3_kwotaId_label').html('% za przedział <?php echo $p3_label?>');
                }
            }

            $(document).ready(function(){
            	przeliczPrzedzialy();
                
                $('#typId').change(function(){
                	toggle_top10();
                });

                $('#kwota_za_frazeId, #top10_1_kwotaId, #top10_2_kwotaId, #top10_3_kwotaId').change(function() {
                	przeliczPrzedzialy();
                }); 


                $('#top10_procentowoId').change(function(){
                	toggle_rozliczanie();
                	przeliczPrzedzialy();
                });

                toggle_rozliczanie();
                toggle_top10();

               $('#wylicz').click(function(){
                    preloader();
                    $.ajax({
                      url: '<?php echo url::page('ow.php');?>?q=' + $('#nazwaId').val(),
                      type: "POST",
                      dataType: "json",
                      error: function(xhr, ajaxOptions, thrownError){
                          alert('Błąd');
                          wylacz_preloader();
                      },
                      success: function(data) {
                          var liczba_wynikow = data.liczba_wynikow;
                          var kwota = (parseInt(liczba_wynikow) / 1000) * 3 / 15;
                          $('#minimalna_kwota_za_frazeId').val(kwota);
                          if(data.linki_sponsorowane != '0') alert('Strona z wynikami posiada dodatkowo linki sponsorowane!');
                          wylacz_preloader();
                      }
                    });
               });
            });
    </script><?php

    $this -> load -> view('footer');

?>