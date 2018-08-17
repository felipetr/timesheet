<?php


@$size= intval($_GET['size']);
@$txt = $_GET['txt'];
@$bg = $_GET['bg'];
@$w = $_GET['w'];
@$h = $_GET['h'];
@$color = $_GET['color'];
if (!$txt)
{
    $txt = 'Erro';
}

if (!$size)
{
    $size = 20;
}

if (!$color)
{
    $color = '777777';
}

if (!$bg)
{
    $bg = 'CCCCCC';
}
if (!$w)
{
    $w = '100';
}
if (!$h)
{
    $h = '100';
}

@$fonttype = $_GET['fonttype'];
if(!$fonttype)
{
 $fonttype = 'r';
}
@$fontstyle = $_GET['fontstyle'];

$font = 'imgfonts/open'.$fonttype.$fontstyle.'.ttf';




$bgr = "0x".substr($bg, 0,2);
$bgg = "0x".substr($bg, 2,2);
$bgb = "0x".substr($bg, 4,2);


$colorr = "0x".substr($color, 0,2);
$colorg = "0x".substr($color, 2,2);
$colorb = "0x".substr($color, 4,2);







$img = imagecreate( $w, $h );
$background = imagecolorallocate( $img, $bgr, $bgg, $bgb);
$text_colour = imagecolorallocate( $img, $colorr, $colorg, $colorb);
if($background==-1) {
    //color does not exist...
    //test if we have used up palette
    $background = imagecolorallocate( $img, 0xCC, 0xCC, 0xCC);
}

if($text_colour==-1) {
    //color does not exist...
    //test if we have used up palette
    $text_colour = imagecolorallocate( $img, 0x77, 0x77, 0x77);
}




//sets the thickness/bolness of the line


//draws a line  params are (imgres,x1,y1,x2,y2,color)

//pulls the value passed in the URL


// place the font file in the same dir level as the php file


//this function sets the font size, places to the co-ords



//places another text with smaller size
$y = ($h+$size)/2;



$tb = imagettfbbox($size, 0, $font, $txt);
$x = ceil(($w - $tb[2]) / 2);

imagettftext($img, $size, 0, $x, $y, $text_colour, $font, $txt); //

//alerts the browser abt the type of content i.e. png image
header( 'Content-type: image/png' );
//now creates the image
imagepng( $img );

//destroys used resources
imagecolordeallocate( $text_color );
imagecolordeallocate( $background );
imagedestroy( $img );

?>