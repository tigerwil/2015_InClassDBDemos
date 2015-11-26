<!DOCTYPE html>
<html>
    <head>
        <meta charset="windows-1252">
        <title>List of Categories</title>
    </head>
    <body>
        <?php
        // require the site configuration file
        require 'includes/config.php';        
        //require the database connection
        require MYSQL;
        
        /* 2 ways to bring in external script into existing
         * scripts:
         * 1- include
         * 2 -require
         * 
         * Note:  Each have the *_once as well
         * include_once
         * require_once
         * 
         * Differences b/w include and require
         * 
         * Failure to include a file results in a warning and the script continues
         * Failure to require a file results in a fatal error and script is halted
         * 
         * Typically require files that are critical to the site's functionality
         * like database connections, configuration files, etc
         * 
         * Typically include files like html header, footer, sidebar, etc
         * 

         */
        
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
        if($cnt>0){
            //we have rows
            $output = "<ul>";
            
            //loop the rows
            while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)){
                //MYSQLI_ASSOC:  use the column names from resultset
                //$row['id']
                //$row['category']
                
                //MYSQLI_NUM:  use the column index from resultset
                //$row[0]
                //$row[1]    
                
                //MYSQLI_BOTH:  use the column index as well as column name
                $output.="<li>".$row['id']. " - ". $row['category']."</li>";
                
            }
            $output.="</ul>";
            
            //display final output
            echo $output;
            
            //optionally we can free the result
            mysqli_free_result($r);
        }else{
            //no rows
            echo "<p style='color:red;font-weight:bold'>No rows returned!</p>";
        }

        ?>
    </body>
</html>
