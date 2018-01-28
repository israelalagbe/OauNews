<script src='../jquery.js'></script>
<?php

require_once "src/autoloader.php";

use Imagecow\Image;
//Load the image from file
$image = Image::fromFile('remilekun.jpg');
//Set the image quality
//$image->quality(50);
//Resize the image to max
//@param $width int||string
//@param $height int||string
//Image::resize($width, $height = 0, $cover = false)
$image->resize(200, 200);

$image->opacity(50);

$image->setBackground(array(225, 50, 255)); // set the background to white

//Change the image format
$image->format('jpeg');
//echo '<img src="' . $image->base64() . '">';
//Get the binary data of the string
//echo $image->getString();
?>
<img src='' id='hello' />
<script type='text/javascript'>
	var h=$('#hello');
	
	h.load(function(el){
		var data=h.attr('src');
		alert('done loading')
	});
	h.error(function(el){
		alert('error occured while loading ')
	});
	setTimeout(function(){
		//h.attr('src','');
		
		h.attr('src','<?php echo $image->base64()	?>');
	},1000);
</script>