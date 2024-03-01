<?php

// functions.php

function getAllCategoryItems($categoryID) {
    global $con; // Assuming $con is your database connection

    $stmt = $con->prepare("
        SELECT items.*
        FROM items
        JOIN categories ON items.Cat_ID = categories.ID
        WHERE categories.ID = ? OR categories.parent = ?
        AND items.Approve = 1
    ");
    $stmt->execute([$categoryID, $categoryID]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



/*
    ** Get All Function v2.0
    ** Function To Get All Records From Any Database Table
    */

    function getAllFrom($field, $table, $where = NULL, $and = NULL, $ordering = "DESC") {

        global $con;

        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY  $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;

    }



/*
    Get  items Functions v1.0
    function to get ad items from DB */
    

function getItems($where ,$value , $approve =NULL){
    global $con;
    
        $sql = $approve == NULL ? 'AND Approve = 1' :'';
    

    $getItems = $con->prepare("SELECT * FROM items WHERE $where =? $sql ORDER BY Item_ID DESC ");
    $getItems->execute(array($value));
    $items =  $getItems->fetchAll();
    return $items;

}
/*check if user is not active 
function to check the regstatus of user */
function checkUserStatus($user){
    global $con;
     
     $stmtx = $con->prepare("SELECT 
     Username , RegStatus
FROM 
    users 
WHERE 
    Username = ? 
AND 
RegStatus = 0 ");

$stmtx->execute(array($user));

$status = $stmtx->rowCount();
return $status ;
}

/*
Title Function That echo page title in case page
has the variable $pageTitle and echo defult title other pages
*/

function getTitle() {

    global $pageTitle;

    if (isset($pageTitle)) {

        echo $pageTitle;

    } else {

        echo 'Default';

    }
}

/*
    Home Redirect Function V1.0 
    This Function Accept Parameters
    $theMsg = echo the message [Error | Success | Warning] 
    $url = Link You Want to redirect to 
    $seconds = secondes before redirection
*/ 
function redirectHome($theMsg , $url = null, $seconds = 3) {
    if($url === null){
        $url = 'index.php';
        $link = 'Homepage';
    } 
    else { 

        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
            // الصفحه اللي انا جاي منها 
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previoud Page';
        } else{
            $url = 'index.php';
            $link = 'Homepage';
        }
        
    }

    echo $theMsg;
    echo "<div class='alert alert-info'> You Will Be Redirected to $link After $seconds Secondes. </div>";
    header("refresh:$seconds;url=$url");
    exit();
}


/*
    Function to check item in DB
    $select = the item to select [ex: user, item, category]
    $from = the table to select from [ex: users, items, categories] 
    $value = the valuse of select [ex: Abanoub , box , electroincs]
*/ 
function checkItem($select , $from , $value){
    global $con;

    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;

}



/*
    Count Number of Items function v1.0
    Function to count number of items rows
    $item = the item to count
    $table = the table to choose from
*/
function countItems($item , $table){
    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table ");
    $stmt2->execute();
    return $stmt2->fetchColumn();

}


/*
    Get Latest Records Functions v1.0
    function to get latest items from DB [users, items , comments]
    $select = Field to Select
    $table = the table to choose from
    $order the Desc Order
    $limit = numbers of record to Get
*/
function getLatest($select , $table , $order ,$limit=5){
    global $con;

    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows =  $getStmt->fetchAll();
    return $rows;

}
