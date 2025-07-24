<?php
require('../fpdf/fpdf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Bilete Eveniment - Ticketa', 0, 1, 'C');
    $pdf->Ln(10);

    $event_names = $_POST['event_name'];
    $event_dates = $_POST['event_date'];
    $event_locations = $_POST['event_location'];
    $ticket_names = $_POST['ticket_name'];
    $cantitati = $_POST['cantitate'];
    $preturi = $_POST['pret_bilet'];

    for ($i = 0; $i < count($ticket_names); $i++) {
        $event = $event_names[$i];
        $date = $event_dates[$i];
        $location = $event_locations[$i];
        $ticket = $ticket_names[$i];
        $qty = $cantitati[$i];
        $price = $preturi[$i];
        $total = number_format($qty * $price, 2);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Eveniment: $event", 0, 1);
        $pdf->Cell(0, 10, "Data: $date", 0, 1);
        $pdf->Cell(0, 10, "Locatie: $location", 0, 1);
        $pdf->Cell(0, 10, "Tip bilet: $ticket", 0, 1);
        $pdf->Cell(0, 10, "Cantitate: $qty", 0, 1);
        $pdf->Cell(0, 10, "Pret/bilet: $price RON", 0, 1);
        $pdf->Cell(0, 10, "Total: $total RON", 0, 1);
        $pdf->Ln(10);
    }

    $pdf->Output("D", "bilet_ticketa_$event.pdf"); // Force download
    exit;
}
?>