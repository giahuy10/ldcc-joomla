<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

if ($task === 'edit' || $layout === 'form')
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add template js
JHtml::_('script', 'core.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'script.js', array('version' => 'auto', 'relative' => true));
// Add html5 shiv
// JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
// JHtml::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));

// Use of Google Font
if ($this->params->get('googleFont'))
{
	JHtml::_('stylesheet', 'https://fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}



// Check for a custom CSS file
JHtml::_('stylesheet', 'bootstrap.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'style.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'fonts.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'user.css', array( 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'user.js', array('version' => 'auto', 'relative' => true));
unset($this->_scripts['/media/jui/js/bootstrap.min.js']);
unset($this->_scripts['/media/jui/js/jquery.min.js']);
unset($this->_scripts['/media/jui/js/jquery-noconflict.js']);
unset($this->_scripts['/media/jui/js/jquery-migrate.min.js']);
unset($this->_scripts['/media/system/js/core.js']);
unset($this->_scripts['/media/system/js/caption.js']);
unset($this->_scripts['/media/system/js/keepalive']);

// Load optional RTL Bootstrap CSS
// JHtml::_('bootstrap.loadCss', false, $this->direction);

// var_dump($this->_scripts);
// Adjusting content width
$position7ModuleCount = $this->countModules('position-7');
$position8ModuleCount = $this->countModules('position-8');

if ($position7ModuleCount && $position8ModuleCount)
{
	$span = 'span6';
}
elseif ($position7ModuleCount && !$position8ModuleCount)
{
	$span = 'span9';
}
elseif (!$position7ModuleCount && $position8ModuleCount)
{
	$span = 'span9';
}
else
{
	$span = 'span12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '')
	. ($this->direction === 'rtl' ? ' rtl' : '');
?>">
<div class="preloader">
      <div class="cssload-container">
        <div class="cssload-speeding-wheel"></div>
        <p>Loading...</p>
      </div>
    </div> 
	<!-- Body -->
	<div class="page" id="top">
				<header class="page-header">
			<!-- RD Navbar-->
			<div class="rd-navbar-wrap">
				<nav class="rd-navbar rd-navbar_corporate" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-sm-device-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-stick-up-clone="false" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-md-stick-up-offset="60px" data-lg-stick-up-offset="145px" data-xl-stick-up-offset="145px" data-xxl-stick-up-offset="145px" data-body-class="rd-navbar-corporate-linked">
					<!-- RD Navbar Panel-->
					<div class="rd-navbar-panel">
						<button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
						<!-- RD Navbar Brand-->
						<div class="rd-navbar-brand rd-navbar-static--hidden"><a class="brand-name" href="/"><img src="images/logo.png" alt="" width="157" height="21"/></a></div>
					</div>
					<!-- RD Navbar Top Panel-->
					<div class="rd-navbar-top-panel rd-navbar-top-panel_extended">
						<div class="rd-navbar-top-panel__main">
							<div class="rd-navbar-top-panel__toggle rd-navbar-fixed__element-1 rd-navbar-static--hidden" data-rd-navbar-toggle=".rd-navbar-top-panel__main"><span></span></div>
							<div class="rd-navbar-top-panel__content">
								<div class="rd-navbar-top-panel__content-top">
									<div class="rd-navbar-top-panel__left">
										<jdoc:include type="modules" name="lang" style="none" />
									</div>
									<div class="rd-navbar-top-panel__right">
										<ul class="rd-navbar-items-list">
											<li>
												<ul class="list-inline-xxs">
													<li><a class="icon icon-xxs icon-primary fa fa-facebook" href="#"></a></li>
													<li><a class="icon icon-xxs icon-primary fa fa-twitter" href="#"></a></li>
													<li><a class="icon icon-xxs icon-primary fa fa-google-plus" href="#"></a></li>
													<li><a class="icon icon-xxs icon-primary fa fa-vimeo" href="#"></a></li>
													<li><a class="icon icon-xxs icon-primary fa fa-youtube" href="#"></a></li>
													<li><a class="icon icon-xxs icon-primary fa fa-pinterest-p" href="#"></a></li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
								<div class="rd-navbar-top-panel__content-bottom rd-navbar-content_middle rd-navbar-content_justify">
									<!-- RD Navbar Brand-->
									<div class="rd-navbar-brand rd-navbar-fixed--hidden"><a class="brand-name" href="/"><img src="images/logo.png" alt="Logo"/></a></div>
									<jdoc:include type="modules" name="header-right" style="none" />
								</div>
							</div>
						</div>
					</div>
					<div class="rd-navbar-bottom-panel rd-navbar-search-wrap">
						<!-- RD Navbar Nav-->
						<div class="rd-navbar-nav-wrap rd-navbar-search_not-collapsable">
							<ul class="rd-navbar-items-list rd-navbar-search_collapsable">
								<li>
									<button class="rd-navbar-search__toggle rd-navbar-fixed--hidden" data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
								</li>
								
							</ul>
							<!-- RD Search-->
							<div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
								<form class="rd-search" action="search-results.html" method="GET" data-search-live="rd-search-results-live">
									<div class="form-wrap">
										<input class="form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off">
										<label class="form-label" for="rd-navbar-search-form-input">Enter keyword</label>
										<div class="rd-search-results-live" id="rd-search-results-live"></div>
									</div>
									<button class="rd-search__submit" type="submit"></button>
								</form>
								<div class="rd-navbar-fixed--hidden">
									<button class="rd-navbar-search__toggle" data-custom-toggle=".rd-navbar-search-wrap" data-custom-toggle-disable-on-blur="true"></button>
								</div>
							</div>
							<div class="rd-navbar-search_collapsable">
								<jdoc:include type="modules" name="menu" style="none" />
							</div>
						</div>
					</div>
				</nav>
			</div>
		</header>
		<?php if ($this->countModules('home-module')) : ?>
			<jdoc:include type="modules" name="home-module" style="none" />
		<?php endif; ?>
		<?php if ($this->countModules('home-sticky')) : ?>
			<div class="home-sticky">
				<jdoc:include type="modules" name="home-sticky" style="none" />
			</div>
		<?php endif; ?>
	
		<main id="content" role="main" class="">
			<!-- Begin Content -->
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<!-- End Content -->
		</main>
		<footer class="footer-modern">
        <div class="container">
          <div class="footer-modern__layer footer-modern__layer_top">
            <a class="brand" href="/"><img src="images/logo.png" alt="Logo"/></a>
           
						<jdoc:include type="modules" name="menu-footer" style="none" />
            <ul class="list-inline-xxs footer-modern__list">
              <li><a class="icon icon-xxs icon-primary fa fa-facebook" href="#"></a></li>
              <li><a class="icon icon-xxs icon-primary fa fa-twitter" href="#"></a></li>
              <li><a class="icon icon-xxs icon-primary fa fa-google-plus" href="#"></a></li>
              <li><a class="icon icon-xxs icon-primary fa fa-vimeo" href="#"></a></li>
              <li><a class="icon icon-xxs icon-primary fa fa-youtube" href="#"></a></li>
              <li><a class="icon icon-xxs icon-primary fa fa-pinterest" href="#"></a></li>
            </ul>
          </div>
          <div class="footer-modern__layer footer-modern__layer_bottom">
            <p class="rights"><span>LDCC-Agency</span><span>&nbsp;&copy;&nbsp;</span><span class="copyright-year"><?php echo date('Y'); ?></span>. All Rights Reserved.</p>
						<jdoc:include type="modules" name="contact-footer" style="none" />
            
          </div>
        </div>
      </footer>
	</div>

	<jdoc:include type="modules" name="debug" style="none" />
	<!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="/templates/<?php echo $this->template ?>/js/core.min.js"></script>
    <script src="/templates/<?php echo $this->template ?>/js/script.js"></script>
</body>
</html>
