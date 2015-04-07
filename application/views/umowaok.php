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

<p align="center">zawarta w dniu .......................... roku we Wrocławiu pomiędzy :</p><br /><br />

<?php echo $klient['faktura_nazwa'] ? $klient['faktura_nazwa'] : '.............................................................';?><br />
<?php echo $klient['faktura_adres'] ? $klient['faktura_adres'] : '.............................................................';?><br />
<?php echo ($klient['faktura_kod_pocztowy'] && $klient['faktura_miejscowosc']) ? $klient['faktura_kod_pocztowy'].' '.$klient['faktura_miejscowosc'] : '.............................................................';?><br />
REGON : <?php echo $klient['regon'] ? $klient['regon'] : '.............................................................';?><br />
numer NIP : <?php echo $klient['nip'] ? $klient['nip'] : '.............................................................';?><br />
Osoba reprezentująca: <?php echo $klient['reprezentant'] ? $klient['reprezentant'] : '.............................................................';?>, zwanym dalej „<b>Zlecającym</b>”, 

<br /><br />
a<br /><br />

<?php echo AGREEMENT_COMPANY_DATA;?>, zwanym dalej „<b>Wykonawcą</b>”.  



<h1 align="center">§ 1</h1>

<h2 align="center">Przedmiot Umowy<br /></h2>

<ol>
<li><b>Zlecający</b> oświadcza:
    <ol type="a">
        <li>że przysługują mu autorskie prawa majątkowe (lub licencja) do strony internetowej umieszczonej pod adresem <b><?php echo $klient['adres_strony'];?></b> zwanej dalej <b>Stroną WWW</b>, uprawniające do korzystania ze <b>Strony WWW</b>, w tym do dokonywania zmian w kodzie lub treści,</li>
        <li>że przysługują mu prawa do domeny pod adresem wskazanym w lit. a</li>
    </ol>
</li>
<li><?php if($frazy_ryczalt){ ?><b>Zlecający</b> zleca <b>Wykonawcy</b>, a <b>Wykonawca</b> zobowiązuje się za wynagrodzeniem ryczałtowym, o którym mowa w § 5, do działań mających na celu poprawę i utrzymanie wysokiej pozycji <b>Strony WWW</b> na liście wyników wyszukiwania przy użyciu wyszukiwarki Google na wybrane przez strony frazy i słowa kluczowe, zwanych dalej przez <b>Strony</b> Optymalizacją Pozycji.<?php }else{ ?><b>Zlecający</b> zleca <b>Wykonawcy</b>, a <b>Wykonawca</b> zobowiązuje się za wynagrodzeniem w ramach <b>wariantu PIERWSZA STRONA</b>, o którym mowa w § 5, do działań mających na celu poprawę i utrzymanie <b>Strony WWW</b> na pierwszej stronie wyników wyszukiwania przy użyciu wyszukiwarki Google na wybrane przez strony frazy i słowa kluczowe, zwanych dalej przez <b>Strony</b> Optymalizacją Pozycji.<?php } ?></li>
<li>Lista słów kluczowych i fraz, o których mowa w niniejszym paragrafie określona jest w załączniku nr 1, stanowiącym integralną część niniejszej Umowy.</li>
<li>Aby wspomóc proces Optymalizacji Pozycji <b>Strony WWW</b> w wyszukiwarce Google <b>Wykonawca</b> może prowadzić również inne działania reklamowe w Internecie lub korzystać z usług świadczonych przez zewnętrznych dostawców.</li>
<li>Na potrzeby niniejszej umowy, pozycją <b>Strony WWW</b> określane będzie miejsce na liście wyników wyszukiwarki Google.pl, na którym widnieje <b>Strona WWW</b> po wpisaniu danej frazy, nie biorąc pod uwagę reklam oraz linków sponsorowanych.</li>
<li><b>Wykonawca</b> zobowiązuje się świadczyć usługi objęte niniejszą umową z należytą starannością, jednakże nie będzie odpowiedzialny względem <b>Zlecającego</b> za jakiekolwiek działania osób trzecich (nie współpracujących na zlecenie <b>Wykonawcy</b> przy realizacji niniejszej umowy), zmiany algorytmu wyszukiwania czy też błędy w kodzie wyszukiwarki.</li>
<li>Usługi świadczone w oparciu o niniejszą umowę dotyczyć będą wyłącznie jednego adresu, wskazanego w ust. 1. Zmiana adresu <b>Strony WWW</b> lub listy fraz (słów kluczowych) nie jest możliwa w trakcie obowiązywania niniejszej umowy, chyba że <b>Strony</b> pisemnie postanowią inaczej. Zmiana adresu <b>Strony WWW</b> lub listy fraz stanowić będzie zmianę niniejszej umowy, dokonywaną w trybie określonym w § 8 ust. 1.</li>
</ol> 

<h1 align="center">§ 2</h1>

<h2 align="center">Obowiązki Wykonawcy<br /></h2>

<ol>
<li>W ramach Optymalizacji Pozycji <b>Wykonawca</b> zobowiązuje się w szczególności do:
    <ol type="a">
        <li>prowadzenia procesu Optymalizacji Pozycji <b>Strony WWW</b> na frazy określone w załączniku nr 1 do niniejszej Umowy, w wyszukiwarce Google;</li>
        <li>dostarczania <b>Zlecającemu</b> dokumentacji pozycji <b>Strony WWW</b> w wyszukiwarce Google;</li>
        <li>wykonania jednorazowo optymalizacji kodu źródłowego <b>Strony WWW</b> pod kątem lepszej jej widoczności przez wyszukiwarkę Google.</li>
        <li>utrzymywanie fraz z listy -Załącznik 1- na pierwszej stronie w wyszukiwarce - z   równoczesnym zmaksymalizowaniem poz. 1-5 i jednoczesnym polepszaniem pozycji w   poszczególnych miesiącach.</li>
    </ol>
</li>
<li>W wykonaniu obowiązku, o którym mowa w ust. 1 a), <b>Wykonawca</b> na następujący adres e-mail <b>Zlecającego</b>: <?php echo $klient['mail'];?> przekazuje raport zawierający historię pozycji zajmowanej przez <b>Stronę WWW</b> w danym miesiącu. <b>Wykonawca</b> udostępni także <b>Zlecającemu</b> dostęp do panelu administracyjnego umożliwiający <b>Zlecającemu</b> bieżące monitorowanie pozycji <b>Strony WWW</b>.</li>
<li><b>Wykonawca</b> zobowiązuje się do dokonywania Optymalizacji Pozycji wyłącznie w oparciu o metody zgodne z etycznymi, powszechnymi zwyczajami społeczności internetowej oraz obowiązującymi przepisami prawa.</li>
<li><strong>Wykonawca</strong> jest zobowiązany do przekazania Zlecającemu w momencie podpisywania   umowy wszelkich haseł ,kodów, loginów  do serwera na którym będzie przechowywana   strona intenetowa.</li>
</ol>

 

<h1 align="center">§ 3</h1>

<h2 align="center">Obowiązki Zlecającego<br /></h2>

<ol>
<li><b>Zlecający</b> zobowiązuje się do:
    <ol type="a">
        <li>przekazania na wezwanie <b>Wykonawcy</b>, dla potrzeb wykonania optymalizacji kodu <b>Strony WWW</b>, informacji umożliwiających dostęp:
            <ul>
                <li>do plików źródłowych <b>Strony WWW</b> (serwera ftp) - login i hasło,</li>
                <li>do panelu administracyjnego CMS (zarządzania <b>Stroną WWW</b>) – login i hasło,</li>
            </ul>
        </li>
        <li>niedokonywania zmian w plikach źródłowych <b>Strony WWW</b> oraz znaczących zmian treści <b>Strony WWW</b> bez uprzedniej zgody <b>Wykonawcy</b>.</li>
        <li>uiszczania wynagrodzenia zgodnie z postanowieniami niniejszej Umowy.</li>
    </ol>
</li>
<li><b>Zlecający</b> oświadcza, że nie korzysta, jak również nie będzie korzystał w trakcie obowiązywania niniejszej umowy, z usług innych podmiotów zajmujących się pozycjonowaniem <b>Strony WWW</b>.</li>
<li><b>Wykonawca</b> nie ponosi odpowiedzialności za nienależyte wykonanie zobowiązania, wskutek naruszenia przez <b>Zlecającego</b> obowiązku, o którym mowa w ust. 2.</li>
<li><b>Zlecający</b> wyraża zgodę na wprowadzenie zmian przez <b>Wykonawcę</b> w kodzie źródłowym <b>Strony WWW</b> dla potrzeb wykonania optymalizacji kodu <b>Strony WWW</b>.</li>
</ol>

 

<h1 align="center">§ 4</h1>

<h2 align="center">Warunki wykonywania prac<br /></h2>

<ol>
<li><b>Strony</b> uzgadniają przesyłanie wszelkich informacji, materiałów lub propozycji przez pocztę e-mail na wskazane adresy <b>Zlecającego</b> i <b>Wykonawcę</b>.</li>
<li>Wszystkie zgłoszenia lub ustalenia przekazywane telefoniczne lub ustnie dotyczące realizacji Umowy wymagają dla swej ważności potwierdzenia przez pocztę e-mail.</li>
<li>Na żądanie każdej ze <b>Stron</b> wszystkie zgłoszenia lub ustalenia związane z realizacją niniejszej Umowy zostaną potwierdzone pisemnie.</li>
<li><b>Wykonawca</b> ma prawo w każdym momencie wstrzymać wykonywanie prac i odmówić ich wykonywania w przypadku umieszczania na <b>Stronie WWW</b> treści i materiałów niezgodnych z polskim prawem, dobrymi obyczajami, wywołujących oburzenie, nawołujących do łamania prawa, przemocy, naruszających dobre imię osób trzecich  itp.</li>
</ol>
 


<h1 align="center">§ 5</h1>

<h2 align="center">Wynagrodzenie i warunki płatności<br /></h2>

<?php if($frazy_ryczalt){ ?>
<ol>
<li>Za wykonanie usługi Optymalizacji Kodu <b>Wykonawcy</b> należne jest wynagrodzenie w kwocie określonej przez <b>Strony</b> w załączniku nr 1 do niniejszej Umowy.</li>
<li>Za wykonywanie pozostałych usług określonych w §2 niniejszej Umowy <b>Wykonawcy</b> należne jest stałe wynagrodzenie określane przez <b>Strony</b> wynagrodzeniem ryczałtowym płatne co miesiąc z dołu na podstawie faktury VAT wystawianej przez <b>Wykonawcę</b> pod koniec okresu rozliczeniowego, w kwocie określonej przez <b>Strony</b> w załączniku nr 1 do niniejszej Umowy.</li>
<li>Do ceny zostanie doliczony podatek VAT w wysokości zgodnej z obowiązującymi na dzień wystawienia faktury VAT przepisami.</li>
<li>Lista fraz wraz z wynagrodzeniem określona jest w załączniku nr 1 do niniejszej Umowy.</li>
<li>Kwota wynagrodzenia o którym mowa w ust. 2 powyżej płatna będzie w terminie do 7 dni każdego miesiąca w którym usługa będzie wykonywana, na podstawie faktury VAT.</li>
<li><b>Zlecający</b> wyraża zgodę na przesyłanie faktur VAT drogą elektroniczną w formie plików PDF lub równoważnych, gwarantujących integralność zawartych danych. Faktury będą przesyłane na następujący adres e-mail <b>Zlecającego</b>: <?php echo $klient['mail'];?></li>
<li><b>Zlecający</b> będzie upoważniony do zmiany adresu e-mail, na który przesyłane będą faktury VAT, lub cofnięcia zgody na przesyłanie faktur drogą elektroniczną, na zasadach określonych w przepisach prawa podatkowego.</li>
<li>W przypadku braku wpływu pełnej kwoty z tytułu wystawionej faktury VAT na konto <b>Wykonawcy</b> w terminie określonym w ust. 5 powyżej, może on wstrzymać świadczenie usług będących przedmiotem niniejszej Umowy, do momentu całkowitego uregulowania należności.</li>
<li>W sytuacji opisanej w ust. 8 powyżej wyłącza się jakąkolwiek odpowiedzialność <b>Wykonawcy</b> wynikającą z tytułu wstrzymania świadczenia usług oraz wahań pozycji <b>Strony WWW</b> na zadane frazy i słowa kluczowe w wyszukiwarce Google.</li>
</ol>
<?php }else{ ?>
<ol>
<li>Za wykonanie usługi Optymalizacji Kodu <b>Wykonawcy</b> należne jest wynagrodzenie w kwocie określonej przez <b>Strony</b> w załączniku nr 1 do niniejszej Umowy.</li>
<li>Za wykonywanie pozostałych usług określonych w §2 niniejszej Umowy, <b>Wykonawcy</b> należne jest wynagrodzenie, określone przez <b>Strony</b> wynagrodzeniem w ramach <b>wariantu PIERWSZA STRONA</b>, uzależnione od pozycji <b>Strony WWW</b> w wyszukiwarce Google na wskazane frazy i obliczane w sposób następujący: w przypadku gdy <b>Strona WWW</b> na dane słowo kluczowe lub frazę zajmuje miejsce na <b>pierwszej stronie wyników</b> w wyszukiwarce Google, kwota wynagrodzenia naliczana jest cząstkowo za każdy dzień, w zależności od uzyskanej pozycji <b>Strony WWW</b> w danym dniu w wyszukiwarce Google i fakturowana zbiorczo każdego miesiąca kalendarzowego okresu pozycjonowania, zgodnie z raportem, o którym mowa w § 2.</li>
<li>Do ceny zostanie doliczony podatek VAT w wysokości zgodnej z obowiązującymi na dzień wystawienia faktury VAT przepisami.</li>
<li>W przypadku zmiany przez strony słów kluczowych lub fraz, Wykonawcy przysługuje wynagrodzenie nie mniejsze niż w wysokości odpowiadającej kwocie wynagrodzenia wynikającej z ostatniej wystawionej Zlecającemu faktury za usługi Optymalizacji Pozycji świadczone przy użyciu fraz i słów kluczowych przed dokonaniem ich zmiany przez Strony.</li>
<li>Lista fraz wraz z wynagrodzeniem określona jest w załączniku nr 1 do niniejszej Umowy.</li>
<li>Kwota wynagrodzenia płatna będzie do 7. dnia miesiąca następującego po miesiącu wykonania usługi.</li>
<li><b>Zlecający</b> wyraża zgodę na przesyłanie faktur VAT drogą elektroniczną w formie plików PDF lub równoważnych, gwarantujących integralność zawartych danych. Faktury będą przesyłane na następujący adres e-mail <b>Zlecającego</b>: <?php echo $klient['mail'];?></li>
<li><b>Zlecający</b> będzie upoważniony do zmiany adresu e-mail, na który przesyłane będą faktury VAT, lub cofnięcia zgody na przesyłanie faktur drogą elektroniczną, na zasadach określonych w przepisach prawa podatkowego.</li>
<li>W przypadku braku wpływu pełnej kwoty z tytułu wystawionej faktury VAT na konto Wykonawcy w terminie określonym w ust. 6 powyżej, może on wstrzymać świadczenie usług będących przedmiotem niniejszej Umowy, do momentu całkowitego uregulowania należności.</li>
<li>W sytuacji opisanej w ust. 9 powyżej wyłącza się jakąkolwiek odpowiedzialność <b>Wykonawcy</b> wynikającą z tytułu wstrzymania świadczenia usług oraz wahań pozycji <b>Strony WWW</b> na zadane frazy i słowa kluczowe w wyszukiwarce Google.</li>
</ol>
<?php } ?>


<h1 align="center">§ 6</h1>

<h2 align="center">Ochrona tajemnicy<br /></h2>

<ol>
<li><b>Strony</b> zobowiązują się do zachowania w tajemnicy wszystkich informacji o drugiej <b>Stronie</b> uzyskanych podczas współpracy w ramach niniejszej umowy, związanych z aplikacjami oraz przekazaną dokumentacją, zarówno w trakcie wykonywania zobowiązań wynikających z niniejszej umowy, jak i po jej rozwiązaniu.</li>
<li>Obowiązek zachowania w poufności informacji dotyczy w szczególności stosowanego przez <b>Wykonawcę</b> sposobu Optymalizacji Pozycji.</li>
<li>Klauzula poufności o której mowa w ust. 1 dotyczy także treści niniejszej umowy.</li>
<li><b>Strony</b> mogą ujawniać osobom trzecim informacje poufne, jeżeli uzyskały na to pisemną akceptację drugiej strony.</li>
<li>Zobowiązania do zachowania przez <b>Strony</b> w tajemnicy informacji poufnych nie narusza ujawnienie:
    <ol type="a">
        <li>informacji ogólnie dostępnych;</li>
        <li>informacji uzyskanych niezależnie od osoby trzeciej, która nie jest zobowiązana do zachowania poufności wobec <b>Stron</b> w odniesieniu do tych informacji;</li>
        <li>informacji, których ujawnienie jest obowiązkowe na podstawie przepisów prawa.</li>
    </ol>
</li>
<li>W przypadku naruszenia przez <b>Zlecającego</b> obowiązku zachowania w poufności informacji, o którym mowa w niniejszym paragrafie, będzie on zobowiązany do zapłaty na rzecz <b>Wykonawcy</b> kary umownej w kwocie odpowiadającej trzykrotności należności wskazanej w ostatniej wystawionej przez <b>Wykonawcę</b> na rzecz <b>Zlecającego</b> fakturze VAT. <b>Wykonawca</b> jest uprawniony do dochodzenia odszkodowania przewyższającego wysokość zastrzeżonej kary umownej.</li>
<li><b>Strony</b> mogą wyjawić informację objętą tajemnicą tylko tym pracownikom lub podwykonawcom, którzy są bezpośrednio zaangażowani w wykonanie lub wykorzystanie aplikacji, pod warunkiem, że będą oni przestrzegać warunków związanych z ochroną tajemnicy.</li>
</ol>


<h1 align="center">§ 7</h1>

<h2 align="center">Czas trwania<br /></h2>

<?php if($frazy_ryczalt){ ?>

    <?php if($klient['umowa_czas_okreslony']){ ?>

<ol>
<li>Niniejsza Umowa zostaje zawarta na czas określony od dnia <?php echo texts::nice_date($klient['umowa_czas_okreslony_od']);?> do dnia <?php echo texts::nice_date($klient['umowa_czas_okreslony_do']);?>.</li>
<li>W przypadku naruszenia przez <b>Zlecającego</b> obowiązku poufności, o którym mowa w § 6, <b>Wykonawca</b> może rozwiązać niniejsza umowę ze skutkiem natychmiastowym. Niezależnie od rozwiązania umowy, <b>Wykonawca</b> jest uprawniony do naliczenia kary umownej stosownie do § 6, jak również do żądania odszkodowania przenoszącego wysokość zastrzeżonej kary.</li>
<li><b>Wykonawca</b> jest uprawniony do rozwiązania umowy ze skutkiem natychmiastowym w przypadku zaległości <b>Zlecającego</b> w zapłacie należności za dwa okresy płatności tj. kwot wynikających z dwóch ostatnich wystawionych przez <b>Wykonawcę</b> faktur.</li>
</ol>

    <?php }else{ ?>

<ol>
<li>Niniejsza Umowa zostaje zawarta na czas nieokreślony.</li>
<li>Każda ze <b>Stron</b> może rozwiązać niniejszą umowę za pisemnym wypowiedzeniem.</li>
<li>Okres wypowiedzenia umowy wynosi 1 (jeden) miesiąc kalendarzowy, liczony od nastepnego okresu rozliczeniowego, następującego po dniu złożenia wypowiedzenia Umowy.</li>
<li>W przypadku naruszenia przez Zlecającego obowiązku poufności, o którym mowa w § 6, <b>Wykonawca</b> może rozwiązać niniejszą umowę ze skutkiem natychmiastowym. Niezależnie od rozwiązania umowy, <b>Wykonawca</b> jest uprawniony do naliczenia kary umownej stosownie do § 6, jak również do żądania odszkodowania przenoszącego wysokość zastrzeżonej kary.</li>
<li><b>Wykonawca</b> jest uprawniony do rozwiązania umowy ze skutkiem natychmiastowym w przypadku zaległości <b>Zlecającego</b> w zapłacie należności za dwa okresy płatności tj. kwot wynikających z dwóch ostatnich wystawionych przez <b>Wykonawcę</b> faktur.</li>
</ol>

    <?php } ?>

<?php }else{ ?>

<ol>
<li>Niniejsza Umowa zostaje zawarta na czas nieokreślony.</li>
<li>Każda ze <b>Stron</b> może rozwiązać niniejszą umowę za pisemnym wypowiedzeniem.</li>
<li>Okres wypowiedzenia Umowy wynosi 3 (trzy) miesiące kalendarzowe, liczony od następnego miesiąca, następującego po dniu złożenia wypowiedzenia Umowy.</li>
<li>W przypadku naruszenia przez <b>Zlecającego</b> obowiązku poufności, o którym mowa w § 6, <b>Wykonawca</b> może rozwiązać niniejsza umowę ze skutkiem natychmiastowym. Niezależnie od rozwiązania umowy, <b>Wykonawca</b> jest uprawniony do naliczenia kary umownej stosownie do § 6, jak również do żądania odszkodowania przenoszącego wysokość zastrzeżonej kary.</li>
<li><b>Wykonawca</b> jest uprawniony do rozwiązania umowy ze skutkiem natychmiastowym w przypadku zaległości <b>Zlecającego</b> w zapłacie należności za dwa okresy płatności tj. kwot wynikających z dwóch ostatnich wystawionych przez <b>Wykonawcę</b> faktur.</li>
</ol>

<?php } ?>


<h1 align="center">§ 8</h1>

<h2 align="center">Postanowienia końcowe<br /></h2>

<ol>
<li>Wszelkie zmiany treści niniejszej Umowy wymagają dla swej ważności zachowania formy pisemnej - aneksu do Umowy.</li>
<li>W sprawach nie uregulowanych niniejszą Umową zastosowanie mają przepisy Kodeksu Cywilnego, ustawy o prawach autorskich i prawach pokrewnych i inne właściwe przepisy prawa.</li>
<li>Wszelkie spory wynikłe z wykonywania postanowień niniejszej Umowy <b>Strony</b> zobowiązują się rozwiązywać polubownie na drodze negocjacji. W razie braku porozumienia spory rozstrzygał będzie sąd właściwy dla miejsca siedziby <b>Wykonawcy</b>.</li>
<li>Umowę sporządzono w 2 jednobrzmiących egzemplarzach, po jednym dla każdej ze <b>Stron</b>.</li>
<li>Integralną częścią do umowy jest Załącznik 1.</li>
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