<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 12/04/2017
 * Time: 17:39
 * XML validation functions

 */

function Validate($xml, $xsd){
 libxml_use_internal_errors(true);

 $objDom = new DOMDocument('1.0', 'utf-8');

 $objDom->loadXML($xml);

 if (!$objDom->schemaValidate($xsd)) {

     $allErrors = libxml_get_errors();
  return false;
 } else {
    return true;
 }
}
?>