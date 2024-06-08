<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $xml = $_POST['xml'];
    if (empty($xml)) {
      throw new Exception("XML est vide");
    }

    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;

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

    echo json_encode([
      "success" => true,
      "message" => "XML formatted successfully",
      "data" => htmlspecialchars($dom->saveXML())
    ]);
  } catch (Exception $e) {
    echo json_encode([
      "success" => false,
      "message" => $e->getMessage()
    ]);
  }
}
