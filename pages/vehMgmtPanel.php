<div class="w3-margin-top" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <p>Select action from the buttons below:</p>
        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="button" id="addVehButton" value="Add Vehicle">
        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="button" id="editVehButton" value="Edit Vehicle">
        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="button" id="delVehButton" value="Delete Vehicle">
        <br>
        <form id="at" style="display:none" method="post" action="${pageContext.request.contextPath}/insVehServlet">
            <div class="w3-responsive w3-card-4 w3-margin-top">
                <p>Vehicle Information Section.</p>
                <p>Please enter the vehicle Number Plate in the format "XnnnnXX" or "XXnnnnXX" where "X" are latin letters and "n" are arabic numbers.</p>
                <div class="w3-center w3-margin">
                    <label class="w3-label w3-left w3-margin">Vehicle Identification Number: </label>
                    <div class="w3-left">
                        <input class="w3-input" name='VIN' type="text" required style="width:200px">
                        <label class="w3-label w3-validate">VIN</label>
                    </div>
                </div>

            </div>
            <p>Owner Information Section.</p>
            <p>Please enter the owners EGN with 10 arabic numbers.</p>
            <div class="w3-responsive w3-card-4 w3-margin-top">
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th class="w3-theme"><div align="center">EGN</div></th>
                        <th class="w3-theme"><div align="center">Name</div></th>
                        <th class="w3-theme"><div align="center">Family Name</div></th>
                        <th class="w3-theme"><div align="center">City</div></th>
                        <th class="w3-theme"><div align="center">Address</div></th>

                    </tr>

                    <tr>
                        <td>
                            <div>
                                <input class="w3-input w3-center" name='EGN' type="text" required style="width:120px" maxlength="10">
                            </div>
                        </td>

                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='Name' type="text" required>
                            </div>
                        </td>

                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='FamilyName' type="text" required>
                            </div>
                        </td>

                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='City' type="text" required>
                            </div>
                        </td>

                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='Address' type="text" required>
                            </div>
                        </td>


                    </tr>
                </table>
            </div>
            <br>
            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Add">
        </form>

        <form id="et" style="display:none" method="post" action="vehmgmtedit.jsp">
            <div class="w3-responsive w3-card-4 w3-margin-top" style="width:25%">
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th class="w3-theme">
                            <div align="center">
                                Number Plate
                            </div>
                        </th>
                        <th class="w3-theme"></th>
                    </tr>
                    <tr>
                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='NumberPlate' type="text" required style="text-transform:uppercase;width:120px" maxlength="8">
                            </div>
                        </td>

                        <td>
                            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Edit">
                        </td>

                    </tr>
                </table>
            </div>
        </form>

        <form id="dt" style="display:none" method="post" action="${pageContext.request.contextPath}/delVehServlet">
            <div class="w3-responsive w3-card-4 w3-margin-top" style="width:25%">
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th class="w3-theme">
                            <div align="center">
                                Number Plate
                            </div>
                        </th>
                        <th class="w3-theme"></th>
                    </tr>
                    <tr>
                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='NumberPlate' type="text" required style="text-transform:uppercase;width:120px" maxlength="8">
                            </div>
                        </td>

                        <td>
                            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Delete">
                        </td>

                    </tr>
                </table>
            </div>
        </form>
        <br>

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