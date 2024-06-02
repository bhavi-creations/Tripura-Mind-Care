<?php

if(!empty($_POST))
{
    $uid=$_POST['name'];
    $upass=$_POST['pass'];
    $sql=mysqli_query($conn,"select * from user where User_ID='$uid' and Password='$upass'");
    
if(mysqli_num_rows($sql)>0){
 
  header("location:app/index.php");
}
else{
     
  $status=0;

}
  }

?>