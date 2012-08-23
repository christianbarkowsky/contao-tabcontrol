<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Config
 * @license    LGPL
 * @filesource
 */

unset($GLOBALS['BE_MOD']['profile']['tasks']);

### INSTALL SCRIPT START ###
$GLOBALS['TL_CONFIG']['websitePath'] = '';
$GLOBALS['TL_CONFIG']['installCount'] = 1;
$GLOBALS['TL_CONFIG']['installPassword'] = 'd1655bb4be33ebae22562621a5c85cfe9509820a:2dce71ad5bfd5049f75f035';
$GLOBALS['TL_CONFIG']['encryptionKey'] = 'meganomi16580';
$GLOBALS['TL_CONFIG']['dbDriver'] = 'MySQL';
$GLOBALS['TL_CONFIG']['dbHost'] = 'localhost';
$GLOBALS['TL_CONFIG']['dbUser'] = 'web11_4';
$GLOBALS['TL_CONFIG']['dbPass'] = 'Black2055!';
$GLOBALS['TL_CONFIG']['dbDatabase'] = 'web11_db4';
$GLOBALS['TL_CONFIG']['dbPconnect'] = false;
$GLOBALS['TL_CONFIG']['dbCharset'] = 'UTF8';
$GLOBALS['TL_CONFIG']['dbPort'] = 3306;
$GLOBALS['TL_CONFIG']['adminEmail'] = 'mail@christianbarkowsky.de';
$GLOBALS['TL_CONFIG']['latestVersion'] = '2.11.5';
$GLOBALS['TL_CONFIG']['liveUpdateId'] = '1b75-f905-4abf-7af3-ee46';
$GLOBALS['TL_CONFIG']['rewriteURL'] = true;
$GLOBALS['TL_CONFIG']['defaultChmod'] = 'a:6:{i:0;s:2:"u1";i:1;s:2:"u2";i:2;s:2:"u3";i:3;s:2:"u4";i:4;s:2:"u5";i:5;s:2:"u6";}';
$GLOBALS['TL_CONFIG']['licenseAccepted'] = true;
$GLOBALS['TL_CONFIG']['displayErrors'] = false;
$GLOBALS['TL_CONFIG']['noqueryPageLastmod'] = true;
$GLOBALS['TL_CONFIG']['pingGoogle'] = true;
$GLOBALS['TL_CONFIG']['lastGooglePing'] = 1275904313;
$GLOBALS['TL_CONFIG']['allowedTags'] = '<a><abbr><acronym><address><area><b><big><blockquote><br><base><bdo><button><caption><code><col><colgroup><dd><div><dfn><dl><dt><em><form><fieldset><hr><h1><h2><h3><h4><h5><h6><i><img><input><label><legend><li><link><map><object><ol><optgroup><option><p><pre><param><q><select><small><span><strong><sub><sup><style><table><tbody><td><textarea><tfoot><th><thead><tr><tt><u><ul><script><iframe><fb:like><script><fb:send>';
$GLOBALS['TL_CONFIG']['enableGZip'] = true;
$GLOBALS['TL_CONFIG']['jpgQuality'] = 80;
$GLOBALS['TL_CONFIG']['secureDNS'] = 'auto';
$GLOBALS['TL_CONFIG']['dateFormat'] = 'd.m.Y';
$GLOBALS['TL_CONFIG']['datimFormat'] = 'd.m.Y';
$GLOBALS['TL_CONFIG']['timeZone'] = 'Europe/Berlin';
$GLOBALS['TL_CONFIG']['cron_weekly'] = 201234;
$GLOBALS['TL_CONFIG']['cron_daily'] = 20120823;
$GLOBALS['TL_CONFIG']['enableSearch'] = false;
$GLOBALS['TL_CONFIG']['cron_hourly'] = 2011021507;
$GLOBALS['TL_CONFIG']['inactiveModules'] = 'a:1:{i:0;s:8:"comments";}';
$GLOBALS['TL_CONFIG']['cbw_clubbd_thumbnail_width'] = 100;
$GLOBALS['TL_CONFIG']['cbw_clubbd_thumbnail_height'] = 50;
$GLOBALS['TL_CONFIG']['cbw_clubbd_list_width'] = 400;
$GLOBALS['TL_CONFIG']['cbw_clubbd_list_height'] = 500;
$GLOBALS['TL_CONFIG']['immo_image_thumbnail'] = 'a:2:{i:0;s:3:"100";i:1;s:3:"100";}';
$GLOBALS['TL_CONFIG']['immo_image_big'] = 'a:2:{i:0;s:3:"100";i:1;s:3:"100";}';
$GLOBALS['TL_CONFIG']['immo_email_sendto'] = 'mail@christianbarkowsky.de';
$GLOBALS['TL_CONFIG']['immo_email_name'] = 'Christian Barkowsky Webentwicklung';
$GLOBALS['TL_CONFIG']['immo_email_subject'] = 'Immo E-Mail';
$GLOBALS['TL_CONFIG']['immo_bigMap'] = 1;
$GLOBALS['TL_CONFIG']['immo_gmapkey'] = 'ABQIAAAA82bcOP5erGVrAlK75vJ_GxSHUTXd-fq86fNGT33DnIIKVaFalRQ95cpr0ClIZMLNzrSLcDiW9LkffA';
$GLOBALS['TL_CONFIG']['debugMode'] = false;
$GLOBALS['TL_CONFIG']['cbw_googlemaps'] = 'ABQIAAAA82bcOP5erGVrAlK75vJ_GxSHUTXd-fq86fNGT33DnIIKVaFalRQ95cpr0ClIZMLNzrSLcDiW9LkffA';
$GLOBALS['TL_CONFIG']['minifyMarkup'] = false;
$GLOBALS['TL_CONFIG']['gzipScripts'] = true;
$GLOBALS['TL_CONFIG']['repository_unsafe_catalog'] = false;
$GLOBALS['TL_CONFIG']['immo_export_scout24_enabled'] = false;
$GLOBALS['TL_CONFIG']['allowedDownload'] = 'jpg,jpeg,gif,png,doc,xls,ppt,odt,ods,odp,pdf,mp3,wma,wmv,ram,rm,mov,exe,zip,css';
$GLOBALS['TL_CONFIG']['li_crm_version'] = '0.4.0';
$GLOBALS['TL_CONFIG']['li_crm_company_name'] = 'Christian Barkowsky Webentwicklung';
$GLOBALS['TL_CONFIG']['li_crm_company_street'] = 'Grenzstraße 56';
$GLOBALS['TL_CONFIG']['li_crm_company_postal'] = 14774;
$GLOBALS['TL_CONFIG']['li_crm_company_city'] = 'Brandenburg an der Havel';
$GLOBALS['TL_CONFIG']['li_crm_company_country'] = 'de';
$GLOBALS['TL_CONFIG']['li_crm_company_phone'] = '03381 333 161';
$GLOBALS['TL_CONFIG']['li_crm_invoice_maturity'] = 7;
$GLOBALS['TL_CONFIG']['li_crm_invoice_dispatch_from'] = 'rechnung@christianbarkowsky.de';
$GLOBALS['TL_CONFIG']['li_crm_invoice_dispatch_fromName'] = 'Christian Barkowsky Webentwicklung';
$GLOBALS['TL_CONFIG']['li_crm_account_number'] = 3615001515;
$GLOBALS['TL_CONFIG']['li_crm_bank_code'] = 16050000;
$GLOBALS['TL_CONFIG']['li_crm_bank'] = 'Mittelbrandenburgische Sparkasse in Potsdam';
$GLOBALS['TL_CONFIG']['websiteTitle'] = 'Christian Barkowsky Webentwicklung';
$GLOBALS['TL_CONFIG']['coreOnlyMode'] = false;
$GLOBALS['TL_CONFIG']['cron_monthly'] = 201208;
$GLOBALS['TL_CONFIG']['immo_disable_deprecated'] = true;
$GLOBALS['TL_CONFIG']['immo_map_startmap'] = 'ROADMAP';
$GLOBALS['TL_CONFIG']['immo_map_maps'] = 'none';
$GLOBALS['TL_CONFIG']['immo_map_zoomcontrol'] = 'NONE';
$GLOBALS['TL_CONFIG']['displayErrors'] = true;
### INSTALL SCRIPT STOP ###

?>