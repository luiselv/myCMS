<?php
$pReferer = $_SERVER['HTTP_REFERER'];
$pMessage = stripslashes($_REQUEST['tznMessage']);
$pMessage = preg_replace("/<script[^>]*>[^<]+<\/script[^>]*>/is"
	,"", $pMessage); 
$pMessage = preg_replace("/<\/?(div|span|iframe|frame|input|"
	."textarea|script|style|applet|object|embed|form)[^>]*>/is"
	,"", $pMessage);
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Error 404</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <style>
	#overlays {left: 0;position: fixed;top: 0;width: 100%;z-index: 999999;}
	#overlays.info {background: -moz-linear-gradient(white, #cccccc) repeat scroll 0 0 transparent;height: 100%;}
#overlays.info > .wrapper {height: 300px;left: 50%;margin-left: -45%;margin-top: -150px;position: absolute;text-align: center;top: 50%;width: 90%;z-index: 99999;}
#overlays.info #notifications {box-shadow: 0 -1px 0 white inset, 0 2px 0 0 rgba(0, 0, 0, 0.2);z-index: 5;}
#overlays.info > .wrapper h2 {font-family: Arial,sans-serif;font-size: 60px;font-weight: normal;text-align: center;margin-top: 10px;margin-bottom:10px;}
#overlays.info > .wrapper .icon {display: block;font-family: Icons;font-size: 100px;text-align: center;width: 100%;}
#overlays.info > .wrapper .desc {background: none repeat scroll 0 0 #000;border-radius: 4px 4px 4px 4px;color: #fff;display: inline-block;margin-top: 20px;padding: 10px 15px;box-shadow: 0 0 50px rgba(0, 0, 0, 0.15), 0 1px 40px rgba(0, 0, 0, 0.1) inset;border:1px solid #c5c5c5;min-width:300px;}
#overlays.info > .wrapper h2 span {font-weight: bold;}
#overlays.info > .wrapper .desc a {color:#fff;text-decoration:none;font-family:Arial, Helvetica, sans-serif;}
.particles {height: 100%;position: absolute;top: 0;width: 100%;z-index: 1;}
@font-face {
    font-family: 'Icons';
    src: url('_css/fonts/icons/glyph.eot');
    src: url('_css/fonts/icons/glyph.eot?#iefix') format('embedded-opentype'),
         url('_css/fonts/icons/glyph.woff') format('woff'),
         url('_css/fonts/icons/glyph.ttf') format('truetype'),
         url('_css/fonts/icons/glyph.svg#iconSweetsRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}
.glyph {position: relative;padding-left: 20px;}
/*Icons*/
.glyph:before {font-family: Icons;line-height: 0px;padding-right: 5px;font-weight: normal!important;}
.glyph.location:before {content: '`';}
.glyph.home:before {content: '0';}
.glyph.home-alt:before {content: '1';}
.glyph.photo:before {content: '2';}
.glyph.photos:before {content: '3';}
.glyph.microphone:before {content: '4';}
.glyph.sound:before {content: '5';}
.glyph.megafon:before {content: '6';}
.glyph.sign:before {content: '7';}
.glyph.pencil:before {content: '8';}
.glyph.brush:before {content: '9';}
.glyph.person:before {content: 'a';}
.glyph.persons:before {content: 'b';}
.glyph.three-persons:before {content: 'c';}
.glyph.man:before {content: 'd';}
.glyph.men:before {content: 'e';}
.glyph.three-men:before {content: 'f';}
.glyph.folder:before {content: 'g';}
.glyph.heart:before {content: 'h';}
.glyph.settings:before {content: 'i';}
.glyph.settings-alt:before {content: 'j';}
.glyph.retweet:before {content: 's';}
.glyph.tag:before {content: '.';}
.glyph.message:before {content: '#';}
.glyph.write:before {content: 'C';}
.glyph.upload:before {content: 'I';}
.glyph.drawer:before {content: 'L';}
.glyph.maps:before {content: 'N';}
.glyph.star-alt:before {content: 'W';}
.glyph.star:before {content: '*';}
.glyph.sort:before {content: "|";}
</style>
		<script type="text/javascript" src="_js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" >
	(function($){
		$.info = function(options) {
		var defaults = { 
			icon: "!",
			type: "Error",  
			title: "404",
			desc: "An error occurred",
			theme: undefined
		};  
		var o = $.extend(defaults, options); 	
		var container;
		function create() {
			remove();
			container = $('<div class="particles" />');	
			$('#overlays').prepend(container);
			$(".particles").live("tap", function() {
				remove();
			});		
		}
		function remove() {
			$(".particles").remove();
		}
		$.getScript("_js/plugins/three.js", function(){
				create();
				var camera, scene, renderer, group, particle;
				var mouseX = 0, mouseY = 0;			
				var windowHalfX = window.innerWidth / 2;
				var windowHalfY = window.innerHeight / 2;			
				init();
				animate();
				function init() {
					camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 3000 );
					camera.position.z = 1000;
					scene = new THREE.Scene();
					scene.add( camera );
					var PI2 = Math.PI * 2;
					var program = function ( context ) {
						context.beginPath();
						context.arc( 0, 0, 1, 0, PI2, true );
						context.closePath();
						context.fill();
					}
					group = new THREE.Object3D();
					scene.add( group );
					for ( var i = 0; i < 120; i++ ) {
						particle = new THREE.Particle( new THREE.ParticleCanvasMaterial( { color: Math.random() * 0xFFFDD0 + 0xffd800, program: program } ) );
						particle.position.x = Math.random() * 2000 - 1000;
						particle.position.y = Math.random() * 2000 - 1000;
						particle.position.z = Math.random() * 2000 - 1000;
						particle.scale.x = particle.scale.y = Math.random() * 10 + 5;
						group.add( particle );
					}
					renderer = new THREE.CanvasRenderer();
					renderer.setSize( window.innerWidth, window.innerHeight );
					container.append( renderer.domElement );
					document.addEventListener( 'mousemove', onDocumentMouseMove, false );
					document.addEventListener( 'touchstart', onDocumentTouchStart, false );
					document.addEventListener( 'touchmove', onDocumentTouchMove, false );
				}
				function onDocumentMouseMove( event ) {mouseX = event.clientX - windowHalfX;mouseY = event.clientY - windowHalfY;}
				function onDocumentTouchStart( event ) {
					if ( event.touches.length == 1 ) {event.preventDefault();mouseX = event.touches[ 0 ].pageX - windowHalfX;mouseY = event.touches[ 0 ].pageY - windowHalfY;}
				}
				function onDocumentTouchMove( event ) {
					if ( event.touches.length == 1 ) {
						event.preventDefault();
						mouseX = event.touches[ 0 ].pageX - windowHalfX;
						mouseY = event.touches[ 0 ].pageY - windowHalfY;
					}
				}
				function animate() {requestAnimationFrame( animate );render();}
				function render() {
					camera.position.x += ( mouseX - camera.position.x ) * 0.25;
					camera.position.y += ( - mouseY - camera.position.y ) * 0.25;
					camera.lookAt( scene.position );
					//group.rotation.x += 0.00001;
					//group.rotation.y += 0.00002;
					renderer.render( scene, camera );
				}
				// make code pretty
				window.prettyPrint && prettyPrint()
		}).fail(function(jqxhr, settings, exception) {create();}); 	
	};
	})(jQuery);
$(document).ready(function(){$.info();});
</script>

</head>

<body>
<div id="overlays" class="info">
	<div class="particles"></div>
    <div class="wrapper">
    	<span class="icon">!</span>
        <h2>Error: <span>404</span></h2>        
          <span class="desc" >
	          <?php  
	if ($_REQUEST['tznMessage']) {echo $pMessage;}
    if ($_SERVER['HTTP_REFERER']) {
  ?>
    <p><a href="<?php echo $_SERVER['../HTTP_REFERER']; ?>">Click to go back and try again</a></p>
  <?php
    } else if (!preg_match('/error\.php$/',$_SERVER['PHP_SELF'])) {
  ?>
    <p><a href="javascript:window.location.reload(true)">Click to try again</a></p>
  <?php
    }else{
  ?>     
  	 <p><a href="index.php">Back to home</a></p>
  <?php } ?>       
      </span>
    </div>
</div>
</body>
</html>