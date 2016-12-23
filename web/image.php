<?php
namespace byjoby\image;

define('PAGE_NOTEMPLATE', true);
require_once $_SERVER['DOCUMENT_ROOT'] . "/../core.php";

use byjoby\Config;
use byjoby\Templates\TwigPage;

$url  = $_GET['f'];
$url  = preg_replace('/\.+/', '.', $url);
$file = __DIR__ . $url;
if (!preg_match('/\.(gif|jpe?g|png|webp|wbmp)$/i', $file) || !is_file($file) || !is_readable($file)) {
    byjoby\Templates\TwigPage::abort('404');
}
$trans = $_GET['t'];
if (!Config::get('image_transforms/' . $trans)) {
    TwigPage::abort('404');
}

//figure out an output file name
$outputFileName = preg_replace('/.+\//', '', $file);
$outputFileName = preg_replace('/(\.[a-z]+)$/', '_' . $trans . '$1', $outputFileName);

header("Content-Disposition: filename=$outputFileName");
header("Content-Type: image/jpeg");

$jobID = md5(file_get_contents($file) . $trans);
$cache = Config::cache('image') . '/' . $jobID;

if (file_exists($cache) && filemtime($cache) + 30 < time()) {
    readfile($cache);
    exit();
}

// echo "<div>Transforming $file with rule $trans, saving to $cache</div>";
// var_dump(Config::get('image_transforms/' . $trans));

{
    $image = @imagecreatefromstring(file_get_contents($file));
}

if (!$image) {
    TwigPage::abort('500');
}

function scale_transform($image, $args, $filename)
{
    $args = explode('x', $args);
    //figure out new height and width
    $getimagesize    = getimagesize($filename);
    $original_width  = $getimagesize[0];
    $original_height = $getimagesize[1];
    $original_ratio  = $original_width / $original_height;

    $desired_width  = intval($args[0]);
    $desired_height = intval($args[1]);
    $desired_ratio  = $desired_width / $desired_height;

    //remember: ratio > 1 = wide, ratio < 1 = tall
    if ($original_ratio >= $desired_ratio) {
        //wider than requested
        $final_width  = $desired_width;
        $final_height = round($final_width / $original_ratio);
    } else {
        //narrower than requested
        $final_height = $desired_height;
        $final_width  = round($final_height * $original_ratio);
    }

    //set up new image
    $new = imagecreatetruecolor($final_width, $final_height);

    //copy old image into it
    imagecopyresampled($new, $image,
        0, 0, //dest x,y
        0, 0, //src x,y
        $final_width, $final_height, //dest w,h
        $original_width, $original_height //src w,h
    );

    //update and replace
    imagedestroy($image);
    return $new;
}

function crop_transform($image, $args, $filename)
{
    $args = explode('x', $args);
    //figure out new height and width
    $getimagesize    = getimagesize($filename);
    $original_width  = $getimagesize[0];
    $original_height = $getimagesize[1];
    $original_ratio  = $original_width / $original_height;

    $desired_width  = intval($args[0]);
    $desired_height = intval($args[1]);
    $desired_ratio  = $desired_width / $desired_height;

    //remember: ratio > 1 = wide, ratio < 1 = tall
    if ($original_ratio >= $desired_ratio) {
        //wider than requested
        $final_height = $desired_height;
        $final_width  = round($final_height * $original_ratio);
    } else {
        //narrower than requested
        $final_width  = $desired_width;
        $final_height = round($final_width / $original_ratio);
    }

    //set up new image
    $new = imagecreatetruecolor($desired_width, $desired_height);

    //copy old image into it
    imagecopyresampled($new, $image,
        -round(($final_width - $desired_width) / 2), //dest x
        -round(($final_height - $desired_height) / 2), //dest y
        0, 0, //src x,y
        $final_width, $final_height, //dest w,h
        $original_width, $original_height //src w,h
    );

    //update and replace
    imagedestroy($image);
    return $new;
}

foreach (Config::get('image_transforms/' . $trans) as $action => $args) {
    $func  = '\\byjoby\\image\\' . $action . '_transform';
    $image = $func($image, $args, $file);
}

imagejpeg($image, $cache, 80);
readfile($cache);
