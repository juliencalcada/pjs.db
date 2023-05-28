<?php
class PjsDB
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file . ".xml"; // Adding the .xml extension to the file name
    }

    // Function to create an empty XML file
    public function createXMLFile()
    {
        // Create a new DOMDocument object
        $xml = new DOMDocument();

        // Create the root element
        $root = $xml->createElement("root");

        // Add the root element to the XML document
        $xml->appendChild($root);

        // Save the XML document content to the file
        $xml->save($this->file);
    }

    // Function to retrieve the last used identifier in the XML file for a specific element type
    public function getLastIdentifier($name)
    {
        // Load the XML file
        $xml = new DOMDocument();
        $xml->load($this->file);

        $xpath = new DOMXPath($xml);
        $query = "//" . $name . "[@id]";
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
    public function addElement($filename, $name, $value)
    {
        // Check if the XML file exists
        if (!file_exists($this->file)) {
            $this->createXMLFile();
        }

        // Retrieve the last used identifier
        $lastIdentifier = $this->getLastIdentifier($name);

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
    public function updateElement($filename, $name, $newValue, $identifier)
    {
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
    public function deleteElements($filename, $name, $identifier = null)
    {
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
            if (
                $identifier === null ||
                $element->getAttribute("id") == $identifier
            ) {
                $element->parentNode->removeChild($element);
            }
        }

        // Save the modifications to the XML file
        $xml->save($this->file);
    }

    // Function to retrieve element(s) from the XML file based on parameters
    public function getElement($filename, $name = null, $identifier = null)
    {
        // Load the XML file
        $xml = new DOMDocument();
        $xml->load($this->file);

        // Create an XPath instance
        $xpath = new DOMXPath($xml);

        // Construct the XPath query based on the provided parameters
        $query = "";
        if ($name !== null && $identifier !== null) {
            $query = "//" . $name . "[@id='" . $identifier . "']";
        } elseif ($name !== null) {
            $query = "//" . $name;
        } else {
            $query = "//*"; // Select all elements in the XML
        }

        // Execute the XPath query
        $elements = $xpath->query($query);

        // Prepare the result array
        $result = [];

        // Iterate over the elements and retrieve the information
        foreach ($elements as $element) {
            $info = [];
            $info["name"] = $element->nodeName;
            $info["value"] = $element->nodeValue;
            $info["id"] = $element->getAttribute("id");
            $result[] = $info;
        }

        if ($name === null && $identifier === null) {
            unset($result[0]);
            $result = array_values($result);
        }

        // Convert the result array to JSON format
        $jsonResult = json_encode($result);

        return $jsonResult;
    }
}

// Check if the action is defined in the request
if (isset($_POST["action"])) {
    $action = $_POST["action"];

    // Create an instance of PjsDB
    $db = new PjsDB($_POST["filename"]);

    // Perform the action based on the value of 'action'
    switch ($action) {
        case "addElement":
            if (isset($_POST["filename"], $_POST["name"], $_POST["value"])) {
                $filename = $_POST["filename"];
                $name = $_POST["name"];
                $value = $_POST["value"];
                $db->addElement($filename, $name, $value);
                // Respond with a success code
                http_response_code(200);
            } else {
                // Respond with an error code
                http_response_code(400);
            }
            break;

        case "updateElement":
            if (
                isset(
                    $_POST["filename"],
                    $_POST["name"],
                    $_POST["newValue"],
                    $_POST["identifier"]
                )
            ) {
                $filename = $_POST["filename"];
                $name = $_POST["name"];
                $newValue = $_POST["newValue"];
                $identifier = $_POST["identifier"];
                $db->updateElement($filename, $name, $newValue, $identifier);
                // Respond with a success code
                http_response_code(200);
            } else {
                // Respond with an error code
                http_response_code(400);
            }
            break;

        case "deleteElement":
            if (
                isset($_POST["filename"], $_POST["name"], $_POST["identifier"])
            ) {
                $filename = $_POST["filename"];
                $name = $_POST["name"];
                $identifier = $_POST["identifier"];
                if ($identifier == "null") {
                    $identifier = null;
                }
                $db->deleteElements($filename, $name, $identifier);
                // Respond with a success code
                http_response_code(200);
            } else {
                // Respond with an error code
                http_response_code(400);
            }
            break;
        case "getElement":
            if (isset($_POST["filename"])) {
                $filename = $_POST["filename"];
                $name = isset($_POST["name"]) ? $_POST["name"] : null;
                $identifier = isset($_POST["identifier"])
                    ? $_POST["identifier"]
                    : null;

                // Call the getElement function
                $result = $db->getElement($filename, $name, $identifier);

                // Respond with the result
                echo json_encode($result);

                // Respond with a success code
                http_response_code(200);
            } else {
                // Respond with an error code
                http_response_code(400);
            }
            break;
        default:
            // Respond with an error code for an unsupported action
            http_response_code(400);
            break;
    }
}

// Usage examples

$db = new PjsDB("filename");

// Add a new element with an automatically incremented identifier
$db->addElement("filename", "name", "John Doe");

// Update the value of an element with a specified identifier
$db->updateElement("filename", "name", "Jane Smith", 1);

// Delete all elements with a specified name
$db->deleteElements("filename", "name");

// Delete a single element with a specified identifier
$db->deleteElements("filename", "name", 1);

// Get all elements
$db->getElement("filename");

// Get all elements with a specified name
$db->getElement("filename", "name");

// Get a single element with a specified name and identifier
$db->getElement("filename", "name", 2);
