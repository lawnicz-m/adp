<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GL</title>
<style type="text/css">
<!-- .style1 { font-family: "Times New Roman", Times, serif; font-size: 14px; } -->
</style>
</head>
<body>
<?php
  $lot=';5;1;';
  $key=$_GET['key'];
  $link=$_GET['link'];
  $datka = date("Y-m-d", strtotime("+2 month"));
  $url=str_replace(' ','',$url);
  $rk=$_GET['rk'];
  $frazki=$_GET['frazy'];
  $frazki= explode("|", $frazki);
  //var_dump($frazki);
  //die;
  $ilefrazek = sizeof($frazki)/2;
  for ($i=0; $i < $ilefrazek ; $i++) { 
  $frazy[$i]=$frazki[0];
  unset($frazki[0]);
  $frazki = array_values($frazki);
  $url[$i]=$frazki[0];
  unset($frazki[0]);
  $frazki = array_values($frazki);
  }
  
  $frazy[count($frazy)]=$frazy[0];
  $frazy[count($frazy)]=$frazy[1];
  $frazy[count($frazy)]=$frazy[2];
if($rk=='2'&&$key!=1){
	if ($url[0]=='') {
		echo "Nie ma przypisanych do fraz URLi";
		die;
	}
	else
	{
	echo 'SeoTools <br />';
	for($n=0;$n<count($frazy)-3;$n++){
		echo $frazy[$n+1].'##'.$frazy[$n+2].'##'.$frazy[$n].'##'.$url[$n].'##'.$frazy[$n].'##'.$datka.'<br />';
	}
	echo '<br />GL<br />';
	for($n=0;$n<count($frazy)-3;$n++){
		echo $frazy[$n].';'.$url[$n].';'.$frazy[$n].';'.$frazy[$n+1].';'.$frazy[$n+2].$lot.$rk.';1;0'.'<br>';
	}
	}
}else if ($key!=1){
	for($n=0;$n<count($frazy)-3;$n++){
		echo $frazy[$n].'<br>';
	}
}else{
$keys='<span class="style1">
&lt;meta name="keywords" content="';
for($n=0;$n<count($frazy)-3;$n++){
		$keys.= $frazy[$n].', ';
	}
	
	 $keys = substr($keys, 0, -1);
	$keys.='" /&gt;</span>';
	echo $keys;
	
}
?>

</body>
</html>
