<!DOCTYPE html>
<?php 
/**
* This file contains the installation instructions  for this application
* 
*/

/**
* This file describes the basic installation and setup of this framework application 
* 
*/


include_once '../config/config.php'; ?>

    
    
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DDA Framework - INSTALLATION</title>
    <!--
    <!--
    <!--
    --Load the bootstrap scripts by reference
    --Note the use of the 'integrity' property
    --More info on that property here: https://blog.compass-security.com/2015/12/subresource-integrity-html-attribute/
    -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>

    <!--apply any local styles if required -->
    <style type="text/css">
        body{
            padding-top: 70px;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

<!--Main container for page content-->  
<div class="container-fluid">      
<div class="row">
    <div class="col-md-12" style="background-color:white;">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>FRAMEWORK Web Application - Installation Instructions</h1></div>
              <div class="panel-body">

            <h2>Welcome</h2>
                  <p>If you are reading this it means that you have downloaded and unzipped the code for the FRAMEWORK web application. 
                  <p>This application provides implementation of login/logout functionality for 3 different user types as well as non logged in user access. A logged in administrator can register other new users. </p>
                  
            <?php include_once 'releaseNotes.php'; ?>
            
            <h2>Database - Restore and Check Application Configuration</h2>
            <p>The first time this framework is run - it runs an installer which will install a minimum database from the  (<code>/database</code>) folder - Note that DEBUG mode must be turned on for this to work.
            <p>The project also contains a folder in which you will find SQL backup of a database: (<code>/database</code>) which can be restored at any time as follows:. 


            <ul>
            <li>Using MySQL Workbench - restore the database using backup file : <code>k00999999_framework_v.sql</code> where 'v' is a version number </li>
            <li>Make sure the database configuration settings are correct for your setup - check the configuration settings in file <code>/config/connection.php</code>  </li>
            </ul>
            
             <h2>Login/Test</h2> 
             <p>This sample FRAMEWORK application supports 4 different user types along with some basic functionality:
             <ul>
                 <li>General user (not logged in)</li>
                 <li>Administrator</li>
                 <li>Manager</li>
                 <li>Customer</li>
             </ul>
             <p>When the application database is set up you will see 3 tables - one for each LOGGED IN usertype. Passwords are encrypted by default. All users login using their registered email address.<br>Sample logins are as follows::
             <ul>
                 <li>Administrator ID: <code>jsmith@college.ie</code> and Password: <code>Password1</code></li>
                 <li>Manager ID: <code>flann@gmail.com</code> and Password: <code>Password1</code></li>
                 <li>Customer ID: <code>janeh@mail.com</code> and Password: <code>Password1</code></li>
             </ul>  
             
             
             <h2>AJAX Setup</h2>
             <p>This application supports an AJAX live chat function for logged in customers. For it to work the following changes must be made to the <code>/config/config.php</code>file:
             <ul>
                 <li>Set the <code>CHAT_ENABLED</code> global variable to TRUE - Note: it is currently set to 
                     <?php  if (CHAT_ENABLED) echo '<code>TRUE</code>'; else echo '<code>FALSE</code>' ?></li>
                 <li>Set the <code>$serverIP_address</code>_address variable to point to the network IP address for the Apache Server this app is running on. This can be found by opening a command window and typing <code>ipconfig</code>
                 - Note: it is currently set to <code><?php echo $serverIP_address; ?> </code></li>
                 <li>Set the <code>$root_path</code>_address variable to path from the Apache Server <code>/htdocs</code> folder to the  <code>index.php</code> file of this application - Note it is currently set to <code><?php echo $root_path; ?></code></li>
                 <li>Then load the home page including the IP address in the URL - your current settings are : <?php echo "<a href='".__THIS_URI_ROOT."'>".__THIS_URI_ROOT."</a>"; ?> </li>
             </ul>    
             
             <h2>Next steps - Explore the framework</h2>
             <p>You should start by studying the structure of this application. You will see that the main features are
             <ul>
                 <li>Each user type has their own specific controller eg <code>/controllers/AdminController.php</code></li>
                 <li>Each user type has their own specific navigation model eg <code>/models/navigationBarContent/NavigationAdmin.php</code></li>
                 <li>Each page is identified by a specific $pageID which is used by all models and controller classes to determine how a page request is handled. </li>
                 <li>The content of each page ($pageID) is generated by a corresponding content model eg <code>/models/panelContent/CustomerHome.php</code></li>
                 <li>Login is universal - ie all user types can login via a single login link. The login model will check each of the 3 user tables in the database for corresponding login credentials.</li>
                 <li>Each table in the database has a corresponding table entity model in the application framework eg <code>/classlib/entities/UserTable.php</code></li>
                 <li>Debug mode may be set to on/off in the configuration file <code>/config/config.php</code></li>
                 <li>All forms used in this application are defined in the <code>Form</code> class which is located in the <code>/forms</code> folder</li>
                 <li>A HTML helper class is included to facilitate generation of HTML elements such as tables if required. <code>/classlib/helperClasses</code></li>
             </ul>    
                 
                 
             <p>Once you are familiar with the structure - then start by creating your own menu structures for your users. As demonstrated in class - New menu item handlers can use the <code>
                     UnderConstruction.php</code> model until you develop your own specific content models. See logged in Manager <code>Manage System</code> menu items as an example.
                     
             <h2>Framework Documentation</h2>
             <p>Full documentation of all classes in this framework can be found <a href='./docs/index.html' target='_blank'>here</a>. 
                     
             </div>
            </div>
    </div>


</div>

</div>  <!--end of main content container-->
     
        
        
    </body>
</html>
