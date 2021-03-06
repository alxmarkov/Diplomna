<?php
    function __autoload($className) {
        $className = str_replace("\\", "/", $className);
        require_once "../../" . $className . '.php';
    }
    session_start();
    $topHeading = "Vehicle Information Service";
    $pageName = "Vehicle Management Panel";
    require_once ("../components/headerLoggedInValues.php");
    require_once ("../components/header.php");
?>

<div class="w3-margin-top" align="center">

    <div class="w3-card-2 w3-padding-top w3-margin" style="min-height:360px;width:80%">
        <h4>Select action from the buttons below:</h4>
        <div style="width: 100%">
            <h5>Vehicles Operations:</h5>
            <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showAddVehicle()">Add Vehicle</button>
            <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showEditVehicle()">Edit Vehicle</button>
            <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showDeleteVehicle()">Delete Vehicle</button>
        </div>
        <div style="width: 100%">
            <h5>Owners Operations:</h5>
            <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showAddOwner()">Add Owner</button>
            <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showEditOwner()">Edit Owner</button>
            <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showDeleteOwner()">Delete Owner</button>
        </div>
        <br>
        <form id="addVehicle" style="display:none" method="post" enctype="multipart/form-data" action="../../controller/addVehicleController.php">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Vehicle Information Section:</h4>
                <p>Please enter the vehicle Number Plate in the format "XnnnnXX" or "XXnnnnXX" where "X" are latin letters and "n" are arabic numbers.</p>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 100%; margin: 0; padding: 2px">
                        <label class="w3-label">Vehicle Type: </label>
                        <select class="w3-select" name="type" required style="width: 80%">
                            <option value="Automobile">Automobile</option>
                            <option value="Motorcycle">Motorcycle</option>
                            <option value="Moped">Moped</option>
                            <option value="Van">Van</option>
                            <option value="Truck">Truck</option>
                            <option value="Trailer">Trailer</option>
                            <option value="Bus">Bus</option>
                        </select>
                    </div>
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
                            <option value="Hybrid">Hybrid</option>
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
                        <input type="file" name="picture" required style="width: 50%" accept="image/*">
                    </div>
                    <div style="width: 100%; float: left; margin: 0; padding: 2px; position: relative">
                        <input class="w3-input w3-center" name="ownerID" id="search-addVeh" type="text" required style="width:100%" maxlength="10" onkeyup="getSuggestions('egn', 'addVeh')" autocomplete="off">
                        <label class="w3-label w3-validate">Owner EGN / EIK</label>
                        <div id="suggest-addVeh" class="search-autocomplete" style="display: none"></div>
                    </div>
                    <input class="w3-btn w3-dark-grey w3-hover-light-grey w3-margin" type="submit" value="Add">
                </div>
            </div>
        </form>
        <div id="addOwner" style="display:none">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Owner Information Section.</h4>
                <p>Please enter the owners EGN / EIK with 10 arabic numbers.</p>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="addOwnerID" type="text" required style="width:100%" maxlength="10">
                        <label class="w3-label w3-validate">EGN / EIK</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="ownerCity" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">City</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="ownerName" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">First Name</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="ownerFName" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Family Name</label>
                    </div>
                    <div class="w3-margin" style="clear: both">
                        <input class="w3-input w3-center" id="ownerAddress" type="text" required style="width:100%">
                        <label class="w3-label w3-validate">Address</label>
                    </div>
                    <button class="w3-btn w3-dark-grey w3-hover-light-grey w3-margin" onclick="createOwner()">Add</button>
                </div>
            </div>
        </div>

        <div id="editVehicle" style="display:none">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Please enter the vehicle Number Plate to edit it's record:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; margin: 10px auto; padding: 2px; position: relative">
                        <input class="w3-input w3-center" name="numberplateEdit" id="search-editVeh" type="text" required style="text-transform:uppercase;width:100%" maxlength="8" onkeyup="getSuggestions('np', 'editVeh')" autocomplete="off">
                        <label class="w3-label w3-validate">Number Plate</label>
                        <div id="suggest-editVeh" class="search-autocomplete" style="display: none"></div>
                    </div>
                    <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="fetchVehicle()">Select</button>
                </div>
            </div>
        </div>

        <form id="editVehicleSection" style="display:none" method="post" enctype="multipart/form-data" action="../../controller/updateVehicleController.php">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Edit Vehicle Information:</h4>
                <p>Please enter the vehicle Number Plate in the format "XnnnnXX" or "XXnnnnXX" where "X" are latin letters and "n" are arabic numbers.</p>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 100%; margin: 0; padding: 2px">
                        <label class="w3-label">Vehicle Type: </label>
                        <input class="w3-w3-input w3-center w3-disabled" name="editType" id="editType" type="text" required style="width: 80%" readonly>
                    </div>
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center w3-disabled" name="editVin" id="editVin" type="text" required style="text-transform:uppercase;width: 100%" maxlength="20" readonly>
                        <label class="w3-label w3-validate">Vehicle Identification Number</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="editNumberplate" id="editNumberplate" type="text" required style="text-transform:uppercase;width:100%" maxlength="8">
                        <label class="w3-label w3-validate">Number Plate</label>
                    </div>

                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center w3-disabled" name="editMake" id="editMake" type="text" required style="width:100%" maxlength="50" readonly>
                        <label class="w3-label w3-validate">Make</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center w3-disabled" name="editModel" id="editModel" type="text" required style="width:100%" maxlength="50" readonly>
                        <label class="w3-label w3-validate">Model</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 0px 0px 10px 0px; padding: 2px">
                        <label class="w3-label">Engine Type: </label>
                        <select class="w3-select" name="editEngineType" id="editEngineType" required style="width: 50%">
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="editEngineSize" id="editEngineSize" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Engine Size</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 10px 0px 0px 0px; padding: 2px">
                        <label class="w3-label">Production Date:</label>
                        <input class="w3-select w3-disabled" name="editYear" id="editYear" type="date" required style="width:50%" readonly>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" name="editColor" id="editColor" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Color</label>
                    </div>
                    <div class="w3-margin" style="clear: both">
                        <label class="w3-label">Picture of vehicle: </label>
                        <img id="viewVehPicture" src="" width="50%" height="auto">
                        <input type="file" name="editPicture" style="width: 50%" accept="image/*">
                    </div>
                    <div style="width: 100%; float: left; margin: 0; padding: 2px; position: relative">
                        <input class="w3-input w3-center" name="editOwnerID" id="search-updateVeh" type="text" required style="width:100%" maxlength="10" onkeyup="getSuggestions('egn', 'updateVeh')" autocomplete="off">
                        <label class="w3-label w3-validate">Owner EGN / EIK</label>
                        <div id="suggest-updateVeh" class="search-autocomplete" style="display: none"></div>
                    </div>
                    <input class="w3-btn w3-dark-grey w3-hover-light-grey w3-margin" type="submit" value="Edit">
                </div>
            </div>
        </form>

        <div id="editOwner" style="display:none">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Please enter the owners EGN or EIK to edit his record:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; margin: 10px auto; padding: 2px; position: relative">
                        <input class="w3-input w3-center" name="egnEdit" id="search-editOwner" type="text" required style="text-transform:uppercase;width:100%" maxlength="10" onkeyup="getSuggestions('egn', 'editOwner')" autocomplete="off">
                        <label class="w3-label w3-validate">EGN / EIK</label>
                        <div id="suggest-editOwner" class="search-autocomplete" style="display: none"></div>
                    </div>
                    <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="fetchOwner()">Select</button>
                </div>
            </div>
        </div>

        <div id="editOwnerSection" style="display:none">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Edit Owner Information:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="editOwnerID" type="text" required style="width:100%" maxlength="10" disabled>
                        <label class="w3-label w3-validate">EGN / EIK</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="editOwnerCity" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">City</label>
                    </div>
                    <div style="width: 50%; float: left; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="editOwnerName" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">First Name</label>
                    </div>
                    <div style="width: 50%; float: right; margin: 0; padding: 2px">
                        <input class="w3-input w3-center" id="editOwnerFName" type="text" required style="width:100%" maxlength="50">
                        <label class="w3-label w3-validate">Family Name</label>
                    </div>
                    <div class="w3-margin" style="clear: both">
                        <input class="w3-input w3-center" id="editOwnerAddress" type="text" required style="width:100%">
                        <label class="w3-label w3-validate">Address</label>
                    </div>
                    <button class="w3-btn w3-dark-grey w3-hover-light-grey w3-margin" onclick="updateOwner()">Edit</button>
                </div>
            </div>
        </div>

        <div id="deleteVehicle" style="display:none">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Please enter the vehicle Number Plate to delete it's record:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; margin: 10px auto; padding: 2px; position: relative">
                        <input class="w3-input w3-center" name="numberplateDelete" id="search-delVeh" type="text" required style="text-transform:uppercase;width:100%" maxlength="8" onkeyup="getSuggestions('np', 'delVeh')" autocomplete="off">
                        <label class="w3-label w3-validate">Number Plate</label>
                        <div id="suggest-delVeh" class="search-autocomplete" style="display: none"></div>
                    </div>
                    <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="deleteVehicle()">Delete</button>
                </div>
            </div>
        </div>

        <div id="deleteOwner" style="display:none">
            <div class="w3-responsive w3-card-4 w3-margin">
                <h4>Please enter the owners EGN or EIK to delete his record:</h4>
                <div class="w3-center w3-margin" style="width: 60%; display: inline-block">
                    <div style="width: 50%; margin: 10px auto; padding: 2px; position: relative">
                        <input class="w3-input w3-center" name="egnDelete" id="search-delOwner" type="text" required style="text-transform:uppercase;width:100%" maxlength="10" onkeyup="getSuggestions('egn', 'delOwner')" autocomplete="off">
                        <label class="w3-label w3-validate">EGN / EIK</label>
                        <div id="suggest-delOwner" class="search-autocomplete" style="display: none"></div>
                    </div>
                    <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="deleteOwner()">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="../../assets/js/vehMgmt.js"></script>
<?php
    include_once ("../components/footer.php");
?>