var addVehicle = document.getElementById('addVehicle');
var delVehicle = document.getElementById('deleteVehicle');
var editVehicle = document.getElementById('editVehicle');
var addOwner = document.getElementById('addOwner');
var delOwner = document.getElementById('deleteOwner');
var editOwner = document.getElementById('editOwner');
var editOwnerSection = document.getElementById('editOwnerSection');

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
        editOwnerSection.style.display = 'none';
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
        editOwnerSection.style.display = 'none';
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
        editOwnerSection.style.display = 'none';
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
        editOwnerSection.style.display = 'none';
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
        editOwnerSection.style.display = 'none';
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
        editOwnerSection.style.display = 'none';
    }
}
function showEditOwnerSection() {
    if (editOwnerSection.style.display !== 'none') {
        editOwnerSection.style.display = 'none';
    }
    else {
        editOwnerSection.style.display = 'block';
        addVehicle.style.display = 'none';
        delVehicle.style.display = 'none';
        editVehicle.style.display = 'none';
        addOwner.style.display = 'none';
        editOwner.style.display = 'none';
        delOwner.style.display = 'none';
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
                        if (response.suggestions[0].EGN != null) {
                            property = "EGN";
                        }
                        else  {
                            property = "Numberplate";
                        }
                        response.suggestions.forEach(function (suggestion) {
                            var value = "";
                            if (suggestion.EGN != null) {
                                value = suggestion.EGN;
                            }
                            else {
                                value = suggestion.Numberplate;
                            }
                            var p = document.createElement('p');
                            p.style.display = 'block';
                            p.innerHTML = value;
                            p.onclick = function() {
                                document.getElementById('search-' + divName).value = value;
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
                        if (type === 'egn') {
                            p.innerHTML = "No owner with such an EGN / EIK found. Please add from Add Owner.";
                            p.onclick = function() {
                                showAddOwner();
                                document.getElementById('suggest-' + divName).style.display = "none";
                            };
                        }
                        else  {
                            p.innerHTML = "No vehicle with such an Number Plate found. Please add from Add Vehicle";
                            p.onclick = function() {
                                showAddVehicle();
                                document.getElementById('suggest-' + divName).style.display = "none";
                            };
                        }
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

function deleteVehicle() {
    swal({
            title: 'Are you sure you want to delete this vehicle?',
            text: "You will not be able to recover this vehicle!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#009788',
        confirmButtonText: 'Yes, delete it!'
    }).then(function () {

    });
}

function createOwner() {
    var ownerId = document.getElementById("addOwnerID").value;
    var ownerCity = document.getElementById("ownerCity").value;
    var ownerName = document.getElementById("ownerName").value;
    var ownerFname = document.getElementById("ownerFName").value;
    var ownerAddress = document.getElementById("ownerAddress").value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            swal({
                text: response.Result,
                type: "info",
                confirmButtonColor: "#009788"
            });
            if (response.Result === "New owner successfully added!") {
                showAddOwner();
                document.getElementById("addOwnerID").value = "";
                document.getElementById("ownerCity").value = "";
                document.getElementById("ownerName").value = "";
                document.getElementById("ownerFName").value = "";
                document.getElementById("ownerAddress").value = "";
            }
        }
    };
    request.open('POST', '../../controller/addOwnerController.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send("ownerID=" + ownerId + "&ownerCity=" + ownerCity + "&ownerName=" + ownerName + "&ownerFName=" + ownerFname +"&ownerAddress=" + ownerAddress);
}
function fetchOwner() {
    var egn = document.getElementById('search-editOwner').value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (response.Result != null) {
                swal({
                    text: response.Result,
                    type: "info",
                    confirmButtonColor: "#009788"
                });
            }
            else if (response.EGN != null){
                document.getElementById("editOwnerID").value = response.EGN;
                document.getElementById("editOwnerCity").value = response.City;
                document.getElementById("editOwnerName").value = response.FirstName;
                document.getElementById("editOwnerFName").value = response.FamilyName;
                document.getElementById("editOwnerAddress").value = response.Address;
                showEditOwnerSection();
            }
        }
    };
    request.open('GET', '../../controller/editOwnerController.php?egn=' + egn);
    request.send();
}

function updateOwner() {
    var ownerId = document.getElementById("editOwnerID").value;
    var ownerCity = document.getElementById("editOwnerCity").value;
    var ownerName = document.getElementById("editOwnerName").value;
    var ownerFname = document.getElementById("editOwnerFName").value;
    var ownerAddress = document.getElementById("editOwnerAddress").value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            swal({
                text: response.Result,
                type: "info",
                confirmButtonColor: "#009788"
            });
            if (response.Result === "Owner info successfully updated!") {
                showEditOwnerSection();
                document.getElementById("editOwnerID").value = "";
                document.getElementById("editOwnerCity").value = "";
                document.getElementById("editOwnerName").value = "";
                document.getElementById("editOwnerFName").value = "";
                document.getElementById("editOwnerAddress").value = "";
                document.getElementById("search-editOwner").value = "";
            }
        }
    };
    request.open('POST', '../../controller/updateOwnerController.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send("ownerID=" + ownerId + "&ownerCity=" + ownerCity + "&ownerName=" + ownerName + "&ownerFName=" + ownerFname +"&ownerAddress=" + ownerAddress);
}