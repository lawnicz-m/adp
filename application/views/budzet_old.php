<?php $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
    $tabela = $this -> db -> table('klienci');
    $id_klienta = $klient['id_klienta'];
    $baza_budzet_arr = $tabela -> select('budzet')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
    
    $baza_budzet = ($baza_budzet_arr[0]["budzet"]);
    $budzet = intval($baza_budzet);
    
    
function wersy($id_klienta) {
					$filename = "budzet/".$id_klienta.".txt";
        $file=fopen($filename,'r');
		$calkowity_koszt = 0;
        while($line = fgets($file)){
                $line=trim($line);
                list($koszt,$na_co) = explode('|',$line);
                echo "<tr><td>$koszt</td><td>$na_co</td></tr>\n";
                $calkowity_koszt = $calkowity_koszt + $koszt;
        }
return true;
}
function koszt($id_klienta) {
		$filename = "budzet/".$id_klienta.".txt";
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
			forms::title(array('title' => 'Budżet klienta'));?>
		<table border="0" cellpadding="30" cellspacing="1" id="dane_klienta" width="100%" >		
			<tr>
				<td style="vertical-align: top; width: 25%">Nazwa klienta:<br /><b><?php echo $klient['nazwa'];?></b></td>
				<td style="vertical-align: top; width: 25%">Nazwa strony:<br /><b><?php echo $klient['adres_strony'];?></b></td>
				<td style="vertical-align: top; width: 25%">Całkowity budżet:<br /><b><?php echo $klient['budzet'];?></b></td>
				<td style="vertical-align: top; width: 25%">Pozostały budżet:<br /><b><?php echo $reszta; ?></b></td>
			</tr>
		</table>

<?php 
if($reszta < 0) {
forms::line(0); ?>
<p style="font-size: 25px; text-align: center;"><span style="color: red;"><strong>Budżet przekroczony</strong></span></p>
<?php
}
forms::line(0);
forms::button(array('value' => 'Edytuj', 'link' => url::page(CONTROLLER.'/form/'.$klient['id_klienta'])));
?>
<table border="1" cellpadding="5" cellspacing="5" id="budżet" width="50%" align="center">
	<tr>
		<th>Koszt</th>
		<th>Przeznaczony na:</th>
	</tr>
	<?php wersy($id_klienta); ?>
</table>
<?php
if($reszta < ($budzet * 20)/100) {
forms::line(0); ?>
<p style="font-size: 25px; text-align: center;"><span style="color: red;"><strong>A chcesz ty coś zarobić?</strong></span></p>
<?php
}
	
		$this -> load -> view('footer');
		
?>