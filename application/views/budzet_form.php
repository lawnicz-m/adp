<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
    $tabela = $this -> db -> table('klienci');
    $id_klienta = $klient['id_klienta'];
    $baza_budzet_arr = $tabela -> select('budzet')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
    
    $baza_budzet = ($baza_budzet_arr[0]["budzet"]);
    $budzet = intval($baza_budzet);
function koszt($id_klienta) {
					$filename = "/ADPPoland_CRM2/application/views/budzet/".$id_klienta.".txt";
        $file=fopen($filename,'r');
        $calkowity_koszt = 0;
        while($line = fgets($file)){
                $line=trim($line);
                list($koszt,$na_co) = explode('|',$line);
                $calkowity_koszt = $calkowity_koszt + $koszt;
        }
return $calkowity_koszt;
}
$wydatek = koszt($id_klienta);
$reszta = $budzet - $wydatek;   
			forms::title(array('title' => 'Budżet klienta'));
			forms::open(array('action' => url::page('budzet/zapisz/'.PARAM))); ?>
			
		<table border="0" cellpadding="30" cellspacing="1" id="dane_klienta" width="100%" >	
			<tr>
				<td style="vertical-align: top; width: 25%">Nazwa klienta:<br /><b><?php echo $klient['nazwa'];?></b></td>
				<td style="vertical-align: top; width: 25%">Nazwa strony:<br /><b><?php echo $klient['adres_strony'];?></b></td>
				<?php if($uzytkownik['typ'] == 'admin') { ?>
				<td style="vertical-align: top; width: 25%">
				<?php
				forms::text(array('label' => 'Całkowity budżet:',
                      'name' => 'budzet',
                      'value' => $klient['budzet']));
      ?>
      </td><?php
      }else { ?>
				<td style="vertical-align: top; width: 25%">Całkowity budżet:<br /><b><?php echo $klient['budzet'];?></b></td> <?php } ?>
				<td style="vertical-align: top; width: 25%">Pozostały budżet:<br /><b><?php echo $reszta ?></b></td>
			</tr>
		</table>
<?php forms::line(0); 

?>

		<table border="0" cellpadding="30" cellspacing="1" id="dane_klienta" width="100%" >
			<tr>
				<td style="width: 25%">
				<?php
				forms::text(array('label' => 'Koszt:',
                      'name' => 'koszt',
                      'value' => ''));
      ?>
				</td>
				<td style="width: 75%">
				<?php
				forms::text(array('label' => 'Przeznaczony na:',
                      'name' => 'na_co',
                      'value' => ''));
      ?>
				</td>
			</tr>
		</table>

<?php
			forms::submit(0);
    	forms::close(0);

    $this -> load -> view('footer');
?>