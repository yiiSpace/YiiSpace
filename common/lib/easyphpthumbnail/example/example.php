<?php

// Examples of use for EasyPhpThumbnail 
// NOTE: Copy the PHP4 or PHP5 class file to the directory 'inc' first!

include_once('inc/easyphpthumbnail.class.php');
$thumb = new easyphpthumbnail;

// Set thumbsize - automatic resize for landscape or portrait
$thumb -> Thumbsize = 300;

// Add a frame around the picture
// $thumb -> Framewidth = 10;
// $thumb -> Framecolor = '#000000';

// Add copyright text in TTF 
// $thumb -> Copyrighttext = 'MYWEBMYMAIL.COM';
// $thumb -> Copyrightposition = '50% 90%';
// $thumb -> Copyrightfonttype = 'gfx/handwriting.ttf';
// $thumb -> Copyrightfontsize = 30;
// $thumb -> Copyrighttextcolor = '#FFFFFF';

// Set thumbsize to 200px height
// $thumb -> Thumbheight = 200;

// Set thumbsize to 200px width
// $thumb -> Thumbwidth = 200;

// Set resizing to percentage instead of pixels
// $thumb -> Thumbsize = 80;
// $thumb -> Percentage = true;

// Allow images to be enlarged (inflated)
// $thumb -> Thumbsize = 800;
// $thumb -> Inflate = true;

// Set JPG output quality 0 - 100%
// $thumb -> Quality = 60;

// Drop shadow around the thumbnail
// $thumb -> Backgroundcolor = '#D0DEEE';
// $thumb -> Shadow = true;

// Clip some corners and blend in with background color
// $thumb -> Backgroundcolor = '#D0DEEE';
// $thumb -> Clipcorner = array(1,15,0,1,1,1,1);

// Clip transparent corners
// $thumb -> Backgroundcolor = '#00FF00';
// $thumb -> Clipcorner = array(2,15,0,1,1,1,1);
// $thumb -> Maketransparent = array(1,0,'#00FF00',30);

// Age the image (reduces colors to 255)
// $thumb -> Ageimage = array(1,10,80);

// Add a border PNG image 
// $thumb -> Borderpng = 'gfx/border.png';

// Add a binder (needs a frame!)
// $thumb -> Framewidth = 10;
// $thumb -> Framecolor = '#000000';
// $thumb -> Binder = true;
// $thumb -> Binderspacing = 8;

// Rotate the image from landscape to portrait, clockwise
// $thumb -> Rotate = 90;

// Flip the image horizontally
// $thumb -> Fliphorizontal = true;

// Flip the image upside down
// $thumb -> Flipvertical = true;

// Rotate the image without cropping (slow)
// $thumb -> Rotate = -30;

// Rotate and crop the image
// $thumb -> Rotate = -30;
// $thumb -> Croprotate = true;
// $thumb -> Backgroundcolor = '#D0DEEE';

// Create a square canvas
// $thumb -> Square = true;

// Crop the image to a square
// $thumb -> Cropimage = array(3,0,0,0,0,0);

// Add a watermark
// $thumb -> Watermarkpng = 'gfx/watermark.png';
// $thumb -> Watermarkposition = '80% 20%';
// $thumb -> Watermarktransparency = 70;

// Apply a pre defined filter to the image (slow in PHP4)
// $thumb -> Edge = true;
// $thumb -> Emboss = true;
// $thumb -> Sharpen = true;
// $thumb -> Blur = true;
// $thumb -> Mean = true;

// Apply a custom filter to the image (slow in PHP4)
// $thumb -> Filter = array(-1,-1,-1,-1,8,-1,-1,-1,-1);
// $thumb -> Divisor = 1;
// $thumb -> Offset = 0;
// $thumb -> Applyfilter = true;

// Apply a perspective to the image
// $thumb -> Perspective = array(1,0,20);
// $thumb -> Backgroundcolor = '#D0DEEE';

// Apply a perspective to the thumbnail
// $thumb -> Perspectivethumb = array(1,1,25);
// $thumb -> Backgroundcolor = '#D0DEEE';

// Apply a shading effect
// $thumb -> Shading = array(1,70,80,0);
// $thumb -> Shadingcolor = '#D0DEEE';

// Apply a mirror effect
// $thumb -> Mirror = array(1,10,70,40,2);
// $thumb -> Mirrorcolor = '#D0DEEE';
// $thumb -> Backgroundcolor = '#D0DEEE';

// Apply a negative effect
// $thumb -> Negative = true;

// Replace a color
// $thumb -> Colorreplace = array(1,'#FFFFFF','#FF6600',60);

// Reposition pixels randonly
// $thumb -> Pixelscramble = array(1,4,2);

// Convert to greyscale
// $thumb -> Greyscale = true;

// Change Brightness
// $thumb -> Brightness = array(1,50);

// Merge a color
// $thumb -> Colorize = array(1,0,0,125,0);

// Pixelate the image
// $thumb -> Pixelate = array(1,10);

// Change Contrast
// $thumb -> Contrast = array(1,30);

// Change Gamma
// $thumb -> Gamma = array(1,0.5);

// Change Palette
// $thumb -> Palette = array(1,64);

// Remove noise
// $thumb -> Medianfilter = true;

// Twirl FX
// $thumb -> Twirlfx = array(1,20,0);

// Ripple FX
// $thumb -> Ripplefx = array(1,5,15,5,5);

// Lake FX
// $thumb -> Lakefx = array(1,15,80);

// Waterdrop FX
// $thumb -> Waterdropfx = array(1,1.2,400,40);

// Transparent image
// $thumb -> Maketransparent = array(1,0,'#171915',30);

// Animated PNG
// First we create some new PNG thumbnails
// Then we create the animation
// set_time_limit(0);
// $frames = array();
// $thumb -> Thumbsaveas = 'png';
// $thumb -> Chmodlevel = '0755';
// $thumb -> Thumbprefix = '';
// $thumb -> Thumblocation = '';
// $thumb -> Copyrighttext = 'MYWEBMYMAIL.COM';
// $thumb -> Copyrightfonttype = 'gfx/handwriting.ttf';
// $thumb -> Copyrighttextcolor = '#FFFFFF';
// for ($i = 1; $i <= 8; $i++) {
//	$frames[] = "frame$i.png";
//	$thumb -> Thumbfilename = "frame$i.png";
//	$thumb -> Copyrightposition = '50% 50%';
//	$thumb -> Copyrightfontsize = $i*4;
	// You can also add the waterdrop effect, but it might (will) time out!
	// $thumb -> Waterdropfx = array(1,$i/6,400,40);
//	$thumb -> Createthumb('gfx/image.jpg','file');
// }
// Create the animation
// $thumb -> Create_apng($frames, 'animation.png', 250);
// Show the animation
// echo "<img src='animation.png'>";

// Apply Polaroid look 
// $thumb -> Thumbsize = 300;
// $thumb -> Shadow = true;
// $thumb -> Polaroid = true;
// $thumb -> Polaroidtext = 'MYWEBMYMAIL.COM';
// $thumb -> Polaroidfonttype = 'gfx/handwriting.ttf';
// $thumb -> Polaroidfontsize = '30';
// $thumb -> Polaroidtextcolor = '#000000';

// Output the base64 thumbnail code (html embedded images)
// Note: some browsers have a limited length URI so large images could not show completely
// echo '<img src="' . $thumb -> Createbase64('gfx/image.jpg') . '" />';

// Create a banner from a canvas and add some effects
// $thumb -> Createcanvas(300,50,IMAGETYPE_PNG,'#D0DEEE',false);
// $thumb -> Addtext = array(1,'MYWEBMYMAIL.COM','50% 50%','gfx/handwriting.ttf',20,'#FF0000');
// $thumb -> Ripplefx = array(1,3,12,0,0);
// $thumb -> Framewidth = 10;
// $thumb -> Framecolor = '#FF6600';
// $thumb -> Backgroundcolor = '#D0DEEE';
// $thumb -> Shadow = true;
// $thumb -> Createthumb();

// *******************************************************
// Example of some combined effects
// $thumb -> Thumbsize = 300;
// $thumb -> Copyrighttext = 'MYWEBMYMAIL.COM';
// $thumb -> Copyrightposition = '50% 80%';
// $thumb -> Copyrightfonttype = 'gfx/handwriting.ttf';
// $thumb -> Copyrightfontsize = 20;
// $thumb -> Copyrighttextcolor = '#FFFFFF';
// $thumb -> Borderpng = 'gfx/border.png';
// $thumb -> Backgroundcolor = '#D0DEEE';
// $thumb -> Mirror = array(1,30,90,40,2);
// $thumb -> Mirrorcolor = '#D0DEEE';
// $thumb -> Displacementmap = array(1,'gfx/displacementmap_ball.jpg',0,0,0,50,50);
// $thumb -> Displacementmapthumb = array(1,'gfx/displacementmap.jpg',0,0,200,25,25);
// *******************************************************

// Create the thumbnail and output to file
// $thumb -> Thumblocation = 'gfx/';
// $thumb -> Thumbprefix = 'test_';
// $thumb -> Thumbsaveas = 'png';
// $thumb -> Thumbfilename = 'mynewfilename.png';
// $thumb -> Createthumb('gfx/image.jpg','file');

// Remove EXIF information from JPG file
// $thumb -> wipe_exif('gfx/image.jpg', 'gfx/noexifimage.jpg');
// exit; // We don't want to create a thumb (see last line below)

// Read EXIF information from JGP file, preserve it and insert it again after image manipulation
// $exifdata = $thumb -> read_exif('gfx/image.jpg');
// $thumb -> Thumblocation = 'gfx/';
// $thumb -> Thumbprefix = '';
// $thumb -> Thumbfilename = 'exifthumb.jpg';
// $thumb -> Createthumb('gfx/image.jpg', 'file');
// $thumb -> insert_exif('gfx/exifthumb.jpg', $exifdata);
// exit; // We don't want to create another thumb (see last line below)

// Create the thumbnail and output to screen
$thumb -> Createthumb('gfx/image.jpg');

?>





