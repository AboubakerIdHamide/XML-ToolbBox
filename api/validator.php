<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // Get the data
    $xml = $_POST['xml'];
    $validation = $_POST['validation'];
    if (empty($xml) || empty($validation)) {
      throw new Exception("Les deux champs sont requis.");
    }

    // Initialize the variables
    $isValid = false;
    $errors = [];

    // Disable libxml errors and enable user error handling
    libxml_use_internal_errors(true);

    // Load the XML
    $doc = new DOMDocument();
    if (!$doc->loadXML($xml)) {
      $errors = libxml_get_errors();
      libxml_clear_errors();
      throw new Exception("Erreur de chargement XML : " . implode(" | ", array_map(function ($error) {
        return trim($error->message);
      }, $errors)));
    }

    // Store the schema in a temporary file
    $xsd = tempnam(sys_get_temp_dir(), 'xsd');
    file_put_contents($xsd, $validation);

    // Validate the XML
    if (!@$doc->schemaValidate($xsd)) {
      $errors = libxml_get_errors();
    }

    // Remove the temporary file & clear the errors
    unlink($xsd);
    libxml_clear_errors();

    // Check if the XML is valid
    if (empty($errors)) {
      echo json_encode([
        "success" => true,
        "message" => "Votre XML est valide."
      ]);
    } else {
      $errorMessages = array_map(function ($error) {
        return trim($error->message);
      }, $errors);
      echo json_encode([
        "success" => false,
        "message" => "Votre XML n'est pas valide : " . implode(" | ", $errorMessages)
      ]);
    }
  } catch (Exception $e) {
    echo json_encode([
      "success" => false,
      "message" => "Une erreur est survenue : " . $e->getMessage()
    ]);
  }
}
