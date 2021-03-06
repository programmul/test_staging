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
class Flagbit_Mip_Model_Server_Adapter_Xml
    extends Flagbit_Mip_Model_Server_Adapter_Abstract
    implements Flagbit_Mip_Model_Server_Adapter_Interface
    {

    /**
     * input Data
     *
     * @param string $resource Name of the Resourcemodel
     * @param string $action
     * @param string $data
     * @return array
     */
    public function input($resource, $action, $data)
    {
        $result = null;
        if(is_array($data)){
            $result = array();
            foreach($data as $datapart){
                $datapartArray = $this->_input($resource, $action, $datapart);
                if(is_array($datapartArray)){
                    $result = array_merge_recursive($result, $datapartArray);
                }
            }
        }else{
            $result = $this->_input($resource, $action, $data);
        }
        return $result;
    }

    /**
     * input Data
     *
     * @param string $resource Name of the Resourcemodel
     * @param string $action
     * @param string $data
     * @return array
     */
    protected function _input($resource, $action, $data)
    {
        # XML-Daten laden
        $xmlDom = new DOMdocument;
        $xmlDom->preserveWhiteSpace = false;
        try {
            $xmlDom->loadXML($data);
        } catch (Exception $e) {
            Mage::helper('mip/log')->getWriter($this)->error('XML Adapter: XML Data Exception -> no valid XML String given', $e);
        }

        // dispatch Event for Data manipulation
        Mage::dispatchEvent('mip_xml_adapter_'.$resource.'_'.$action.'_input', array('data' => $xmlDom, 'adapter' => $this));

        $xsltFile = $this->_getXslt($resource, $action, 'input');

        if($xsltFile !== null){

            $xslProcessor = $this->getTrigger()->getProcessor();
            $xslProcessor->setRuleFile($xsltFile);
            $xslProcessor->setInput($xmlDom);

            $xml = $xslProcessor->transform();

            $xml = $this->postFilterData($xml);

            $xmlDom = new DOMdocument;
            $xmlDom->loadXML($xml);
        }

        return parent::input($resource, $action, $this->xmlToData($xmlDom, $resource));
    }

    /**
     * get XSL Template File
     *
     * @param string $resource
     * @param string $action
     * @param string $direction
     * @return string
     */
    protected function _getXslt($resource, $action, $direction)
    {
        $xslFile = null;
        if ($this->getSettings('xslt') !== null) {
            $xslFile = $this->getPath() . $this->getSettings('xslt');
        } else {
            $xslFile = $this->getPath() . $resource .'_'. $action .'_'.$direction.'.xslt';
        }

        // pre Filter XSLT and create new from result
        if (!is_null($xslFile) && is_readable($xslFile)) {

            Mage::helper('mip/log')->getWriter($this)->info('XSLT Template '.$xslFile);

            $fileName = 'mip_'.md5_file($xslFile).'.xslt';
            $filePath = Mage::getConfig()->getOptions()->getCacheDir().DS.$fileName;
            if (!file_exists($filePath)) {
                $content = file_get_contents($xslFile);
                $content = $this->preFilterData($content);
                $fp = fopen($filePath, "w+");
                fwrite($fp, $content);
                fclose($fp);
            }
            $xslFile = $filePath;
        }elseif(!is_null($xslFile)){
            Mage::helper('mip/log')->getWriter($this)->warn('XSL Template File is not readable or do not exists: '.$xslFile);
            $xslFile = null;
        }
        if(!is_null($xslFile)){
            Mage::helper('mip/log')->getWriter($this)->info('XSL Template (generated) '.$xslFile);
        }

        return $xslFile;
    }

    /**
     * output Data
     *
     * @param string $resource
     * @param string $action
     * @param string $data
     * @return string
     */
    public function output($resource, $action, $data)
    {
        $output = null;

        # XML-Daten laden
        $xmlDom = $this->dataToXml($data, $resource);

        $xsltFile = $this->_getXslt($resource, $action, 'output');

        if($xsltFile !== null){

            $xslProcessor = $this->getTrigger()->getProcessor();
            $xslProcessor->setRuleFile($xsltFile);
            $xslProcessor->setInput($xmlDom);

            $output = $xslProcessor->transform();

        }else{
            $output = $xmlDom->saveXML();
        }

        return parent::output($resource, $action, $output);
    }

    /**
     * transform XML to Array
     *
     * @param DOMNode $parentNode
     * @return array
     */
    public function xmlToData(DOMNode $parentNode, $resource = NULL)
    {
        $retVal = array();
            foreach ($parentNode->childNodes as $domNode) {

               if (count($domNode->childNodes)
                   && $domNode->firstChild !== NULL
                   && !$domNode->firstChild instanceof DOMCharacterData) {

                   if(!($parentNode instanceof DOMElement) or
                       (($parentNode instanceof DOMElement)
                       && $parentNode->getAttribute('array') != 'true')){

                       $retVal[$domNode->nodeName] = $this->xmlToData($domNode, $resource);
                   }else{
                       $retVal[] = $this->xmlToData($domNode, $resource);
                   }
               } else {
                   switch (get_class($domNode)){

                       case 'DOMText':
                           $retVal[$domNode->nodeName] = $domNode->wholeText;
                           break;

                       default:
                           if(($parentNode instanceof DOMElement)
                               && $parentNode->getAttribute('array') == 'true'){
                               if ( !is_numeric($domNode->nodeValue) && empty($domNode->nodeValue)){
                                   $retVal = array();
                               }
                               else{
                                   $retVal[] = $domNode->nodeValue;
                               }

                           }else{
                               $retVal[$domNode->tagName] = $domNode->nodeValue;
                           }
                   }
               }
           }
           return $retVal;
    }

    /**
     * The main function for converting to an XML document.
     * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
     *
     * @param array $data
     * @param string $rootNodeName - what you want the root node to be - defaultsto data.
     * @param DomElement $elem - should only be used recursively
     * @param DOMDocument $xml - should only be used recursively
     * @return object DOMDocument
     */
    public function dataToXml(array $data, $resource, $rootNodeName = 'data', $elem=null, $xml=null, &$objects=array())
    {

        if ($xml === null)
        {
            $xml = new DOMDocument("1.0", "UTF-8");
            $xml->formatOutput = true;
            $elem = $xml->createElement( $rootNodeName );
              $xml->appendChild( $elem );
        }

        // loop through the data passed in.
        foreach((array) $data as $key => $value)
        {
            $isNumericArray = false;

            // no numeric keys in our xml please!
            if (is_numeric($key)) {
                $isNumericArray = true;
                $key = 'node';
                if($rootNodeName == 'data'){
                    $key = $resource;
                }elseif($rootNodeName){
                    $key = Mage::getSingleton('mip/inflector')->singularize($rootNodeName);
                }

            }

            // replace anything not alpha numeric
            $key = preg_replace('/[^a-z0-9\_]/i', '', (string)$key);
            if(is_numeric($key) || is_numeric(substr($key, 0, 1))){
                $key = 'numeric_'.$key;
            }
            if(empty($key)){
                continue;
            }

            // if there is another array found recursively call this function
            if (is_array($value))
            {
                $subelem = $xml->createElement( $key );
                $elem->appendChild( $subelem);
                // recrusive call.
                $this->dataToXml($value, $resource, $key, $subelem, $xml);
            }elseif (is_object($value)){
                if(is_callable(array($value, '__toArray'))){
                    $subelem = $xml->createElement( $key );
                    $elem->appendChild( $subelem);
                    $hash = spl_object_hash($value);

                    // recrusive call.
                    if (!empty($objects[$hash])) {
                        $objects[$hash] = true;
                        $this->dataToXml((array) $value, $resource, $key, $subelem, $xml, $objects);
                    }
                }
            }
            else
            {
                $value = Mage::helper('mip/encoding')->fixUTF8($value);
                $subelem = $xml->createElement( $key );
                $subelem->appendChild(
                    strpos($value, '<')
                    || strpos($value, '>')
                    /*|| !ctype_print($value)*/
                    ? $xml->createCDATASection( $value )
                    : $xml->createTextNode( $value )
                );
                $elem->appendChild( $subelem );
            }

            if($isNumericArray){
                $elem->setAttribute ( 'array' , 'true' );
            }
        }
        // pass back as DOMDocument object
        return $xml;
    }

}