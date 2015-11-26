<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Category</title>
    </head>
    <body>
        <h1>Edit Category</h1>
        <?php
        //test
        //var_dump($_GET);
        
        //Check for a valid parameter called id from GET coming from the categories.php
        //edit hyperlink
        
        if(  (isset($_GET['id']))  && (is_numeric($_GET['id']))   ){
            //GET
            //we have our parameter store in variable
            $id = $_GET['id'];
            //echo "<h3>Editing Record:  $id</h3>";
        }elseif( (isset($_POST['id']))  && (is_numeric($_POST['id'])) ){
            //POST - AFTER SUBMIT FOR UPDATE CATEGORY
            $id = $_POST['id'];
            //echo "success";
            //var_dump($_POST);
        }else{
            //parameter does not exist kill the script
            echo '<h3>This page has been accessed in error!</h3>';
            exit();
        }
        
        //good to go
        // require the site configuration file
        require 'includes/config.php';
        //require the database connection
        require MYSQL;
        
        //===================== PROCESS POST ==========================
        //Check if there has been a form submission
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            
          $category = trim(filter_var(mysqli_real_escape_string($dbc,$_POST['category']),FILTER_SANITIZE_STRING));  
        
          //Build the update query
          $q = "UPDATE categories SET category='$category' WHERE id=$id LIMIT 1";
          //Run the update 
          $r=  mysqli_query($dbc, $q);
          //Test if it ran ok
          /*mysqli_affected_rows:
           *returns: 
           * An integer greater than zero indicates the number of rows affected 
           * Zero indicates that no records were updated for an UPDATE statement
           * -1 indicates that the query returned an error.
           * 
           * 
           */
          if(mysqli_affected_rows($dbc)===1){         
              //ok - print message
              echo "<p>The category has been updated!</p>";
          }elseif(mysqli_affected_rows ($dbc) === 0){// use three equal signs so there is no confusion with a false return
              //no rows updated (value unchanged)
              echo "<p>The category unchanged because it was the same as on record!</p>";
          }else{
              //error - no row updated
              echo "<p>The category was not updated due to a system error!</p>";
              echo "<p>". mysqli_error($dbc)."</p>";
          }
          
        }            
        
        //=================== END PROCESS POST ========================
        //Always show the form
       
        //Retrieve the specified category
        $q = "SELECT category FROM categories WHERE id=$id";
        
        $r = mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r)==1){
            
            //Get the row 
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            
            //valid ID - populate HTML FORM with info 
            echo "<form action=\"EditCategory.php\" method=\"post\"> 
                    Category Name:
                    <input type='text' name='category' id='category' 
                           autofocus='true' value='{$row[0]}'>
                    <input type='hidden' name='id' id='id' value='$id'>
                    <button type='submit'>Edit Category</button>
                 </form>";
        }else{
            //The id value does not exist in category table
            echo '<p>That is not a valid category!</p>';
        }   
        
        
        
        
        
        ?>
        
        <a href="categories.php">Cancel</a>
    </body>
</html>
