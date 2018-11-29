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

class acymupdateHelper
{
    var $errors = array();

    public function __construct()
    {
        global $acymCmsUserVars;
        $this->cmsUserVars = $acymCmsUserVars;
    }

    function addUpdateSite()
    {
        $config = acym_config();

        $newconfig = new stdClass();
        $newconfig->website = ACYM_LIVE;
        $newconfig->max_execution_time = 0;

        $config->save($newconfig);

        acym_query("DELETE FROM #__updates WHERE element = 'com_acym'");

        $update_site_id = acym_loadResult("SELECT update_site_id FROM #__update_sites WHERE location LIKE '%component=acymailing%' AND type LIKE 'extension'");

        $object = new stdClass();
        $object->name = 'AcyMailing';
        $object->type = 'extension';
        $object->location = ACYM_UPDATEMEURL.'updatexml&component=acymailing&cms=joomla&level='.$config->get('level').'&version='.$config->get('version');
        if (acym_level(1)) {
            $object->location .= '&li='.urlencode(base64_encode(ACYM_LIVE));
        }

        $object->enabled = 1;

        if (empty($update_site_id)) {
            $update_site_id = acym_insertObject("#__update_sites", $object);
        } else {
            $object->update_site_id = $update_site_id;
            acym_updateObject("#__update_sites", $object, 'update_site_id');
        }

        $extension_id = acym_loadResult("SELECT extension_id FROM #__extensions WHERE `element` = 'com_acym' AND type LIKE 'component'");
        if (empty($update_site_id) || empty($extension_id)) {
            return false;
        }

        $query = 'INSERT IGNORE INTO #__update_sites_extensions (update_site_id, extension_id) values ('.$update_site_id.','.$extension_id.')';
        acym_query($query);

        return true;
    }

    function installLanguages($output = true)
    {
        $siteLanguages = acym_getLanguages();
        if (!empty($siteLanguages[ACYM_DEFAULT_LANGUAGE])) {
            unset($siteLanguages[ACYM_DEFAULT_LANGUAGE]);
        }

        $installedLanguages = array_keys($siteLanguages);
        if (empty($installedLanguages)) {
            return;
        }

        if (!$output) {
            $newConfig = new stdClass();
            $newConfig->installlang = implode(',', $installedLanguages);
            $config = acym_config();
            $config->save($newConfig);

            return;
        }

        $js = '
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "'.acym_prepareAjaxURL('file').'&task=installLanguages&languages='.implode(',', $installedLanguages).'");
			xhr.onload = function(){
				container = document.getElementById("acym_div");
				container.innerHTML = xhr.responseText+container.innerHTML;
			};
			xhr.send();';
        acym_addScript(true, $js);
    }

    function installBackLanguages()
    {
        $menuStrings = array(
            'ACYM_USERS',
            'ACYM_CUSTOM_FIELDS',
            'ACYM_LISTS',
            'ACYM_TEMPLATES',
            'ACYM_CAMPAIGNS',
            'ACYM_QUEUE',
            'ACYM_AUTOMATION',
            'ACYM_STATISTICS',
            'ACYM_CONFIGURATION',
            'ACYM_MENU_PROFILE',
            'ACYM_MENU_PROFILE_DESC',
        );

        $siteLanguages = array_keys(acym_getLanguages());

        foreach ($siteLanguages as $code) {

            $path = acym_getLanguagePath(ACYM_ROOT, $code).DS.$code.'.com_acym.ini';
            if (!file_exists($path)) {
                continue;
            }

            $content = file_get_contents($path);
            if (empty($content)) {
                continue;
            }


            $menuFileContent = 'ACYM="AcyMailing 6"'."\r\n";
            $menuFileContent .= 'COM_ACYM="AcyMailing 6"'."\r\n";
            $menuFileContent .= 'COM_ACYM_CONFIGURATION="AcyMailing 6"'."\r\n";

            foreach ($menuStrings as $oneString) {
                preg_match('#'.$oneString.'="(.*)"#i', $content, $matches);
                if (empty($matches[1])) {
                    continue;
                }
                $menuFileContent .= $oneString.'="'.$matches[1].'"'."\r\n";
            }

            $menuPath = ACYM_ROOT.'administrator'.DS.'language'.DS.$code.DS.$code.'.com_acym.sys.ini';

            if (!acym_writeFile($menuPath, $menuFileContent)) {
                acym_enqueueNotification(acym_translation_sprintf('ACYM_FAIL_SAVE_FILE', $menuPath), 'error', 0);
            }
        }
    }

    function installFields()
    {
        $query = "INSERT IGNORE INTO #__acym_field (`id`, `name`, `type`, `value`, `active`, `default_value`, `required`, `ordering`, `option`, `core`, `backend_profile`, `backend_listing`, `backend_filter`, `frontend_form`, `frontend_profile`, `frontend_listing`, `frontend_filter`, `access`) VALUES
    (1, 'Name', 'text', NULL, 1, NULL, 0, 1, '{\"editable_user_creation\":\"1\",\"editable_user_modification\":\"1\",\"error_message\":\"\",\"error_message_invalid\":\"\",\"size\":\"\",\"rows\":\"\",\"columns\":\"\",\"format\":\"\",\"custom_text\":\"\",\"css_class\":\"\",\"authorized_content\":{\"0\":\"all\",\"regex\":\"\"}}', 1, 1, 1, 0, 1, 1, 1, 0, 'all'),
    (2, 'Email', 'text', NULL, 1, NULL, 1, 2, '{\"editable_user_creation\":\"1\",\"editable_user_modification\":\"1\",\"error_message\":\"\",\"error_message_invalid\":\"\",\"size\":\"\",\"rows\":\"\",\"columns\":\"\",\"format\":\"\",\"custom_text\":\"\",\"css_class\":\"\",\"authorized_content\":{\"0\":\"all\",\"regex\":\"\"}}', 1, 1, 1, 0, 1, 1, 1, 0, 'all');";
        acym_query($query);
    }

    function installTemplate()
    {
        $names = array('default_template', 'default_template_2');
        foreach ($names as $name) {
            $query = "INSERT INTO `#__acym_mail` (`name`, `creation_date`, `thumbnail`, `drag_editor`, `library`, `type`, `body`, `subject`, `template`, `from_name`, `from_email`, `reply_to_name`, `reply_to_email`, `bcc`, `settings`, `stylesheet`, `attachments`, `creator_id`) VALUES
                     ('".str_replace('_', ' ', $name)."', '2018-11-14 13:28:23', ".acym_escapeDB(ACYM_IMAGES.'img_template'.DS.$name.'.png').", 1, 1, 'standard', ".acym_escapeDB(str_replace('{acym_media}', ACYM_IMAGES, file_get_contents(ACYM_BACK.'templates'.DS.$name.DS.'content.txt'))).", 'Subject', 1, NULL, NULL, NULL, NULL, NULL, ".acym_escapeDB(file_get_contents(ACYM_BACK.'templates'.DS.$name.DS.'settings.txt')).", '', NULL, 1);";
            acym_query($query);
        }

        acym_deleteFolder(ACYM_BACK.'templates');
    }

    function installNotifications()
    {
        $searchSettings = array(
            'offset' => 0,
            'mailsPerPage' => 9000,
            'key' => 'name',
        );

        $mailClass = acym_get('class.mail');
        $notifications = $mailClass->getMailsByType('notification', $searchSettings);
        $notifications = $notifications['mails'];

        $addNotif = array();

        if (empty($notifications['acy_report'])) {
            $addNotif[] = array(
                'name' => 'acy_report',
                'subject' => 'AcyMailing Cron Report {mainreport}',
                'content' => '<p>{report}</p><p>{detailreport}</p>',
            );
        }

        if (empty($notifications['acy_confirm'])) {
            $addNotif[] = array(
                'name' => 'acy_confirm',
                'subject' => '{subtag:name|ucfirst}, {trans:ACYM_PLEASE_CONFIRM_SUBSCRIPTION}',
                'content' => $this->getFormatedNotification(
                    '<h1>Hello {subtag:name|ucfirst},</h1>
                    <p>{trans:ACYM_CONFIRM_MESSAGE}<br /></p>
                    <br />
                    <p style="text-align:center;"><strong>{confirm}{trans:ACYM_CONFIRM_SUBSCRIPTION}{/confirm}</strong></p>'
                ),
            );
        }

        if (!empty($addNotif)) {
            foreach ($addNotif as $oneNotif) {
                $notif = new stdClass();
                $notif->type = 'notification';
                $notif->library = 1;
                $notif->template = 0;
                $notif->drag_editor = 1;
                $notif->creator_id = acym_currentUserId();
                $notif->creation_date = date('Y-m-d H:i:s', time());
                $notif->name = $oneNotif['name'];
                $notif->subject = $oneNotif['subject'];
                $notif->body = $oneNotif['content'];

                $mailClass->save($notif);
            }
        }
    }

    private function getFormatedNotification($content)
    {
        return $content;
    }

    function installExtensions()
    {
        $dirs = acym_getFolders(ACYM_BACK.'extensions');

        if (empty($dirs)) {
            return true;
        }
        $installer = JInstaller::getInstance();

        foreach ($dirs as $oneExtension) {
            $installer->install(ACYM_BACK.'extensions'.DS.$oneExtension);
        }

        acym_deleteFolder(ACYM_BACK.'extensions');
    }
}
