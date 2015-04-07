<?php
    include('slownie.php');
    $klasa_slownie = new slownie;
    $wynagrodzenie_slownie = trim($klasa_slownie -> pokaz($umowa['wynagrodzenie'])); 

?><html>
    <body>

<h1 align="center">Umowa nr <?php echo $umowa['numer'];?></h1>

<p align="center">zawarta w dniu .......................... roku <?php echo AGREEMENT_CITY;?> pomiędzy :</p><br /><br />

<?php echo $klient['faktura_nazwa'] ? $klient['faktura_nazwa'] : '.............................................................';?><br />
<?php echo $klient['faktura_adres'] ? $klient['faktura_adres'] : '.............................................................';?><br />
<?php echo ($klient['faktura_kod_pocztowy'] && $klient['faktura_miejscowosc']) ? $klient['faktura_kod_pocztowy'].' '.$klient['faktura_miejscowosc'] : '.............................................................';?><br />
REGON : <?php echo $klient['regon'] ? $klient['regon'] : '.............................................................';?><br />
numer NIP : <?php echo $klient['nip'] ? $klient['nip'] : '.............................................................';?><br />
Pesel: <?php echo $klient['pesel'] ? $klient['pesel'] : '.............................................................';?>,<br />
Osoba reprezentująca: <?php echo $klient['reprezentant'] ? $klient['reprezentant'] : '.............................................................';?>, zwanym dalej „<b>Zlecającym</b>”, 

<br /><br />
a<br /><br />

<?php echo AGREEMENT_COMPANY_DATA;?>, zwanym dalej „<b>Wykonawcą</b>”. 



<h1 align="center">§1</h1>

<h2 align="center">Przedmiot Umowy</h2>

<ol>
<li><b>Zamawiający</b> powierza <b>Wykonawcy</b> realizację <b><?php echo $umowa['typ_realizacji'];?></b>, zwanego dalej w treści Umowy <b>Witryną Internetową</b>.</li>
<li><b>Wykonawca</b> oświadcza, iż podejmuje się wykonania wyżej określonej <b>Witryny Internetowej</b> oraz zobowiązuje się do przeniesienia majątkowych praw autorskich do niej na <b>Zamawiającego</b>.</li>
<li><b>Zamawiający</b> zobowiązuje się do dostarczenia <b>Wykonawcy</b> wszelkich niezbędnych do realizacji zamówienia materiałów a w szczególności tekstów, zdjęć, logotypów, itp.</li>
<li><b>Zamawiający</b> bierze pełną odpowiedzialność za treści umieszczone na <b>Witrynie Internetowej</b>.</li>
<li><b>Wykonawca</b> zobowiązuje się do realizacji dzieła w sposób profesjonalny, z dołożeniem należytej staranności oraz zgodnie ze wskazówkami i zaleceniami <b>Zamawiającego</b>. Zamawiający bierze odpowiedzialność <STRONG>wyłącznie za treści umieszczone na   stronie www  pochodzące od Zamawiającego.</STRONG></li>
<li><b>Witryna Internetowa</b> zostanie wykonana zgodnie ze specyfikacją zawartą w <b>Załączniku nr 1</b> do niniejszej Umowy, stanowiącym wraz z nią integralną całość.</li>
</ol>

 

<h1 align="center">§2</h1>

<h2 align="center">Termin i warunki wykonywania prac</h2>

<ol>
<li>Przed rozpoczęciem prac, <b>Zamawiający</b> w terminie 3 dni od podpisania niniejszej Umowy, zobowiązuje się wpłacić zadatek w wysokości <b><?php echo $umowa['wysokosc_zadatku'];?>%</b> kwoty wynagrodzenia należnego <b>Wykonawcy</b>, określonego w <b>§3</b> niniejszej Umowy.</li>
<li><b>Wykonawca</b> zobowiązuje się do rozpoczęcia prac w ciągu trzech dni od daty wpłynięcia wyżej uzgodnionej kwoty zadatku na konto bankowe <b>Wykonawcy</b>.</li>
<li><b>Wykonawca</b> zobowiązuje się wykonać <b>Witrynę Internetową</b> w terminie <b><?php echo $umowa['termin_realizacji'];?></b> dni od dostarczenia przez Zamawiającego niezbędnych materiałów, o których mowa w <b>§1</b> ust. 2.</li>
<li>Termin wykonania może ulec wydłużeniu z przyczyn niezależnych od <b>Wykonawcy</b>, w szczególności w przypadku wprowadzania przez <b>Zamawiającego</b> zmian w projekcie lub specyfikacji zawartości <b>Witryny Internetowej</b>, w tracie wykonywanych prac, zmiany parametrów technicznych <b>Witryny Internetowej</b> lub zwłoki w zatwierdzaniu przez niego poszczególnych etapów realizacji dzieła.</li>
<li><b>Zamawiający</b> udostępni <b>Wykonawcy</b> dostęp do docelowego serwera FTP i domeny gdzie docelowo będzie funkcjonowała <b>Witryna Internetowa</b> wraz z niezbędnymi uprawnieniami niezbędnymi do prowadzenie i wykonania prac.</li>
<li><b>Zamawiającemu</b> w każdym momencie realizacji przysługuje prawo do wglądu w aktualny stan prac.</li>
<li>Po ukończeniu prac <b>Wykonawca</b> zobowiązuje się do udostępnienia <b>Zamawiającemu</b> wykonanej <b>Witryny Internetowej</b> w postaci elektronicznej oraz jej kodów źródłowych. Odbiór przedmiotu Umowy i przekazanie nośników (materiałów lub urządzeń) niezbędnych do jej użytkowania (pliki na FTP i pliki na CD) nastąpi na podstawie protokołu odbioru.</li>
</ol>

 

<h1 align="center">§3</h1>

<h2 align="center">Wynagrodzenie i warunki płatności </h2>

<ol>
<li>Za wykonanie <b>Witryny Internetowej</b> o parametrach określonych w <b>§ 1</b> i <b>Załączniku nr 1</b>,a także za przeniesienie majątkowych praw autorskich do zmian wykonanych na   stronie www, <b>Wykonawca</b> otrzyma wynagrodzenie w wysokości <b><?php echo str_replace('.00', '', number_format($umowa['wynagrodzenie'], 2, '.', ' '));?> zł</b>. (słownie: <b><?php echo $wynagrodzenie_slownie;?></b>).</li>
<li>Do ceny zostanie doliczony podatek VAT w wysokości zgodnej z obowiązującymi na dzień wystawienia faktury VAT przepisami.</li>
<li>Wynagrodzenie, o którym mowa w ust. 1 obejmuje również nabycie przez <b>Zamawiającego</b> autorskich praw majątkowych do wykonanej <b>Witryny Internetowej</b>.</li>
<li>Kwota wynagrodzenia płatna będzie w terminie <b><?php echo $umowa['termin_platnosci'];?></b> dni od daty otrzymania faktury VAT.</li>
<li>Do chwili wypłacenia należnego <b>Wykonawcy</b> wynagrodzenia, wykonana <b>Witryna Internetowa</b> pozostaje jego własnością.</li>
<li>Z chwilą zapłaty pełnej kwoty wynagrodzenia określonego w niniejszym paragrafie <b>Wykonawca</b> przenosi, a <b>Zamawiający</b> nabywa majątkowe prawa autorskie do wykonanej <b>Witryny Internetowej</b>.</li>
</ol>

 

<h1 align="center">§4</h1>

<h2 align="center">Szkolenie użytkowników</h2>

<ol>
Uchylony
</ol>
 


<h1 align="center">§5</h1>

<h2 align="center">Ochrona tajemnicy</h2>

<ol>
<li>Strony zobowiązują się do utrzymania w tajemnicy i nie przekazywania osobom trzecim wszelkich informacji o warunkach niniejszej umowy, a dotyczących:<br />
&nbsp;&nbsp;&nbsp;&nbsp;a) utrzymania tajemnicy związanej z aplikacjami i dokumentacją,<br />
&nbsp;&nbsp;&nbsp;&nbsp;b) danych uzyskanych w czasie realizacji przedmiotu umowy o przedsiębiorstwie i działalności drugiej ze stron, o ile informacje takie nie są powszechnie znane lub strona nie uzyskała uprzednio pisemnej zgody drugiej ze Stron.</li>
<li>Treść niniejszej umowy stanowi tajemnicę handlową i może zostać ujawniona jedynie uprawnionym organom, bądź w celu wykonania ciążących na którejkolwiek ze Stron obowiązków w sposób wyraźny przez przepisy prawa, bądź w celu realizacji praw należnych każdej ze Stron pod warunkiem, że pozostają w związku z niniejszą Umową.</li>
<li>Strony mogą wyjawić informację objętą tajemnicą tylko tym pracownikom lub podwykonawcom, którzy są bezpośrednio zaangażowani w wykonanie lub wykorzystanie aplikacji, pod warunkiem, że będą oni przestrzegać warunków związanych z ochroną tajemnicy.</li>
</ol>



<h1 align="center">§6</h1>

<h2 align="center">Postanowienia końcowe</h2>

<ol>
<li>Wszelkie zmiany treści niniejszej Umowy wymagają dla swej ważności zachowania formy pisemnej - aneksu do umowy.</li>
<li>W sprawach nie uregulowanych niniejszą Umową zastosowanie mają przepisy Kodeksu Cywilnego, ustawy Prawo autorskie i prawa pokrewne i innych właściwych przepisów prawa.</li>
<li>Wszelkie spory wynikłe z wykonywania postanowień niniejszej Umowy Strony zobowiązują się rozwiązywać polubownie na drodze negocjacji. W razie braku porozumienia spory rozstrzygał będzie sąd właściwy dla miejsca siedziby pozwanego.</li>
<li>Umowę sporządzono w 2 jednobrzmiących egzemplarzach, po jednym dla każdej ze Stron.</li>
</ol> 

<table>
    <tr>
        <td>
            <p align="center"><br /><br />ZLECAJĄCY:</p>
        </td>
        <td>
            <p align="center"><br /><br />WYKONAWCA:</p>
        </td>
    </tr>
</table>


    </body>
</html>