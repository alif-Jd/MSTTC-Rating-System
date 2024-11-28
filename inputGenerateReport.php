<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
require('fpdf.php');  // Adjust path if necessary
include 'config.php'; // Database configuration

// Initialize FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Add Logo and Title
$pdf->Image('MsttcLogo-1-copy.png', 10, 10, 50); // Adjust position and size as needed
$pdf->Ln(20);
$pdf->Cell(0, 10, 'MUADZAM SHAH TABLE TENNIS CLUB RATING SYSTEM', 0, 1, 'C');

$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Comprehensive Analysis Report', 0, 1, 'C');
$pdf->Ln(10);

// Draw underline
$pdf->SetDrawColor(0, 0, 0); // Set color for the line (black)
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Draw line across the page width
$pdf->Ln(10); // Additional space after the underline

// Introduction
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 8, "This report presents an in-depth analysis of the player ratings and characteristics within the Muadzam Shah Table Tennis Club (MSTTC). The data encompasses various aspects, including player playstyle, career progression, grip preference, dominant hand, and age distribution. This analysis is designed to provide valuable insights into player demographics and performance trends, helping the club's management make data-driven decisions.", 0, 'L');
$pdf->Ln(10);

// Define chart types and titles
$charts = [
    'playstyle' => 'i-Player Playstyle',
    'careerType' => 'ii-Player Career Type',
    'grip' => 'iii-Player Grip',
    'dominantHand' => 'iv-Player Dominant Hand',
    'ageDistribution' => 'v-Player Age Distribution'
];

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($charts as $chartType => $title) {
        // Add a page break if necessary
        if ($pdf->GetY() > 220) {
            $pdf->AddPage();
            $pdf->Ln(10); // Additional spacing at top of new page
        }

        // Fetch data for each chart type
        $data = [];
        switch ($chartType) {
            case 'playstyle':
                $stmt = $pdo->prepare("SELECT Playstyle AS label, COUNT(*) as count FROM player GROUP BY Playstyle");
                break;
            case 'careerType':
                $stmt = $pdo->prepare("SELECT CareerType AS label, COUNT(*) as count FROM player GROUP BY CareerType");
                break;
            case 'grip':
                $stmt = $pdo->prepare("SELECT Grip AS label, COUNT(*) as count FROM player GROUP BY Grip");
                break;
            case 'dominantHand':
                $stmt = $pdo->prepare("SELECT DominantHand AS label, COUNT(*) as count FROM player GROUP BY DominantHand");
                break;
            case 'ageDistribution':
                $ageIntervals = [
                    '1-10' => 'Age < 11',
                    '11-20' => 'Age >= 11 AND Age < 21',
                    '21-30' => 'Age >= 21 AND Age < 31',
                    '31-40' => 'Age >= 31 AND Age < 41',
                    '41-50' => 'Age >= 41 AND Age < 51',
                    '51-60' => 'Age >= 51 AND Age < 61',
                    '61-70' => 'Age >= 61 AND Age < 71',
                    '71-80' => 'Age >= 71 AND Age < 81',
                    '81-90' => 'Age >= 81 AND Age < 91',
                    '91-100' => 'Age >= 91 AND Age < 101'
                ];
                foreach ($ageIntervals as $label => $condition) {
                    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM player WHERE $condition");
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $data[] = ['label' => $label, 'count' => (int)$result['count']];
                }
                break;
        }

        if ($chartType !== 'ageDistribution') {
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Section title with added margin
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $title . ' Analysis', 0, 1, 'L');
        $pdf->Ln(5);

        // Table Headers
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 10, 'Category', 1, 0, 'C');
        $pdf->Cell(90, 10, 'Total Players', 1, 1, 'C');

        // Data Rows
        $pdf->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $pdf->Cell(90, 10, $row['label'], 1, 0, 'C');
            $pdf->Cell(90, 10, $row['count'], 1, 1, 'C');
        }

        $pdf->Ln(10); // Space after each chart section
    }

    // Query to get the total number of players based on DominantHand
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM player WHERE DominantHand IN ('Right', 'Left')");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Total players
    $totalPlayers = $result['total'];

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Total Players in Club: ' . $totalPlayers, 0, 1, 'L');



    // Add Conclusion
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Conclusion', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->MultiCell(0, 8, "The information presented in this report is proprietary and the exclusive property of Muadzam Shah Table Tennis Club (MSTTC). All data, analysis, and insights contained herein are copyrighted and intended solely for the internal use of MSTTC management. Unauthorized distribution, reproduction, or disclosure of this report or its contents, in whole or in part, is strictly prohibited without the prior written consent of MSTTC.", 0, 'L');
    $pdf->Ln(10);

    // Add date at the end
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(0, 5, 'Latest Updated: ' . date('Y-m-d'), 0, 1, 'L');
    $pdf->Ln(5);

    // Add disclaimer
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, 'This document is computer-generated and does not require a signature.', 0, 0, 'L');

    // Output PDF
    $pdf->Output();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
