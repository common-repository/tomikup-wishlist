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
<div class="wrap">
    <h1 class="mb-3"><?php echo __( 'Tomikup Nastavení', 'tomikup-wishlist' ); ?></h1>
        
    <div id="poststuff">
        <form id="post-body" class="metabox-holder columns-2" method="POST">
            <div id="post-body-content" class="edit-form-section edit-comment-section">
                <?php require_once( TMKDIR . 'admin/tmk-generator.php' ); ?>
            </div>

            <div id="postbox-container-1" class="postbox-container">
                <?php require_once( TMKDIR . 'admin/tmk-save.php' ); ?>
                <?php require_once( TMKDIR . 'admin/tmk-premium.php' ); ?>
            </div>
        </form>
    </div>
</div>