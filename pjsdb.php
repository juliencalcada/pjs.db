<?php
class PjsDB {
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    // Function to create an empty XML file
    public function createXMLFile() {
        // Create a new DOMDocument object
        $xml = new DOMDocument();

        // Create the root element
        $root = $xml->createElement("root");

        // Add the root element to the XML document
        $xml->appendChild($root);

        // Save the XML document content to the file
        $xml->save($this->file);
    }

    // Function to retrieve the last used identifier in the XML file
    public function getLastIdentifier() {
        // Load the XML file
        $xml = new DOMDocument();
        $xml->load($this->file);

        $xpath = new DOMXPath($xml);
        $query = "//*[@id]";
        $elements = $xpath->query($query);

        $lastIdentifier = 0;

        // Iterate over the elements and find the last used identifier
        foreach ($elements as $element) {
            $identifier = intval($element->getAttribute("id"));
            if ($identifier > $lastIdentifier) {
                $lastIdentifier = $identifier;
            }
        }

        return $lastIdentifier;
    }

    // Function to add a new element to the XML file with an automatically incremented identifier
    public function addElement($name, $value) {
        // Check if the XML file exists
        if (!file_exists($this->file)) {
            $this->createXMLFile();
        }

        // Retrieve the last used identifier
        $lastIdentifier = $this->getLastIdentifier();

        // Increment the identifier for the new element
        $newIdentifier = $lastIdentifier + 1;

        // Load the XML file
        $xml = new DOMDocument();
        $xml->load($this->file);

        // Create a new element with the identifier
        $element = $xml->createElement($name, $value);
        $element->setAttribute("id", $newIdentifier);

        // Add the element to the XML document
        $xml->documentElement->appendChild($element);

        // Save the modifications to the XML file
        $xml->save($this->file);
    }

    // Function to update the value of an element in the XML file with a specified identifier
    public function updateElement($name, $newValue, $identifier) {
        // Check if the XML file exists
        if (!file_exists($this->file)) {
            $this->createXMLFile();
        }

        // Load the XML file
        $xml = new DOMDocument();
        $xml->load($this->file);

        // Get the elements with the specified name and matching identifier
        $elements = $xml->getElementsByTagName($name);
        foreach ($elements as $element) {
            if ($element->getAttribute("id") == $identifier) {
                $element->nodeValue = $newValue;
            }
        }

        // Save the modifications to the XML file
        $xml->save($this->file);
    }

    // Function to delete elements with a specified name in the XML file, with an optional identifier
    public function deleteElements($name, $identifier = null) {
        // Check if the XML file exists
        if (!file_exists($this->file)) {
            $this->createXMLFile();
        }

        // Load the XML file
        $xml = new DOMDocument();
        $xml->load($this->file);

        // Get the elements with the specified name
        $elements = $xml->getElementsByTagName($name);

        // Delete the corresponding elements with a matching identifier if specified
        foreach ($elements as $element) {
            if ($identifier === null || $element->getAttribute("id") == $identifier) {
                $element->parentNode->removeChild($element);
            }
        }

        // Save the modifications to the XML file
        $xml->save($this->file);
    }
}

// Usage examples

$db = new PjsDB("file.xml");

// Add a new element with an automatically incremented identifier
$db->addElement("name", "John Doe");

// Update the value of an element with a specified identifier
$db->updateElement("name", "Jane Smith", 1);

// Delete all elements with a specified name
$db->deleteElements("name");

// Delete a single element with a specified identifier
$db->deleteElements("name", 1);