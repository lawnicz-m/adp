<?php
	$qServers = $this->load->model('queryservers');
	
	$queryServerURL = 'jestemwbik.com.pl';
	$ip = 'www.google.pl';
	$fileName = '22041371454968509-ok-.txt';
	$pageAddress = 'dzialkibudowlaneszczecin.net';
	$phrases = '11061123|dziaĹki budowlane szczecin prawobrzeĹźe||11061125|dziaĹki na sprzedaĹź szczecin||11061124|dziaĹki rekreacyjne szczecin';
	
	$qServers->queryPhrases($queryServerURL, $ip, $fileName, $pageAddress, $phrases);
	