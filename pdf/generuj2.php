<?

    $pdf_margin_top = isset($_GET['margin_top']) ? $_GET['margin_top'] : 20;
    $pdf_page_orientation = isset($_GET['page_orientation']) ? $_GET['page_orientation'] : 'P';

    require_once('../config.php');
    require_once('config/lang/pol.php');
    require_once('tcpdf.php');

    $pdf = new TCPDF($pdf_page_orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('');
    $pdf->SetTitle('');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // set default header data
    $pdf->SetHeaderData('', '', '');

    // set header and footer fonts
    $pdf->setHeaderFont(Array('dejavusanscondensed', '', '9'));
    $pdf->setFooterFont(Array('dejavusanscondensed', '', '9'));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, $pdf_margin_top, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    $pdf->setLanguageArray($l);

    // ---------------------------------------------------------

    //$pdf->SetFont('freeserif', '', 12);
    //$pdf->SetFont('dejavusans', '', 10);
    $pdf->SetFont('dejavusanscondensed', '', 9);

    $pdf->AddPage();

    $html = file_get_contents($_GET['input_file'], false);

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output($_GET['output_file'], 'D');

?>
