<?php
// Prevent any warnings/errors from corrupting the PDF output
error_reporting(0);
ini_set('display_errors', 0);

ob_start();
require('../fpdf/fpdf.php');
require('../fpdf/phpqrcode/qrlib.php');

// Function to clean text
function cleanText($text) {
    if ($text === null) return '';
    // Remove all control characters (0-31 and 127) including newlines (\n, \r) and tabs (\t)
    $text = preg_replace('/[\x00-\x1F\x7F]/', '', $text);
    // Convert to latin1 with transliteration for the font
    $cleaned = iconv('UTF-8', 'windows-1252//TRANSLIT', $text);
    return ($cleaned === false) ? $text : $cleaned;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Ensure font files exist before adding
    $fontPathRegular = '../fpdf/font/DejaVuSans.php';
    $fontPathBold = '../fpdf/font/DejaVuSans-Bold.php';
    
    if (file_exists($fontPathRegular) && file_exists($fontPathBold)) {
        $pdf->AddFont('DejaVu','','DejaVuSans.php');
        $pdf->AddFont('DejaVu','B','DejaVuSans-Bold.php');
        $pdf->SetFont('DejaVu', 'B', 16);
    } else {
        $pdf->SetFont('Arial', 'B', 16);
    }

    $pdf->Cell(0, 10, cleanText('Bilete Eveniment - Ticketa'), 0, 1, 'C');
    $pdf->Ln(10);

    $event_names = $_POST['event_name'] ?? [];
    $event_dates = $_POST['event_date'] ?? [];
    $event_locations = $_POST['event_location'] ?? [];
    $ticket_names = $_POST['ticket_name'] ?? [];
    $cantitati = $_POST['cantitate'] ?? [];
    $preturi = $_POST['pret_bilet'] ?? [];
    $coduri_bilete = $_POST['cod_bilet'] ?? [];
    $order_id = $_POST['order_id'] ?? 'unknown';

    // Local temp dir for QR codes
    $localTempDir = __DIR__ . '/../temp';
    if (!file_exists($localTempDir)) {
        mkdir($localTempDir, 0777, true);
    }
    $localTempDir = realpath($localTempDir);

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
        $pdf->Cell(0, 10, cleanText("Order ID: $order_id"), 0, 1);

        $pdf->SetFont('DejaVu', '', 12);
        $pdf->Cell(0, 10, cleanText("Eveniment: $event"), 0, 1);
        $pdf->Cell(0, 10, cleanText("Data: $date"), 0, 1);
        $pdf->Cell(0, 10, cleanText("Locatie: $location"), 0, 1);
        $pdf->Cell(0, 10, cleanText("Tip bilet: $ticket"), 0, 1);
        $pdf->Cell(0, 10, cleanText("Cantitate: $qty"), 0, 1);
        $pdf->Cell(0, 10, cleanText("Pret/bilet: $price RON"), 0, 1);
        $pdf->Cell(0, 10, cleanText("Total: $total RON"), 0, 1);

        $cod_bilet_array = json_decode($cod_bilet_json, true);
        if (is_array($cod_bilet_array)) {
            $pdf->Cell(0, 10, cleanText("Coduri bilete:"), 0, 1);
            foreach ($cod_bilet_array as $cod) {
                if (empty($cod)) continue;

                $cleanCod = preg_replace('/[^a-zA-Z0-9]/', '', $cod);
                $uniqueName = 'qr_' . $cleanCod . '_' . uniqid() . '.png';
                $qr_temp_path = $localTempDir . DIRECTORY_SEPARATOR . $uniqueName;
                
                // Generate QR Code
                QRcode::png($cod, $qr_temp_path, QR_ECLEVEL_L, 4);

                $pdf->Cell(0, 10, " - " . cleanText($cod), 0, 1);

                if ($pdf->GetY() > 250) {
                    $pdf->AddPage();
                }

                $yBeforeQR = $pdf->GetY();
                if (file_exists($qr_temp_path)) {
                    $pdf->Image($qr_temp_path, $pdf->GetX(), $yBeforeQR, 30, 30);
                    unlink($qr_temp_path);
                } else {
                    $pdf->Cell(30, 30, 'QR Error', 1, 0, 'C');
                }
                
                $pdf->Ln(35); 
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
    echo "Metoda POST este necesara.";
}
?>
