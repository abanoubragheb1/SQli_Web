<?php

    /*
    ================================================
    == Items Page
    ================================================
    */

    ob_start(); // Output Buffering Start

    session_start();

    $pageTitle = 'Items';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {


            $stmt = $con->prepare("SELECT 
                                        items.*, 
                                        categories.Name AS category_name, 
                                        users.Username 
                                    FROM 
                                        items
                                    INNER JOIN 
                                        categories 
                                    ON 
                                        categories.ID = items.Cat_ID 
                                    INNER JOIN 
                                        users 
                                    ON 
                                        users.UserID = items.Member_ID
                                    ORDER BY 
                                        Item_ID DESC");

            // Execute The Statement

            $stmt->execute();

            // Assign To Variable 

            $items = $stmt->fetchAll();

            if (! empty($items)) {

            ?>

            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table  manage-members text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Avatar</td>
                            <td>Item Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Username</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($items as $item) {
                                echo "<tr>";
                                    echo "<td>" . $item['Item_ID'] . "</td>";
                                    echo "<td>";
                                    if (empty($item['avatar'])) {
                                        echo 'No Image';
                                    } else {
                                        echo "<img src='uploads/avatars/" . $item['avatar'] . "' alt='' />";
                                    }
                                    echo "</td>";
                                    echo "<td>" . $item['Name'] . "</td>";
                                    echo "<td>" . $item['Description'] . "</td>";
                                    echo "<td>" . $item['Price'] . "</td>";
                                    echo "<td>" . $item['Add_Date'] ."</td>";
                                    echo "<td>" . $item['category_name'] ."</td>";
                                    echo "<td>" . $item['Username'] ."</td>";
                                    echo "<td>
                                        <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                        if ($item['Approve'] == 0) {
                                            echo "<a 
                                                    href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                                    class='btn btn-info activate'>
                                                    <i class='fa fa-check'></i> Approve</a>";
                                        }
                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                        <tr>
                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> New Item
                </a>
            </div>

            <?php } else {

                echo '<div class="container">';
                    echo '<div class="nice-message">There\'s No Items To Show</div>';
                    echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> New Item
                        </a>';
                echo '</div>';

            } ?>

        <?php 

        } elseif ($do == 'Add') { ?>

            <?php include 'item_Add.html'; ?>

            <?php

        } elseif ($do == 'Insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo "<h1 class='text-center'>Insert Item</h1>";
                echo "<div class='container'>";
                // Upload Variables

                $avatarName = $_FILES['avatar']['name'];
                $avatarSize = $_FILES['avatar']['size'];
                $avatarTmp  = $_FILES['avatar']['tmp_name'];
                $avatarType = $_FILES['avatar']['type'];

                // List Of Allowed File Typed To Upload

                $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                // Get Avatar Extension

                $avatarExtension = strtolower(end(explode('.', $avatarName)));


                // Get Variables From The Form

                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $member     = $_POST['member'];
                $cat        = $_POST['category'];
                $tags       = $_POST['tags'];

                

                // Validate The Form

                $formErrors = array();

                if (empty($name)) {
                    $formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
                }

                if (empty($desc)) {
                    $formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
                }

                if (empty($price)) {
                    $formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
                }

                if (empty($country)) {
                    $formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
                }

                if ($status == 0) {
                    $formErrors[] = 'You Must Choose the <strong>Status</strong>';
                }

                if ($member == 0) {
                    $formErrors[] = 'You Must Choose the <strong>Member</strong>';
                }

                if ($cat == 0) {
                    $formErrors[] = 'You Must Choose the <strong>Category</strong>';
                }
                 if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
                    $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
                }

                if (empty($avatarName)) {
                    $formErrors[] = 'Avatar Is <strong>Required</strong>';
                }

                if ($avatarSize > 4194304) {
                    $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                }

                // Loop Into Errors Array And Echo It

                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check If There's No Error Proceed The Update Operation

                if (empty($formErrors)) {
                     $avatar = rand(0, 10000000000) . '_' . $avatarName;

                    move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
                    $avatarDestination = "uploads/avatars/" . $avatar;
                     move_uploaded_file($avatarTmp, $avatarDestination);

                    // Insert Userinfo In Database

                    $stmt = $con->prepare("INSERT INTO 

                        items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags ,avatar)

                        VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags , :zavatar)");

                    $stmt->execute(array(

                        'zname'     => $name,
                        'zdesc'     => $desc,
                        'zprice'    => $price,
                        'zcountry'  => $country,
                        'zstatus'   => $status,
                        'zcat'      => $cat,
                        'zmember'   => $member,
                        'ztags'     => $tags,
                        'zavatar'   => $avatar

                    ));

                    // Echo Success Message

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

                    redirectHome($theMsg, 'back');

                }

            } else {

                echo "<div class='container'>";

                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

                redirectHome($theMsg);

                echo "</div>";

            }

            echo "</div>";

        } elseif ($do == 'Edit') {

            // Check If Get Request item Is Numeric & Get Its Integer Value

            // Check If Get Request item Is Numeric & Get Its Integer Value

            

            $itemid = $_GET['itemid'];

            // Select All Data Depend On This ID

            $sql = "SELECT * FROM items WHERE Item_ID = $itemid";

            // Execute Query

           // Execute the query
            $stmt = $con->query($sql);

            // Fetch the data
            $item = $stmt->fetch();

            $count = $stmt->rowCount();

            // If There's Such ID Show The Form

            if ($count > 0) { ?>

                <?php include 'item_Edit.html'; ?>

                    <?php

                    // Select All Users Except Admin 

                    $stmt = $con->prepare("SELECT 
                                                comments.*, users.Username AS Member  
                                            FROM 
                                                comments
                                            INNER JOIN 
                                                users 
                                            ON 
                                                users.UserID = comments.user_id
                                            WHERE item_id = ?");

                    // Execute The Statement

                    $stmt->execute(array($itemid));

                    // Assign To Variable 

                    $rows = $stmt->fetchAll();

                    if (! empty($rows)) {
                        
                    ?>
                    <h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>
                            </tr>
                            <?php
                                foreach($rows as $row) {
                                    echo "<tr>";
                                        echo "<td>" . $row['comment'] . "</td>";
                                        echo "<td>" . $row['Member'] . "</td>";
                                        echo "<td>" . $row['comment_date'] ."</td>";
                                        echo "<td>
                                            <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                            <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                            if ($row['status'] == 0) {
                                                echo "<a href='comments.php?do=Approve&comid="
                                                         . $row['c_id'] . "' 
                                                        class='btn btn-info activate'>
                                                        <i class='fa fa-check'></i> Approve</a>";
                                            }
                                        echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                            <tr>
                        </table>
                    </div>
                    <?php } ?>
                </div>

            <?php

            // If There's No Such ID Show Error Message

            } else {

                echo "<div class='container'>";

                $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

                redirectHome($theMsg);

                echo "</div>";

            }           

        } elseif ($do == 'Update') {

            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variables From The Form

                $id         = $_POST['itemid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $cat        = $_POST['category'];
                $member     = $_POST['member'];
                $tags       = $_POST['tags'];

                // Validate The Form

                $formErrors = array();

                if (empty($name)) {
                    $formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
                }

                if (empty($desc)) {
                    $formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
                }

                if (empty($price)) {
                    $formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
                }

                if (empty($country)) {
                    $formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
                }

                if ($status == 0) {
                    $formErrors[] = 'You Must Choose the <strong>Status</strong>';
                }

                if ($member == 0) {
                    $formErrors[] = 'You Must Choose the <strong>Member</strong>';
                }

                if ($cat == 0) {
                    $formErrors[] = 'You Must Choose the <strong>Category</strong>';
                }

                // Loop Into Errors Array And Echo It

                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check If There's No Error Proceed The Update Operation

                if (empty($formErrors)) {

                    // Update The Database With This Info

                    $stmt = $con->prepare("UPDATE 
                                                items 
                                            SET 
                                                Name = ?, 
                                                Description = ?, 
                                                Price = ?, 
                                                Country_Made = ?,
                                                Status = ?,
                                                Cat_ID = ?,
                                                Member_ID = ?,
                                                tags = ?
                                            WHERE 
                                                Item_ID = ?");

                    $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));

                    // Echo Success Message

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

                    redirectHome($theMsg, 'back');

                }

            } else {

                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

                redirectHome($theMsg);

            }

            echo "</div>";

        } elseif ($do == 'Delete') {

            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";

                // Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                // Select All Data Depend On This ID

                $check = checkItem('Item_ID', 'items', $itemid);

                // If There's Such ID Show The Form

                if ($check > 0) {

                    $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

                    $stmt->bindParam(":zid", $itemid);

                    $stmt->execute();

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

                    redirectHome($theMsg, 'back');

                } else {

                    $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

                    redirectHome($theMsg);

                }

            echo '</div>';

        } elseif ($do == 'Approve') {

            echo "<h1 class='text-center'>Approve Item</h1>";
            echo "<div class='container'>";

                // Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                // Select All Data Depend On This ID

                $check = checkItem('Item_ID', 'items', $itemid);

                // If There's Such ID Show The Form

                if ($check > 0) {

                    $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                    $stmt->execute(array($itemid));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

                    redirectHome($theMsg, 'back');

                } else {

                    $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

                    redirectHome($theMsg);

                }

            echo '</div>';

        }

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();
    }

    ob_end_flush(); // Release The Output

?>