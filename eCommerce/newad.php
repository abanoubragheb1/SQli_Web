<?php
	ob_start();
	session_start();
	$pageTitle = 'Create New Item';
	include 'init.php';
	if (isset($_SESSION['user'])) {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$formErrors = array();
			error_reporting(E_ALL & ~E_DEPRECATED);
             ini_set('display_errors', 1);
$name     =  'name';
$desc     =  'description';
$price    = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
$country  = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
$status   = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
$tags     = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);
$name     = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$desc     = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$avatar = $_FILES['avatar'];
$avatarName = $avatar['name'];
$avatarTmp = $avatar['tmp_name'];
$avatarSize = $avatar['size'];
$avatarError = $avatar['error'];

			if (strlen($name) < 4) {

				$formErrors[] = 'Item Title Must Be At Least 4 Characters';

			}

			if (strlen($desc) < 10) {

				$formErrors[] = 'Item Description Must Be At Least 10 Characters';

			}

			if (strlen($country) < 2) {

				$formErrors[] = 'Item Title Must Be At Least 2 Characters';

			}

			if (empty($price)) {

				$formErrors[] = 'Item Price Cant Be Empty';

			}

			if (empty($status)) {

				$formErrors[] = 'Item Status Cant Be Empty';

			}

			if (empty($category)) {

				$formErrors[] = 'Item Category Cant Be Empty';

			}
			if ($avatarError === 0) {
    $avatarExtension = strtolower(pathinfo($avatarName, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    
    if (in_array($avatarExtension, $allowedExtensions)) {
      $avatarDestination = 'uploads/avatars/' . $avatarName;
        move_uploaded_file($avatarTmp, $avatarDestination);
    } else {
        $formErrors[] = 'Invalid file extension. Allowed extensions are: ' . implode(', ', $allowedExtensions);
    }
} else {
    $formErrors[] = 'Error uploading the avatar: ' . $avatarError;
}

			// Check If There's No Error Proceed The Update Operation

			if (empty($formErrors)) {

				// Insert Userinfo In Database

				$stmt = $con->prepare("INSERT INTO 

					items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags , avatar)

					VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags,:zavatar)");

				$stmt->execute(array(

					'zname' 	=> $name,
					'zdesc' 	=> $desc,
					'zprice' 	=> $price,
					'zcountry' 	=> $country,
					'zstatus' 	=> $status,
					'zcat'		=> $category,
					'zmember'	=> $_SESSION['uid'],
					'ztags'		=> $tags,
					'zavatar'   => $avatarName

				));

				// Echo Success Message

				if ($stmt) {

					$succesMsg = 'Item Has Been Added';
					
				}

			}

		}

?>
<h1 class="text-center"><?php echo $pageTitle ?></h1>
<?php include 'newad.html';?>
                    <!-- Start Loopiong Through Errors -->

				<?php 
					if (! empty($formErrors)) {
						foreach ($formErrors as $error) {
							echo '<div class="alert alert-danger">' . $error . '</div>';
						}
					}
					if (isset($succesMsg)) {
						echo '<div class="alert alert-success">' . $succesMsg . '</div>';
					}
				?>
				<!-- End Loopiong Through Errors -->
			</div>
		</div>
	</div>
</div>
<?php
	} else {
		header('Location: login.php');
		exit();
	}
	include $tpl . 'footer.php';
	ob_end_flush();
?>

