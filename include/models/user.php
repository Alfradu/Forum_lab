<?php
function genString($length){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}
function referenceComment($comment, $id){
    $arr = preg_split('/\s(?=>{2}[0-9]+)/', $comment, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (count($arr) > 1){
        if ($arr[0] != ""){
            return $arr[0]." ".splDel($arr, $id);
        } else {
            return splDel($arr, $id);
        }
    } else {
        preg_match('/>{2}[0-9]+/', $comment, $matches, PREG_UNMATCHED_AS_NULL);
        if (count($matches) > 0){
            $number = preg_split('/>{2}/', $comment, -1, PREG_SPLIT_DELIM_CAPTURE);
            if ($id == $number[1]) {
                return '<a href="thread.php?id='.$id.'#'.$number[1].'" class="likealink">'.$comment.' (OP)</a>';
            } else {
                return '<a href="thread.php?id='.$id.'#'.$number[1].'" class="likealink">'.$comment.'</a>';
            }
        } else {
            return $comment;
        }
    }
}
function splDel($arr, $id){
    $string = "";
    for ($x = 1; $x <= count($arr)-1; $x++){
        $delimiterArr = preg_split('/(>{2}[0-9]+)(?=\s)/', $arr[$x], -1, PREG_SPLIT_DELIM_CAPTURE);
        $number = preg_split('/>{2}/', $delimiterArr[1], -1, PREG_SPLIT_DELIM_CAPTURE);
        if ($id == $number[1]){
            $string .= '<a href="thread.php?id='.$id.'#'.$number[1].'" class="likealink">'.$delimiterArr[1].' (OP)</a>'.$delimiterArr[2];
        } else {
            $string .= '<a href="thread.php?id='.$id.'#'.$number[1].'" class="likealink">'.$delimiterArr[1].'</a>'.$delimiterArr[2];
        }
    }
    return $string;
}
?>
