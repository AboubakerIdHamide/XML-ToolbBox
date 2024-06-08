<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $xml = $_POST['xml'];
    $typingType = $_POST['typing_type'];

    if (empty($xml)) {
      throw new Exception("XML est vide.");
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    if (!$dom->loadXML($xml)) {
      $errors = libxml_get_errors();
      libxml_clear_errors();

      $errorMessages = [];
      foreach ($errors as $error) {
        $errorMessages[] = trim($error->message);
      }

      throw new Exception(implode(", ", $errorMessages));
    }

    $response = [
      "success" => true,
      "message" => "",
      "data" => ""
    ];

    if ($typingType === 'dtd') {
      $dtd = generateDTD($dom);
      $response["message"] = "DTD généré avec succès.";
      $response["data"] = htmlspecialchars($dtd);
    } else if ($typingType === 'xsd') {
      $xsd = generateXSD($dom);
      $response["message"] = "XSD généré avec succès.";
      $response["data"] = htmlspecialchars($xsd);
    } else {
      throw new Exception("Type de typage inconnu.");
    }

    echo json_encode($response);
  } catch (Exception $e) {
    echo json_encode([
      "success" => false,
      "message" => $e->getMessage()
    ]);
  }
}

function generateDTD($dom)
{
  $dtd = "<!DOCTYPE " . $dom->documentElement->tagName . " [\n";
  $dtd .= generateDTDElements($dom->documentElement);
  $dtd .= "]>";
  return $dtd;
}

function generateDTDElements($element)
{
  $elements = [];
  collectElements($element, $elements);

  $dtd = "";
  foreach ($elements as $name => $children) {
    $dtd .= "<!ELEMENT " . $name . " (" . (empty($children) ? "#PCDATA" : implode(", ", $children)) . ")>\n";
  }
  return $dtd;
}

function collectElements($element, &$elements)
{
  $children = [];
  foreach ($element->childNodes as $child) {
    if ($child->nodeType == XML_ELEMENT_NODE) {
      $children[] = $child->tagName;
      collectElements($child, $elements);
    }
  }
  $elements[$element->tagName] = array_unique($children);
}

function generateXSD($dom)
{
  $xsd = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $xsd .= '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">' . "\n";
  $xsd .= generateXSDElements($dom->documentElement);
  $xsd .= '</xs:schema>';
  return $xsd;
}

function generateXSDElements($element)
{
  $unique_elements = [];
  $xsd = '<xs:element name="' . $element->tagName . '"';

  if (hasComplexChildren($element)) {
    $xsd .= ">\n";
    $xsd .= '<xs:complexType>' . "\n";
    $xsd .= '<xs:sequence>' . "\n";
    foreach ($element->childNodes as $child) {
      if ($child->nodeType == XML_ELEMENT_NODE) {
        if (in_array($child->tagName, $unique_elements)) {
          continue;
        }
        $unique_elements[] = $child->tagName;
        $xsd .= generateXSDElements($child);
      }
    }
    $xsd .= '</xs:sequence>' . "\n";
    $xsd .= '</xs:complexType>' . "\n";
    $xsd .= '</xs:element>' . "\n";
  } else {
    $xsd .= ' type="' . getXSDElementType($element) . '"  minOccurs="0" maxOccurs="unbounded"/>'."\n";
  }
  return $xsd;
}

function getXSDElementType($element)
{
  return 'xs:string';
}

function hasComplexChildren($element)
{
  $hasComplexChildren = false;
  foreach ($element->childNodes as $child) {
    if ($child->nodeType == XML_ELEMENT_NODE) {
      $hasComplexChildren = true;
      break;
    }
  }
  return $hasComplexChildren;
}
