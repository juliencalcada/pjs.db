// Function to add an element
function addElement(filename, name, value) {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pjsdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        // Check if the request has been completed
        if (xhr.readyState === XMLHttpRequest.DONE) {
            // Check the response status
            if (xhr.status === 200) {
                console.log("Element added successfully!");
            } else {
                console.error("Error adding element: " + xhr.status);
            }
        }
    };
    // Send the request to the server with the necessary parameters
    xhr.send("action=addElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&value=" + encodeURIComponent(value));
}

// Function to update an element
function updateElement(filename, name, newValue, identifier) {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pjsdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        // Check if the request has been completed
        if (xhr.readyState === XMLHttpRequest.DONE) {
            // Check the response status
            if (xhr.status === 200) {
                console.log("Element updated successfully!");
            } else {
                console.error("Error updating element: " + xhr.status);
            }
        }
    };
    // Send the request to the server with the necessary parameters
    xhr.send("action=updateElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&newValue=" + encodeURIComponent(newValue) + "&identifier=" + encodeURIComponent(identifier));
}

// Function to delete an element
function deleteElement(filename, name, identifier = null) {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pjsdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        // Check if the request has been completed
        if (xhr.readyState === XMLHttpRequest.DONE) {
            // Check the response status
            if (xhr.status === 200) {
                console.log("Element deleted successfully!");
            } else {
                console.error("Error deleting element: " + xhr.status);
            }
        }
    };
    // Send the request to the server with the necessary parameters
    xhr.send("action=deleteElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&identifier=" + encodeURIComponent(identifier));
}

// Function to get elements
function getElements(filename, name = null, identifier = null) {
    // Return a promise to handle asynchronous operations
    return new Promise(function(resolve, reject) {
        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "pjsdb.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            // Check if the request has been completed
            if (xhr.readyState === XMLHttpRequest.DONE) {
                // Check the response status
                if (xhr.status === 200) {
                    // Parse the JSON response into an array of elements
                    var elements = JSON.parse(xhr.responseText);
                    // Resolve the promise with the retrieved elements
                    resolve(elements);
                } else {
                    // Reject the promise with an error message
                    reject("Error retrieving elements: " + xhr.status);
                }
            }
        };

        // Send the request to the server with the necessary parameters based on the provided arguments
        if (name !== null && identifier !== null) {
            xhr.send("action=getElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&identifier=" + encodeURIComponent(identifier));
        } else if (name !== null) {
            xhr.send("action=getElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name));
        } else {
            xhr.send("action=getElement&filename=" + encodeURIComponent(filename));
        }
    });
}




// Usage examples

// Add a new element with an automatically incremented identifier
addElement("filename", "name", "John Doe");

// Update the value of an element with a specified identifier
updateElement("filename", "name", "Jane Smith", 1);

// Delete all elements with a specified name
deleteElement("filename", "name");

// Delete a single element with a specified identifier
deleteElement("filename", "name", 2);

// Get all elements
getElements("filename").then(function(elements) {
    console.log(elements);
}).catch(function(error) {
    console.error(error);
});

// Get all elements with a specified name
getElements("filename", "name").then(function(elements) {
    console.log(elements);
}).catch(function(error) {
    console.error(error);
});

// Get a single element with a specified name and identifier
getElements("filename", "name", 1).then(function(elements) {
    console.log(elements);
}).catch(function(error) {
    console.error(error);
});