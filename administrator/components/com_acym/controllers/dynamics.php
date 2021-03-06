<?php
/**
 * @package	AcyMailing for Joomla
 * @version	6.0.1
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><?php

class DynamicsController extends acymController
{
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultTask('popup');
    }

    public function popup()
    {
        $plugins = acym_trigger('dynamicText');

        $js = 'function setTag(tagvalue, element){
                    var $allRows = $(".acym__listing__row__popup");
                    $allRows.removeClass("selected_row");
                    element.addClass("selected_row");
                    window.document.getElementById(\'dtextcode\').value = tagvalue;
               }';
        $js .= 'try{window.parent.previousSelection = window.parent.getPreviousSelection(); }catch(err){window.parent.previousSelection=false; }';

        acym_addScript(true, $js);

        $tab = acym_get('helper.tab');

        $data = array(
            "type" => acym_getVar('string', 'type', 'news'),
            "plugins" => $plugins,
            "tab" => $tab,
        );

        parent::display($data);
    }

    public function replaceDummy()
    {
        $code = acym_getVar('string', 'code', '');
        $email = new stdClass();
        $email->id = 0;
        $email->body = $code;
        acym_trigger('replaceContent', array(&$email));
        $userClass = acym_get('class.user');
        $userEmail = acym_currentUserEmail();
        $user = $userClass->getOneByEmail($userEmail);
        acym_trigger('replaceUserInformation', array(&$email, &$user, false));

        echo $email->body;
        exit;
    }

    function trigger()
    {
        $plugin = acym_getVar('string', 'plugin', '');
        $trigger = acym_getVar('string', 'trigger', '');
        if (empty($plugin) || empty($trigger)) {
            exit;
        }

        acym_trigger($trigger, array(), $plugin);

        exit;
    }
}
