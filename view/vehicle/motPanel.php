<?php
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../../" . $className . '.php';
}
session_start();
$topHeading = "Vehicle Information Service";
$pageName = "MOT Management Panel";
require_once ("../components/headerLoggedInValues.php");
require_once ("../components/header.php");
?>

<div class="w3-margin-top" align="center">

    <div class="w3-card-2 w3-padding-top w3-margin" style="min-height:360px;width:80%">
        <h4>Select action from the buttons below:</h4>
        <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showAddSection()">Add Record</button>
        <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showEditSection()">Edit Record</button>
        <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="showDLSection()">Download Attachment</button>
        <br>
        <form id="at" style="display:none; width:70%" method="post" action="" enctype="multipart/form-data">
            <p>Please enter the Dates in the format YYYY-MM-DD:</p>
            <div class="w3-responsive w3-card-4 w3-margin-top">
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th class="w3-theme"><div align="center">MOT From</div></th>
                        <th class="w3-theme"><div align="center">MOT To</div></th>
                        <th class="w3-theme"><div align="center">Attachment</div></th>
                        <th class="w3-theme"></th>
                    </tr>

                    <tr>
                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='From' type="text" required>
                            </div>
                        </td>

                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='To' type="text" required>
                            </div>
                        </td>

                        <td>
                            <input class="w3-btn w3-dark-grey w3-hover-light-grey" name="File" type="file" style="width:300px" required>
                        </td>

                        <td>
                            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Add">
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <form id="et" style="display:none" method="post" action="">
            <div class="w3-responsive w3-card-4 w3-margin-top" style="width:25%">
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th class="w3-theme">
                            <div align="center">
                                ID Number
                            </div>
                        </th>
                        <th class="w3-theme"></th>
                    </tr>
                    <tr>
                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='ID' type="text" required >
                            </div>
                        </td>

                        <td>
                            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Edit">
                        </td>

                    </tr>
                </table>
            </div>
        </form>

        <form id="dlt" style="display:none" method="post" action="">
            <div class="w3-responsive w3-card-4 w3-margin-top" style="width:25%">
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th class="w3-theme">
                            <div align="center">
                                ID Number
                            </div>
                        </th>
                        <th class="w3-theme"></th>
                    </tr>
                    <tr>
                        <td>
                            <div align="center">
                                <input class="w3-input w3-center" name='motID' type="text" required >
                            </div>
                        </td>

                        <td>
                            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Download">
                        </td>

                    </tr>
                </table>
            </div>
        </form>

        <h4>MOT history:</h4>

        <div class="w3-responsive w3-card-4 w3-margin-top" style="width:50%">
            <table class="w3-table w3-striped w3-bordered">
                <!-- column headers -->

                <!-- column data -->

            </table>
        </div>
        <br>

    </div>
</div>

<script src="../../assets/js/sectionControl.js"></script>

<?php
include_once ("../components/footer.php");
?>
