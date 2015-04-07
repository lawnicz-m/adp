-- sesje
CREATE TABLE IF NOT EXISTS sesje(
    cookie VARCHAR(25) NOT NULL,
    expire VARCHAR(11) NOT NULL,
    name VARCHAR(25) NOT NULL,
    value TEXT NOT NULL
)ENGINE = MyISAM DEFAULT CHARSET utf8;


-- partnerzy
CREATE TABLE IF NOT EXISTS partnerzy(
    data_utworzenia DATE NOT NULL DEFAULT '0000-00-00',
    haslo VARCHAR(50) NOT NULL,
    id_partnera INT UNSIGNED NOT NULL AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    nazwa VARCHAR(250) NOT NULL,
PRIMARY KEY (id_partnera)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- klienci
CREATE TABLE IF NOT EXISTS klienci(
    adres_korespondencyjny TEXT NOT NULL,
    adres_strony VARCHAR(250) NOT NULL,
    etap TINYINT UNSIGNED NOT NULL DEFAULT '1',
    dane_do_faktury TEXT NOT NULL,
    dane_kontaktowe TEXT NOT NULL,
    data_utworzenia DATE NOT NULL DEFAULT '0000-00-00',
    data_nastepnego_kontaktu DATE NOT NULL DEFAULT '0000-00-00',
    data_pierwszego_kontaktu DATE NOT NULL DEFAULT '0000-00-00',
    hash VARCHAR(32) NOT NULL,
    id_klienta INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_partnera INT UNSIGNED NOT NULL DEFAULT '0',
    id_pozycjonera INT UNSIGNED NOT NULL DEFAULT '1',
    kwota_ryczaltu FLOAT UNSIGNED NOT NULL DEFAULT '0',
    minimalna_kwota_ryczaltu FLOAT UNSIGNED NOT NULL DEFAULT '0',
    mail VARCHAR(50) NOT NULL,
    nazwa VARCHAR(250) NOT NULL,
    notatka_do_nastepnego_kontaktu TEXT NOT NULL,
    top_10_1_od TINYINT UNSIGNED NOT NULL DEFAULT '1',
    top_10_1_do TINYINT UNSIGNED NOT NULL DEFAULT '3',
    top_10_2_od TINYINT UNSIGNED NOT NULL DEFAULT '4',
    top_10_2_do TINYINT UNSIGNED NOT NULL DEFAULT '6',
    top_10_3_od TINYINT UNSIGNED NOT NULL DEFAULT '7',
    top_10_3_do TINYINT UNSIGNED NOT NULL DEFAULT '10',
PRIMARY KEY (id_klienta)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- klienci notatki
CREATE TABLE IF NOT EXISTS klienci_notatki(
    data_utworzenia DATE NOT NULL DEFAULT '0000-00-00',
    id_klienta INT UNSIGNED NOT NULL DEFAULT '0',
    id_notatki INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tresc TEXT NOT NULL,
PRIMARY KEY (id_notatki)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- pozycjonerzy
CREATE TABLE IF NOT EXISTS pozycjonerzy(
    data_utworzenia DATE NOT NULL DEFAULT '0000-00-00',
    haslo VARCHAR(50) NOT NULL,
    id_pozycjonera INT UNSIGNED NOT NULL AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    nazwa VARCHAR(250) NOT NULL,
PRIMARY KEY (id_pozycjonera)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- frazy
CREATE TABLE IF NOT EXISTS frazy(
    id_frazy INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_klienta INT UNSIGNED NOT NULL,
    kwota_za_fraze FLOAT UNSIGNED NOT NULL DEFAULT '0',
    minimalna_kwota_za_fraze FLOAT UNSIGNED NOT NULL DEFAULT '0',
    nazwa VARCHAR(250) NOT NULL,
    typ TINYINT UNSIGNED NOT NULL DEFAULT '1',
PRIMARY KEY (id_frazy)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- admini
CREATE TABLE IF NOT EXISTS admini(
    data_utworzenia DATE NOT NULL DEFAULT '0000-00-00',
    haslo VARCHAR(50) NOT NULL,
    id_admina INT UNSIGNED NOT NULL AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    nazwa VARCHAR(250) NOT NULL,
PRIMARY KEY (id_admina)) ENGINE = MyISAM DEFAULT CHARSET utf8;

INSERT IGNORE INTO admini SET data_utworzenia = '2010-06-12', haslo = 'test', id_admina = '1', login = 'admin', mail = 'anixa.pl@gmail.com', nazwa = 'Administrator';


-- frazy wyniki
CREATE  TABLE IF NOT EXISTS frazy_wyniki(
  data DATE NOT NULL DEFAULT '0000-00-00',
  id_frazy INT UNSIGNED NOT NULL DEFAULT '0',
  wynik INT UNSIGNED NOT NULL DEFAULT '0'
) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2010-06-14 OK
ALTER TABLE partnerzy ADD id_partnera_polecajacego INT UNSIGNED NOT NULL DEFAULT '0' AFTER id_partnera;
ALTER TABLE partnerzy ADD prowizja_partnera_polecajacego TINYINT UNSIGNED NOT NULL DEFAULT '5' AFTER nazwa;
ALTER TABLE partnerzy ADD prowizja_partnera TINYINT UNSIGNED NOT NULL DEFAULT '20' AFTER nazwa;
ALTER TABLE partnerzy ADD prowizja_partnera_prog INT UNSIGNED NOT NULL DEFAULT '500' AFTER prowizja_partnera_polecajacego;


-- 2010-06-15 OK
ALTER TABLE klienci ADD nip VARCHAR(50) NOT NULL AFTER nazwa;
ALTER TABLE klienci ADD regon VARCHAR(50) NOT NULL AFTER notatka_do_nastepnego_kontaktu;
ALTER TABLE klienci ADD faktura_adres VARCHAR(250) NOT NULL AFTER data_pierwszego_kontaktu;
ALTER TABLE klienci ADD faktura_kod_pocztowy VARCHAR(250) NOT NULL AFTER faktura_adres;
ALTER TABLE klienci ADD faktura_miejscowosc VARCHAR(250) NOT NULL AFTER faktura_kod_pocztowy;
ALTER TABLE klienci ADD faktura_nazwa VARCHAR(250) NOT NULL AFTER faktura_miejscowosc;
ALTER TABLE klienci ADD faktura_ulica VARCHAR(250) NOT NULL AFTER faktura_nazwa;
ALTER TABLE klienci ADD korespondencja_adres VARCHAR(250) NOT NULL AFTER id_pozycjonera;
ALTER TABLE klienci ADD korespondencja_kod_pocztowy VARCHAR(250) NOT NULL AFTER korespondencja_adres;
ALTER TABLE klienci ADD korespondencja_miejscowosc VARCHAR(250) NOT NULL AFTER korespondencja_kod_pocztowy;
ALTER TABLE klienci ADD korespondencja_nazwa VARCHAR(250) NOT NULL AFTER korespondencja_miejscowosc;
ALTER TABLE klienci ADD korespondencja_ulica VARCHAR(250) NOT NULL AFTER korespondencja_nazwa;
ALTER TABLE klienci DROP adres_korespondencyjny;
ALTER TABLE klienci DROP dane_do_faktury;
ALTER TABLE klienci DROP faktura_ulica;
ALTER TABLE klienci DROP korespondencja_ulica;
ALTER TABLE klienci ADD data_rozpoczecia_pozycjonowania DATE NOT NULL DEFAULT '0000-00-00' AFTER data_pierwszego_kontaktu;
ALTER TABLE klienci ADD adres_strony_2 VARCHAR(250) NOT NULL AFTER adres_strony;


-- 2010-06-17
-- faktury vat OK
CREATE TABLE IF NOT EXISTS faktury_vat(
    data_sprzedazy DATE NOT NULL DEFAULT '0000-00-00',
    data_utworzenia DATE NOT NULL DEFAULT '0000-00-00',
    data_wystawienia DATE NOT NULL DEFAULT '0000-00-00',
    forma_zaplaty VARCHAR(50) NOT NULL DEFAULT 'Przelew',
    id_faktury INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_klienta INT UNSIGNED NOT NULL DEFAULT '0',
    id_towaru_lub_uslugi TINYINT UNSIGNED NOT NULL DEFAULT '0',
    kwota_brutto FLOAT UNSIGNED NOT NULL DEFAULT '0',
    kwota_netto FLOAT UNSIGNED NOT NULL DEFAULT '0',
    kwota_podatku FLOAT UNSIGNED NOT NULL DEFAULT '0',
    miejsce_sprzedazy VARCHAR(50) NOT NULL,
    nabywca_adres VARCHAR(100) NOT NULL,
    nabywca_kod_pocztowy VARCHAR(10) NOT NULL,
    nabywca_miejscowosc VARCHAR(50) NOT NULL,
    nabywca_nazwa VARCHAR(250) NOT NULL,
    nabywca_nip VARCHAR(25) NOT NULL,
    numer_faktury INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_id_partnera_1 INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_id_partnera_2 INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_1 TINYINT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_1_prog INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_2 TINYINT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_2_prog INT UNSIGNED NOT NULL DEFAULT '0',
    sprzedawca_adres VARCHAR(100) NOT NULL,
    sprzedawca_kod_pocztowy VARCHAR(10) NOT NULL,
    sprzedawca_miejscowosc VARCHAR(50) NOT NULL,
    sprzedawca_nazwa VARCHAR(50) NOT NULL,
    sprzedawca_nip VARCHAR(25) NOT NULL,
    status TINYINT UNSIGNED NOT NULL DEFAULT '0',
    stawka_podatku TINYINT UNSIGNED NOT NULL DEFAULT '22',
    termin_zaplaty DATE NOT NULL DEFAULT '0000-00-00',
PRIMARY KEY (id_faktury)) ENGINE = MyISAM DEFAULT CHARSET utf8;

ALTER TABLE partnerzy ADD saldo FLOAT UNSIGNED NOT NULL DEFAULT '0' AFTER prowizja_partnera_prog;

CREATE TABLE IF NOT EXISTS historia_salda_partnerow(
    data_utworzenia DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    id_partnera INT UNSIGNED NOT NULL DEFAULT '0',
    id_wpisu INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tresc VARCHAR(250) NOT NULL,
PRIMARY KEY (id_wpisu)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2010-06-22 OK
ALTER TABLE klienci ADD reprezentant VARCHAR(250) NOT NULL AFTER regon;


-- 2010-06-27 OK
ALTER TABLE klienci ADD osoba_kontaktowa VARCHAR(250) NOT NULL AFTER notatka_do_nastepnego_kontaktu;
ALTER TABLE klienci ADD telefon VARCHAR(250) NOT NULL AFTER reprezentant;
ALTER TABLE klienci ADD faktura_papierowa TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER faktura_nazwa;


-- 2010-06-28 OK
ALTER TABLE faktury_vat ADD adnotacje TEXT NOT NULL FIRST;


-- 2010-06-30 OK
ALTER TABLE klienci ADD odsetek_fraz_w_top_10_zmiana FLOAT SIGNED NOT NULL DEFAULT '0' AFTER notatka_do_nastepnego_kontaktu;


-- 2010-07-01 OK
CREATE TABLE IF NOT EXISTS towary_i_uslugi(
    id_towaru_lub_uslugi INT UNSIGNED NOT NULL AUTO_INCREMENT,
    jednostka_miary VARCHAR(250) NOT NULL,
    nazwa VARCHAR(250) NOT NULL,
    pkwiu VARCHAR(250) NOT NULL,
    stawka_vat TINYINT UNSIGNED NOT NULL DEFAULT '22',
PRIMARY KEY (id_towaru_lub_uslugi)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2010-07-01 OK
-- faktury vat pozycje
CREATE TABLE IF NOT EXISTS faktury_vat_pozycje(
    cena_netto FLOAT UNSIGNED NOT NULL DEFAULT '0',
    id_faktury INT UNSIGNED NOT NULL DEFAULT '0',
    id_pozycji INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_towaru_lub_uslugi INT UNSIGNED NOT NULL DEFAULT '0',
    ilosc FLOAT UNSIGNED NOT NULL DEFAULT '1',
    jednostka_miary VARCHAR(250) NOT NULL,
    kwota_brutto FLOAT UNSIGNED NOT NULL DEFAULT '0',
    kwota_netto FLOAT UNSIGNED NOT NULL DEFAULT '0',
    kwota_podatku FLOAT UNSIGNED NOT NULL DEFAULT '0',
    pkwiu VARCHAR(250) NOT NULL,
    prowizja_id_partnera_1 INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_id_partnera_2 INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_1 TINYINT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_1_prog INT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_2 TINYINT UNSIGNED NOT NULL DEFAULT '0',
    prowizja_partnera_2_prog INT UNSIGNED NOT NULL DEFAULT '0',
    stawka_vat TINYINT UNSIGNED NOT NULL DEFAULT '0',
    tytul VARCHAR(250) NOT NULL,
PRIMARY KEY (id_pozycji)) ENGINE = MyISAM DEFAULT CHARSET utf8;

-- kasowanie niepotrzebnych pól OK
ALTER TABLE faktury_vat DROP id_towaru_lub_uslugi;
ALTER TABLE faktury_vat DROP prowizja_id_partnera_1;
ALTER TABLE faktury_vat DROP prowizja_id_partnera_2;
ALTER TABLE faktury_vat DROP prowizja_partnera_1;
ALTER TABLE faktury_vat DROP prowizja_partnera_1_prog;
ALTER TABLE faktury_vat DROP prowizja_partnera_2;
ALTER TABLE faktury_vat DROP prowizja_partnera_2_prog;
ALTER TABLE faktury_vat DROP stawka_podatku;


-- 2010-07-05 OK
ALTER TABLE faktury_vat CHANGE kwota_brutto kwota_brutto DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat CHANGE kwota_netto kwota_netto DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat CHANGE kwota_podatku kwota_podatku DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat_pozycje CHANGE cena_netto cena_netto DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat_pozycje CHANGE ilosc ilosc DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat_pozycje CHANGE kwota_brutto kwota_brutto DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat_pozycje CHANGE kwota_netto kwota_netto DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE faktury_vat_pozycje CHANGE kwota_podatku kwota_podatku DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE frazy CHANGE kwota_za_fraze kwota_za_fraze DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE frazy CHANGE minimalna_kwota_za_fraze minimalna_kwota_za_fraze DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE klienci CHANGE kwota_ryczaltu kwota_ryczaltu DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE klienci CHANGE minimalna_kwota_ryczaltu minimalna_kwota_ryczaltu DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE klienci CHANGE odsetek_fraz_w_top_10_zmiana odsetek_fraz_w_top_10_zmiana DECIMAL(13,2) NOT NULL DEFAULT '0';
ALTER TABLE partnerzy CHANGE saldo saldo DECIMAL(13,2) NOT NULL DEFAULT '0';


-- 2010-07-10 OK
ALTER TABLE partnerzy ADD data_ostatniej_aktywnosci DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER nazwa;


-- 2010-07-13 OK
ALTER TABLE klienci ADD komentarz_do_wyceny TEXT NOT NULL AFTER id_pozycjonera;
ALTER TABLE klienci ADD faktury_za_pozycjonowanie TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER faktura_papierowa;


-- 2010-07-16 OK
ALTER TABLE partnerzy ADD telefon VARCHAR(250) NOT NULL AFTER saldo;
ALTER TABLE partnerzy ADD adres_strony VARCHAR(250) NOT NULL FIRST;


-- 2010-07-29 OK
ALTER TABLE klienci ADD data_sprawdzenia_wynikow DATE NOT NULL DEFAULT '0000-00-00' AFTER data_rozpoczecia_pozycjonowania;


-- 2010-07-31 OK
ALTER TABLE frazy ADD najlepsza_pozycja INT UNSIGNED NOT NULL DEFAULT '0' AFTER minimalna_kwota_za_fraze;


-- 2010-08-25 OK
ALTER TABLE faktury_vat ADD data_zaplaty DATE NOT NULL DEFAULT '0000-00-00' AFTER data_wystawienia;
ALTER TABLE faktury_vat ADD wplacona_kwota DECIMAL(13,2) NOT NULL DEFAULT '0' AFTER termin_zaplaty;


-- 2010-08-27 OK
ALTER TABLE faktury_vat ADD wyslana_mailem TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER wplacona_kwota;


-- 2010-08-30 OK
ALTER TABLE faktury_vat ADD wezwanie_mailowe_1 TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER termin_zaplaty;
ALTER TABLE faktury_vat ADD wezwanie_mailowe_1_data_wyslania DATE NOT NULL DEFAULT '0000-00-00' AFTER wezwanie_mailowe_1;
ALTER TABLE faktury_vat ADD wezwanie_mailowe_2 TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER wezwanie_mailowe_1_data_wyslania;
ALTER TABLE faktury_vat ADD wezwanie_mailowe_2_data_wyslania DATE NOT NULL DEFAULT '0000-00-00' AFTER wezwanie_mailowe_2;


-- 2010-09-06 OK
ALTER TABLE klienci ADD ga_haslo VARCHAR(250) NOT NULL AFTER faktury_za_pozycjonowanie;
ALTER TABLE klienci ADD ga_mail VARCHAR(250) NOT NULL AFTER ga_haslo;
ALTER TABLE klienci ADD ga_profil VARCHAR(250) NOT NULL AFTER ga_mail;

-- 2010-09-24 OK
ALTER TABLE faktury_vat ADD finalna_forma_zaplaty VARCHAR(250) NOT NULL DEFAULT 'Przelew' AFTER data_zaplaty;
ALTER TABLE faktury_vat ADD osoba_pobierajaca_gotowke VARCHAR(250) NOT NULL AFTER numer_faktury;


-- 2010-09-27 OK
-- umowy
CREATE TABLE IF NOT EXISTS umowy(
    id_klienta INT UNSIGNED NOT NULL DEFAULT '0',
    id_umowy INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nazwa VARCHAR(250) NOT NULL,
    numer VARCHAR(250) NOT NULL,
    termin_platnosci VARCHAR(250) NOT NULL DEFAULT '3',
    termin_realizacji VARCHAR(250) NOT NULL DEFAULT '14',
    typ_realizacji VARCHAR(250) NOT NULL DEFAULT 'Serwisu Internetowego',
    wynagrodzenie DECIMAL(13,2) NOT NULL DEFAULT '1000.00',
    wysokosc_zadatku VARCHAR(250) NOT NULL DEFAULT '40',
PRIMARY KEY (id_umowy)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2010-09-29 OK
-- faktury vat wplaty
CREATE TABLE IF NOT EXISTS faktury_vat_wplaty(
    data_wplaty DATE NOT NULL DEFAULT '0000-00-00',
    forma_zaplaty VARCHAR(250) NOT NULL DEFAULT 'Przelew',
    id_faktury INT UNSIGNED NOT NULL DEFAULT '0',
    id_wplaty INT UNSIGNED NOT NULL AUTO_INCREMENT,
    osoba_pobierajaca_gotowke VARCHAR(250) NOT NULL,
    wplacona_kwota DECIMAL(13,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (id_wplaty)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2010-10-05 OK
ALTER TABLE klienci ADD powod_usuniecia VARCHAR(250) NOT NULL AFTER osoba_kontaktowa;


-- 2010-10-06 OK
ALTER TABLE faktury_vat ADD zaliczka TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER wyslana_mailem;
ALTER TABLE faktury_vat ADD id_faktury_zaliczkowej INT UNSIGNED NOT NULL DEFAULT '0' AFTER id_faktury;


-- wezwania OK
CREATE TABLE IF NOT EXISTS faktury_vat_wezwania(
    adresat_adres VARCHAR(100) NOT NULL,
    adresat_kod_pocztowy VARCHAR(10) NOT NULL,
    adresat_miejscowosc VARCHAR(50) NOT NULL,
    adresat_nazwa VARCHAR(250) NOT NULL,
    data_wezwania DATE NOT NULL DEFAULT '0000-00-00',
    id_klienta INT UNSIGNED NOT NULL DEFAULT '0',
    id_wezwania INT UNSIGNED NOT NULL AUTO_INCREMENT,
    kwota_do_zaplaty DECIMAL(13,2) NOT NULL DEFAULT '0.00',
    miejscowosc_nadania VARCHAR(100) NOT NULL,
    nadawca_adres VARCHAR(100) NOT NULL,
    nadawca_kod_pocztowy VARCHAR(10) NOT NULL,
    nadawca_miejscowosc VARCHAR(50) NOT NULL,
    nadawca_nazwa VARCHAR(250) NOT NULL,
    pozostala_kwota DECIMAL(13,2) NOT NULL DEFAULT '0.00',
    wplacona_kwota DECIMAL(13,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (id_wezwania)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- wezwania pozycje OK
CREATE TABLE IF NOT EXISTS faktury_vat_wezwania_pozycje(
    calkowita_kwota_faktury DECIMAL(13,2) NOT NULL DEFAULT '0.00',
    data_wystawienia_faktury DATE NOT NULL DEFAULT '0000-00-00',
    id_pozycji INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_wezwania INT UNSIGNED NOT NULL DEFAULT '0',
    ilosc_dni_przeterminowanych INT UNSIGNED NOT NULL DEFAULT '0',
    numer_faktury VARCHAR(20) NOT NULL,
    termin_zaplaty_faktury DATE NOT NULL DEFAULT '0000-00-00',
    tytul_faktury VARCHAR(250) NOT NULL,
    zaplacona_kwota_faktury DECIMAL(13,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (id_pozycji)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2010-10-20 OK
ALTER TABLE umowy ADD typ_umowy VARCHAR(250) NOT NULL AFTER typ_realizacji;
ALTER TABLE umowy ADD data_rozpoczecia DATE NOT NULL DEFAULT '0000-00-00' FIRST;


-- 2010-11-08 OK
ALTER TABLE frazy_wyniki ADD pierwsza_strona TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER id_frazy;
ALTER TABLE klienci ADD komentarz_do_wynikow TEXT NOT NULL AFTER komentarz_do_wyceny;


-- 2010-11-30 OK
ALTER TABLE klienci ADD akceptacja_wynikow_na_pierwszej_stronie VARCHAR(250) NOT NULL AFTER adres_strony_2;

-- 2010-12-07 OK
ALTER TABLE klienci ADD ga_ukrywanie_listy_profili TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER ga_profil;

-- 2010-12-17 OK
ALTER TABLE faktury_vat ADD typ_uslugi_index TEXT NOT NULL AFTER termin_zaplaty;

-- 2010-12-21 OK
ALTER TABLE partnerzy ADD dane_kontaktowe TEXT NOT NULL AFTER adres_strony;
ALTER TABLE partnerzy ADD faktura_adres VARCHAR(250) NOT NULL AFTER data_utworzenia;
ALTER TABLE partnerzy ADD faktura_kod_pocztowy VARCHAR(250) NOT NULL AFTER faktura_adres;
ALTER TABLE partnerzy ADD faktura_miejscowosc VARCHAR(250) NOT NULL AFTER faktura_kod_pocztowy;
ALTER TABLE partnerzy ADD faktura_nazwa VARCHAR(250) NOT NULL AFTER faktura_miejscowosc;
ALTER TABLE partnerzy ADD faktura_papierowa TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER faktura_nazwa;
ALTER TABLE partnerzy ADD indywidualny TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER id_partnera_polecajacego;
ALTER TABLE partnerzy ADD korespondencja_adres VARCHAR(250) NOT NULL AFTER indywidualny;
ALTER TABLE partnerzy ADD korespondencja_kod_pocztowy VARCHAR(250) NOT NULL AFTER korespondencja_adres;
ALTER TABLE partnerzy ADD korespondencja_miejscowosc VARCHAR(250) NOT NULL AFTER korespondencja_kod_pocztowy;
ALTER TABLE partnerzy ADD korespondencja_nazwa VARCHAR(250) NOT NULL AFTER korespondencja_miejscowosc;
ALTER TABLE partnerzy ADD nip VARCHAR(50) NOT NULL AFTER nazwa;
ALTER TABLE partnerzy ADD osoba_kontaktowa VARCHAR(250) NOT NULL AFTER nip;
ALTER TABLE partnerzy ADD regon VARCHAR(50) NOT NULL AFTER prowizja_partnera_prog;
ALTER TABLE partnerzy ADD reprezentant VARCHAR(50) NOT NULL AFTER regon;

-- 2010-12-23 OK
ALTER TABLE faktury_vat_pozycje ADD wynagrodzenie_wykonawcy_id_partnera INT UNSIGNED NOT NULL DEFAULT '0' AFTER tytul;
ALTER TABLE faktury_vat_pozycje ADD wynagrodzenie_wykonawcy_kwota DECIMAL(13,2) NOT NULL DEFAULT '0' AFTER wynagrodzenie_wykonawcy_id_partnera;
ALTER TABLE faktury_vat ADD wykonawca_uslugi_index TEXT NOT NULL AFTER wplacona_kwota;

-- 2010-12-28 OK
CREATE TABLE IF NOT EXISTS wiadomosci(
    data_odczytania DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    data_potwierdzenia DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    data_wyslania DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    id_nadawcy INT UNSIGNED NOT NULL DEFAULT '0',
    id_odbiorcy INT UNSIGNED NOT NULL DEFAULT '0',
    id_wiadomosci INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tresc TEXT NOT NULL,
    typ_nadawcy VARCHAR(25) NOT NULL,
    typ_odbiorcy VARCHAR(25) NOT NULL,
    tytul VARCHAR(250) NOT NULL,
PRIMARY KEY (id_wiadomosci)) ENGINE = MyISAM DEFAULT CHARSET utf8;


-- 2011-01-12 OK
ALTER TABLE klienci ADD umowa_czas_okreslony TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER top_10_3_do;
ALTER TABLE klienci ADD umowa_czas_okreslony_do DATE NOT NULL DEFAULT '0000-00-00' AFTER umowa_czas_okreslony;
ALTER TABLE klienci ADD umowa_czas_okreslony_od DATE NOT NULL DEFAULT '0000-00-00' AFTER umowa_czas_okreslony_do;


ALTER TABLE faktury_vat ADD numer_faktury_proforma int(10) unsigned not null default '0' AFTER numer_faktury;
ALTER TABLE faktury_vat ADD proforma tinyint(3) unsigned not null default '0' after osoba_pobierajaca_gotowke;