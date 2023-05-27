// Fonction pour ajouter un élément
function addElement(filename, name, value) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pjsdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Élément ajouté avec succès !");
            } else {
                console.error("Erreur lors de l'ajout de l'élément : " + xhr.status);
            }
        }
    };
    xhr.send("action=addElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&value=" + encodeURIComponent(value));
}

// Fonction pour mettre à jour un élément
function updateElement(filename, name, newValue, identifier) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pjsdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Élément mis à jour avec succès !");
            } else {
                console.error("Erreur lors de la mise à jour de l'élément : " + xhr.status);
            }
        }
    };
    xhr.send("action=updateElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&newValue=" + encodeURIComponent(newValue) + "&identifier=" + encodeURIComponent(identifier));
}

// Fonction pour supprimer un élément
function deleteElement(filename, name, identifier = null) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pjsdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Élément supprimé avec succès !");
            } else {
                console.error("Erreur lors de la suppression de l'élément : " + xhr.status);
            }
        }
    };
    xhr.send("action=deleteElement&filename=" + encodeURIComponent(filename) + "&name=" + encodeURIComponent(name) + "&identifier=" + encodeURIComponent(identifier));
}

// Usage examples

// Add a new element with an automatically incremented identifier
addElement("filename2", "name", "John Doe");

// Update the value of an element with a specified identifier
updateElement("filename2", "name", "Jane Smith", 1);

// // Delete all elements with a specified name
deleteElement("filename2", "name");

// Delete a single element with a specified identifier
deleteElement("filename", "name", 1);