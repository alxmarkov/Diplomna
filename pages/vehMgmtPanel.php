<div class="w3-margin-top" align="center">

    <div class="w3-card-2 w3-padding-top w3-margin" style="min-height:360px;width:80%">
        <h4>Select action from the buttons below:</h4>
        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="button" id="addVehButton" value="Add Vehicle">
        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="button" id="editVehButton" value="Edit Vehicle">
        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="button" id="delVehButton" value="Delete Vehicle">
        <br>
        <form id="at" style="display:none" method="post" enctype="multipart/form-data" action="">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Vehicle Information Section:</h4>
                <p>Please enter the vehicle Number Plate in the format "XnnnnXX" or "XXnnnnXX" where "X" are latin letters and "n" are arabic numbers.</p>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="vin" type="text" required style="text-transform:uppercase;width: 100%" maxlength="20">
                        <label class="w3-label w3-validate">Vehicle Identification Number</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="numberplate" type="text" required style="text-transform:uppercase;width:100%" maxlength="8">
                        <label class="w3-label w3-validate">Number Plate</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="make" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Make</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="model" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Model</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 0px 0px 10px 0px; padding: 2px">
                        <label class="w3-label">Engine Type: </label>
                        <select class="w3-select" name="engineType" required style="width: 50%">
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                        </select>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="engineSize" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Engine Size</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 10px 0px 0px 0px; padding: 2px">
                        <label class="w3-label">Production Date:</label>
                        <input class="w3-select" name="year" type="date" required style="width:50%">
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="color" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Color</label>
                    </div>
                    <div class="w3-margin" style="clear: both">
                        <label class="w3-label">Picture of vehicle: </label>
                        <input type="file" name="picture" required style="width: 50%">
                    </div>
                </div>
            </div>

            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Owner Information Section.</h4>
                <p>Please enter the owners EGN / EIK with 10 arabic numbers.</p>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="ownerID" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">EGN / EIK</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="ownerCity" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">City</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="ownerName" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">First Name</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="ownerFName" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Family Name</label>
                    </div>
                    <div class="w3-margin" style="clear: both">
                        <input class="w3-input w3-center" name="ownerAddress" type="text" required style="width:100%">
                        <label class="w3-label w3-validate">Address</label>
                    </div>
                </div>
            </div>
            <input class="w3-btn w3-dark-grey w3-hover-light-grey w3-margin" type="submit" value="Add">
        </form>

        <form id="et" style="display:none" method="post" action="vehmgmtedit.jsp">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Please enter the vehicle Number Plate to edit it's record:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; margin: 10px auto; padding: 2px">
                        <input class="w3-input w3-center" name="numberplate" type="text" required style="text-transform:uppercase;width:100%" maxlength="8">
                        <label class="w3-label w3-validate">Number Plate</label>
                    </div>
                    <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Edit">
                </div>
            </div>
        </form>

        <form id="dt" style="display:none" method="post" action="${pageContext.request.contextPath}/delVehServlet">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Please enter the vehicle Number Plate to delete it's record:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; margin: 10px auto; padding: 2px">
                        <input class="w3-input w3-center" name="numberplate" type="text" required style="text-transform:uppercase;width:100%" maxlength="8">
                        <label class="w3-label w3-validate">Number Plate</label>
                    </div>
                    <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Delete">
                </div>
            </div>
        </form>

    </div>
</div>

<script type="text/javascript">
    var button = document.getElementById('addVehButton'); // Assumes element with id='button'

    button.onclick = function() {
        var at = document.getElementById('at');
        var dt = document.getElementById('dt');
        var et = document.getElementById('et');
        if (at.style.display !== 'none') {
            at.style.display = 'none';
        }
        else {
            if (dt.style.display !== 'none' || et.style.display !== 'none'){
                at.style.display = 'block';
                dt.style.display = 'none';
                et.style.display = 'none';
            }
            else {
                at.style.display = 'block';
            }
        }
    };

</script>

<script type="text/javascript">
    var button = document.getElementById('delVehButton'); // Assumes element with id='button'

    button.onclick = function() {
        var dt = document.getElementById('dt');
        var at = document.getElementById('at');
        var et = document.getElementById('et');
        if (dt.style.display !== 'none') {
            dt.style.display = 'none';
        }
        else {
            if (at.style.display !== 'none' || et.style.display !== 'none') {
                dt.style.display = 'block';
                at.style.display = 'none';
                et.style.display = 'none';
            }
            else {
                dt.style.display = 'block';
            }

        }
    };

</script>

<script type="text/javascript">
    var button = document.getElementById('editVehButton'); // Assumes element with id='button'

    button.onclick = function() {
        var dt = document.getElementById('dt');
        var at = document.getElementById('at');
        var et = document.getElementById('et');
        if (et.style.display !== 'none') {
            et.style.display = 'none';
        }
        else {
            if (at.style.display !== 'none' || dt.style.display !== 'none') {
                et.style.display = 'block';
                at.style.display = 'none';
                dt.style.display = 'none';
            }
            else {
                et.style.display = 'block';
            }

        }
    };

</script>