var au = document.getElementById('addUser');
var du = document.getElementById('deactUser');
var actu = document.getElementById('actUser');

function showAddUser() {
    if (au.style.display !== 'none') {
        au.style.display = 'none';
    }
    else {
        if(du.style.display !== 'none' || actu.style.display !== 'none'){
            au.style.display = 'block';
            du.style.display = 'none';
            actu.style.display = 'none';
        }
        else {
            au.style.display = 'block';
        }
    }
}
function showDeactUser() {
    if (du.style.display !== 'none') {
        du.style.display = 'none';
    }
    else {
        if(au.style.display !== 'none' || actu.style.display !== 'none'){
            du.style.display = 'block';
            au.style.display = 'none';
            actu.style.display = 'none';
        }
        else {
            du.style.display = 'block';
        }
    }
}
function showActUser() {
    if (actu.style.display !== 'none') {
        actu.style.display = 'none';
    }
    else {
        if(au.style.display !== 'none' || du.style.display !== 'none'){
            actu.style.display = 'block';
            au.style.display = 'none';
            du.style.display = 'none';
        }
        else {
            actu.style.display = 'block';
        }
    }
}

function getUserSuggestions(divName) {
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
                            var p = document.createElement('p');
                            p.style.display = 'block';
                            p.innerHTML = suggestion.Username;
                            p.onclick = function() {
                                document.getElementById('search-' + divName).value = suggestion.Username;
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
                        p.innerHTML = "No user with such a username found. Please add from Add User.";
                        p.onclick = function() {
                            showAddUser();
                            document.getElementById('suggest-' + divName).style.display = "none";
                        };


                        autocompleteDiv.appendChild(p);
                    }
                }
            }
        };
        request.open('GET', '../../controller/autocompleteController.php?type=user&value=' + searchValue);
        request.send();
    }
    autocompleteDiv.style.display = 'none';
}

function changeActive(action) {
    swal({
        title: 'Are you sure you want to change this users status?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#009788',
        confirmButtonText: 'Yes, change it!'
    }).then(function () {
        var user = document.getElementById("search-" + action).value;
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);
                swal({
                    text: response.Result,
                    type: "info",
                    confirmButtonColor: "#009788"
                });
                if (response.Result === "Success!") {
                    if (action === "actUser") {
                        showActUser();
                    }
                    else {
                        showDeactUser();
                    }
                    var lastLogContent = "<tr>";
                    for (var i in response.Log[0]) {
                        lastLogContent += "<th class='w3-theme'>" + i + "</th>";
                    }
                    lastLogContent += "</tr>";
                    for (var p in response.Log) {
                        lastLogContent += "<tr>";
                        for (var q in response.Log[p]) {
                            lastLogContent += "<td>" + response.Log[p][q] + "</td>";
                        }
                        lastLogContent += "</tr>";
                    }
                    document.getElementById('lastLog').innerHTML = lastLogContent;
                    if (document.getElementById(user) !== null) {
                        if (document.getElementById(user).innerText === "YES") {
                            document.getElementById(user).innerText = "NO";
                        }
                        else {
                            document.getElementById(user).innerText = "YES";
                        }
                    }
                     document.getElementById("search-" + action).value = "";
                }
            }
        };
        request.open('POST', '../../controller/changeUserActiveController.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send("Username=" + user + "&action=" + action);
    });
}

function createUser() {
    var user = document.getElementById('Username').value;
	var pass = document.getElementById('Password').value;
	var confPass = document.getElementById('ConfirmPassword').value;
	var role = document.getElementById('Role').value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            swal({
                text: response.Result,
                type: "info",
                confirmButtonColor: "#009788"
            });
            if (response.Result === "User successfully added.") {
                showAddUser();

                var lastUsersContent = "<tr>";
                for (var i in response.Users[0]) {
                    lastUsersContent += "<th class='w3-theme'>" + i + "</th>";
                }
                lastUsersContent += "</tr>";
                for (var p in response.Users) {
                    lastUsersContent += "<tr>";
                    for (var q in response.Users[p]) {
                        lastUsersContent += "<td>" + response.Users[p][q] + "</td>";
                    }
                    lastUsersContent += "</tr>";
                }
                document.getElementById('lastUsers').innerHTML = lastUsersContent;

                var lastLogContent = "<tr>";
                for (i in response.Log[0]) {
                    lastLogContent += "<th class='w3-theme'>" + i + "</th>";
                }
                lastLogContent += "</tr>";
                for (p in response.Log) {
                    lastLogContent += "<tr>";
                    for (q in response.Log[p]) {
                        lastLogContent += "<td>" + response.Log[p][q] + "</td>";
                    }
                    lastLogContent += "</tr>";
                }
                document.getElementById('lastLog').innerHTML = lastLogContent;


                document.getElementById("Username").value = "";
				document.getElementById("Password").value = "";
				document.getElementById("ConfirmPassword").value = "";
				document.getElementById("Role").value = "select";
            }
        }
    };
    request.open('POST', '../../controller/addUserController.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send("Username=" + user + "&Password=" + pass + "&ConfirmPassword=" + confPass + "&Role=" + role);
}