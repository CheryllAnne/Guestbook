<?php
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns = "http://www.w3.org/1999/xhtml"   >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> GuestBook </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>

<?php

//"http://www.w3.org/TR/xhtmll/DTD/xht"
    //connect to db
    $conn = mysqli_connect("localhost:3306", "root", "root") or die(mysqli_error($conn));
    mysqli_select_db($conn, "guestbook") or die(mysqli_error($conn));

    /**********************/
    // form and add stuff


    echo "<h2> Hey! Drop A word or Two! </h2>";

    //check if Update btn has been pressed

                                    // updatebtn was an unset value - runtime error
    if (isset($_POST['updatebtn'])) //isset= test for the existence of a variable or array element without actually trying to access it
    {
        $name = strip_tags($_POST['name']); //striptags to avoid cross site scripting
        $email = strip_tags($_POST['email']);
        $comment = strip_tags($_POST['comment']);

        if($name && $email && $comment){

            date_default_timezone_set('Asia/Kuala_Lumpur');
            $time = date("h:i:s A");
            $date = date("F d,Y");


            //add to the db ( guestbook )
            mysqli_query($conn,"INSERT INTO guestList (name, email, comment, time, date) VALUES 
            ('$name', '$email', '$comment', '$time', '$date'
            )") or die(mysqli_error($conn)) ;

            echo "<h1> Guest Book Updated!</h1>";

        } else
            echo "<h1>You have not completed the required information!</h1>";
    }

    echo "<div align='center' xmlns=\"http://www.w3.org/1999/html\"/><form id='form_logs' action = './GuestBook.php' method='post' >
    <table>
    
        <tr>
            <td><span style='color: snow'>Name :</td>
            <td><input type='text' name='name' style='padding-left: 50px; background: transparent; border: none; border-bottom: 1px solid beige; color: floralwhite; font-size: 18px; margin-bottom: 16px; ' /></td>   
        </tr>
        
        <tr>
            <td><span style='color: snow'>Email :</td>
            <td><input type='text' name='email' style='padding-left: 50px; background: transparent; border: none; border-bottom: 1px solid beige; color: floralwhite; font-size: 18px; margin-bottom: 16px; ' /></td>   
        </tr>
        
        <tr>
            <td><span style='color: snow'>Comment :</td>
            <td><textarea  name='comment' style= 'width: 220px; height: 100px; padding-left: 50px; background: transparent; border: none; border-bottom: 1px solid beige; color: floralwhite; font-size: 16px; margin-bottom: 16px; ' ></textarea></td>   
        </tr>
        
        <tr>
            <td><input type='submit' name='updatebtn' value='Update' style='font-size: 16px; font-weight: bold; margin-top: 20px;'  /></td>   
        </tr>
        
    </table>
    </div>
    </form>";

    /**********************/
    // display
    echo "<h2> Guest SAYS! </h2>";


    $query = mysqli_query($conn, "SELECT * FROM guestList ORDER BY id DESC");
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        echo "<hr />";
        while( $row = mysqli_fetch_assoc($query) ){
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $comment = $row['comment'];
            $time = $row['time'];
            $date = $row['date'];

            $comment = nl2br($comment);

            echo "<div class='booklogs' xmlns=\"http://www.w3.org/1999/html\"><form name='form1' action='' method='post'>
                <input type='checkbox' name='num[]' value='<?php echo $row[id];?>'/>
                <h1><b>$name</b> posted at <b>$time</b> on <b>$date</b></h1> <br/>
                <h3><i>$comment</i></h3>

 
                
            </form>   
            </div><hr />";


        }
    }else
        echo "<h1>NO POSTS</h1>";
    /**********************/


mysqli_close($conn);

?>



</body>
</html>