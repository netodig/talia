<?
if(extension_loaded('zlib')){ob_start('ob_gzhandler');} 
header("Content-type: text/jscript");
include("jquery.js");
include("jquery.ui.core.js");
include("jquery.ui.widget.js");
include("jquery_validate.js");
include("jquery.ui.mouse.js");
include("jquery.ui.slider.js");
include("jquery.ui.datepicker.js");
include("jquery.magnific-popup.min.js");
include("jquery.tooltipster.min.js");
include("npframej.js");
include("npframe.js");
include("funcionesfront.js");
if(extension_loaded('zlib')){ob_end_flush();}

?>