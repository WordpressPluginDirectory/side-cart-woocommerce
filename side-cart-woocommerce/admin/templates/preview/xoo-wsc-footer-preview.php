<?php

$subtotal = wc_price(100);

?>

<# if ( data.informationBoxLocation === 'footer_start' || data.informationBoxLocation === 'mobile_body' ) { #>
	<?php echo $information_box ?>
<# } #>


<?php echo $footer_template ?>

<# if ( data.footer.footerTxt ) { #>
<span class="xoo-wsc-footer-txt">{{{data.footer.footerTxt}}}</span>
<# } #>


<div class="xoo-wsc-ft-buttons-cont">

	<# _.each( data.footer.buttonsPosition, function( key ) { #>
		<# if( data.footer.buttonsText[key] ){ #>
			<a href="#" class="xoo-wsc-ft-btn xoo-wsc-ft-btn-{{key}}">{{{data.footer.buttonsText[key]}}} <# if( key === 'checkout' && data.footer.checkoutTotal === 'yes' ){ #>  -  <?php echo $subtotal; ?> <# } #></a>
		<# } #>
	<# }) #>

</div>

<# if ( data.informationBoxLocation === 'footer_end' ) { #>
	<?php echo $information_box ?>
<# } #>

