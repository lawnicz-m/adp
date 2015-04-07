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



<p align="right">Wrocław dnia <?php echo $umowa['data_rozpoczecia'];?> roku <?php echo AGREEMENT_CITY;?> dla :</p>
<h2 align="center">  Podziękowanie za rozmowę</h2>
<p align="center">==============================================</p>
<h2>Link do panelu z wynikami dla strony www.<?php echo $klient['adres_strony'];?></h2>
<p><a href="<?php echo url::page('klient/wyniki/'.$klient['hash']);?>"><?php echo url::page('klient/wyniki/'.$klient['hash']);?></a></p>

Pomimo, że nie byli Państwo zainteresowani naszą ofertą, 
chcieliśmy serdecznie   podziękować za poświęcony czas.<BR>

    
  Jeżeli kiedykolwiek w przyszłości   będą potrzebowali 
Państwo kompleksowych rozwiązań    informatycznych, 
pozycjonowania stron lub stworzenia   aplikacji/fanpage 
firmowego na Facebook'a. Zapraszamy do współpracy.<BR>
Nasi   wysokiej klasy specjaliści będą do Państwa usług.
<p>W razie jakoichkolwiek pytań prosimy o kontakt z działem sprzedaży - </p>
<p><?php echo $uzytkownik['nazwa'];?> <?php echo isset($uzytkownik['telefon']) ? $uzytkownik['telefon'] : '601 68 38 15';?> <A href="mailto:<?php echo $uzytkownik['mail'];?>"><?php echo $uzytkownik['mail'];?></A></p>
<p>W razie pytań technicznych prosimy o kontakt z działem IT - </p>
<p>Jacek Wyrębkiewicz  601 68 38 15 <a href="mailto:jacek@onesite.pl">jacek@onesite.pl</a></p>
<p align="center">==============================================</p>
<p>-- <BR>
Zajmujemy się:</p>
<ul>
  <li>Pozycjonowaniem stron w wyszukiwarce Google.</li>
  <li>Tworzeniem aplikacji firmowych na Facebook'a, oraz fanpage'ów.</li>
  <li>Integrowanie   "like-it'ow" ze stroną firmową.</li>
  <li>Wykonujemy zlecenia "White Hat SEO"   (czyszczenie wyników Google na zadany temat do 3 strony włącznie).</li>
</ul>
<p><BR>
  <BR>
</p>
</body>
</html>