<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

<div class="page-header">
        <h1>5-Minute PNG Image Optimization</h1>
</div>

<p>
A great way to improve the performance of your site is to optimize the size of your images. Smaller image sizes require less bandwidth, disk space and load time, and ultimately improve visitor experience. In this article, I share my effective 5-minute technique for optimizing PNG images. This is a two-step, lossless optimization process that removes as much extraneous data as possible without sacrificing any image quality whatsoever. It’s fast, free, and highly effective.
</p>

<hr />
<h3>Step 1: Optimize with OptiPNG or Pngcrush</h3>

<p>For the first (and most important) step in our image-optimization process, we want to run our PNG images through a command-line optimizer like OptiPNG or Pngcrush (404 link removed 2015/07/21).</p>

<p>Either of these powerful programs will remove unnecessary data from your PNG images without reducing image quality. Both are excellent programs that work beautifully. Here are the commands that I use to optimize my images with either OptiPNG or Pngcrush.</p>

<hr />
<h4>PNGcrush</h4>
<p>If you decide to use PNGcrush, try this command for great results:</p>
<div class="code">
pngcrush -rem allb -brute -reduce original.png optimized.png

</div>
<p>Quick break down of the different parameters:</p>
<ul>
	<li><b>pngcrush</b> - run the pngcrush program</li>
    <li><b>-rem allb</b> - remove all extraneous data</li>
    <li><b>-brute</b> - attempt all optimization methods</li>
    <li><b>-reduce</b> - eliminate unused colors and reduce bit-depth</li>
    <li><b>original.png</b> - the name of the original (unoptimized) PNG file</li>
    <li><b>optimized.png</b> - the name of the new, optimized PNG file</li>
</ul>

<hr />
<h4>OptiPNG</h4>
<p>If you decide to use OptiPNG, throw down with this fine command:</p>
<div class="code">
optipng -o7 original.png

</div>
<p>OptiPNG is very straightforward (and very effective):</p>
<ul>
	<li><b>optipng</b> - run the optipng program</li>
    <li><b>-o7</b> - optimize the image at the highest possible level</li>
    <li><b>-original.png</b> - the name of the PNG file to be optimized</li>
</ul>

<p>Or, to batch process an entire directory of PNG images, use this:</p>
<div class="code">
optipng -o7 *.png

</div>	

<p>Important note: to keep a backup of the modified files, include the -k parameter before the file name within the execution command. Just in case!</p>

<hr />
<h3>Step 2: Optimize with Smush.it</h3>
<p>Now that you have stripped out all the extraneous data from your PNGs, it’s time to smush ‘em even more with the powerful Smush.it online optimizer. It’s so easy. Simply click on the “Uploader” tab, upload your images, and let Smush.it do its thing. Smush.it optimizes your images on the fly and even returns a summary of the saved bytes and percentages. I always get a sh.it-eating grin on my face whenever I use this excellent service. ;)</p>

<p>And that’s all there is to it! Once you are done uploading your images to Smush.it, download the provided zip file and compare your optimized file sizes with those of your original images. If all goes well, you should enjoy anywhere from a 5% to 30% (or more) reduction in size, depending on the complexity and size of your images. And best of all, this fast, free and effective technique is completely lossless, meaning that your images suffer absolutely no loss of quality. Nice :)</p>



<hr />
<a href="https://perishablepress.com/png-image-optimization/" target="_blank">Original Source</a>
<hr />

</div>

<?php require_once(assets("includes/footer.php")); ?>