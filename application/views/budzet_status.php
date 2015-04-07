<?php
	$this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
			
	forms::title(array('title' => 'Checklista'));
	$pozycjonerzy = $this -> load -> model('pozycjonerzy');
	$pozycjoner = $pozycjonerzy -> jeden($klient['id_pozycjonera']);
	$partnerzy = $this -> load -> model('partnerzy');
	$partner = $partnerzy -> jeden($klient['id_partnera']);
	
	$con=mysqli_connect("adpsg2.eu","adpsg208_rmtusr","dupa666", true);
	// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else {
echo "OK";
}


mysqli_close($con);

	forms::close(0);

    $this -> load -> view('footer');
?>