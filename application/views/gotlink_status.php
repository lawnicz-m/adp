<?php
    function search($array, $key, $value)
			{
				$results = array();
				if (is_array($array))
				{
					if ((isset($array[$key]) && $array[$key] == $value) || (isset($array[$key]) && preg_match('/(.*)'.$value.'(.*)/', $array[$key])))
						$results[] = $array;

						foreach ($array as $subarray)
								$results = array_merge($results, search($subarray, $key, $value));
				}
				return $results;
			}
	
	$adres_strony = $klient['adres_strony'];
	$z_pliku = file_get_contents('gotlinek.txt');
	$z_pliku = json_decode($z_pliku, true);
	$key = 'url';
	$szukaj = array();
    $szukaj = search($z_pliku, $key, $adres_strony);
	
	$ile_linkow = count($szukaj);
	
	if ($ile_linkow != 0){
	$grp = $szukaj[0]['group_id'];
?>
							<table style="border:1px solid black;width:100%;text-align:center;">
								<tr>
									<th style="border:1px solid black;">
									URL:
									</th>
									<th style="border:1px solid black;">
									Anchor:
									</th>
									<th style="border:1px solid black;">
									Liczba punków:
									</th>
									<th style="border:1px solid black;">
									Data dodania:
									</th>
								</tr>
									<?php for ($i=0; $i<$ile_linkow; $i++){ ?>
								<tr>
									<td style="border:1px solid black;text-align:center;">
									<?php echo " ".$szukaj[$i]["url"]." "; ?>
									</td>
									<td style="border:1px solid black;text-align:center;">
									<?php echo " ".$szukaj[$i]['anchor']." "; ?>
									</td>
									<td style="border:1px solid black;text-align:center;">
									<?php echo " ".$szukaj[$i]['points']." "; ?>
									</td>
									<td style="border:1px solid black;text-align:center;">
									<?php $unixtime_to_date = date('d-m-Y H:i', $szukaj[$i]['add_date']);
									echo " ".$unixtime_to_date." "; ?>
									</td>
								</tr>
							<?php } ?>
							</table>
							<br />
							Ile punktów dla całej grupy linków ??
<?php
							$punkty = 0;
							
							for ($i=0;$i<$ile_linkow;$i++){
								$punkty = ($punkty + $szukaj[$i]['points']);}
								
							forms::open(array('action' => url::page(CONTROLLER.'/aktualizuj_gotlink/'.PARAM)));
							forms::text(array('fieldClass' => 'widthQuarter',
							'name' => 'points',
							'required' => 1,
							'value' => $punkty));
							forms::hidden(array('name' => 'id_grupy',
                            'value' => $grp));
							forms::hidden(array('name' => 'punkty_stare',
                            'value' => $punkty));
							forms::submit(0);
							forms::close(0);
							
							
							
							
							

}
	else
{
echo 'Nie jest w gotlinku, lub nie ma linków dodanych';
							}
?>