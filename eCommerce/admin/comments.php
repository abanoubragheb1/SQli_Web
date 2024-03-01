<?php

	/*
	================================================
	== Manage Comments Page
	== You Can Edit | Delete | Approve Comments From Here
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();
    $pageTitle='comments';
    
    if(isset($_SESSION['Username'])){
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        //Start Manage Page 
        if ($do == 'Manage') { // Manage Members Page
            
            
			

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT comments.* , items.Name , users.Username
			                      FROM comments
								  INNER JOIN
								  items
								  ON
								  items.Item_ID = comments.item_id
								  INNER JOIN
								  users
								  ON
								  users.UserID = comments.user_id
                                  ORDER BY c_id DESC ");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();

			if (! empty($rows)) {

			?>

		 <?php include 'comm_Manage.html';?>
						<?php
                      
							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['c_id'] . "</td>";
									echo "<td>" . $row['comment'] . "</td>";
									echo "<td>" . $row['item_id'] . "</td>";
									echo "<td>" . $row['user_id'] . "</td>";
									echo "<td>" . $row['comment_date'] ."</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
										// يعني لو الشغص مش مفعل هيظهلي زرار التفعيل 
                                        if ($row['status'] == 0) {
											echo "<a 
													href='comments.php?do=Activate&comid=" . $row['c_id'] . "' 
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
				
			</div>

        <?php 
    }
                        else {
                            echo '<div class="container">';
                            echo '<div class="nice-message">There\'s Comments To Show</div>';
                            
                        echo '</div>'; }?>

		<?php
       
        }

        elseif($do == 'Edit')//Edit Page
        {  
            //Check if Get Request userid is Numeric &Get the Integer Value of It
            //  Check for Prevent from SQL
            // && is_numeric($_GET['userid']) and intval لو شيلتهم كده اقدر اكتب اي حاجه ف ال url
            $comid = isset($_GET['comid']) && is_numeric( $_GET['comid']) ? intval($_GET['comid']) : 0 ;
            // Select All Data Depend On this ID
            $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? ");
            // Execute Query
            $stmt->execute(array($comid));
            // Fatch The Data
            $row=$stmt->fetch();
            // the Row Count
            $count = $stmt->rowCount();
            // if there is such ID Show the form
            // يعني لو في اي دي اكبر من صفر هيظهرلي الفورم
            if ($count > 0) { ?>

				<?php include 'comm_Edit.html'; ?>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";
				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';
                // شيلت الباك من هنا علشان يرجعه ع صفحه الهوم ع طول لانه جاي من ال url
				redirectHome($theMsg);

				echo "</div>";

			}

        }

        elseif($do == 'Update')// Update Page
        {
            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";
            // يعني لو اليوزر جايلي عن طريق الريكويست ميثود هدخله ع طول غير كده روح ع ايلس
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Get Variables from the form
                
                $comid     = $_POST['comid'];
                $comment   = $_POST['comment'];
               


                    // Update the DB with the info
                    $stmt=$con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
                    $stmt->execute(array($comment,$comid));
                    // Echo Success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
                    
                    redirectHome($theMsg, 'back');
                    

                

            } else {

                $theMsg = '<div class="alert alert-danger">Sorry You cant Browse this page Directly </div>';
                redirectHome($theMsg);
            }
            echo "</div>";


        }
        
        elseif($do == 'Delete')//Delete memeber page
        {
            echo "<h1 class='text-center'>Delete Comment</h1>";
            echo "<div class='container'>";

                //Check if Get Request userid is Numeric &Get the Integer Value of It
                //  Check for Prevent from SQL
                // && is_numeric($_GET['userid']) and intval لو شيلتهم كده اقدر اكتب اي حاجه ف ال url
                $comid = isset($_GET['comid']) && is_numeric( $_GET['comid']) ? intval($_GET['comid']) : 0 ;
                
                // Select All Data Depend On this ID
                $check = checkItem('c_id' , 'comments', $comid);
                
                // if there is such ID Show the form
                // يعني لو في اي دي اكبر من صفر هيظهرلي الفورم
                if ( $check > 0)
                {
                    $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");
                    // ربط اليوزر الجاي ب ال zuser
                    $stmt->bindParam(":zid", $comid);
                    $stmt->execute();
                    
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
                    redirectHome($theMsg , 'back');
                }
                else
                {
                    $theMsg = '<div class="alert alert-danger"> This ID is not Exist </div>';
                    redirectHome($theMsg);
                }
            echo '</div>';
        }

        elseif($do == 'Activate')
        {
            echo "<h1 class='text-center'>Approve Comment</h1>";
            echo "<div class='container'>";

                //Check if Get Request userid is Numeric &Get the Integer Value of It
                //  Check for Prevent from SQL
                // && is_numeric($_GET['userid']) and intval لو شيلتهم كده اقدر اكتب اي حاجه ف ال url
                $comid = isset($_GET['comid']) && is_numeric( $_GET['comid']) ? intval($_GET['comid']) : 0 ;
                
                // Select All Data Depend On this ID
                $check = checkItem('c_id' , 'comments', $comid);
                
                // if there is such ID Show the form
                // يعني لو في اي دي اكبر من صفر هيظهرلي الفورم
                if ( $check > 0)
                {
                    // هنا بغيرحاله التفعيل من 0 ل 1 علشان يكون مفعل
                    $stmt=$con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

                    $stmt->execute(array($comid));
                    
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approve</div>';
                    redirectHome($theMsg);
                }
                else
                {
                    $theMsg = '<div class="alert alert-danger"> This ID is not Exist </div>';
                    redirectHome($theMsg ,'back');
                }
            echo '</div>';
        
        
        
        }


        include $tpl . 'footer.php'; }
    
    else
    {
        header('Location: index.php');
        exit();
    }

?>
 