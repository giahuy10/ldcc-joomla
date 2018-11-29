<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;http://funschool.net/uploadcourse/uploads/FF2_Unit%203_Further%20Practice%20.docx
JLoader::register(
    'FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php'
);
// echo $params->get('catid')[0]
?>
<section class="section-md bg-default text-center" id="portfolio">
  <div class="container">
    <h4 class="heading-decorated"><?php echo JText::_('MOD_ARTICLES_CATEGORY_COMPLETED_PROJECTS'); ?></h4>
    <div class="isotope-wrap row row-70">
      <div class="col-sm-12">
        <ul class="list-nav isotope-filters isotope-filters-horizontal">
          <li><a class="active" data-isotope-filter="*" data-isotope-group="gallery" href="#"><?php echo JText::_('MOD_ARTICLES_CATEGORY_ALL'); ?></a></li>
          <li><a data-isotope-filter="Category 3" data-isotope-group="gallery" href="#"><?php echo JText::_('MOD_ARTICLES_CATEGORY_DEVELOPMENT'); ?></a></li>
          <li><a data-isotope-filter="Category 2" data-isotope-group="gallery" href="#"><?php echo JText::_('MOD_ARTICLES_CATEGORY_DESIGN'); ?></a></li>
          <li><a data-isotope-filter="Category 1" data-isotope-group="gallery" href="#"><?php echo JText::_('MOD_ARTICLES_CATEGORY_SOLUTION'); ?></a></li>
        </ul>
        <div class="isotope row" data-isotope-layout="fitRows" data-isotope-group="gallery" style="position: relative; height: 2338.27px;">
        <?php foreach ($list as $item) { ?>
       
        <?php $fields = FieldsHelper::getFields('com_content.article',  $item);?>
          <div class="col-12 col-md-6 col-lg-4 isotope-item" data-filter="Category <?php echo $fields[0]->value?>" style="position: absolute; left: 0px; top: 0px;">
            <div class="thumb thumb--effect-julia"><img src="<?php echo json_decode($item->images)->image_intro?>" alt="<?php echo $item->title; ?>">
              <div class="thumb__overlay">
                <h4 class="thumb__title"><?php echo $item->title; ?></span>
                </h4>
                <div>
                  
                </div><a class="thumb__overlay__link" href="<?php echo $item->link; ?>"><?php echo JText::_('MOD_ARTICLES_CATEGORY_READMORE'); ?></a>
              </div>
            </div>
          </div>
        <?php }?>
        </div>
      </div>
    </div>
    
    <a class="btn-anis btn-anis-primary" href="<?php echo JRoute::_('index.php?option=com_content&view=category&layout=blog&id='.$params->get('catid')[0])?>"><?php echo JText::_('MOD_ARTICLES_CATEGORY_READMORE'); ?></a>
  </div>
</section>