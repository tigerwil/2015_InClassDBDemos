<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>table of categories</title>
    </head>
    <body>
        <?php
        // require the site configuration file
        require 'includes/config.php';
        //require the database connection
        require MYSQL;

        //1.  Build the sql query
        $q = "SELECT id, category FROM categories ORDER BY id";

        //2.  Execute the query
        $r = mysqli_query($dbc, $q); //$dbc is the db connection
        //$q is the query to execute       
        //3.  Check the number of rows returned by query
        $cnt = mysqli_num_rows($r);

        //4.  Display the number of rows
        echo "<h2>Total Categories: $cnt</h2>";

        //5.  Display the records in a unordered list
        if ($cnt > 0) {
            //we have rows
            $output = "<table border='1'>
                          <tr>
                                <th>ID</th>
                                <th>Category</th>
                          </tr>";

            //loop the rows
            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
               $output.="<tr><td>" . $row['id'] . "</td><td>" . $row['category'] . "</td></tr>";
            }
            $output.="</table>";

            //display final output
            echo $output;

            //optionally we can free the result
            mysqli_free_result($r);
        } else {
            //no rows
            echo "<p style='color:red;font-weight:bold'>No rows returned!</p>";
        }
        ?>
    </body>
</html>