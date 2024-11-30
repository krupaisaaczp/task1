<?php
session_start();

// Set the content type to image
header('Content-Type: image/png');

// Create a blank image
$image = imagecreatetruecolor(120, 40);

// Set colors
$bg_color = imagecolorallocate($image, 255, 255, 255); // white background
$text_color = imagecolorallocate($image, 0, 0, 0); // black text
$line_color = imagecolorallocate($image, 64, 64, 64); // gray lines

// Fill the background with white
imagefill($image, 0, 0, $bg_color);

// Generate a random string for the CAPTCHA
$captcha_string = '';
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
for ($i = 0; $i < 6; $i++) {
    $captcha_string .= $characters[rand(0, strlen($characters) - 1)];
}

// Save the CAPTCHA string in the session
$_SESSION['captcha'] = $captcha_string;

// Add some random lines for noise
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line_color);
}

// Add the CAPTCHA string to the image
$font = 'arial.ttf'; // Make sure this path is correct
if (file_exists($font)) {
    imagettftext($image, 20, rand(-10, 10), rand(10, 30), rand(25, 35), $text_color, $font, $captcha_string);
} else {
    // If font file doesn't exist, use default text function (though it won't look as nice)
    imagestring($image, 5, 30, 10, $captcha_string, $text_color);
}

// Output the image as a PNG
imagepng($image);

// Free memory
imagedestroy($image);
?>
