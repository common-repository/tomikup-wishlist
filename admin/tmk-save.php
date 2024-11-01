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

   $tmk_status             = tmk_status(); 
   $woocommerce_position   = get_option( 'tmk-woocommerce-position', 'woocommerce_before_add_to_cart_form' );
   $woocommerce_positions  = array(
      'woocommerce_before_add_to_cart_form'     => __( 'Před - přidat do košíku - formulářem', 'tomikup-wishlist' ),
      'woocommerce_before_add_to_cart_button'   => __( 'Před - přidat do košíku - tlačítkem', 'tomikup-wishlist' ),
      'woocommerce_after_add_to_cart_button'    => __( 'Po - přidat do košíku - tlačítku', 'tomikup-wishlist' ),
      'woocommerce_after_add_to_cart_form'      => __( 'Po - přidat do košíku - formuláři', 'tomikup-wishlist' ),
   );
?>
<div id="submitdiv" class="stuffbox">
   <h2><?php echo __( 'Uložit', 'tomikup-wishlist' ); ?></h2>

   <div class="inside">
      <div class="submitbox">
         <div id="minor-publishing">
            <div id="misc-publishing-actions">
               <?php if( tmk_is_woo() ): ?>
               <div class="misc-pub-section" id="woocommerce-status">
                  <fieldset id="woocomerce-status-radio">
                     <legend class="screen-reader-text"><?php echo __( 'Zobrazit u Produktů (WooCommerce)', 'tomikup-wishlist' ); ?></legend>
                     <label>
                        <input type="radio" name="tmk-status" <?php tmk_check_status( 'tmk-status-woo', $tmk_status, true ); ?> value="tmk-status-woo">
                        <?php echo __( 'Zobrazit u Produktů (WooCommerce)', 'tomikup-wishlist' ); ?>
                     </label>
                  </fieldset>
               </div>
               
               <div class="misc-pub-section" id="woocommerce-status">
                  <fieldset id="woocomerce-status-radio">
                     <select name="tmk-woocommerce-position" class="tmk-woocommerce-position" id="tmk-woocommerce-position">
                        <?php foreach ( $woocommerce_positions as $key => $value ): ?>
                        <option <?php echo ( $key == $woocommerce_position ) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </fieldset>
               </div>

               <hr />
               <?php endif; ?>

               <div class="misc-pub-section" id="button-status">
                  <fieldset id="woocomerce-status-radio">
                     <legend class="screen-reader-text"><?php echo __( 'Zobrazit všude (fixace)', 'tomikup-wishlist' ); ?></legend>
                     <label>
                        <input type="radio" name="tmk-status" <?php tmk_check_status( 'tmk-status-fixed', $tmk_status, true ); ?> value="tmk-status-fixed">
                        <?php echo __( 'Zobrazit všude (fixace)', 'tomikup-wishlist' ); ?>
                     </label>
                  </fieldset>
               </div>

               <div class="misc-pub-section" id="button-status">
                  <fieldset id="woocomerce-status-radio">
                     <legend class="screen-reader-text"><?php echo __( 'Vložit kód ručně, či přes Shortcode', 'tomikup-wishlist' ); ?></legend>
                     <label>
                        <input type="radio" name="tmk-status" <?php tmk_check_status( 'tmk-status-custom', $tmk_status, true ); ?> value="tmk-status-custom">
                        <?php echo __( 'Vložit kód ručně, či přes Shortcode', 'tomikup-wishlist' ); ?>
                     </label>
                  </fieldset>
               </div>

               <div class="misc-pub-section" id="button-status">
                  <fieldset id="woocomerce-status-radio">
                     <legend class="screen-reader-text">Vypnout vkládání<?php echo __( 'Vypnout vkládání', 'tomikup-wishlist' ); ?></legend>
                     <label>
                        <input type="radio" name="tmk-status" <?php tmk_check_status( 'tmk-status-off', $tmk_status, true ); ?> value="tmk-status-off">
                        <?php echo __( 'Vypnout vkládání', 'tomikup-wishlist' ); ?>
                     </label>
                  </fieldset>
               </div>
            </div>

            <div class="clear"></div>
         </div>
         <div id="major-publishing-actions">
            <div id="publishing-action">
               <?php wp_nonce_field( 'tmk_nonce_action', 'tmk_nonce_field' ); ?>
               <input type="submit" name="tmk-save" id="save" class="button button-primary button-large" value="Aktualizovat">
            </div>
            
            <div class="clear"></div>
         </div>
      </div>
   </div>
</div>