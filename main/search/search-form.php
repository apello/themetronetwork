<?php


if(isset($_POST['submit'])){

    //intializes variables
    $search_query = $_POST["search"];

    
    //if empty directs user back with all empty error
    if(isEmpty($search_query)) {
        header("Location: http://localhost:8888/themetronetwork/main/search/search.php?alert=missing-value");
        exit();
    }

    if(filterInput($search_query)) {
        header("Location: http://localhost:8888/themetronetwork/main/search/search.php?alert=inappropriate-value");
        exit();
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/search/search.php?alert=input-set");
        exit();
    }

}

//checks if  input is empty
function isEmpty($search_query) {

    $result;

    if(empty($search_query)) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }
    
    return $result;
}


//function checks if passwords are the same
function filterInput($search_query) {

    $result = false;

    include("../../includes/bad-words.php");

    for ($iterative = 0; $iterative < count($bad_words); $iterative++) { 
        if($search_query == $bad_words[$iterative]) {
            $result = true;
        }
    }

    return $result;
}
