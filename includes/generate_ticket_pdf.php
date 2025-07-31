<?php
ob_start();
require('../fpdf/fpdf.php');
require('../fpdf/phpqrcode/qrlib.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->AddFont('DejaVu','','DejaVuSans.php');
    $pdf->AddFont('DejaVu','B','DejaVuSans-Bold.php');
    $pdf->SetFont('DejaVu', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('Bilete Eveniment - Ticketa'), 0, 1, 'C');
    $pdf->Ln(10);

    $event_names = $_POST['event_name'] ?? [];
    $event_dates = $_POST['event_date'] ?? [];
    $event_locations = $_POST['event_location'] ?? [];
    $ticket_names = $_POST['ticket_name'] ?? [];
    $cantitati = $_POST['cantitate'] ?? [];
    $preturi = $_POST['pret_bilet'] ?? [];
    $coduri_bilete = $_POST['cod_bilet'] ?? [];
    $order_id = $_POST['order_id'] ?? 'unknown';

    for ($i = 0; $i < count($ticket_names); $i++) {
        $event = $event_names[$i] ?? '';
        $date = $event_dates[$i] ?? '';
        $location = $event_locations[$i] ?? '';
        $ticket = $ticket_names[$i] ?? '';
        $qty = $cantitati[$i] ?? 0;
        $price = $preturi[$i] ?? 0;
        $cod_bilet_json = $coduri_bilete[$i] ?? '[]';

        $total = number_format($qty * $price, 2);

        $pdf->SetFont('DejaVu', 'B', 14);
        $pdf->Cell(0, 10, "Order ID: $order_id", 0, 1);

        $pdf->SetFont('DejaVu', '', 12);
        $pdf->Cell(0, 10, utf8_decode("Eveniment: $event"), 0, 1);
        $pdf->Cell(0, 10, "Data: $date", 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Locatie: $location"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Tip bilet: $ticket"), 0, 1);
        $pdf->Cell(0, 10, "Cantitate: $qty", 0, 1);
        $pdf->Cell(0, 10, "Pret/bilet: $price RON", 0, 1);
        $pdf->Cell(0, 10, "Total: $total RON", 0, 1);

        $cod_bilet_array = json_decode($cod_bilet_json, true);
        if (is_array($cod_bilet_array)) {
            $pdf->Cell(0, 10, "Coduri bilete:", 0, 1);
            foreach ($cod_bilet_array as $cod) {
                // Creează imaginea QR temporar
                $qr_temp_path = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
                QRcode::png($cod, $qr_temp_path, QR_ECLEVEL_L, 4);

                // Afișează codul biletului
                $pdf->Cell(0, 10, " - $cod", 0, 1);

                // Verificăm dacă mai este suficient spațiu pe pagină, altfel adăugăm una nouă
                if ($pdf->GetY() > 250) {
                    $pdf->AddPage();
                }

                // Afișează codul QR
                $yBeforeQR = $pdf->GetY();
                $pdf->Image($qr_temp_path, $pdf->GetX(), $yBeforeQR, 30, 30);
                $pdf->Ln(35); // Spațiu sub QR

                // Șterge fișierul QR temporar
                unlink($qr_temp_path);
            }
        }
        $pdf->Ln(10);
    }

    ob_end_clean();

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="bilet_comanda_' . ($order_id ?? 'unknown') . '.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');

    $pdf->Output("D", "bilet_comanda_" . ($order_id ?? 'unknown') . ".pdf");
    exit;
} else {
    echo "Metoda POST este necesară.";
}
?>
