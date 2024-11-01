<?php
/**
 * @package   Tomikup Wishlist
 * @author    Pavel Mareš
 * @license   GPL-2.0+
 * @link      https://tomikup.cz/
 * @copyright 2020 Tomikup.cz
 */

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) die;
?>
<div class="stuffbox">
   <h2><?php echo __( 'Prémiové funkce', 'tomikup-wishlist' ); ?></h2>

   <div class="inside">
      <div class="submitbox">
         <div id="minor-publishing">
            <div id="misc-publishing-actions">
                <div class="misc-pub-section">
                    <p style="margin-bottom:0;"><?php echo wp_kses( __( "<a href='https://www.tomikup.cz/stat/e-shopy-wishlist' target='_blank'>Podívejte se na marketingové vychytávky Tomikupu</a>, které získáte s prémiovým účtem. Hlídací pes a wishlist jsou jen špičkou ledovce …", 'tomikup-wishlist' ), 'post' ); ?></p>
                </div>
            </div>

            <div class="clear"></div>
         </div>
      </div>
   </div>
</div>

<div class="stuffbox">
   <h2><?php echo __( 'Podpora', 'tomikup-wishlist' ); ?></h2>

   <div class="inside">
      <div class="submitbox">
         <div id="minor-publishing">
            <div id="misc-publishing-actions">
                <div class="misc-pub-section">
                    <p style="margin-bottom:0;"><?php echo wp_kses( __( "V případě jakýchkoliv dotazů nás neváhejte oslovit přes <a href='https://www.facebook.com/tomikup' target='_blank'>Facebooku</a> nebo <a href='https://www.tomikup.cz/stat/contact' target='_blank'>kontaktní formulář</a>.", 'tomikup-wishlist' ), 'post' ); ?></p>
                </div>
            </div>

            <div class="clear"></div>
         </div>
      </div>
   </div>
</div>