<?php

//include db config file
//include_once 'GuestBook.php';

//if record delete request is submitted
if(isset($_POST['deletebtn'])){

    //if id array is not empty
    if(!empty($_POST['num'])){

        //get all selected id and convert to string
        $idStr = implode(',', $_POST['num']);

        //delete records from database
        $delete = $db->query("DELETE FROM guestbook WHERE id IN ($idStr)");

        //if delete is successful
        if($delete){
            $statusMsg = 'Selected comments have been deleted successfully!';
        }else{
            $statusMsg = 'Error occured, please try again.';
        }

    }else{
        $statusMsg = 'Select atleast 1 record to delete.';
    }

}

?>