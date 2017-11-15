var addVehicle = document.getElementById('addVehicle');
var delVehicle = document.getElementById('deleteVehicle');
var editVehicle = document.getElementById('editVehicle');
var addOwner = document.getElementById('addOwner');
var delOwner = document.getElementById('deleteOwner');
var editOwner = document.getElementById('editOwner');

function showAddVehicle() {
    if (addVehicle.style.display !== 'none') {
        addVehicle.style.display = 'none';
    }
    else {
        addVehicle.style.display = 'block';
        delVehicle.style.display = 'none';
        editVehicle.style.display = 'none';
        addOwner.style.display = 'none';
        editOwner.style.display = 'none';
        delOwner.style.display = 'none';
    }
}

function showDeleteVehicle() {
    if (delVehicle.style.display !== 'none') {
        delVehicle.style.display = 'none';
    }
    else {
        delVehicle.style.display = 'block';
        addVehicle.style.display = 'none';
        editVehicle.style.display = 'none';
        addOwner.style.display = 'none';
        editOwner.style.display = 'none';
        delOwner.style.display = 'none';
    }
}

function showEditVehicle() {
    if (editVehicle.style.display !== 'none') {
        editVehicle.style.display = 'none';
    }
    else {
        editVehicle.style.display = 'block';
        addVehicle.style.display = 'none';
        delVehicle.style.display = 'none';
        addOwner.style.display = 'none';
        editOwner.style.display = 'none';
        delOwner.style.display = 'none';
    }
}
function showAddOwner() {
    if (addOwner.style.display !== 'none') {
        addOwner.style.display = 'none';
    }
    else {
        addOwner.style.display = 'block';
        addVehicle.style.display = 'none';
        delVehicle.style.display = 'none';
        editVehicle.style.display = 'none';
        editOwner.style.display = 'none';
        delOwner.style.display = 'none';
    }
}

function showEditOwner() {
    if (editOwner.style.display !== 'none') {
        editOwner.style.display = 'none';
    }
    else {
        editOwner.style.display = 'block';
        addVehicle.style.display = 'none';
        delVehicle.style.display = 'none';
        editVehicle.style.display = 'none';
        addOwner.style.display = 'none';
        delOwner.style.display = 'none';
    }
}

function showDeleteOwner() {
    if (delOwner.style.display !== 'none') {
        delOwner.style.display = 'none';
    }
    else {
        delOwner.style.display = 'block';
        addVehicle.style.display = 'none';
        delVehicle.style.display = 'none';
        editVehicle.style.display = 'none';
        addOwner.style.display = 'none';
        editOwner.style.display = 'none';
    }
}

function getSuggestions(type, divName) {
    var searchValue = document.getElementById('search-' + divName).value;
    var request = new XMLHttpRequest();
    var autocompleteDiv = document.getElementById('suggest-' + divName);
    if (searchValue.length > 0 && searchValue.trim().length > 0) {
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (response != '') {
                    var response = JSON.parse(this.responseText);
                    if (response.suggestions.length !== 0) {
                        autocompleteDiv.innerHTML = '';
                        autocompleteDiv.style.display = 'block';
                        response.suggestions.forEach(function (suggestion) {
                            var egn = suggestion.EGN;
                            var p = document.createElement('p');
                            p.style.display = 'block';
                            p.innerHTML = egn;
                            p.onclick = function() {
                                document.getElementById('search-' + divName).value = egn;
                                document.getElementById('suggest-' + divName).style.display = "none";
                            };
                            autocompleteDiv.appendChild(p);
                        });
                    }
                    else {
                        autocompleteDiv.innerHTML = '';
                        autocompleteDiv.style.display = 'block';
                        var p = document.createElement('p');
                        p.style.display = 'block';
                        p.innerHTML = "No owner with such an EGN / EIK found. Please add from Add Owner.";
                        p.onclick = function() {
                            showAddOwner();
                            document.getElementById('suggest-' + divName).style.display = "none";
                        };
                        autocompleteDiv.appendChild(p);
                    }
                }
            }
        };
        request.open('GET', '../../controller/autocompleteController.php?type=' + type + '&value=' + searchValue);
        request.send();
    }
    autocompleteDiv.style.display = 'none';
}
