<?php
require_once(dirname(dirname(dirname(__DIR__))) . "/Classes/System/Root.php");

$root = new Root();
?>
<img id="camera_video" class="img-responsive margin_auto image_preload" src="<?php echo $root->getIpCamera()->getVideoUrl(); ?>" alt="Video"/>
<div id="camera_video_area"></div>