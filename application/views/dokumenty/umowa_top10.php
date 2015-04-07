<?php
    $frazy_ryczalt = false;
    $frazy_top_10 = false;
    foreach($frazy as $fraza){
        if($fraza['typ'] == 1) $frazy_top_10 = true;
        if($fraza['typ'] == 2) $frazy_ryczalt = true;
    }
?><html>
    <body>

<h3 align="center">Umowa  nr 1/P/<?php echo $klient['id_klienta'];?>/<?php echo date("Y");?></h3>

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
<li><b>Zlecający</b> oświadcza że jest właścicielem strony internetowej umieszczonej pod adresem <?php echo $klient['adres_strony'];?> zwanej dalej <b>Stroną WWW</b>.</li>
<li><b>Zlecający</b> zleca <b>Wykonawcy</b> usługę stałej optymalizacji <b>Strony WWW</b>, mającej na celu poprawienie jej pozycji w wyszukiwarce Google dla wybranych słów kluczowych.</li>
<li>Działania <b>Wykonawcy</b> wymienione w p. 2 niniejszego paragrafu obejmują w szczególności :
<ol type="a">
<li>wyczyszczenie kodu ze zbędnych funkcji;</li>
<li>stałą optymalizację kodu pod katem lepszej widoczności <b>Strony WWW</b> dla robotów wyszukiwarki Google;</li>
<li>stałą optymalizację treści i układu <b>Strony WWW</b>;</li>
<li>uzgadnianie  treści i zakresu zmian ze <b>Zlecającym</b>;</li>
<li>uzgadnianie warunków technicznych zmian ze <b>Zlecającym</b>;</li>
<li>przeprowadzenie pozostałych niezbędnych uzgodnień związanych z przebiegiem zmian ze <b>Zlecającym</b>;</li>
<li>zarządzanie procesem wyświetlania pozycji strony na zadane frazy w Google;</li>
<li>dostarczanie uzgodnionej dokumentacji i statystyk z przebiegu optymalizacji zainteresowanym stronom.</li>
</ol>
</li>
<li>Lista słów kluczowych o których mowa w pkt. 2 niniejszego paragrafu określona jest w załączniku nr 1 do niniejszej Umowy.</li>
<li>Aby wspomóc proces poprawiania pozycji Strony WWW w wyszukiwarce Google <b>Wykonawca</b> może prowadzić również inne działania reklamowe w Internecie.</li>
</ol>

 

<h1 align="center">§2</h1>

<h2 align="center">Warunki wykonywania prac</h2>

<ol>
<li><b>Strony</b> uzgadniają przesyłanie wszelkich informacji, materiałów lub propozycji przez pocztę e-mail na wskazane adresy <b>Zlecającego i Wykonawcy.</b></li>
<li>Na żądanie każdej ze <b>Stron</b> wszystkie ustalenia związane z realizacją niniejszej Umowy zostaną potwierdzone pisemnie.</li>
<li><b>Zlecającemu</b> w każdym momencie prowadzenia prac przysługuje prawo do wglądu w aktualny stan ich przebiegu.</li>
<li><b>Zlecający</b> zachowuje autorskie prawa majątkowe do wszystkich zamieszczonych na stronie własnych materiałów, w tym własnych, wymaganych na ogłoszeniach wzorów graficznych, logotypów i innych materiałów.</li>
<li><b>Wykonawca</b> ma prawo w każdym momencie wstrzymać wykonywanie prac i odmówić ich wykonywania w przypadku umieszczania na <b>Stronie WWW</b> treści i materiałów niezgodnych z polskim prawem, dobrymi obyczajami, wywołujących oburzenie, nawołujących do łamania prawa, przemocy, naruszających dobre imię osób trzecich  itp.</li>
</ol>

 

<h1 align="center">§3</h1>

<h2 align="center">Wynagrodzenie i warunki płatności </h2>

<ol>
<li>Usługi wymienione w <b>§1</b> mogą być wykonywane i rozliczane dla wybranych fraz w dwóch wariantach : wg zasady stałej opłaty ryczałtowej (<b>Wariant Ryczałtowy</b>) lub wg uzyskanej pozycji strony w wyszukiwarce Google na wskazane frazy (<b>Wariant TOP10</b>).</li>
<li>W przypadku <b>Wariantu Ryczałtowego</b> dla wybranych fraz naliczana jest stała ryczałtowa opłata płatna miesięcznie. W takim wypadku za usługi wymienione w  <b>§1 Wykonawca</b> otrzymywać będzie uzgodnione, stałe wynagrodzenie, w kwocie określonej w załączniku nr 1 do niniejszej Umowy, płatne z dołu na podstawie faktury VAT wystawianej na koniec każdego miesiąca kalendarzowego.</li>
<li>W przypadku <b>Wariantu TOP10</b> za usługi wymienione w <b>§1 Wykonawca</b> otrzymywać będzie uzgodnione, zmienne wynagrodzenie, uzależnione od pozycji strony na dane słowo kluczowe lub frazę w wyszukiwarce Google.  W takim wypadku kwota wynagrodzenia naliczana jest cząstkowo za każdy dzień, w zależności od uzyskanej pozycji strony w danym dniu w wyszukiwarce Google i fakturowana zbiorczo na koniec każdego miesiąca kalendarzowego.</li>
<li>Lista fraz dla Wariantu Ryczałtowego oraz Wariantu TOP10 wraz ze specyfikacją kwot i wyceną prac określona jest w załączniku nr 1 do niniejszej Umowy.</li>
<li>Do ceny zostanie doliczony podatek VAT w wysokości zgodnej z obowiązującymi na dzień wystawienia faktury VAT przepisami.</li>
<li>Kwota wynagrodzenia płatna będzie w terminie 7 dni od daty otrzymania faktury VAT.</li>
<li>W przypadku braku wpływu pełnej kwoty z tytułu wystawionej faktury VAT na konto <b>Wykonawcy</b> w terminie określonym w pkt. 6 powyżej, może on wstrzymać świadczenie usług będących przedmiotem niniejszej Umowy na rzecz <b>Zlecającego</b> do momentu całkowitego uregulowania należności.</li>
<li>W sytuacji mającej miejsce opisanej w pkt. 7 powyżej wyłącza się jakąkolwiek odpowiedzialność <b>Wykonawcy</b> wynikającą z tytułu wstrzymania świadczenia usług oraz wahań wyników wyszukiwania uzgodnionych fraz w wyszukiwarce Google.</li>
</ol>

 

<h1 align="center">§4</h1>

<h2 align="center">Ochrona tajemnicy</h2>

<ol>
<li><b>Strony</b> zobowiązują się do utrzymania w tajemnicy i nie przekazywania osobom trzecim wszelkich informacji o warunkach niniejszej umowy, a dotyczących:
<ol>
<li>utrzymania tajemnicy związanej z aplikacjami i dokumentacją,</li>
<li>danych uzyskanych w czasie realizacji przedmiotu umowy o przedsiębiorstwie i działalności drugiej ze stron, o ile informacje takie nie są powszechnie znane lub strona nie uzyskała uprzednio pisemnej zgody drugiej ze <b>Stron</b>.</li>
</ol>
</li>
<li>Treść niniejszej umowy stanowi tajemnicę handlową i może zostać ujawniona jedynie uprawnionym organom, bądź w celu wykonania ciążących na którejkolwiek ze Stron obowiązków w sposób wyraźny przez przepisy prawa, bądź w celu realizacji praw należnych każdej ze Stron pod warunkiem, że pozostają w związku z niniejszą Umową.</li>
<li>Strony mogą wyjawić informację objętą tajemnicą tylko tym pracownikom lub podwykonawcom, którzy są bezpośrednio zaangażowani w wykonanie lub wykorzystanie aplikacji, pod warunkiem, że będą oni przestrzegać warunków związanych z ochroną tajemnicy.</li>
</ol>
 


<h1 align="center">§5</h1>

<h2 align="center">Postanowienia końcowe</h2>

<ol>
<li>Umowa niniejsza zostaje zawarta na czas nieokreślony.</li>
<?php if($frazy_ryczalt && !$frazy_top_10){ ?>

    <?php if($klient['id_klienta'] == 127){ ?>
        <li>Okres wypowiedzenia Umowy wynosi 30 dni, liczonych od dnia złożenia wypowiedzenia Umowy.</li>
    <?php }else{ ?>
        <li>Okres wypowiedzenia Umowy wynosi 1 (jeden) miesiąc kalendarzowy, liczony od następnego miesiąca, od dnia złożenia wypowiedzenia Umowy.</li>
    <?php } ?>

<?php }else{ ?>
    <li>Okres wypowiedzenia Umowy wynosi 3 (trzy) miesiące kalendarzowe, liczone od następnego miesiąca, od dnia złożenia wypowiedzenia Umowy.</li>
<?php } ?>
<li>Wszelkie zmiany treści niniejszej Umowy wymagają dla swej ważności zachowania formy pisemnej - aneksu do Umowy.</li>
<li>W sprawach nie uregulowanych niniejszą Umową zastosowanie mają przepisy Kodeksu Cywilnego, ustawy Prawo autorskie i prawa pokrewne i innych właściwych przepisów prawa.</li>
<li>Wszelkie spory wynikłe z wykonywania postanowień niniejszej Umowy Strony zobowiązują się rozwiązywać polubownie na drodze negocjacji. W razie braku porozumienia spory rozstrzygał będzie sąd właściwy dla miejsca siedziby pozwanego.</li>
<li>Umowę sporządzono w 2 jednobrzmiących egzemplarzach, po jednym dla każdej ze Stron.</li>
</ol>
 

<table>
    <tr>
        <td>
            <p align="center"><br />ZLECAJĄCY:</p>
        </td>
        <td>
            <p align="center"><br />WYKONAWCA:</p>
        </td>
    </tr>
</table>


    </body>
</html>