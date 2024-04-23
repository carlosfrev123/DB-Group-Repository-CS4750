<?php

require 'connect-db.php'; 
if (isset($_GET['size']) && isset($_GET['Name'])) {
    $size = $_GET['size'];
    $name = $_GET['Name'];

    // Call function to get price
    $result = updatePrice($size, $name);
    echo htmlspecialchars($result['Price']); // Price output
}
// get Products query
function getAvailableProducts($db) {
    global $db;
    $query = "SELECT product_ID, Name, Price, size FROM Product WHERE stock > 0 GROUP BY Name";
    
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function updatePrice($displayedSize, $displayedName) {
    global $db;
    $query = "SELECT Price FROM Product WHERE Name = :displayedName AND size = :displayedSize";

    $statement = $db->prepare($query);
    $statement->bindValue(':displayedName', $displayedName);
    $statement->bindValue(':displayedSize', $displayedSize);
    $statement->execute();
    $result = $statement->fetch();  
    $statement->closeCursor();  

    return $result;
}


function getUserId($email){
    global $db;
    $query = "SELECT user_ID FROM UserInfo WHERE email = :email";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    return $result['user_ID'];   
}


// function addToCart($productName, $userID, $quantity){
//     global $db
    
// }
?>