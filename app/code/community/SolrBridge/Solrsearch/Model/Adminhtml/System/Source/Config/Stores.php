<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    
 * @package     _home
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Source for cron hours
 *
 * @category    Find
 * @package     Find_Feed
 */
class SolrBridge_Solrsearch_Model_Adminhtml_System_Source_Config_Stores
{

    /**
     * Fetch options array
     * 
     * @return array
     */
    public function toOptionArray()
    {
		$options = array();
		$websites = Mage::app()->getWebsites();
		foreach (Mage::app()->getWebsites() as $website) {
			$website_id = $website->getId();
			$options[$website_id]['label'] = $website->getName();
			
		    foreach ($website->getGroups() as $group) {
		        $stores = $group->getStores();
				
				$options[$website_id]['value'][$group->getId()]['label'] = $group->getName();
		        
		        foreach ($stores as $store) {
		            $options[$website_id]['value'][$group->getId()]['value'][] = array('label' => $store->getName(), 'value' => $store->getId());
		        }
				
		    }
			
		}
        return $options;
    }
}
