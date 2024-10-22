<?php declare(strict_types=1);

use Sprain\SwissQrBill as QrBill;
use Sprain\SwissQrBill\PaymentPart\Output\PrintOptions;

require __DIR__ . '/../../vendor/autoload.php';

// 1. Let's load the base example to define the qr bill contents
require __DIR__ . '/../example.php';

// 2. Create an FPDF instance (or use an existing one from your project)
// – alternatively, an instance of \setasign\Fpdi\Fpdi() is also accepted by FpdfOutput.
$fpdf = new \Fpdf\Fpdf('P', 'mm', 'A4');

// In case your server does not support "allow_url_fopen", use this way to create your FPDF instance:
// $fpdf = new class('P', 'mm', 'A4') extends \Fpdf\Fpdf {
//     use \Fpdf\Traits\MemoryImageSupport\MemImageTrait;
// };

// In case you want to draw scissors and dashed lines, use this way to create your FPDF instance:
// $fpdf = new class('P', 'mm', 'A4') extends \Fpdf\Fpdf {
//     use \Sprain\SwissQrBill\PaymentPart\Output\FpdfOutput\FpdfTrait;
// };

$fpdf->AddPage();

// 3. Optional, set layout options
$options = new PrintOptions();
$options
    ->setPrintable(false)
    ->setSeparatorSymbol(false); // TRUE to show scissors instead of text

// 4. Create a full payment part for FPDF
$output = new QrBill\PaymentPart\Output\FpdfOutput\FpdfOutput($qrBill, 'en', $fpdf);
$output
    ->setPrintOptions($options)
    ->getPaymentPart();

// 5. For demo purposes, let's save the generated example in a file
$examplePath = __DIR__ . "/fpdf_example.pdf";
$fpdf->Output($examplePath, 'F');

print "PDF example created here : " . $examplePath;
