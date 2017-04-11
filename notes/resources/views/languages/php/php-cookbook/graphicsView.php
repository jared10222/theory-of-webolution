<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Graphics</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#drawing_lines">Drawing Lines, Rectangles, and Polygons</a></td>
        <td><a href="#drawing_arcs">Drawing Arcs, Ellipses, and Circles</a></td>
        <td><a href="#drawing_patterned">Drawing with Patterned Lines</a></td>
        <td><a href="#drawing_text">Drawing Text</a></td>
    </tr>
    <tr>
    	<td><a href="#drawing_centered">Drawing Centered Text</a></td>
        <td><a href="#building_dynamic">Building Dynamic Images</a></td>
        <td><a href="#getting_setting">Getting and Setting a Transparent Color</a></td>
        <td><a href="#overlaying">Overlaying Watermarks</a></td>
    </tr>
    <tr>
    	<td><a href="#thumbnail">Creating Thumbnail Images</a></td>
        <td><a href="#reading_exif">Reading EXIF Data</a></td>
        <td><a href="#serving_images">Serving Images Securely</a></td>
        <td><a href="#program">Program: Generating Bar Chars from Poll Results</a></td>
    </tr>    
</table>

<hr />

<p>There are two easy ways to see which version, if any, of GD is intalled on your server and how it's configured. One way is to call phpinfo(). The other option is to check the return value of funciton_exists('imagecreate'). If it returns true, GD is installed. The imagetypes() function returns a bit field indicating which graphics formats are available.</p>

<p>The basic image-generation process has three steps: creating the image, adding graphics and text to the canvas, and displaying or saving the image. For Example:</p>

<pre class="prettyprint">
$image = ImageCreateTrueColoe(200, 50); //defaults to black

//color the background grey
$grey = 0xCCCCCC;
ImageFilledRectangle($image, 0,0,200 -1, 50 -1, $grey);

//draw a white rectangle on top
$white = 0xFFFFFF;
ImageFilledRectangle($image, 50,10,150,40 $white);

//send it as PNG
header('Content-type: image/png');
ImagePNG($image);
ImageDestroy($image);
    </pre>



<hr />

<h2><a name="drawing_lines">Drawing Lines, Rectangles, and Polygons</a></h2>
<p><b>Problem:</b> You want to draw a line, rectangle, or polygon. You also want to be able to control if the rectangle or polygon is open or filled in. For example, you want to be able to draw bar charts or create graphs of stock quotes.</p>
<p><b>Solution:</b> To draw a line, use ImageLine():</p>
<p>To draw an open rectangle, use ImageRectangle():</p>
<p>To draw a solid rectangle, use ImageFilledRectangle():</p>
<p>To draw an open polygon, use ImagePolygon():</p>
<p>To draw a filled polygon, use ImageFilledPolygon():</p>

<p>Documentation on <a href="http://php.net/imageline" target="_blank">ImageLine()</a></p>
<p>Documentation on <a href="http://php.net/imagerectangle" target="_blank">ImageRectangle()</a></p>
<p>Documentation on <a href="http://php.net/imagepolygon" target="_blank">ImagePolygon()</a></p>

<pre class="prettyprint">
$width = 200;
$height = 50;
$image = ImageCreateTrueColor($width, $height);

$background_color = 0xFFFFFF; //white
ImageFilledRectangle($image, 0, 0, $width - 1, $height - 1, $background_color);

$x1 = $y1 = 0; /0
$x2 = $y2 = $height - 1; //49
$color = 0xCCCCCC; //gray

ImageLine($image, $x1, $y1, $x2, $y2, $color);

header('Content-type: image/png');
ImagePNG($image);
ImageDestroy($image); 

<hr /> 
//open rectangle
ImageRectangle($image, $x1, $y1, $x2, $y2, $color);
<hr />
//solid rectangle
ImagedFilledRectangle($image, $x1, $y1, $x2, $y2);
<hr />
//open polygon
$points = array($x1, $y1, $x2, $y2, $x3, $y3);
ImagePolygon($image, $points, count($points)/2, $color);
<hr />
//filled polygon
$points = array($x1, $y1, $x2, $y2, $x3, $y3);
ImageFilledPolygon($image, $points, count($points)/2, $color); 
    </pre>


<hr />

<h2><a name="drawing_arcs">Drawing Arcs, Ellipses, and Circles</a></h2>
<p><b>Problem:</b> You want to draw open or filled curves. For example, you want to draw a pie chart showing the results of a user poll.</p>
<p><b>Solution:</b> To draw an arc, use ImageArc():</p>
<p>To draw an ellipse, use ImageEllipse():</p>
<p>To draw a cirlce, use ImageEllipse(), and use the same value for both $width and $height:</p>

<p>Documentation on <a href="http://php.net/imagearc" target="_blank">ImageArc()</a></p>
<p>Documentation on <a href="http://php.net/imagefilledarc" target="_blank">ImageFilledArc()</a></p>
<p>Documentation on <a href="http://php.net/imageellipse" target="_blank">ImageEllipse()</a></p>
<p>Documentation on <a href="http://php.net/imagefilledellipse" target="_blank">ImageFilledEllipse().</a></p>

<pre class="prettyprint">
ImageArc($image, $x, $y, $width, $height, $start, $end, $color);

ImageEllipse($image, $x, $y, $width, $height, $color);

ImageEllipse($image, $x, $y, $diameter, $diameter, $color);
    </pre>

<hr />

<h2><a name="drawing_patterned">Drawing with Patterned Lines</a></h2>
<p><b>Problem:</b> You want to draw shapes using line styles other than the default, a solid line.</p>
<p><b>Solution:</b> To draw shapes with a patterned line, use ImageSetStyle() and pass in IMG_COLOR_STYLES as the image color:</p>

<p>Documentation on <a href="http://php.net/imagesetstyle" target="_blank">ImageSetStyle()</a></p>

<pre class="prettyprint">
//make a two-pixel thick black and white dashed line
$black = 0x000000;
$white = 0xFFFFFF;

$style = array($black, $black, $white, $white);
ImageSetStyle($image, $style);

ImageLine($image, 0, 0, 50, 50, IMG_COLOR_STYLED);
ImageFilledRectangle($image, 50, 50, 100, 100, IMG_COLOR_STYLED);
    </pre>


<hr />

<h2><a name="drawing_text">Drawing Text</a></h2>
<p><b>Problem:</b> You want to draw text as a graphic. This allows you to make dynamic buttons or hit counters.</p>
<p><b>Solution:</b> For built-in GD fonts, use ImageString():</p>
<p>For TrueType fonts, use ImageFTText():</p>

<p>Documentation on <a href="http://php.net/imagestring" target="_blank">ImageString()</a></p>
<p>Documentation on <a href="http://php.net/imagestringup" target="_blank">ImageStringUp()</a></p>
<p>Documentation on <a href="http://php.net/imagefttext" target="_blank">ImageFTText()</a></p>

<pre class="prettyprint">
ImageString($image, 1, $x, $y, 'I love PHP Cookbook', $text_color);

ImageFTText($image, $size, 0, $x, $y, $text_color, '/path/to/font.tff',
    'I love PHP Cookbook');
    
    </pre>


<hr />

<h2><a name="drawing_centered">Drawing Centered Text</a></h2>
<p><b>Problem:</b> You want to draw text in the center of an image.</p>
<p><b>Solution:</b> Find the size of the image and the bounding box of the text. Using those coordinates, computer the correct spot to draw the text.</p>
<p>For TrueType fonts, use the ImageFTCenter() function:</p>

<p>Documentation on <a href="http://php.net/imagesx" target="_blank">ImageSX()</a></p>
<p>Documentation on <a href="http://php.net/imagesy" target="_blank">ImageSY()</a></p>
<p>Documentation on <a href="http://php.net/imageftbbox" target="_blank">ImageFTBBox()</a></p>

<pre class="prettyprint">
function ImageFTCenter($image, $size, $angle, $font, $text, $extrainfo = 
        array()){
    //find the size of the image
    $xi = ImageSX($image);
    $yi = ImageSY($image);
    
    //find the size of the text
    $box = ImageFTBBox($size, $angle, $font, $text, $extrainfo);
    
    $xr = abs(max($box[2], $box[4]));
    $yr = abs(max($box[5], $box[7]));
    
    //compute centering
    $x = intval(($xi - $xr) / 2);
    $y = intval(($yi + $yr) / 2);
    
    return array($x, $y);

} 

For Example:
list($x, $y) = ImageFTCenter($image, $size, $angle, $font, $text);
ImageFTText($image, $size, $angle, $x, $y, $fore, $font, $text);  


For built-in GD fonts, use the ImageStringCenter() function:
function ImageStringCenter($image, $text, $font) {
// font sizes
$width = array(1 => 5, 6, 7, 8, 9);
$height = array(1 => 6, 8, 13, 15, 15);
// find the size of the image
$xi = ImageSX($image);
$yi = ImageSY($image);
// find the size of the text
$xr = $width[$font] * strlen($text);
$yr = $height[$font];
// compute centering
$x = intval(($xi - $xr) / 2);
$y = intval(($yi - $yr) / 2);
return array($x, $y);
}
For example:
list($x, $y) = ImageStringCenter($image, $text, $font);
ImageString($image, $font, $x, $y, $text, $fore); 
    </pre>


<hr />

<h2><a name="building_dynamic">Building Dynamic Images</a></h2>
<p><b>Problem:</b> You want to create an image based on an existing image template and dynamic data (Typically text). For instance, you want to create a hit counter.</p>
<p><b>Solution:</b> Load the template image, find the correct position to properly center your text, add the text to the canvas, and send the image to the browser:</p>

<pre class="prettyprint">
include 'imageftcenter.php';

//Configuration settings
$image = ImageCreateFromPNG('/path/to/button.png');//Template image
$size = 24;
$angle = 0;
$color = 0x000000;
$fontfile = '/path/to/font.ttf'; //edit accordingly
$text = $_GET['text']; //or any other source

//Print-centered text
list($x, $y) = ImageFTCenter($image, $size, $angle, $fontfile, $text);
ImageFTText($image, $size, $angle, $x, $y, $color, $fontfile, $text);

//Preserve Transparency
ImageColorTransparent($image,
    ImageColorAllocateAlpha($image, 0, 0, 0, 127));
ImageAlphaBlending($image, false);
ImageSaveAlpha($image, true);

//Send image
header('Content-type: image/png');
ImagePNG($image);

//Clean up
ImagePSFreeFont($font);
ImageDestroy($image);
    </pre>


<hr />

<h2><a name="getting_setting">Getting and Setting a Transparent Color</a></h2>
<p><b>Problem:</b> You want to set one color in an image as transparent. When the image is overlayed on a background, the background shows through the transparent section of the image.</p>
<p><b>Solution:</b> Use ImageColorTransparent():</p>

<p>Documentation on <a href="http://php.net/imagecolortransparent" target="_blank">ImageColorTransparent()</a></p>
<p>Documentation on <a href="http://php.net/imagecolorsforindex" target="_blank">ImageColorsForIndex()</a></p>

<pre class="prettyprint">
$color = 0xFFFFFF;
ImageColorTransparent($image, $color);
    </pre>


<hr />

<h2><a name="overlaying">Overlaying Watermarks</a></h2>
<p><b>Problem:</b> You want to overlay a watermark stamp on top of images.</p>
<p><b>Solution:</b> If your watermark stamp has a transparent background, use ImageCopy() to use alpha channels:</p>
<p>Otherwise, use ImageCopyMerge() with an opacity:</p>

<p>Documentation on <a href="http://php.net/imagecopy" target="_blank">ImageCopy()</a></p>
<p>Documentation on <a href="http://php.net/imagecopymerge" target="_blank">ImageCopyMerge()</a></p>


<pre class="prettyprint">
$image = ImageCreateFromPNG('/path/to/image.png');
$stamp = ImageCreateFromPNG('/path/to/stamp.png');

$margin = ['right' => 10, 'bottom' => 10]; //offset from the edge

ImageCopy($image, $stamp,
    imagesx($image) - imagesx($stamp) - $margin['right'],
    imagesy($image) - imagesy($stamp) - $margin['bottom'],
    0, 0, imagesx($stamp), imagesy($stamp));
<hr />
$image = ImageCreateFromPNG('/path/to/image.png');
$stamp = ImageCreateFromPNG('/path/to/stamp.png');

$margin = ['right' => 10, 'bottom' => 10]; //offset from the edge
$opacity = 50; //between 0 and 100%

ImageCopyMerge($image, $stamp,
    imagesx($image) - imagesx($stamp) - $margin['right'],
    imagesy($image) - imagesy($stamp) - $margin['bottom'],
    0, 0, imagesx($stamp), imagesy($stamp),
    $opacity);

    </pre>


<hr />

<h2><a name="thumbnail">Creating Thumbnail Images</a></h2>
<p><b>Problem:</b> You want to create scaled-down thumbnail images.</p>
<p><b>Solution:</b> Use the ImageCopyResampled() function, scaling the image as needed.</p>

<p>Documentation on <a href="http://php.net/imagecopyresampled" target="_blank">ImageCopyResampled()</a></p>


<pre class="prettyprint">
    <h3 class="nocode">To Shrink Proportionally</h3>

$filename = __DIR__ . '/php.png';
$scale = 0.5; //scale

//Images
$image = ImageCreateFromPNG($filename);
$thumbnail = ImageCreateTrueColor(
    ImageSX($image) * $scale,
    ImageSY($image) * $scale);

//Preserver Transparency
ImageColorTransparent($thumbnail, 
    ImageColorAllocateAlpha($thumbnail, 0, 0, 0, 127));
ImageAlphaBlending($thumbnail, false);
ImageSaveAlpha($thumbnail, true);

//Scale and Copy
ImageCopyResampled($thumbnail, $image, 0, 0, 0, 0,
    ImageSX($thumbnail), ImageSY($thumbnail),
    ImageSX($image), ImageSY($image));

//Send
header('Content-type: image/png');
ImagePNG($thumbnail);
ImageDestroy($image);
ImageDestroy($thumbnail);



    </pre>


<hr />

<h2><a name="reading_exif">Reading EXIF Data</a></h2>
<p><b>Problem:</b> You want to extract metainformation from an image file. This lets you find out when the photo was taken, the image size, and the MIME type.</p>
<p><b>Solution:</b> Use the exif_read_data() function:</p>

<p>Exchangeable Image File Format (EXIF)</p>

<p>Documentation on <a href="http://php.net/exif-read-data" target="_blank">exif_read_data()</a></p>
<p>Documentation on <a href="http://php.net/exif-thumbnail" target="_blank">exif_thumbnail()</a></p>

<pre class="prettyprint">
$exif = exif_read_data('beth-and-seth.jpeg');

print_r($exif);
    </pre>


<hr />

<h2><a name="serving_images">Serving Images Securely</a></h2>
<p><b>Problem:</b> You want to control who can view a set of images.</p>
<p><b>Solution:</b> Don't keep the images in your document root, but store them elsewhere. To deliver a file, manually open it and send it to the browser:</p>

<pre class="prettyprint">
header('Content-type: image/png');
readfile('/path/to/graphic.png');
    </pre>


<hr />

<h2><a name="program">Program: Generating Bar Charts from Poll Results</a></h2>

<pre class="prettyprint">
    <h3 class="nocode">Graphical bar charts</h3>

function bar_chart($question, $answers){
    //define colors to draw the bars
    $colors = array(0xFF6600, 0x009900, 0x3333CC,
        0xFF0033, 0xFFFF00, 0x66FFFF, 0x9900CC);
    $total = array_sum($answers['votes']);
    
    //define spacing values and other magic numbers
    $padding = 5;
    $line_width = 20;
    $scale = $line_width * 7.5;
    $bar_height = 10;
    
    $x = $y = $padding;
    
    //allocate a large palette for drawing, since you don't know
    //the image length ahead of time
    $image = ImageCreateTrueColor(150, 500);
    ImageFilledRectangle($image, 0, 0, 149, 499, 0xE0E0E0);
    $black = 0x000000;
    
    //print the question
    $wrapped = explode("\n", wordwrap($question, $line_width));
    foreach($wrapped as $line){
        ImageString($image, 3, $x, $y, $line, $black);
        $y += 12;
    }
    
    $y += $padding;
    
    //print the answers
    for($i = 0; $i &lt; count($answers['answer']); $i++){
        //format percentage
        $percent = sprintf('%1.1f', 100*$answers['votes'][$i]/$total);
        $bar = sprintf('%d', $scale*$answers['votes'][$i]/$total);
        
        //grab color
        $c = $i % count($colors); //handle cases with more bars than colors
        $text_color = $colors[$c];
        
        //draw bar and percentage numbers
        ImageFilledRectangle($image, $x, $y, $x + $bar,
            $y + $bar_height, $text_color);
        ImageString($image, 3, $x + $bar + $padding, $y,
            "$percent%", $black);
        $y += 12;
        
        //print answer
        $wrapped = explode("\n", wordwrap($answers['answer'][$i], $line_width));
        foreach($wrapped as $line){
            ImageString($image, 2, $x, $y, $line, $black);
            $y += 12;
        }
        $y += 7;
    }
    
    //crop image by copying it
    $chart = ImageCreateTrueColor(150, $y);
    ImageCopy($chart, $image, 0, 0, 0, 0, 150, $y);
    
    //PHP 5.5+ supports
    //$chart = ImageCrop($image, array('x' => 0, 'y' => 0,
    //        'width' => 150, 'height' => $y));
    
    //deliver image
    header ('Content-type: image/png');
    ImagePNG($chart);
    
    //clean up
    ImageDestroy($image);
    ImageDestroy($chart);
}



/** To call this program, create an array holding two parallel arrays: $answers['answ
 *er'] and $answer['votes']. Element $i of each array holds the answer text and the
 *total number of votes for answer $i. Figure 17-14 shows this sample output:
 */
// Act II. Scene II.
$question = 'What a piece of work is man?';
$answers['answer'][] = 'Noble in reason';
$answers['votes'][] = 29;
$answers['answer'][] = 'Infinite in faculty';
$answers['votes'][] = 22;
$answers['answer'][] = 'In form, in moving, how express and admirable';
$answers['votes'][] = 59;
$answers['answer'][] = 'In action how like an angel';
$answers['votes'][] = 45;
bar_chart($question, $answers);
    </pre>






      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>