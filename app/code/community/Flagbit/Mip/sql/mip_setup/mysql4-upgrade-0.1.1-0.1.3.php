<?php
/**
 * This source file is subject to the Magento Integration Platform License
 * that is bundled with this package in the file LICENSE_MIP.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.flagbit.de/license/mip
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to magento@flagbit.de so we can send you a copy immediately.
 *
 * The Magento Integration Platform is a property of Flagbit GmbH & Co. KG.
 * It is NO part or deravative version of Magento and as such NOT published
 * as Open Source. It is NOT allowed to copy, distribute or change the
 * Magento Integration Platform or any of its parts. If you wish to adapt
 * the software to your individual needs, feel free to contact us at
 * http://www.flagbit.de or via e-mail (magento@flagbit.de) or phone
 * (+49 (0)800 FLAGBIT (3524248)).
 *
 *
 *
 * Dieser Quelltext unterliegt der Magento Integration Platform License,
 * welche in der Datei LICENSE_MIP.txt innerhalb des MIP Paket hinterlegt ist.
 * Sie ist außerdem über das World Wide Web abrufbar unter der Adresse:
 * http://www.flagbit.de/license/mip
 * Falls Sie keine Kopie der Lizenz erhalten haben und diese auch nicht über
 * das World Wide Web erhalten können, senden Sie uns bitte eine E-Mail an
 * magento@flagbit.de, so dass wir Ihnen eine Kopie zustellen können.
 *
 * Die Magento Integration Platform ist Eigentum der Flagbit GmbH & Co. KG.
 * Sie ist WEDER Bestandteil NOCH eine derivate Version von Magento und als
 * solche nicht als Open Source Softeware veröffentlicht. Es ist NICHT
 * erlaubt, die Software als Ganze oder in Einzelteilen zu kopieren,
 * verbreiten oder ändern. Wenn Sie eine Anpassung der Software an Ihre
 * individuellen Anforderungen wünschen, kontaktieren Sie uns unter
 * http://www.flagbit.de oder via E-Mail (magento@flagbit.de) oder Telefon
 * (+49 (0)800 FLAGBIT (3524248)).
 *
 *
 *
 * @package     Flagbit
 * @subpackage  Flagbit_Mip
 * @copyright   2009 by Flagbit GmbH & Co. KG
 * @author      Flagbit Magento Team <magento@flagbit.de>
 */


/**
 * @package     Flagbit
 * @subpackage  Flagbit_Mip
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('mip/data_relation')}`
  ADD `mage_id` int(10) unsigned NOT NULL default 0,
  ADD `mage_type` varchar(255) NOT NULL default '',
  ADD `resource_type` varchar(255) NOT NULL default '',
  ADD `resource_id` varchar(255) NOT NULL default '',
  ADD `ext_id` varchar(255) NOT NULL default '',
  ADD `interface` varchar(30) NOT NULL default '',
  ADD `datahash_identifier` varchar(30) NOT NULL default '',
  ADD `status` varchar(30) NOT NULL default '',
  ADD `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  ADD `updated_at` datetime NOT NULL default '0000-00-00 00:00:00';

UPDATE `{$this->getTable('mip/data_relation')}` SET
  `mage_id` = `relation_mage`,
  `resource_id` = `relation_mage`,
  `resource_type` = `relation_type`,
  `mage_type` = `relation_type`,
  `ext_id` = `relation_ext`;

ALTER TABLE `{$this->getTable('mip/data_relation')}`
  DROP KEY `relation_mage`,
  DROP KEY `relation_ext`,
  DROP `relation_mage`,
  DROP `relation_type`,
  DROP `relation_ext`,
  ADD KEY `relation_mage` (`resource_type`,`mage_id`),
  ADD KEY `relation_ext` (`mage_type`,`ext_id`),
  ADD UNIQUE KEY `relation_ext_unique` (`mage_type`, `resource_type`, `resource_id`);



ALTER TABLE `{$this->getTable('mip/data_hash')}` CHANGE `datahash_identifier` `identifier` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `datahash_hash` `hash` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `datahash_type` `type` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


CREATE TABLE IF NOT EXISTS `{$this->getTable('mip/data_import')}` (
  `data_id` int(10) unsigned NOT NULL auto_increment,
  `relation_id` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL default '',
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` varchar(30) NOT NULL default '',

  PRIMARY KEY  (`data_id`),
  KEY `datahash_hash_type` (`relation_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Mip Import Data' AUTO_INCREMENT=1;


ALTER TABLE `{$this->getTable('mip/data_hash')}`
  DROP KEY `datahash_hash_type`,
  ADD KEY `datahash_hash_type` (`type`, `identifier`);

");

$installer->endSetup();