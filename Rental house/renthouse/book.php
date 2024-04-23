<?php
  include('config/constants.php');
  session_start();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
  if(isset($_POST['book_property']))
  {
    $query1="insert into booking(tenant_id, property_id) values (".$_SESSION['tenant_id'].", ".$_POST['property_id'].")";

    mysqli_query($conn, $query1);

    $query2="update add_property set booked='yes' where property_id=".$_POST['property_id'].";";
    mysqli_query($conn, $query2);
    echo"<script>
      alert('Property Booked');
      window.location.href='index.php';
    </script>";
  }
}

// echo "tenant_id: ".$_SESSION['tenant_id'];
// echo "property_id:".$_POST['property_id'];
?>
