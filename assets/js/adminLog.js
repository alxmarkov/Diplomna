function changePage(direction) {
    var logID = parseInt(document.getElementById('logNumber').value);
    var change = true;
    if (direction === "previous") {
        logID -= 10;
        if (logID < 0) {
            logID = 0;
            document.getElementById('logNumber').value = "0";
            change = false;
        }
        else {
            document.getElementById('logNumber').value = logID.toString();
        }
    }
    else if (direction === "next") {
        logID += 10;
        if (logID > parseInt(document.getElementById('maxLogNumber').value)) {
            logID -= 10;
            change = false;
        }
        document.getElementById('logNumber').value = logID.toString();
    }
    if (change) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.status === 200) {
                var result = JSON.parse(this.responseText);
                var tableContent = "";
                for (var i = 0; i < result.length; i++) {
                    if (i === 0) {
                        tableContent += "<tr>";
                        for (var heading in result[0]) {
                            tableContent += "<th class='w3-theme'>" + heading + "</th>";
                        }
                        tableContent += "</tr>";
                    }
                    tableContent += "<tr>";
                    for (var key in result[i]) {
                        if (result[i][key] !== null) {
                            tableContent += "<td>" + result[i][key] + "</td>";
                        }
                        else {
                            tableContent += "<td></td>";
                        }
                    }
                    tableContent += "</tr>";
                }
                document.getElementById('logTable').innerHTML = tableContent;
            }
        };
        xmlhttp.open("GET", "../../controller/changeLogPageController.php?logID="+logID);
        xmlhttp.send();
    }
}