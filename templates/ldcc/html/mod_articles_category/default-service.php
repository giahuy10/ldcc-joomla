<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<section class="section-md text-center" id="services">
   <div class="container">
      <div class="row justify-content-lg-center">
         <div class="col-lg-10 col-xl-8">
            <h4 class="heading-decorated"><?php echo JText::_('MOD_ARTICLES_CATEGORY_OUR_SERVICES'); ?></h4>
            <p><?php echo JText::_('MOD_ARTICLES_CATEGORY_OUR_SERVICES_DESC'); ?></p>
         </div>
      </div>
      <div class="row row-50">
      <?php foreach ($list as $item) { ?>
      <?php // var_dump($item)?>
         <div class="col-md-6 col-lg-4">
            <!-- Blurb circle-->
            <article class="blurb blurb-circle blurb-circle_centered">
               <div class="blurb-circle__icon"><span class="icon linear-icon-<?php echo $item->metakey?>"></span></div>
               <p class="blurb__title"><a href="<?php echo $item->link?>"><?php echo $item->title?></a></p>
               <p><?php echo strip_tags($item->introtext)?></p>
            </article>
         </div>
      <?php } ?>
      </div>
   </div>
</section>