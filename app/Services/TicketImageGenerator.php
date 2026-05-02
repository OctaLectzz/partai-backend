<?php

namespace App\Services;

use App\Models\EventParticipant;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use Carbon\Carbon;

class TicketImageGenerator
{
    private \GdImage $img;

    private int $width = 800;

    private int $headerHeight = 140;

    private int $bodyHeight = 350;

    private int $footerHeight = 50;

    private int $totalHeight;

    /** @var array<string, int> */
    private array $colors = [];

    private string $fontRegular;

    private string $fontBold;

    private string $fontMono;

    public function __construct(private readonly EventParticipant $participant)
    {
        $this->totalHeight = $this->headerHeight + $this->bodyHeight + $this->footerHeight;
        $this->resolveFonts();
    }

    /**
     * Generate the ticket image and return PNG binary data.
     */
    public function generate(): string
    {
        $this->img = imagecreatetruecolor($this->width, $this->totalHeight);
        imagesavealpha($this->img, true);
        imagealphablending($this->img, true);

        $this->allocateColors();
        $this->drawHeader();
        $this->drawBody();
        $this->drawQrCode();
        $this->drawFooter();

        $this->applyBorderRadius(25);

        ob_start();
        imagepng($this->img, null, 9);
        $data = ob_get_clean();
        imagedestroy($this->img);

        return $data;
    }

    private function resolveFonts(): void
    {
        $fontsDir = storage_path('app/fonts');

        if (file_exists($fontsDir.'/Inter-Bold.ttf')) {
            $this->fontRegular = $fontsDir.'/Inter-Regular.ttf';
            $this->fontBold = $fontsDir.'/Inter-Bold.ttf';
            $this->fontMono = file_exists($fontsDir.'/RobotoMono-SemiBold.ttf')
                ? $fontsDir.'/RobotoMono-SemiBold.ttf'
                : $fontsDir.'/Inter-Bold.ttf';

            return;
        }

        // Fallback to system fonts
        if (PHP_OS_FAMILY === 'Windows') {
            $this->fontRegular = 'C:/Windows/Fonts/arial.ttf';
            $this->fontBold = 'C:/Windows/Fonts/arialbd.ttf';
            $this->fontMono = 'C:/Windows/Fonts/cour.ttf';
        } else {
            $base = '/usr/share/fonts/truetype/dejavu/';
            $this->fontRegular = $base.'DejaVuSans.ttf';
            $this->fontBold = $base.'DejaVuSans-Bold.ttf';
            $this->fontMono = $base.'DejaVuSansMono.ttf';
        }
    }

    private function allocateColors(): void
    {
        $this->colors = [
            'gold' => imagecolorallocate($this->img, 255, 203, 0),
            'goldDark' => imagecolorallocate($this->img, 180, 145, 0),
            'white' => imagecolorallocate($this->img, 255, 255, 255),
            'bgGray' => imagecolorallocate($this->img, 248, 250, 252),
            'textDark' => imagecolorallocate($this->img, 30, 41, 59),
            'textLabel' => imagecolorallocate($this->img, 148, 163, 184),
            'textMedium' => imagecolorallocate($this->img, 51, 65, 85),
            'borderLight' => imagecolorallocate($this->img, 226, 232, 240),
            'black' => imagecolorallocate($this->img, 0, 0, 0),
            'transparent' => imagecolorallocatealpha($this->img, 0, 0, 0, 127),
        ];
    }

    private function drawHeader(): void
    {
        // Gold gradient (simulated with two rectangles)
        $midX = (int) ($this->width * 0.6);
        imagefilledrectangle($this->img, 0, 0, $midX, $this->headerHeight - 1, $this->colors['gold']);
        imagefilledrectangle($this->img, $midX, 0, $this->width - 1, $this->headerHeight - 1, $this->colors['goldDark']);

        // Smooth gradient transition
        for ($x = $midX - 60; $x < $midX + 60; $x++) {
            $ratio = ($x - ($midX - 60)) / 120;
            $r = (int) (255 + (180 - 255) * $ratio);
            $g = (int) (203 + (145 - 203) * $ratio);
            $color = imagecolorallocate($this->img, $r, $g, 0);
            imageline($this->img, $x, 0, $x, $this->headerHeight - 1, $color);
        }

        // --- Decorations ---
        $whiteAlpha = imagecolorallocatealpha($this->img, 255, 255, 255, 110);
        $blackAlpha = imagecolorallocatealpha($this->img, 0, 0, 0, 115);

        // Large circles to simulate glow/blur
        imagefilledellipse($this->img, $this->width + 20, -20, 300, 300, $whiteAlpha);
        imagefilledellipse($this->img, -20, $this->headerHeight + 20, 250, 250, $blackAlpha);

        // Diagonal stripes on the right side
        for ($i = 0; $i < 15; $i++) {
            $x1 = $this->width - ($i * 25);
            $y1 = 0;
            $x2 = $x1 + 100;
            $y2 = $this->headerHeight;
            imageline($this->img, $x1, $y1, $x2, $y2, $whiteAlpha);
            // Thicker line by drawing adjacent lines
            imageline($this->img, $x1 + 1, $y1, $x2 + 1, $y2, $whiteAlpha);
            imageline($this->img, $x1 + 2, $y1, $x2 + 2, $y2, $whiteAlpha);
        }

        // Event name (centered)
        $eventName = mb_strtoupper($this->participant->event->name ?? '-');
        $this->drawCenteredText($eventName, $this->fontBold, 20, 60, $this->colors['textDark']);

        // TICKET PASS badge
        $badgeText = 'TICKET PASS';
        $bbox = imagettfbbox(10, 0, $this->fontBold, $badgeText);
        $badgeW = $bbox[2] - $bbox[0] + 30;
        $badgeH = 28;
        $badgeX = (int) (($this->width - $badgeW) / 2);
        $badgeY = 90;

        // Semi-transparent badge background
        $badgeBg = imagecolorallocatealpha($this->img, 0, 0, 0, 100);
        imagefilledrectangle($this->img, $badgeX, $badgeY, $badgeX + $badgeW, $badgeY + $badgeH, $badgeBg);

        $textX = $badgeX + 15;
        $textY = $badgeY + 19;
        imagettftext($this->img, 10, 0, $textX, $textY, $this->colors['textDark'], $this->fontBold, $badgeText);
    }

    private function drawBody(): void
    {
        $bodyTop = $this->headerHeight;
        imagefilledrectangle($this->img, 0, $bodyTop, $this->width - 1, $bodyTop + $this->bodyHeight - 1, $this->colors['white']);

        $x = 40;
        $y = $bodyTop + 40;

        // Nama Partisipan
        imagettftext($this->img, 8, 0, $x, $y, $this->colors['textLabel'], $this->fontBold, 'NAMA PARTISIPAN');
        $y += 25;
        $name = mb_strtoupper($this->participant->massa->full_name ?? '-');
        imagettftext($this->img, 18, 0, $x, $y, $this->colors['textDark'], $this->fontBold, $name);
        $y += 35;

        // NIK
        imagettftext($this->img, 8, 0, $x, $y, $this->colors['textLabel'], $this->fontBold, 'NIK');
        $y += 20;
        imagettftext($this->img, 12, 0, $x, $y, $this->colors['textMedium'], $this->fontMono, $this->participant->massa->nik ?? '-');
        $y += 30;

        // Divider line
        imageline($this->img, $x, $y, 420, $y, $this->colors['borderLight']);
        $y += 20;

        // Tanggal
        if ($this->participant->event->start_date ?? false) {
            imagettftext($this->img, 8, 0, $x, $y, $this->colors['textLabel'], $this->fontBold, 'TANGGAL');
            $y += 18;
            $date = Carbon::parse($this->participant->event->start_date)->translatedFormat('d F Y');
            imagettftext($this->img, 11, 0, $x, $y, $this->colors['textMedium'], $this->fontRegular, $date);
            $y += 25;
        }

        // Waktu
        if ($this->participant->event->start_time ?? false) {
            imagettftext($this->img, 8, 0, $x, $y, $this->colors['textLabel'], $this->fontBold, 'WAKTU');
            $y += 18;
            $time = substr($this->participant->event->start_time, 0, 5);
            if ($this->participant->event->end_time) {
                $time .= ' - '.substr($this->participant->event->end_time, 0, 5);
            }
            $time .= ' WIB';
            imagettftext($this->img, 11, 0, $x, $y, $this->colors['textMedium'], $this->fontRegular, $time);
            $y += 25;
        }

        // Lokasi
        if ($this->participant->event->location ?? false) {
            imagettftext($this->img, 8, 0, $x, $y, $this->colors['textLabel'], $this->fontBold, 'LOKASI');
            $y += 18;
            $location = $this->participant->event->location;
            // Truncate if too long
            if (mb_strlen($location) > 40) {
                $location = mb_substr($location, 0, 37).'...';
            }
            imagettftext($this->img, 11, 0, $x, $y, $this->colors['textMedium'], $this->fontRegular, $location);
            $y += 25;
        }

        // Penyelenggara
        if ($this->participant->event->organizer ?? false) {
            imagettftext($this->img, 8, 0, $x, $y, $this->colors['textLabel'], $this->fontBold, 'PENYELENGGARA');
            $y += 18;
            $organizer = $this->participant->event->organizer;
            // Truncate if too long
            if (mb_strlen($organizer) > 40) {
                $organizer = mb_substr($organizer, 0, 37).'...';
            }
            imagettftext($this->img, 11, 0, $x, $y, $this->colors['textMedium'], $this->fontRegular, $organizer);
        }
    }

    private function drawQrCode(): void
    {
        $qrSize = 240;
        $qrX = $this->width - $qrSize - 40; // Shift slightly to right to accommodate larger size
        $qrY = $this->headerHeight + 40;

        // QR background box
        $padding = 15;
        $boxColor = $this->colors['bgGray'];
        imagefilledrectangle(
            $this->img,
            $qrX - $padding,
            $qrY - $padding,
            $qrX + $qrSize + $padding,
            $qrY + $qrSize + $padding + 30,
            $boxColor
        );

        // Border
        imagerectangle(
            $this->img,
            $qrX - $padding,
            $qrY - $padding,
            $qrX + $qrSize + $padding,
            $qrY + $qrSize + $padding + 30,
            $this->colors['borderLight']
        );

        // White inner box for QR
        $innerPad = 8;
        imagefilledrectangle(
            $this->img,
            $qrX - $innerPad,
            $qrY - $innerPad,
            $qrX + $qrSize + $innerPad,
            $qrY + $qrSize + $innerPad,
            $this->colors['white']
        );

        $code = $this->participant->participant_code;
        $qrPath = storage_path('app/public/qrcodes/'.$this->participant->qr_code);

        if (file_exists($qrPath) && str_ends_with($qrPath, '.png')) {
            // Load from storage if it's a PNG
            $qrImg = imagecreatefrompng($qrPath);
            $origWidth = imagesx($qrImg);
            $origHeight = imagesy($qrImg);

            imagecopyresampled(
                $this->img, $qrImg,
                $qrX, $qrY,
                0, 0,
                $qrSize, $qrSize,
                $origWidth, $origHeight
            );
            imagedestroy($qrImg);
        } else {
            // Generate QR matrix using BaconQrCode
            $qrCode = Encoder::encode($code, ErrorCorrectionLevel::M());
            $matrix = $qrCode->getMatrix();
            $matrixWidth = $matrix->getWidth();
            $moduleSize = (int) ($qrSize / $matrixWidth);
            $offset = (int) (($qrSize - ($moduleSize * $matrixWidth)) / 2);

            for ($row = 0; $row < $matrixWidth; $row++) {
                for ($col = 0; $col < $matrixWidth; $col++) {
                    if ($matrix->get($col, $row) === 1) {
                        $px = $qrX + $offset + ($col * $moduleSize);
                        $py = $qrY + $offset + ($row * $moduleSize);
                        imagefilledrectangle(
                            $this->img,
                            $px,
                            $py,
                            $px + $moduleSize - 1,
                            $py + $moduleSize - 1,
                            $this->colors['textDark']
                        );
                    }
                }
            }
        }

        // Participant code text below QR
        $codeY = $qrY + $qrSize + $padding + 18;
        $this->drawCenteredText(
            $code,
            $this->fontMono,
            11,
            $codeY,
            $this->colors['goldDark'],
            $qrX - $padding,
            $qrX + $qrSize + $padding
        );
    }

    private function drawFooter(): void
    {
        $footerTop = $this->headerHeight + $this->bodyHeight;

        // Dashed border line
        imagedashedline($this->img, 0, $footerTop, $this->width - 1, $footerTop, $this->colors['borderLight']);

        // Footer background
        imagefilledrectangle($this->img, 0, $footerTop + 1, $this->width - 1, $this->totalHeight - 1, $this->colors['bgGray']);

        // Cutouts on the sides between body and footer
        imagealphablending($this->img, false);
        imagefilledellipse($this->img, 0, $footerTop, 40, 40, $this->colors['transparent']);
        imagefilledellipse($this->img, $this->width - 1, $footerTop, 40, 40, $this->colors['transparent']);
        imagealphablending($this->img, true);

        // Footer text
        $text = 'Tunjukkan QR Code ini pada saat registrasi ulang di lokasi acara.';
        $this->drawCenteredText($text, $this->fontRegular, 9, $footerTop + 30, $this->colors['textLabel']);
    }

    /**
     * Draw centered text within a horizontal region.
     */
    private function drawCenteredText(
        string $text,
        string $font,
        int $size,
        int $y,
        int $color,
        ?int $regionLeft = null,
        ?int $regionRight = null
    ): void {
        $regionLeft ??= 0;
        $regionRight ??= $this->width;
        $regionWidth = $regionRight - $regionLeft;

        $bbox = imagettfbbox($size, 0, $font, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $x = $regionLeft + (int) (($regionWidth - $textWidth) / 2);

        imagettftext($this->img, $size, 0, $x, $y, $color, $font, $text);
    }

    /**
     * Round the corners of the final image by masking out the edges with transparent pixels.
     */
    private function applyBorderRadius(int $radius): void
    {
        imagealphablending($this->img, false);
        $transparent = $this->colors['transparent'];

        for ($x = 0; $x < $radius; $x++) {
            for ($y = 0; $y < $radius; $y++) {
                // If the pixel is outside the circle radius, make it transparent
                if (pow($radius - $x, 2) + pow($radius - $y, 2) > pow($radius, 2)) {
                    // Top Left
                    imagesetpixel($this->img, $x, $y, $transparent);
                    // Top Right
                    imagesetpixel($this->img, $this->width - 1 - $x, $y, $transparent);
                    // Bottom Left
                    imagesetpixel($this->img, $x, $this->totalHeight - 1 - $y, $transparent);
                    // Bottom Right
                    imagesetpixel($this->img, $this->width - 1 - $x, $this->totalHeight - 1 - $y, $transparent);
                }
            }
        }
        imagealphablending($this->img, true);
    }
}
