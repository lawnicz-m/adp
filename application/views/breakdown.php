<?php

$this->load->view(
		'header',
		array(
				'uzytkownik' => $user
		)
);
?>
<div id="breakdown_filters">
	<h4>Znaleziono <?php echo $clientsCount; ?> klientów spełniających warunki filtrowania</h4>
	<form action="/klienci/breakdown/<?php echo $dateDay ?>/<?php echo $dateCalendar; ?>/" method="post">
		<label for="breakdown_filter_count">Ilu na stronie</label>
		<select id="breakdown_filter_count" name="breakdown_filter_count">
			<option value="5" <?php if($_SESSION['breakdown_filter_count'] == 5) {echo 'selected';}?>>5</option>
			<option value="10" <?php if($_SESSION['breakdown_filter_count'] == 10) {echo 'selected';}?>>10</option>
			<option value="15" <?php if($_SESSION['breakdown_filter_count'] == 15) {echo 'selected';}?>>15</option>
			<option value="20" <?php if($_SESSION['breakdown_filter_count'] == 20) {echo 'selected';}?>>20</option>
			<option value="25" <?php if($_SESSION['breakdown_filter_count'] == 25) {echo 'selected';}?>>25</option>
		</select>
		
		<label for="breakdown_filter_payment">Rozliczani?</label>
		<select id="breakdown_filter_payment" name="breakdown_filter_payment">
			<option value="0" <?php if($_SESSION['breakdown_filter_payment'] == 0) {echo 'selected';}?>>wszyscy</option>
			<option value="1" <?php if($_SESSION['breakdown_filter_payment'] == 1) {echo 'selected';}?>>rozliczani</option>
			<option value="2" <?php if($_SESSION['breakdown_filter_payment'] == 2) {echo 'selected';}?>>nierozliczani</option>
		</select>
		
		<label for="breakdown_filter_lump_sum">Ryczałt?</label>
		<select id="breakdown_filter_lump_sum" name="breakdown_filter_lump_sum">
			<option value="0" <?php if($_SESSION['breakdown_filter_lump_sum'] == 0) {echo 'selected';}?>>wszyscy</option>
			<option value="1" <?php if($_SESSION['breakdown_filter_lump_sum'] == 1) {echo 'selected';}?>>tylko ryczałt</option>
			<option value="2" <?php if($_SESSION['breakdown_filter_lump_sum'] == 2) {echo 'selected';}?>>bez ryczałtu</option>
		</select>
		
		<label for="breakdown_filter_problem">Problem?</label>
		<select id="breakdown_filter_problem" name="breakdown_filter_problem">
			<option value="0" <?php if($_SESSION['breakdown_filter_problem'] == 0) {echo 'selected';}?>>wszyscy</option>
			<option value="1" <?php if($_SESSION['breakdown_filter_problem'] == 1) {echo 'selected';}?>>tylko z problemem</option>
			<option value="2" <?php if($_SESSION['breakdown_filter_problem'] == 2) {echo 'selected';}?>>tylko bez problemów</option>
		</select>
		
		<?php if($user['typ'] == 'admin') { ?>
		
		<label for="breakdown_filter_gotlink">Gotlink?</label>
		<select id="breakdown_filter_gotlink" name="breakdown_filter_gotlink">
			<option value="0" <?php if($_SESSION['breakdown_filter_gotlink'] == 0) {echo 'selected';}?>>wszyscy</option>
			<option value="1" <?php if($_SESSION['breakdown_filter_gotlink'] == 1) {echo 'selected';}?>>tylko z GL</option>
			<option value="2" <?php if($_SESSION['breakdown_filter_gotlink'] == 2) {echo 'selected';}?>>tylko bez GL</option>
		</select>
		
		<?php } ?>
		
		<label for="breakdown_filter_vip">VIP?</label>
		<select id="breakdown_filter_vip" name="breakdown_filter_vip">
			<option value="0" <?php if($_SESSION['breakdown_filter_vip'] == 0) {echo 'selected';}?>>wszyscy</option>
			<option value="1" <?php if($_SESSION['breakdown_filter_vip'] == 1) {echo 'selected';}?>>tylko VIP</option>
			<option value="2" <?php if($_SESSION['breakdown_filter_vip'] == 2) {echo 'selected';}?>>tylko nie VIP</option>
		</select>
		
		<?php if($user['typ'] == 'admin') { ?>
		
		<label for="breakdown_filter_partner">Partner:</label>
		<select id="breakdown_filter_partner" name="breakdown_filter_partner">
			<option value="0">dowolny</option>
			<?php echo $partnersOptionHTML; ?>
		</select>
		
		<?php } ?>
		<br>
		
		<label for="breakdown_order_by">Sortuj</label>
		<select id="breakdown_order_by" name="breakdown_order_by">
			<option value="0" <?php if($_SESSION['breakdown_order_by'] == 0) {echo 'selected';}?>>Alfabetycznie</option>
			<option value="1" <?php if($_SESSION['breakdown_order_by'] == 1) {echo 'selected';}?>>Data utworzenia</option>
			<option value="2" <?php if($_SESSION['breakdown_order_by'] == 2) {echo 'selected';}?>>Następny kontakt</option>
			<option value="3" <?php if($_SESSION['breakdown_order_by'] == 3) {echo 'selected';}?>>Zmiana w TOP 10</option>
			<option value="4" <?php if($_SESSION['breakdown_order_by'] == 4) {echo 'selected';}?>>Liczba fraz na 1</option>
			<option value="5" <?php if($_SESSION['breakdown_order_by'] == 5) {echo 'selected';}?>>Procent fraz na 1</option>
			<option value="6" <?php if($_SESSION['breakdown_order_by'] == 6) {echo 'selected';}?>>Umowa od</option>
			<option value="7" <?php if($_SESSION['breakdown_order_by'] == 7) {echo 'selected';}?>>Priorytet</option>
		</select>
		
		<select id="breakdown_order" name="breakdown_order">
			<option value="0" <?php if($_SESSION['breakdown_order'] == 0) {echo 'selected';}?>>rosnąco</option>
			<option value="1" <?php if($_SESSION['breakdown_order'] == 1) {echo 'selected';}?>>malejąco</option>
		</select>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		<input type="submit" value="Ustaw filtry">
		<input name="breakdown_clear_filters" type="submit" value="Wyczyść filtry">
	</form>
</div>
<div class="breakdown_client_list">
	<div id="breakdown_pagin_menu">

		<?php if($page < $totalPages) { ?>
		<a
			href="/klienci/breakdown/<?php echo $dateDay ?>/<?php echo $dateCalendar; ?>/<?php echo $page+1; ?>"
			class="headButtons">Nast. strona</a>
		<?php }	?>

		<?php if($page > 1) { ?>
		<a
			href="/klienci/breakdown/<?php echo $dateDay ?>/<?php echo $dateCalendar; ?>/<?php echo $page-1; ?>"
			class="headButtons">Pop. strona</a>
		<?php } ?>

		<div class="clear"></div>
	</div>

	<?php if($clientsCount < 1) { ?>
		<div class="breakdown_client_row">
			<h3>Brak wyników dla wybranych kryteriów filtrowania</h3>
		</div>
	<?php } else { ?>
	
	<?php foreach($clients as $client) { ?>

	<div class="breakdown_client_row">
		<a name="klient_<?php echo $client['id_klienta']; ?>"> </a>
		<div class="breakdown_client_leftcolumn">
			<h2>
				<?php echo $client['nazwa']; ?><br>
				<a target="_blank"
					href="http://<?php echo $client['adres_strony']; ?>"><?php echo $client['adres_strony']; ?>
				</a>
			</h2>
			<h4>
				Handlowiec:
				<?php echo $client['partner_fullname']; ?>
			</h4>
			<h4>Notatka do następnego kontaktu: <br>
				<?php echo $client['notatka_do_nastepnego_kontaktu']; ?>
			</h4>
			<h4>
				<a target="_blank"
					href="/klienci/profil/<?php echo $client['id_klienta']; ?>">Profil klienta</a>
			</h4>
			
			<table border="0" cellpadding="0" cellspacing="0" id="frazy">
				<thead>
					<tr>
						<th>Fraza</th>
						<th>Pozycja</th>
						<th>Zmiana</th>
						<th>1 str.</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 0;
						foreach($client['wynikiDzis'] as $phrase) {
							$googleNum = 0;
							$tmp = $phrase['wynik'];
							while ($tmp - 10 > 0) {
								$tmp -= 10;
								$googleNum += 10;
							}
					?>
					<tr <?php if($i%2 != 0){ ?> class="odd" <?php } ?>>
						<td>
							<a href="http://www.google.pl/search?q=<?php echo $phrase['nazwa'];?>&num=10&start=<?php echo $googleNum; ?>">
								<?php echo $phrase['nazwa']; ?></td>
							</a>
						<td <?php if($phrase['pierwsza_strona'] == 1) {
								echo 'class="position_top10"';
						 	} else {
								if($phrase['wynik'] == 0) {
									echo 'class="position_not_found"';
								}
							} ?>><?php echo $phrase['wynik']; ?>
						</td>
						<td
							class="change_<?php echo ($phrase['zmiana'] > 0 ? 'up' : ($phrase['zmiana'] < 0 ? 'dn' : 'eq'));?>"><?php echo $phrase['zmiana'] > 0 ? '+' : ''; echo $phrase['zmiana']; ?>
						</td>
						<td><?php echo $phrase['pierwsza_strona'] == 1 ? 'TAK' : 'NIE'; ?>
						</td>
					</tr>
					<?php $i++;
} // end foreach fraza ?>
				</tbody>
			</table>

		</div>

		<div class="breakdown_client_rightcolumn">

			<h2>
				Statystyka
				<?php echo $monthBefore ?>
				do
				<?php echo $dateCalendar ?>
			</h2>
			<h3>Odsetek fraz na 1 stronie Google | <?php if($dateDay != date('Y-m-d')) {?>
				<span style="color: red; font-size: 18px;"> <?php } ?>Wybrana data:
					<?php echo $dateDay; ?> <?php if($dateDay != date('Y-m-d')) { ?>
					<?php if($dateDay != date('Y-m-d')) {?> (Nie dzień dzisiejszy!)<?php } ?>
				</span>
				<?php } ?>
			</h3></h3>
			<table border="0" cellpadding="0" cellspacing="0"
				class="tabela_slupkowa">
				<tr>
					<?php for($i=29; $i>=0; $i--) {

						$tableDate = date('Y-m-d', strtotime('-'.$i.' day', strtotime($dateCalendar)));

						$fstPagePct = 0.0;
						$upPct = 0.0;
						$dnPct = 0.0;
							
						if(isset($client['precentages'][$tableDate]['precentage_1st_page'])) {
							$fstPagePct = $client['precentages'][$tableDate]['precentage_1st_page'];
						}
							
						if(isset($client['precentages'][$tableDate]['precentage_up'])) {
							$upPct = $client['precentages'][$tableDate]['precentage_up'];
						}
							
						if(isset($client['precentages'][$tableDate]['precentage_dn'])) {
							$dnPct = $client['precentages'][$tableDate]['precentage_dn'];
						}

						if( substr($tableDate, 8) == '01') { ?>
					<td>
						<div style="height: 100px; width: 1px; background-color: black;"></div>
						<span style="font-size: 10px;"><b><?php echo substr($tableDate, 0, 4);?></b></span><br>
						<span style="font-size: 10px;"><b><?php echo substr($tableDate, 5, 2);?></b></span><br>
						<span>&nbsp;</span><br>
						<span>&nbsp;</span>
					</td>
					<?php }	?>
					<td>
						<div style="width: 25px; background-color: transparent; text-align: center;">
						<div style="height: <?php echo (int)$fstPagePct; ?>px;"></div>
						<span style="font-size: 10px;"><?php echo (int)$fstPagePct; ?>%</span><br>
						<a
						href="/klienci/breakdown/<?php echo $tableDate; ?>/<?php echo $dateCalendar; ?>/<?php echo $page ?>/#klient_<?php echo $client['id_klienta']; ?>">
							<?php
							if($tableDate == $dateDay) {
									echo '<b>';
								}

								echo substr($tableDate, 8);

								if($tableDate == $dateDay) {
									echo '</b>';
								}
								?>
						</a><br>
						<span style="color: green; font-size: 10px;"><?php echo (int)$upPct; ?>%</span><br>
						<span style="color: red; font-size: 10px;"><?php echo (int)$dnPct; ?>%</span>
						</div>
					</td>
					<?php } ?>
				</tr>
			</table>
			<br> <span><b>Ostatnie płatności</b> </span>
			<div>
				<table style="width: 300px; margin-right: 20px; margin-bottom: 20px; float: left" border="0" cellpadding="0"
					cellspacing="0" id="payments_table">
					<thead>
						<tr>
							<th>Numer faktury</th>
							<th>Data wystawienia</th>
							<th>Kwota brutto</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 0;
						if(isset($client['faktury'])) {
							foreach ($client['faktury'] as $payment) { ?>
							<tr
								class="<?php if($i%2 != 0){ echo 'odd'; } ?> <?php
							if($payment['payment_done']) {
								echo 'payment_done';
							} else {
								if($payment['payment_overtime']) {
									echo 'payment_overtime';
								}
							}
						
						?>">
							<td><a target="_blank"
								href="/faktury/podglad/<?php echo $payment['id_faktury']; ?>/<?php echo $client['id_klienta']; ?>"><?php echo texts::numer_faktury($payment); ?>
							</a></td>
							<td><?php echo $payment['data_wystawienia']; ?></td>
							<td><?php echo $payment['kwota_brutto']; ?> zł</td>
						</tr>
						<?php $i++;
						} // end foreach payment
						} // end if isset faktury?>
						<tr class="<?php if($i%2 != 0){ echo 'odd'; } $i++;?>">
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr class="<?php if($i%2 != 0){ echo 'odd'; } $i++;?>">
							<td colspan="2" style="border-top: solid black 1px;"><b>RAZEM :</b></td>
							<td style="border-top: solid black 1px;"><b><?php echo $client['paymentsTotal4']; ?> zł</b></td>

						</tr>
						<tr
							class="<?php if($i%2 != 0){ echo 'odd'; } $i++;?> payment_done">
							<td colspan="2"><b>ZAPŁACONE :</b></td>
							<td><b><?php echo $client['paymentsTotal4Done']; ?> zł</b></td>
						</tr>
						<tr
							class="<?php if($i%2 != 0){ echo 'odd'; } $i++; ?> payment_overtime">
							<td colspan="2" style="border-bottom: solid black 1px;"><b>NIEZAPŁACONE :</b></td>
							<td style="border-bottom: solid black 1px;"><b><?php echo $client['paymentsTotal4Overtime']; ?> zł</b></td>
						</tr>
					</tbody>
				</table>

				<table style="width: 590px; float: left; margin-bottom: 20px; "
					border="0" cellpadding="0" cellspacing="0" id="payments_table">
					<thead>
						<tr>
							<th>Rozliczany ryczałtem</th>
							<th>Rozliczany TOP</th>
							<th>Data podpisania umowy</th>
							<th>Umowa od</th>
							<th>Data rozpoczęcia pozycjonowania</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="border-bottom: solid black 1px;"><?php echo $client['hasBulkPayment'] ? 'TAK' : 'NIE'; ?></td>
							<td style="border-bottom: solid black 1px;"><?php echo $client['hasTopPayment'] ? 'TAK' : 'NIE'; ?></td>
							<td style="border-bottom: solid black 1px;"><?php echo $client['data_utworzenia']; ?></td>
							<td style="border-bottom: solid black 1px;"><?php echo $client['umowa_czas_okreslony_od']; ?></td>
							<td style="border-bottom: solid black 1px;"><?php echo $client['data_rozpoczecia_pozycjonowania']; ?></td>
						</tr>
					</tbody>
				</table>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>

		<div class="clear"></div>

		<div>

			<a
				href="/klienci/breakdown/<?php echo $dateDay; ?>/<?php echo $monthAfter ?>/<?php echo $page; ?>/#klient_<?php echo $client['id_klienta']; ?>"
				class="headButtons">+miesiac</a> <a
				href="/klienci/breakdown/<?php echo $dateDay; ?>/<?php echo $weekAfter ?>/<?php echo $page; ?>/#klient_<?php echo $client['id_klienta']; ?>"
				class="headButtons">+tydzień</a> <a
				href="/klienci/breakdown/<?php echo $dateDay; ?>/<?php echo $weekBefore ?>/<?php echo $page; ?>/#klient_<?php echo $client['id_klienta']; ?>"
				class="headButtons">-tydzień</a> <a
				href="/klienci/breakdown/<?php echo $dateDay; ?>/<?php echo $monthBefore ?>/<?php echo $page; ?>/#klient_<?php echo $client['id_klienta']; ?>"
				class="headButtons">-miesiac</a> <a
				href="/klienci/breakdown/<?php echo date('Y-m-d'); ?>/<?php echo $dateCalendar; ?>/<?php echo $page; ?>/#klient_<?php echo $client['id_klienta']; ?>"
				class="headButtons">Powrót do dnia bieżącego</a>

			<div class="clear"></div>
		</div>
	</div>
	<?php } // end foreach $klienci as $klient
	} // else ?>

</div>

<div>
	<?php if($page < $totalPages) { ?>
	<a
		href="/klienci/breakdown/<?php echo $dateDay ?>/<?php echo $dateCalendar ?>/<?php echo $page+1; ?>"
		class="headButtons">Nast. strona</a>
	<?php }	?>

	<?php if($page > 1) { ?>
	<a
		href="/klienci/breakdown/<?php echo $dateDay ?>/<?php echo $dateCalendar ?>/<?php echo $page-1; ?>"
		class="headButtons">Pop. strona</a>
	<?php } ?>

	<div class="clear"></div>
</div>
