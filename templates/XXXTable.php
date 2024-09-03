<?php
/**
* This file contains the XXXTable Class Template
* 
*/

/**
 * 
 * ChatMsgTable entity class implements the table entity class for the 'XXXTable' table in the database. 
 * 
 * 
 * To use this TEMPLATE - change 'XXX' to the required tablename everywhere it appears 
 * 
 * eg: if you want to define a table  'SUPPLIER'
 * Rename this file - replace the 'XXX' with 'SUPPLIER' in the file name 
 * Then edit this file to REPLACE ALL 'XXX' in this file with 'SUPPLIER' 
 * Move this file to its correct folder in the project eg /classlib/entities/ 
 * Finally include this file in the index.php 
 * 
 * 
 * 
 * @author Gerry Guinane
 * 
 */

class XXXTable extends TableEntity {

    /**
     * Constructor for the XXXTable Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'XXX');  //the name of the table is passed to the parent constructor
    }
    //END METHOD: Construct
   
    
   
    
}

