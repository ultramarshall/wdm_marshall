<?php
    require_once('lib/fpdf/fpdf.php');
    require_once('lib/fpdi/fpdi.php');          <br>require_once("lib/pdfwatermarker/pdfwatermark.php");
    require_once("lib/pdfwatermarker/pdfwatermarker.php");
    $watermark = new PDFWatermark('assets/copyright.png'); // gambar png untuk watermark
    $watermarker = new PDFWatermarker('input.pdf', 'output.pdf', $watermark);
    $watermarker->setWatermarkPosition('center'); // posisi watermark
    $watermarker->watermarkPdf();
?>