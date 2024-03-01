<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';

    if (isset($_SESSION['Username'])) {
        header('Location: dashboard.php'); // Redirect To Dashboard Page
    }

    include 'init.php'; 

    // Check if user coming from HTTP post request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        // Check if the user exists in the DB
        $stmt = $con->prepare("SELECT 
                                    adminid, Username, Password
                                FROM 
                                    admin 
                                WHERE 
                                    Username = ? 
                                    AND 
                                    Password = ? 
                                   
                                LIMIT 1");
                                
       // Hash the password when storing in the database
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Check the hashed password when verifying login credentials
$stmt->execute(array($username, $password));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        // if count > 0, this means the DB contains a record for this Username
        if ($count > 0) {
            $_SESSION['Username'] = $username; // Register Session name
            $_SESSION['ID'] = $row['adminid']; // Register Session name
            
            header('Location: dashboard.php');  // Redirect to Dashboard page
            exit();
        }
    }
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <input class="btn btn-primary btn-block" type="submit" value="Login"/>
</form>

<?php include $tpl . 'footer.php'; ?>
