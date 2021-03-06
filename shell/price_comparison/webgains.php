<?php
require_once 'price_comparison/abstract.php';
		
class Mage_Shell_PriceComparison_Webgains extends Mage_Shell_PriceComparison_Abstract {
	public $name = 'Webgains Exporter';
	protected $_code = 'webgains';
	protected $_csvDelimiter = ';';
	protected $_csvEnclosure = '"';
		
	public function __construct(Mage_Shell_PriceComparison $shell) {
		$this->_csvDelimiter = chr(9);
		parent::__construct($shell);
	}
	
	
	function getFields() {
		return array(
				'Produktname' => array('code' => 'name'),
				'Produkt-Nummer' => array('function' => 'getMagentoPID'),
				'Produkt-Kategorie' => array('function' => 'getCategoryPath'),
				'Produktbeschreibung' => array('function' => 'getDescription', 'fields' => array('description')),
				'Deeplink' => array('function' => 'getUrl_for_webgains'),
				'Preis' => array('function' => 'calcPrice'),
				'Währung' => array('static' => 'EUR'),
				'Produktbild' => array('function' => 'getImageUrl'),
				'Lieferzeit' => array('code' => 'delivery_time'),
				'Lieferkosten' => array('function' => 'calcShipping'),
				'EAN' => array('function' => 'getEan', 'fields' => array('ps_ean')),
				'Hersteller' => array('function' => 'getManufacturer', 'fields' => array('ps_brand','manufacturer')),
				'Herstellernummer' => array('code' => 'sku'),
				'Shopsiegel' => array('static' => 'Trusted Shop'),
				'Bezahlmoeglichkeiten' => array('static' => 'Rechnung, Kreditkarte, Sofortüberweisung, Vorkasse, Paypal, Barzahlen'),
				'Verfuegbarkeit' => array('static' => 'ja'),
				);
	}
	
	function getEan($_product) {
		if($_product->getPsEan() && $_product->getPsEan() != 0) return $_product->getPsEan();
		return '';
	}
	
	function calcPrice($_product) {
		return number_format(parent::calcPrice($_product), 2, null, '');
	}

	function getCategoryPath($_product){
		$currentCatIds = $_product->getCategoryIds();
		$categoryCollection = Mage::getResourceModel('catalog/category_collection')
													->addAttributeToSelect('name')
													->addAttributeToFilter('entity_id', $currentCatIds)
													->addIsActiveFilter();
		$return = array();
		foreach($categoryCollection as $cat){
			$return[]=$cat->getName();
		}
		return implode(' > ',$return);
	}

	function getUrl_for_webgains($_product) {
		try {
			$url = '';
			$store = $this->_shell->currentStoreCode;
			$tsid = "";
			if($store == "md_de") {
				$tsid = 72559;
			} elseif($store == "ps_de") {
				$tsid = 67950;
			}
			if($_product->getVisibility() == 1 && $_product->getTypeId() != "configurable") {
				$parentId = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($_product->getId());
				if(isset($parentId[0])){
					$parentProduct = Mage::getModel('catalog/product')->load($parentId[0]);
					$url = $parentProduct->getUrlPath();
					$url .= "/?utm_source=webgains&utm_medium=affiliate&utm_content=mp&utm_campaign=affiliate-webgains&_\$ja=tsid:".$tsid;
					
					//function in abstract
					$variant_url = $this->getVariantUrl($_product);
					$url .= $variant_url;
				}
			} else {
				$url = $_product->getUrlPath();
				$url .= "/?utm_source=webgains&utm_medium=affiliate&utm_content=mp&utm_campaign=affiliate-webgains&_\$ja=tsid:".$tsid;
			}
			$url = Mage::getUrl($url);
			$url = rtrim($url, "/");
			return $url;
		}catch (Exception $e) {
			return '';
		}
	}
} 