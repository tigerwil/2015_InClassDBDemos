<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Category</title>
    </head>
    <body>
        <h1>Delete Category</h1>
        <?php
        //Check for a valid parameter called id from GET coming from the categories.php
        //edit hyperlink

        if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
            //GET
            //we have our parameter store in variable
            $id = $_GET['id'];
        } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
            //POST - AFTER SUBMIT FOR DELETE CATEGORY
            $id = $_POST['id'];
        } else {
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            //var_dump($_POST);
            //exit();
            if ($_POST['sure']=='Yes'){//delete the record
                //Build the DELETE query
                $q = "DELETE FROM categories WHERE id=$id LIMIT 1";
                //Run the DELETE 
                $r = mysqli_query($dbc, $q);

                if (mysqli_affected_rows($dbc) === 1) {
                    //ok - print message
                    echo "<p>The category has been deleted!</p>";
                } else {
                    //error - no row updated
                    echo "<p>The category was not deleted due to a system error!</p>";
                    echo "<p>" . mysqli_error($dbc) . "</p>";
                }                
            }else{//do not delete the record
                echo "<p>The category has not been deleted!</p>";
            }
                       

            //=================== END PROCESS POST ========================
            
        }else{//show the form     
        
        //Retrieve the specified category
        $q = "SELECT category FROM categories WHERE id=$id";

        $r = mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) == 1) {

                //Get the row 
                $row = mysqli_fetch_array($r, MYSQLI_NUM);
                
                //Display the selected category to be deleted to the user
                echo "<h3>Category:  $row[0]</h3>";

                //Build the form 
                echo "<form action=\"DeleteCategory.php\" method=\"post\"> 
                        <input type='radio' name='sure' value='Yes'> Yes
                        <input type='radio' name='sure' value='No' checked='checked'> No
                        <input type='hidden' name='id' id='id' value='$id'>
                        <button type='submit'>Delete Category</button>
                     </form>";
            } else {
                //The id value does not exist in category table
                echo '<p>That is not a valid category!</p>';
            }
        }
        ?>
        <a href="categories.php">Cancel</a>
    </body>
</html>
