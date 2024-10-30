<?php
// Agregamos la libreria FPDF
require('fpdf/fpdf.php');

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        // Logo
        $this->Image('imagenes/kayser_logo2-removebg-preview (1).png', 10, 6, 30); // Ajusta la ruta y el tamaño del logo
        // Arial bold 16
        $this->SetFont('Arial', 'B', 16);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Learned Lessons Kayser Automotive System', 0, 1, 'C');
        // Salto de línea
        $this->Ln(20);
    }
  
    // Pie de página
    function Footer() {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Creación del objeto de PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
// Agregar contenido sin borde
$pdf->Cell(0, 10, 'Hola, Mundo', 0, 1, 'L');
$pdf->Output('D', 'Lesson.pdf'); // Generamos el PDF para descarga directa
?>
