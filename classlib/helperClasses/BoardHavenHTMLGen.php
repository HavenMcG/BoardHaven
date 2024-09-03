<?php

class BoardHavenHTMLGen {
    public static function generate_boardlist($resultSet)
    {
        $string = '';
        $i = 0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $string .= '<ul>';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            foreach ($row as $value) {
                $string .= '<li><a href='.$_SERVER['PHP_SELF'].'?pageID=b/'.$value.'>'.$value.'</a></li>';
            }
        }
        $string .= '</ul>';
        return $string;
    }

    public static function generate_postlist($resultSet) {
        $string = '';
        $i = 0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $string .= '<ul>';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            $string .=
                '<li><a href='.$_SERVER['PHP_SELF'].'?pageID='.$_GET['pageID'].'/'.$row['Id'].'>'
                .$row['Title']
                .'</a></li>';
        }
        $string .= '</ul>';
        return $string;
    }
}