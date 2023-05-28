

# PjsDB Documentation

This code provides methods to create, update, delete, and get elements in an XML file.

## Constructor

### PjsDB(`$file`)

Creates a new instance of the PjsDB class.

- `$file` (string): The name of the XML file without the extension.

#### Usage example
```php
$db = new PjsDB("filename");
```

## Methods

### addElement(`$filename`, `$name`, `$value`)

Adds a new element to the XML file with an automatically incremented identifier.

- `$filename` (string): The name of the XML file without the extension.
- `$name` (string): The name of the element.
- `$value` (string): The value of the element.

#### Usage example
```php
$db->addElement("filename", "name", "John Doe");
```

### updateElement(`$filename`, `$name`, `$newValue`, `$identifier`)

Updates the value of an element in the XML file with a specified identifier.

- `$filename` (string): The name of the XML file without the extension.
- `$name` (string): The name of the element.
- `$newValue` (string): The new value of the element.
- `$identifier` (int): The identifier of the element to update.

#### Usage example
```php
$db->updateElement("filename", "name", "Jane Smith", 1);
```

### deleteElements(`$filename`, `$name`, `$identifier` = null)

Deletes elements with a specified name in the XML file, with an optional identifier.

- `$filename` (string): The name of the XML file without the extension.
- `$name` (string): The name of the elements to delete.
- `$identifier` (int|null): The identifier of the element to delete (optional).

#### Usage example
```php
// Delete all elements
$db->deleteElements("filename", "name");
// Delete specific element
$db->deleteElements("filename", "name", 1);
```

### getElement(`$filename`, `$name = null`, `$identifier = null`)

Retrieves element(s) from the XML file based on parameters.

- `$filename` (string): The name of the XML file without the extension.
- `$name` (string|null): The name of the element(s) to retrieve (optional).
- `$identifier` (int|null): The identifier of the element to retrieve (optional).

#### Usage example
```php
// Get all elements
$db->getElement("filename");

// Get all elements with a specified name
$db->getElement("filename", "name");

// Get a single element with a specified name and identifier
$db->getElement("filename", "name", 2);
```

## Usage examples

```php
// Creates a new instance of the PjsDB class
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
```

# Known Errors

You might encounter the following error:

``` php
Fatal error: Uncaught Error: Class "DOMDocument" not found in /your/project/pjs.php:6 Stack trace: #0 {main} thrown in /your/project/pjs.php on line 6
```

This error occurs when the DOM extension is missing. To resolve this error, you can install the DOM extension using the following steps:

- Debian / Ubuntu: Run `sudo apt-get install php-dom` in the terminal.
- CentOS / Fedora / Red Hat: Run `yum install php-xml` in the terminal.

These commands install the DOM extension for PHP, which is required to use the `DOMDocument` class. After the installation is complete, the error should be resolved, and you will be able to use the `DOMDocument` class without any issues.

Make sure to run these commands as a user with administrative privileges (e.g., using `sudo`).

Additionally, to see detailed error messages, make sure to add the following PHP code at the beginning of your script:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

These lines of code enable error reporting and display errors in PHP. By adding these instructions, you will be able to see detailed error messages that can help you identify and resolve any issues.

Remember to use this code only in a development environment, as displaying errors in a production environment can pose security risks. Once you have resolved the issues, consider removing or commenting out these lines to prevent error display to end users.