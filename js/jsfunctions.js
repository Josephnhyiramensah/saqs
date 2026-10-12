<?php 
    require('includes/db.php');
    include('includes/auth.php');
    include('includes/header_main.php');
    include('includes/navbar_main.php');
?>

$( "#createattd_btn" ).click(function() {
        $( "#createattd_btn" ).dialog({
          resizable: false,
          height: "auto",
          width: 400,
          modal: true,
          title: "Create New Attendance",
          buttons: {
            "Yes": function() {
              $( this ).dialog( "close" );
              <?php
              
              ?>
            },
            No: function() {
              $( this ).dialog( "close" );
            }
          }
        });
  });