<?php

    /*
    ================================================
    == Category Page
    ================================================
    */

    ob_start(); // Output Buffering Start

    session_start();

    $pageTitle = 'Categories';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {

            $sort = 'asc';

            $sort_array = array('asc', 'desc');

            if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

                $sort = $_GET['sort'];

            }

            $stmt2 = $con->prepare("SELECT * FROM categories  ORDER BY Ordering $sort");

            $stmt2->execute();

            $cats = $stmt2->fetchAll(); 

            if (! empty($cats)) {

            ?>

            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i> Manage Categories
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i> Ordering: [
                            <a class="<?php if ($sort == 'asc') { echo 'active'; } ?>" href="?sort=asc">Asc</a> | 
                            <a class="<?php if ($sort == 'desc') { echo 'active'; } ?>" href="?sort=desc">Desc</a> ]
                            <!-- <i class="fa fa-eye"></i> View: [
                            <span class="active" data-view="full">Full</span> |
                            <span data-view="classic">Classic</span> ] -->
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            foreach($cats as $cat) {
                                echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                        echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
                                    echo "</div>";
                                    echo "<h3>" . $cat['Name'] . '</h3>';
                                    echo "<div class='full-view'>";
                                        echo "<p>"; if($cat['Description'] == '') { echo 'This category has no description'; } else { echo $cat['Description']; } echo "</p>";
                                       
                                    echo "</div>";

                                  

                                echo "</div>";
                                echo "<hr>";
                            }
                        ?>
                    </div>
                </div>
                <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
            </div>

            <?php } else {

                echo '<div class="container">';
                    echo '<div class="nice-message">There\'s No Categories To Show</div>';
                    echo '<a href="categories.php?do=Add" class="btn btn-primary">
                            <i class="fa fa-plus"></i> New Category
                        </a>';
                echo '</div>';

            } ?>

            <?php

        } 
        elseif ($do == 'Add') { 
                include 'Cat_Add.html';
        } 
        
        elseif ($do == 'Insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo "<h1 class='text-center'>Insert Category</h1>";
                echo "<div class='container'>";

                // Get Variables From The Form

                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                // $parent     = $_POST['parent'];
                $order      = $_POST['ordering'];
               

                // Check If Category Exist in Database

                $check = checkItem("Name", "categories", $name);

                if ($check == 1) {

                    $theMsg = '<div class="alert alert-danger">Sorry This Category Is Exist</div>';

                    redirectHome($theMsg, 'back');

                } else {

                    // Insert Category Info In Database

                    $stmt = $con->prepare("INSERT INTO 

                        categories(Name, Description, Ordering)

                    VALUES(:zname, :zdesc, :zorder)");

                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdesc'     => $desc,
                        // 'zparent'   => $parent,
                        'zorder'    => $order,
                        
                    ));

                    // Echo Success Message

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

                    redirectHome($theMsg, 'back');

                }

            } else {

                echo "<div class='container'>";

                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

                redirectHome($theMsg, 'back');

                echo "</div>";

            }

            echo "</div>";

        } elseif ($do == 'Edit') {

            // Check If Get Request catid Is Numeric & Get Its Integer Value

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

            // Execute Query

            $stmt->execute(array($catid));

            // Fetch The Data

            $cat = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            // If There's Such ID Show The Form

            if ($count > 0) { ?>

               <?php include 'Cat_Edit.html'; ?>

            <?php

            // If There's No Such ID Show Error Message

            } else {

                echo "<div class='container'>";

                $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

                redirectHome($theMsg);

                echo "</div>";

            }

        } elseif ($do == 'Update') {

            echo "<h1 class='text-center'>Update Category</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variables From The Form

                $id         = $_POST['catid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering'];
               

               

                // Update The Database With This Info

                $stmt = $con->prepare("UPDATE 
                                            categories 
                                        SET 
                                            Name = ?, 
                                            Description = ?, 
                                            Ordering = ?, 
                                            
                                           
                                        WHERE 
                                            ID = ?");

                $stmt->execute(array($name, $desc, $order, $parent, $id));

                // Echo Success Message

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

                redirectHome($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

                redirectHome($theMsg);

            }

            echo "</div>";

        } elseif ($do == 'Delete') {

            echo "<h1 class='text-center'>Delete Category</h1>";
            echo "<div class='container'>";

                // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                // Select All Data Depend On This ID

                $check = checkItem('ID', 'categories', $catid);

                // If There's Such ID Show The Form

                if ($check > 0) {

                    $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

                    $stmt->bindParam(":zid", $catid);

                    $stmt->execute();

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

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