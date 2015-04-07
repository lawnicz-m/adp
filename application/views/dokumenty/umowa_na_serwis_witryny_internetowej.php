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
Osoba reprezentująca: <?php echo $klient['reprezentant'] ? $klient['reprezentant'] : '.............................................................';?>, zwanym dalej „<b>Zlecającym</b>”, 

<br /><br />
a<br /><br />

<?php echo AGREEMENT_COMPANY_DATA;?>, zwanym dalej „<b>Wykonawcą</b>”. 



<h1 align="center">§1</h1>

<h2 align="center">Przedmiot Umowy</h2>
 
<ol>
<li><b>Zamawiający</b> powierza <b>Wykonawcy</b> realizację usług związanych z utrzymaniem i obsługą działającej <b>Strony WWW</b> umieszczonej pod adresem <b><?php echo $klient['adres_strony'];?></b>, a <b>Wykonawca</b> oświadcza, iż podejmuje się stałego świadczenia tych usług na zasadach opisanych poniżej.</li>
<li>Zakres prac o których mowa w p. 1 niniejszego paragrafu obejmuje :<br />
&nbsp;&nbsp;&nbsp;&nbsp;a) Usługi zarządzania treścią i administrowania <b>Strony WWW</b>.<br />
&nbsp;&nbsp;&nbsp;&nbsp;b) Wprowadzania zmian związanych z rozwojem technologicznym na <b>Stronie WWW</b>.
</li>
<li>Szczegółowa specyfikacja usług wymienionych w niniejszym paragrafie znajduje się w <b>Załączniku nr 1</b> do niniejszej Umowy, stanowiącym wraz z nią integralną całość.</li>
<li><b>Zamawiający</b> zobowiązuje się do dostarczenia <b>Wykonawcy</b> wszelkich niezbędnych do realizacji zamówienia materiałów a w szczególności tekstów, zdjęć, logotypów, itp.</li>
<li><b>Zamawiający</b> bierze pełną odpowiedzialność za treści umieszczone na <b>Stronie WWW</b>.</li>
<li><b>Wykonawca</b> zobowiązuje się do realizacji prac w sposób profesjonalny, z dołożeniem należytej staranności oraz zgodnie ze wskazówkami i zaleceniami <b>Zamawiającego</b>.</li>
</ol>



<h1 align="center">§2</h1>

<h2 align="center">Warunki wykonywania prac</h2>

<ol>
<li><b>Wykonawca</b> zobowiązuje się świadczyć usługi określone w okresie obowiązywania niniejszej umowy codziennie za wyjątkiem dni ustawowo wolnych od pracy, świąt religijnych i państwowych.</li>
<li>Strony uzgadniają przesyłanie wszelkich informacji, materiałów lub propozycji przez pocztę e-mail na wskazany adres <b>Wykonawcy</b>.</li>
<li>Czas wprowadzenia i udostępnienia na <b>Stronie WWW</b> dostarczonych tekstów lub zdjęć nie będzie dłuższy niż 48 godzin. W przypadku gdy czas publikacji wypadnie w dzień wolny od pracy, zmiany zostaną opublikowane w następny dzień po wydającym (wypadających) dniu wolnym od pracy.</li>
<li><b>Zamawiający</b> udostępni <b>Wykonawcy</b> dostęp do docelowego serwera FTP i domeny gdzie docelowo będą funkcjonowały <b>Strony WWW</b> wraz z niezbędnymi uprawnieniami niezbędnymi do prowadzenie i wykonania prac.</li>
<li><b>Zamawiającemu</b> w każdym momencie realizacji przysługuje prawo do wglądu w aktualny stan prac.</li>
<li><b>Wykonawca</b> dołoży należytej staranności aby z wszelkich materiałów publikowanych na <b>Stronie WWW</b> eliminować treści niezgodne z polskim prawem, dobrymi obyczajami, wywołujące oburzenie, nawołujące do łamania prawa, przemocy, godzące w wizerunek osób, firm i instytucji prywatnych, publicznych oraz państwowych.</li>
</ol>



<h1 align="center">§3</h1>

<h2 align="center">Wynagrodzenie i warunki płatności</h2>

<ol>
<li>Za usługi określone w <b>§ 1</b> i <b>Załączniku nr 1</b>, <b>Wykonawca</b> otrzymywać będzie zryczałtowane wynagrodzenie w wysokości <b><?php echo str_replace('.00', '', number_format($umowa['wynagrodzenie'], 2, '.', ' '));?></b> zł. netto (słownie: <b><?php echo $wynagrodzenie_slownie;?></b>) miesięcznie płatne z dołu na podstawie faktury VAT wystawianej na koniec każdego miesiąca kalendarzowego.</li>
<li>Do ceny zostanie doliczony podatek VAT w wysokości zgodnej z obowiązującymi na dzień wystawienia faktury VAT przepisami.</li>
<li><b>Zamawiający</b> zachowuje autorskie prawa majątkowe do wszystkich zamieszczonych na stronie materiałów oraz zmian wykonanych na <b>Stronie WWW</b> w ramach niniejszej umowy.</li>
<li>Kwota wynagrodzenia płatna będzie w terminie 7 dni od daty doręczenia Zamawiającemu faktury VAT.</li>
<li>Do chwili wypłacenia wynagrodzenia należnego <b>Wykonawcy</b> wynagrodzenia, zmiany i modyfikacje wykonane na <b>Stronie WWW</b> w danym okresie rozliczeniowym w ramach niniejszej Umowy pozostają jego własnością. </li>
<li>Z chwilą zapłaty pełnej kwoty wynagrodzenia określonego w niniejszym paragrafie <b>Wykonawca</b> przenosi, a <b>Zamawiający</b> nabywa majątkowe prawa autorskie do zmian wykonanych na <b>Stronie WWW</b> w ramach niniejszej Umowy w danym okresie rozliczeniowym.</li>
</ol>



<h1 align="center">§4</h1>

<h2 align="center">Ochrona tajemnicy</h2>

<ol>
<li>Strony zobowiązują się do utrzymania w tajemnicy i nie przekazywania osobom trzecim wszelkich informacji o warunkach niniejszej umowy, a dotyczących:<br />
&nbsp;&nbsp;&nbsp;&nbsp;a) utrzymania tajemnicy związanej z aplikacjami i dokumentacją,<br />
&nbsp;&nbsp;&nbsp;&nbsp;b)danych uzyskanych w czasie realizacji przedmiotu umowy o przedsiębiorstwie i działalności drugiej ze stron, o ile informacje takie nie są powszechnie znane lub strona nie uzyskała uprzednio pisemnej zgody drugiej ze Stron.</li>
<li>Treść niniejszej umowy stanowi tajemnicę handlową i może zostać ujawniona jedynie uprawnionym organom, bądź w celu wykonania ciążących na którejkolwiek ze Stron obowiązków w sposób wyraźny przez przepisy prawa, bądź w celu realizacji praw należnych każdej ze Stron pod warunkiem, że pozostają w związku z niniejszą Umową.</li>
<li>Strony mogą wyjawić informację objętą tajemnicą tylko tym pracownikom lub podwykonawcom, którzy są bezpośrednio zaangażowani w wykonanie lub wykorzystanie aplikacji, pod warunkiem, że będą oni przestrzegać warunków związanych z ochroną tajemnicy.</li>
</ol>


<h1 align="center">§5</h1>

<h2 align="center">Postanowienia końcowe</h2>

<ol>
<?php
    $d_1 = explode('-', $umowa['data_rozpoczecia']);
    $rok_rozpoczecia = $d_1[0];
    $d = str_replace('01', 'stycznia', $d_1[1]);
    $d = str_replace('02', 'lutego', $d);
    $d = str_replace('03', 'marca', $d);
    $d = str_replace('04', 'kwietnia', $d);
    $d = str_replace('05', 'maja', $d);
    $d = str_replace('06', 'czerwca', $d);
    $d = str_replace('07', 'lipca', $d);
    $d = str_replace('08', 'sierpnia', $d);
    $d = str_replace('09', 'września', $d);
    $d = str_replace('10', 'paźdzernika', $d);
    $d = str_replace('11', 'listopada', $d);
    $d = str_replace('12', 'grudnia', $d);
?>
<li>Umowa niniejsza obowiązuje od miesiąca <?php echo $d;?> <?php echo $rok_rozpoczecia;?> roku i zostaje zawarta na czas nieoznaczony.</li>
<li>Okres wypowiedzenia Umowy wynosi 1 (jeden) miesiąc.</li>
<li>Wszelkie zmiany treści niniejszej Umowy wymagają dla swej ważności zachowania formy pisemnej - aneksu do Umowy.</li>
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