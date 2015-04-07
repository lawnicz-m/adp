<?php
 include('slownie.php');
 $klasa_slownie = new slownie;
 $wynagrodzenie_slownie = trim($klasa_slownie -> pokaz($umowa['wynagrodzenie'])); 

?><html>
<style type="text/css">
<!--
.style1 {
	color: #FF0000
}
-->
</style>
<body>

<h1 align="center">Dokument potwierdzenia nr <?php echo $umowa['numer'];?></h1>

<p align="center">wystawiony w dniu <?php echo $umowa['data_rozpoczecia'];?> roku <?php echo AGREEMENT_CITY;?> dla :</p>
<p><br />
 <br />

 <?php echo $klient['faktura_nazwa'] ? $klient['faktura_nazwa'] : '.............................................................';?>
 <br />
 <?php echo $klient['faktura_adres'] ? $klient['faktura_adres'] : '.............................................................';?>
 <br />
 <?php echo ($klient['faktura_kod_pocztowy'] && $klient['faktura_miejscowosc']) ? $klient['faktura_kod_pocztowy'].' '.$klient['faktura_miejscowosc'] : '.............................................................';?>
 <br />

numer NIP : 
<?php echo $klient['nip'] ? $klient['nip'] : '.............................................................';?>
<br />
Osoba reprezentująca: 
<?php echo $klient['reprezentant'] ? $klient['reprezentant'] : '.............................................................';?>
, zwanym dalej „<b>Zlecającym test</b>”, 

<br />
<br />
a<br />
<br />

<?php echo AGREEMENT_COMPANY_DATA;?>
, zwanym dalej „<b>Wykonawcą testu</b>”. 

<?php if($frazy){ ?>
</p>

<p align="center">==============================================</p>
<h2 align="center">Darmowy test pozycjonowania dla strony <?php echo $klient['adres_strony'];?>
</h2>
<p>W nawiązaniu do rozmowy telefonicznej. Przesyłam link z wynikami Państwa strony w wyszukiwarce google.pl,
 dla wybranych przez nas fraz. </p>
<p>Ewentualnie zapraszamy do przesłania własnej listy fraz (do 15-stu sztuk). </p>
<p>Dokument został wysłany na adres <strong>Zlecającego test</strong> 
 <?php echo $klient['mail'];?>
</p>
<h2>Frazy:</h2>
<ol>
<?php foreach($frazy as $fraza){ ?>
<li><?php echo $fraza['nazwa'];?></li>
<?php } ?>
</ol>
<?php }else{ ?>
<h2>UWAGA!!! Brak frazy w umowie na test pozycjonowania! Proszę uzupełnić frazy!</h2>
<?php } ?>

<h2>Link do panelu z wynikami dla strony www.<?php echo $klient['adres_strony'];?></h2>
<p><a href="<?php echo url::page('klient/wyniki/'.$klient['hash']);?>"><?php echo url::page('klient/wyniki/'.$klient['hash']);?></a></p>

<h2>Data rozpoczęcia</h2>
<p> Data rozpoczęcia testu: <b><?php echo $umowa['data_rozpoczecia'];?></b>
<h2>Przewidywany czas testu</h2> to okres do 2 tygodni lub do osiągnięcia wyników na poziomie 40% w „TOP-10”


<h3 class="style1">Niniejsza usługa jest całkowicie bezpłatna i niezobowiązująca żadnej ze stron !</h3>
<p>W przypadku zainteresowania prosimy o kontakt z działem sprzedaży - </p>
<p><?php echo $uzytkownik['nazwa'];?> <?php echo isset($uzytkownik['telefon']) ? $uzytkownik['telefon'] : '601 68 38 15';?> <A href="mailto:<?php echo $uzytkownik['mail'];?>"><?php echo $uzytkownik['mail'];?></A></p>
<p>W razie pytań technicznych prosimy o kontakt z działem IT - </p>
<p>Jacek Wyrębkiewicz  601 68 38 15 <a href="mailto:jacek@onesite.pl">jacek@onesite.pl</a></p>
<p align="center">==============================================</p>
<p>Zajmujemy się m.in.:<BR>
  - Pozycjonowaniem stron w wyszukiwarce Google.<BR>
  - Tworzeniem   witryn internetowych.<BR>
  - Tworzeniem sklepów internetowych.<BR>
  - Tworzeniem   aplikacji firmowych na Facebook'a, jak i fanpage'ów.<BR>
  - Wykonujemy zlecenia   "White Hat SEO" (czyszczenie wyników Google na zadany temat do 3 strony   włącznie).<BR>
</p>
</body>
</html>