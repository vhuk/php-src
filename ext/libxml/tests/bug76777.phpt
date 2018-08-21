--TEST--
Bug #76777 (first parameter of libxml_set_external_entity_loader callback undefined)
--SKIPIF--
<?php if (!extension_loaded('libxml')) die('skip'); ?>
--FILE--
<?php
ini_set('error_reporting',PHP_INT_MAX-1);
$xml=<<<EOF
<?xml version="1.0"?>
<test/>
EOF;

$xsd=<<<EOF
<?xml version="1.0"?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:include schemaLocation="nonexistent.xsd"/>
    <xs:element name="test"/>
    </xs:schema>
EOF;

libxml_set_external_entity_loader(function($p,$s,$c) {
    var_dump($p,$s,$c);
        die();
	});

$dom=new DOMDocument($xml);
var_dump($dom->schemaValidateSource($xsd));
?>
--EXPECTF--
NULL
string(15) "nonexistent.xsd"
array(4) {
  ["directory"]=>
  NULL
  ["intSubName"]=>
  NULL
  ["extSubURI"]=>
  NULL
  ["extSubSystem"]=>
  NULL
}
