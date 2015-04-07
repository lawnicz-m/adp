
<?php 

$this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

?>

<div>
	<form
		action="/frazy/genpairs/<?php echo $idKlienta; ?>/<?php echo $count; ?>"
		method="post">
		<label>Temat:</label> <input type="text" name="genpairs_topic"
			value="<?php echo $_SESSION['genpairs_topic']; ?>"> <label>Ilość:</label>
		<input type="number" name="count" value="<?php echo $count; ?>"> <input
			type="submit" value="Generuj">
	</form>

	<textarea rows="<?php echo count($generatedPairs) + 10; ?>" cols="120">
Proszę o napisanie <?php echo count($generatedPairs); ?> tekstów, po 200 słów każdy,
na zaplecze tematyczne z kategorii <?php echo $category; ?> 
na temat "<?php echo $_SESSION['genpairs_topic']; ?>"
dla klienta http://<?php echo $clientPage; ?> .

Proszę w poszczególnych tekstach o użycie następujących fraz kluczowych. 

<?php 

for($i=0; $i<count($generatedPairs); $i++) {
	echo 'W tekście nr '.($i+1).' proszę o użycie ';

	if( (strpos($generatedPairs[$i], ';')) === false) {
		echo 'następującej jednej frazy kluczowej: '.$generatedPairs[$i];
	} else {
		echo 'następujących dwóch fraz kluczowych: '.$generatedPairs[$i];
	}

	echo PHP_EOL;
}

?>
</textarea>
</div>

<div></div>

<?php 

$this -> load -> view('footer');

?>