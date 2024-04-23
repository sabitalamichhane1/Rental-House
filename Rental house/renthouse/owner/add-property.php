<?php
  include('navbar.php');
  include("../config/constants.php");
  session_start();
?>

<div class="main-content">
  <div class="wrapper">
    <h1>Add Property</h1>
    <br><br>

    <?php
      if(isset($_SESSION['upload']))
      {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
      }
     ?>

     <form action="" method="POST" enctype="multipart/form-data">
       <table class="tbl-30">
         <tr>
           <td>Country: </td>
           <td>
             <input type="text" name="country" placeholder="Country">
           </td>
         </tr>
         <tr>
           <td>Province: </td>
           <td>
             <input type="text" name="province" placeholder="province">
           </td>
         </tr>
         <tr>
           <td>Zone: </td>
           <td>
             <input type="text" name="zone" placeholder="Zone">
           </td>
         </tr>
         <tr>
           <td>District: </td>
           <td>
             <input type="text" name="district" placeholder="District">
           </td>
         </tr>
         <tr>
           <td>City: </td>
           <td>
             <input type="text" name="city" placeholder="City">
           </td>
         </tr>
         <tr>
           <td>VDC/Municipality: </td>
           <td>
             <input type="text" name="vdc_municipality" placeholder="VDC/Municipality">
           </td>
         </tr>
         <tr>
           <td>Ward No: </td>
           <td>
             <input type="number" name="ward_no" placeholder="Ward No">
           </td>
         </tr>
         <tr>
           <td>Tole: </td>
           <td>
             <input type="text" name="tole" placeholder="Tole">
           </td>
         </tr>
         <tr>
           <td>Contact No: </td>
           <td>
             <input type="number" name="contact_no" placeholder="Contact No">
           </td>
         </tr>
         <tr>
           <td>Property Type: </td>
           <td>
             <input type="text" name="property_type" placeholder="Property Type">
           </td>
         </tr>
         <tr>
           <td>Estimated Price: </td>
           <td>
             <input type="number" name="estimated_price" placeholder="Estimated Price">
           </td>
         </tr>
         <tr>
           <td>Total Rooms: </td>
           <td>
             <input type="number" name="total_rooms" placeholder="Total Rooms">
           </td>
         </tr>
         <tr>
           <td>Bedroom: </td>
           <td>
             <input type="number" name="bedroom" placeholder="Bedroom">
           </td>
         </tr>
         <tr>
           <td>Living Room: </td>
           <td>
             <input type="number" name="living_room" placeholder="Living Room">
           </td>
         </tr>
         <tr>
           <td>Kitchen: </td>
           <td>
             <input type="number" name="kitchen" placeholder="Kitchen">
           </td>
         </tr>
         <tr>
           <td>Bathroom: </td>
           <td>
             <input type="number" name="bathroom" placeholder="Bathroom">
           </td>
         </tr>
         <tr>
           <td>Description: </td>
           <td>
             <textarea name="description" rows="5" cols="30" placeholder="Description of Property"></textarea>
           </td>
         </tr>
         <tr>
           <td>Latitude: </td>
           <td>
             <input type="number" name="latitude" placeholder="Latitude">
           </td>
         </tr>
         <tr>
           <td>Longitude: </td>
           <td>
             <input type="number" name="longitude" placeholder="Longitude">
           </td>
         </tr>
         <tr>
           <td>Select Image: </td>
           <td>
             <input type="file" name="image">
           </td>
         </tr>
         <tr>
           <td colspan="2">
             <input type="submit" name="submit" value="Add Property" class="btn-secondary">
           </td>
         </tr>
       </table>
     </form>

     <?php
      if(isset($_POST['submit']))
      {
        $country=$_POST['country'];
        $province=$_POST['province'];
        $zone=$_POST['zone'];
        $district=$_POST['district'];
        $city=$_POST['city'];
        $vdc_municipality=$_POST['vdc_municipality'];
        $ward_no=$_POST['ward_no'];
        $tole=$_POST['tole'];
        $contact_no=$_POST['contact_no'];
        $property_type=$_POST['property_type'];
        $estimated_price=$_POST['estimated_price'];
        $total_rooms=$_POST['total_rooms'];
        $bedroom=$_POST['bedroom'];
        $living_room=$_POST['living_room'];
        $kitchen=$_POST['kitchen'];
        $bathroom=$_POST['bathroom'];
        $description=$_POST['description'];
        $latitude=$_POST['latitude'];
        $longitude=$_POST['longitude'];
        $owner_id=$_SESSION['owner_id'];

        if(isset($_FILES['image']['name']))
        {
          $image_name=$_FILES['image']['name'];

          if($image_name!="")
          {
            $exp=explode('.',$image_name);
            $ext=end($exp);
            $image_name="Property-".rand(0000,9999).".".$ext;
            $src=$_FILES['image']['tmp_name'];
            $dst="product-photo/".$image_name;

            $upload=move_uploaded_file($src,$dst);

            if($upload==false)
            {
              $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
              header('location:'.SITEURL.'owner/add-property.php');
              die();
            }
          }
        }
        else
        {
          $image_name="";
        }

        $sql0="select * from add_property order by property_id desc limit 1";
        $res0=mysqli_query($conn,$sql0);
        $count=mysqli_num_rows($res0);
        if($count>0)
        {
          $row=mysqli_fetch_assoc($res0);
          $pro_id=$row['property_id'];
          $property_id=$pro_id+1;
        }

        $sql1="insert into add_property set
          country='$country',
          province='$province',
          zone='$zone',
          district='$district',
          city='$city',
          vdc_municipality='$vdc_municipality',
          ward_no='$ward_no',
          tole='$tole',
          contact_no='$contact_no',
          property_type='$property_type',
          estimated_price='$estimated_price',
          total_rooms='$total_rooms',
          bedroom='$bedroom',
          booked='no',
          living_room='$living_room',
          kitchen='$kitchen',
          bathroom='$bathroom',
          description='$description',
          latitude='$latitude',
          longitude='$longitude',
          owner_id='$owner_id'
        ";

        $sql2="insert into property_photo set
          p_photo='$image_name',
          property_id='$property_id'
        ";

        $res1=mysqli_query($conn,$sql1);
        $res2=mysqli_query($conn,$sql2);

        if($res1 && $res2 == true)
        {
          echo"<script>
            alert('Property Added');
            window.location.href='owner-index.php';
          </script>";
        }
      }
     ?>
  </div>
</div>
