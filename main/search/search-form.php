<?php


if(isset($_POST['submit'])){

    require_once("../../includes/functions.php");

    //intializes variables
    $search_query = $_POST["search"];
    /* $search_param = $_POST['search-param']; */
    $bad_words_filepath = "../../includes/bad-words.php";

    
    //if empty directs user back with all empty error
    if(isEmpty($search_query)) {
        header("Location: http://localhost:8888/themetronetwork/main/search/search.php?alert=missing-value");
        exit();
    }

    if(filterInput($search_query, $bad_words_filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/search/search.php?alert=inappropriate-value");
        exit();
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/search/search.php?alert=input-set&search=".$search_query);
        exit();
    }

}

