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
   
   $tmk_status = tmk_status();
   
   // bottom codes settings of view
   $tmk_statuses_to_control = array( 'tmk-status-off', 'tmk-status-custom' );
   $class[] = ( ! in_array( $tmk_status, $tmk_statuses_to_control ) ) ? '' : 'hide-it';
   $class[] = (   in_array( $tmk_status, $tmk_statuses_to_control ) ) ? '' : 'hide-it';
?>
<div class="article--v2" id="buttonGeneratorApp">
   <div class="grey-row--article">
      <div class="container">
         <div class="row">
            <div class="col-lg-9 controls">
               <div class="row">
                  <div class="col-16">
                     <h2><?php echo wp_kses( __( '<span class="green">Konfigurace</span> tlačítka', 'tomikup-wishlist' ), 'post' ); ?></h2>
                  </div>
               </div>
               <div class="row">
                  <!-- buttonText -->
                  <div class="col-16">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Text tlačítka', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16 suggested-input__wrap">
                           <input class="text form-control list-settings__input api-button-text suggested-input__input" type="text" placeholder="Zadejte text nebo ponechte prázdné" name="buttonText" v-model="buttonText">
                        </div>
                     </div>
                  </div>

                  <!-- fixed -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Umístění tlačítka', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-md-8">
                           <input type="radio" id="positionStatic" v-model="fixed" v-bind:value="false" name="fixed">

                           <label for="positionStatic" class="api-button-option">
                              <span class="label-button-option_text"><?php echo __( 'Bez fixace', 'tomikup-wishlist' ); ?></span>
                           </label>
                        </div>
                        
                        <div class="col-md-8">
                           <input type="radio" id="positionFixed" v-model="fixed" v-bind:value="true" name="fixed">

                           <label for="positionFixed" class="api-button-option">
                              <span class="label-button-option_text"><?php echo __( 'Fixace vpravo uprostřed', 'tomikup-wishlist' ); ?></span>
                           </label>
                        </div>
                     </div>
                  </div>

                  <!-- initial style -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Výchozí styl', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-md-8">
                           <input type="radio" name="default_style" id="styleButton" value="button">

                           <label class="api-button-option" for="styleButton" v-on:click="setAsButton">
                              <span class="label-button-option_text"><?php echo __( 'Tlačítko', 'tomikup-wishlist' ); ?></span>
                           </label>
                        </div>
                        
                        <div class="col-md-8">
                           <input type="radio" name="default_style" id="styleLink" value="link">

                           <label class="api-button-option" for="styleLink" v-on:click="setAsLink">
                              <span class="label-button-option_text"><?php echo __( 'Odkaz', 'tomikup-wishlist' ); ?></span>
                           </label>
                        </div>
                     </div>
                  </div>

                  <!-- iconSize -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Velikost ikony:', 'tomikup-wishlist' ); ?> <span class="green">{{iconSize}} px</span></h3>
                        </div>

                        <div class="col-16 col-md-16">
                           <input class="form-control" type="range" name="iconSize" v-model="iconSize" min="16" max="48">
                        </div>
                     </div>
                  </div>

                  <!-- fontSize -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Velikost písma:', 'tomikup-wishlist' ); ?> <span class="green">{{fontSize}} px</span></h3>
                        </div>

                        <div class="col-16 col-md-16">
                           <input class="form-control" type="range" name="fontSize" v-model="fontSize" min="12" max="32">
                        </div>
                     </div>
                  </div>

                  <div class="col-16 mt-4">
                     <a href="#" class="show-more"><?php echo __( 'Rozšířené možnosti přizpůsobení', 'tomikup-wishlist' ); ?></a>
                  </div>
               </div>

               <div class="row more-options">
                  <!-- fontWeight -->
                  <div class="col-md-16">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Váha písma:', 'tomikup-wishlist' ); ?> <span class="green">{{fontWeightLabel()}}</span></h3>
                        </div>

                        <div class="col-16 col-md-16">
                           <input class="form-control" type="range" name="fontWeightSliderValue" v-model="fontWeightSliderValue" min="0" max="4">
                        </div>
                     </div>
                  </div>

                  <!-- textColor -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Barva textu', 'tomikup-wishlist' ); ?></h3>
                        </div>
                        <div class="col-16">
                           <colorpicker :color="textColor" name="textColor" v-model="textColor" />
                        </div>
                     </div>
                  </div>

                  <!-- textColorHover -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Barva textu při najetí', 'tomikup-wishlist' ); ?></h3>
                        </div>
                        <div class="col-16">
                           <colorpicker :color="textColorHover" name="textColorHover" v-model="textColorHover" />
                        </div>
                     </div>
                  </div>

                  <!-- textUnderline -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="form-group row list-settings__group align-items-center mb-0">
                           <label class="styled-checkbox pl-4">
                              <input class="styled-checkbox__input form-control" name="textUnderline" value="true" type="checkbox" v-model="textUnderline">
                              <span class="styled-checkbox__mark"></span>
                              <span class="styled-checkbox__text">
                                 <h3><?php echo __( 'Podtržení textu', 'tomikup-wishlist' ); ?></h3>
                              </span>
                           </label>
                        </div>
                     </div>
                  </div>

                  <!-- textUnderlineHover -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="form-group row list-settings__group align-items-center mb-0">
                           <label class="styled-checkbox pl-4">
                              <input class="styled-checkbox__input form-control" name="textUnderlineHover" value="true" type="checkbox" v-model="textUnderlineHover">
                              <span class="styled-checkbox__mark"></span>
                              <span class="styled-checkbox__text">
                                 <h3><?php echo __( 'Podtržení při najetí', 'tomikup-wishlist' ); ?></h3>
                              </span>
                           </label>
                        </div>
                     </div>
                  </div>

                  <!-- backgroundColor -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Barva pozadí', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16">
                           <colorpicker :color="backgroundColor" name="backgroundColor" v-model="backgroundColor" />
                        </div>
                     </div>
                  </div>

                  <!-- backgroundColorHover -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Barva pozadí při najetí', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16">
                           <colorpicker :color="backgroundColorHover" name="backgroundColorHover" v-model="backgroundColorHover" />
                        </div>
                     </div>
                  </div>

                  <!-- borderWidth -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Šířka okraje:', 'tomikup-wishlist' ); ?> <span class="green">{{borderWidth}} px</span></h3>
                        </div>

                        <div class="col-16">
                           <input class="form-control" type="range" name="borderWidth" v-model="borderWidth" min="0" max="15">
                        </div>
                     </div>
                  </div>

                  <!-- borderRadius -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Zaoblení okraje:', 'tomikup-wishlist' ); ?> <span class="green">{{borderRadius}} px</span></h3>
                        </div>
                        <div class="col-16">
                           <input class="form-control" type="range"  name="borderRadius" v-model="borderRadius" min="0" max="100">
                        </div>
                     </div>
                  </div>

                  <!-- borderStyle -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Styl okraje', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16">
                           <div class="list-settings__select--wrapper">
                              <select v-model="borderStyle" name="borderStyle" class="text form-control list-settings__select api-button-text">
                                 <option value="solid">solid</option>
                                 <option value="dotted">dotted</option>
                                 <option value="dashed">dashed</option>
                                 <option value="double">double</option>
                                 <option value="hidden">hidden</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- borderStyleHover -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Styl okraje při najetí', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16">
                           <div class="list-settings__select--wrapper">
                              <select v-model="borderStyleHover" name="borderStyleHover" class="text form-control list-settings__select api-button-text">
                                 <option value="solid">solid</option>
                                 <option value="dotted">dotted</option>
                                 <option value="dashed">dashed</option>
                                 <option value="double">double</option>
                                 <option value="hidden">hidden</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- borderColor -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Barva okraje', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16">
                           <colorpicker :color="borderColor" name="borderColor" v-model="borderColor" />
                        </div>
                     </div>
                  </div>

                  <!-- borderColorHover -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Barva okraje při najetí', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16">
                           <colorpicker :color="borderColorHover" name="borderColorHover" v-model="borderColorHover" />
                        </div>
                     </div>
                  </div>

                  <!-- paddingHorizontal -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Horizontální vnitřní okraj:', 'tomikup-wishlist' ); ?> <span class="green">{{paddingHorizontal}} px</span></h3>
                        </div>

                        <div class="col-16">
                           <input class="form-control" type="range" name="paddingHorizontal" v-model="paddingHorizontal" min="0" max="50">
                        </div>
                     </div>
                  </div>

                  <!-- paddingVertical -->
                  <div class="col-md-8">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Vertikální vnitřní okraj:', 'tomikup-wishlist' ); ?> <span class="green">{{paddingVertical}} px</span></h3>
                        </div>

                        <div class="col-16">
                           <input class="form-control" type="range" name="paddingVertical" v-model="paddingVertical" min="0" max="50">
                        </div>
                     </div>
                  </div>

                  <!-- helpUrl -->
                  <div class="col-md-16 mb-5 mb-md-0">
                     <div class="api-button-conf row">
                        <div class="col-16">
                           <h3><?php echo __( 'Odkaz tlačítka &quot;Jak to funguje?&quot;', 'tomikup-wishlist' ); ?></h3>
                        </div>

                        <div class="col-16"><input class="text form-control list-settings__input api-button-link" name="helpUrl" type="text" placeholder="Výchozí" v-model="helpUrl"></div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-lg-7 sticky-scroll-outer">
               <div class="sticky-scroll-inner">
                  <h2><?php echo wp_kses( __( '<span class="green">Náhled</span> tlačítka', 'tomikup-wishlist' ), 'post' ); ?></h2>

                  <div class="api-button-preview">
                     <div v-bind:class="{'api-button-preview-placeholder': !fixed}"><?php echo __( 'Tlačítko naleznete uprostřed pravého okraje obrazovky', 'tomikup-wishlist' ); ?></div>
                     <div id="preview">
                        <div class="tomikup-button" v-bind:class="{'tomikup-fixed': fixed}" :data-json="json()"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="container raw-code-alert <?php echo $class[0]; ?>">
      <p class="notice notice-error tmk-codes-warning"><?php echo __( "Pokud chcete vložit kód ručně nebo přes shortcode [tomikup], musíte aktivovat možnost <a href='#' onclick=\"changeTmkStatus('tmk-status-custom');\">Vložit kód ručně, či přes Shortcode</a>", 'tomikup-wishlist' ); ?></p>
   </div>

   <div class="raw-code container <?php echo $class[1]; ?>">
      <h2 class="article__title"><span class="green"><?php echo __( 'Vygenerované kódy</span> tlačítka', 'tomikup-wishlist' ); ?></h2>

      <div class="row">
         <div class="col-16 col-md-8">
            <p class="article__text"><strong>1/</strong> <?php echo wp_kses( __( 'Tento kód vložte na konec stránky, těsně před uzavírací tag &lt;/body&gt;:', 'tomikup-wishlist' ), 'post' ); ?></p>
         
            <div class="api-button-code-wrapper copybox copybox__textarea">
               <textarea name="default_script" class="api-button-code-textarea copybox-textarea form-control" readonly id="jscode">&lt;script&gt; (function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//www.tomikup.cz/scripts/ext/wishlist.js"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'tomikupsdk')); &lt;/script&gt;</textarea>
               <div class="copy-to-clipboard copy-to-clipboard-textarea clipboard_copy-button copybox-button"></div>
            </div>
         </div>
         
         <div class="col-16 col-md-8">
            <p class="article__text"><strong>2/</strong> <?php echo __( 'Tento kód vložte tam, kde chcete mít tlačítko zobrazené:', 'tomikup-wishlist' ); ?></p>
         
            <div class="api-button-code-wrapper copybox copybox__textarea">
               <autosized-textarea>
                  <textarea name="button_design" class="api-button-code-textarea form-control copybox-textarea" readonly :value.lazy="code()" ref="codeTextarea" style="min-height:33px;"></textarea>
               </autosized-textarea>

               <div class="copy-to-clipboard copy-to-clipboard-textarea clipboard_copy-button copybox-button"></div>
            </div>
         </div>
      </div>
   </div>
</div>