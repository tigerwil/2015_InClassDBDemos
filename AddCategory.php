<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Category</title>
    </head>
    <body>
        <h1>Add Category</h1>
        <?php
        // Handle post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);
            
            //check if the category has been entered
            if (!empty($_POST['category'])){
                //good to go
                // require the site configuration file
                require 'includes/config.php';
                //require the database connection
                require MYSQL;
                
                $category = trim(filter_var(mysqli_real_escape_string($dbc,$_POST['category']),FILTER_SANITIZE_STRING));  
                
                //1. Check for duplicate category name
                $q = "SELECT COUNT(*) FROM categories WHERE category= '$category'";
                $r = mysqli_query($dbc,$q);
                $row = mysqli_fetch_array($r, MYSQLI_NUM);
                $cnt = $row[0];  //total count returned
                
                if ($cnt>=1){                    
                    //duplicate category
                    $error = "That category already exists!";
                }else{
                    //Not a duplicate - OK to insert new category
                    //Build our insert stmt using a prepared statement
                    //Page 425 in book 
                    //This will prevent SQL Injection 
                    $q = "INSERT INTO categories (category) VALUE(?)";
                    $stmt = mysqli_prepare($dbc, $q);
                    //bind the parameter
                    mysqli_stmt_bind_param($stmt, 's', $category);
                    //execute the prepared statement
                    mysqli_stmt_execute($stmt);                    
                    //get rows affected
                    $count = mysqli_stmt_affected_rows($stmt);
                    //close the statement
                    mysqli_stmt_close($stmt);
                    
                    //Check if successful
                    if ($count>0){
                        //success
                        echo "<p>Category successfully added!</p>";
                    }else{
                        //fail
                        echo "<p>Error adding Category!</p>";
                    }                   
                }            
            }else{
                //display message - need category name
                echo "<p>Category Name is required!</p>";
                
            }
        }//End of form submission
        
        
        if (isset($error)){
            echo "<h2>Error!</h2>
                  <p style='color:red;font-weight:bold'>$error <br> Please try again!</p>";
        }
        
        ?>
        
        <form action="AddCategory.php" method="post">
            <input type="text" name="category" id="category"
                   placeholder="Enter category name"
                   autofocus="true" required
                   value="<?php if (isset($_POST['category']))echo $_POST['category'];?>">
            <button type="submit">Add Category</button>
        </form>
        <a href="categories.php">Cancel</a>
    </body>
</html>
