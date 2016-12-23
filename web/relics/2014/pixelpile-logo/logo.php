<?php
$PPC_Cool = ["#003e53","#006bb6","#3dadc1","#8bd470","#bce362","#eeffdc"];
$PPC_Warm = ["#d13100","#f14400","#ff6100","#ffba15","#ffdd6c","#ffffdf"];
$PPC_Grey = ["#111","#333","#555","#bbb","#ccc","#eee"];
$PPC_GreyCyan = ["#111","#444","#09c","#0bd","#ccc","#eee"];
$PPC_GreyCool = ["#333","#444","#3dadc1","#8bd470","#eee","#fafafa"];
$PPC = $PPC_GreyCyan;

//function for outputting a logo
function drawPixelpileLogo ($size,$seed="",$colors=["#111","#333","#555","#bbb","#ccc","#eee"]) {
	//produce seed and readable seed
	$seedReadable = preg_replace("/[^a-z0-9]/i", "_", $seed);
	if ($seedReadable == '') {
		$seedReadable = md5(rand());
	}
	$seed = md5($seedReadable);
	$values = array(
	                array(2,3,2,1),
	                array(3,4,3,2),
	                array(4,5,4,3),
	                array(3,4,3,2)
	               );
	if ($seedReadable != 'root') {
		$i = 0;
		for ($x = 0; $x < 4; $x++) {
			for ($y = 0; $y < 4; $y++) {
				$value = hexdec(substr($seed, $i*2, 2))%6;
				$values[$x][$y] = round(($values[$x][$y]+$value*4)/5);
				$i++;
			}
		}
	}

	//figure out box size based on output size
	$size = $size*1;
	if ($size > 1000) {
		$size = 1000;
	}
	if ($size < 16) {
		$size = 16;
	}
	$stackScale = $size>64?1.05:1;
	$gridPadding = $size>64?$size/34:0;
	$boxSize = ($size-$gridPadding*2)/4;

	//set up new image object
	$im = new Imagick();
	$im->newImage($size,$size,'none','png');

	//draw all the boxes
	$draw = new ImagickDraw();
	for ($level = 1; $level <= 5; $level++) {
		for ($y = 0; $y < 4; $y++) {
			for ($x = 0; $x < 4; $x++) {
				if ($values[$x][$y] == $level) {
					$boxX = round($offset+$boxSize*$x);
					$boxY = round($offset+$boxSize*$y);
					$unitSize = floor($boxSize*pow($stackScale,$level-1));
					$boxColor = new iMagickPixel($colors[$level]);
					$draw->setFillColor($boxColor);
					$x1 = $gridPadding+($boxSize*$x)-($unitSize-$boxSize)/2;
					$y1 = $gridPadding+($boxSize*$y)-($unitSize-$boxSize)/2;
					$draw->rectangle(floor($x1),floor($y1),ceil($x1+$unitSize),ceil($y1+$unitSize));
				}
			}
		}
	}
	$im->drawImage($draw);

	//return image
	return array("im"=>$im,"size"=>$size,"seed"=>$seed,"seedReadable"=>$seedReadable);
}

//output
$image = drawPixelpileLogo($_GET['size'],$_GET['seed'],$PPC);
header ("Content-type: image/png");
header('Content-Disposition: inline; filename="pixelpileLogo-'.$image['seedReadable'].'-'.$image['size'].'.png"');
echo $image['im'];