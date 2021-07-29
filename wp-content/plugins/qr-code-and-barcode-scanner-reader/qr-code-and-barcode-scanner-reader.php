<?php 
/**
 * Plugin Name: QR Code and Barcode Scanner Reader
 * Plugin URI: https://4wp.it/contatti
 * Description: Simple Web QR code and barcode scanner reader for Wordpress
 * Version: 1.0.0
 * Author: 4wpbari
 * Author URI: https://4wp.it/roberto-bottalico/
 * Developer: Roberto Bottalico
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 **/


$QR_Barcode_Scanner_Reader = new QRCodeBarcodeScanner();

class QRCodeBarcodeScanner {
  protected $mwidth;
  protected $mheight;
  public function __construct() {
    add_action( 'wp_enqueue_scripts', array($this, 'qrcodescanner_scripts'), 10, 0  );
    add_action( 'wp_footer', array($this, 'qrcodescanner_fscript'));
    add_shortcode('qrcodescanner', array($this, 'qrcodescanner_shortcode'));
  }
  public function qrcodescanner_scripts() {
    wp_register_script('html5_qrcode', plugins_url('html5-qrcode.min.js', __FILE__), array( 'jquery'),null);

    wp_enqueue_script('html5_qrcode');
  }
public function strLength($str,$len){ 
      $length = strlen($str); 
      if($length > $len){ 
          return substr($str,0,$len).'...'; 
      }else{ 
          return $str; 
      } 
  } 
public function qrcodescanner_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'width' => '320px',
    'height' => '320px'
  ), $atts, 'qrcodescanner' ) );

  $this->mwidth = $width;
  $this->mheight = $height;

  $v = '<div id="qr-reader" style="width:'.$width.';height:'.$height.'"></div>
<div id="qr-reader-results"></div>';
  return $v;
	
  
}
public function qrcodescanner_fscript() {
	?>
        <script>
var resultContainer = document.getElementById('qr-reader-results');
var lastResult, countResults = 0;
			
			
function validURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}

			
function onScanSuccess(qrCodeMessage) {
	window.location.href = qrCodeMessage;
    if (qrCodeMessage !== lastResult) {
        ++countResults;
        lastResult = qrCodeMessage;
        resultContainer.innerHTML 
            += `<div>[${countResults}] - ${qrCodeMessage}</div>`;
    }
	if (validURL(qrCodeMessage)) {
    window.location.href = qrCodeMessage;//if url go to url scanned
  }
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
  </script>
  <?php
  
}
}