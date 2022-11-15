<?php
session_start();
if(isset($_SESSION['username']))
{
    if($_SESSION['GROUPID']==1){$location='dashboard';} elseif($_SESSION['GROUPID']==2){$location='profileS';} elseif($_SESSION['GROUPID']==3){$location='profileS';}
    header("location:$location.php");
}else{

$noNav='';
$pageTitle="Login";
include "init.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{

    $name=$_POST['user'];
    $pass=$_POST['pass'];
    $hashpass=sha1($pass);

    $ob=new dataConnection();
   
    $result=$ob->select("ID,UserName,Password,avatar,GroupID",'members',"WHERE UserName = '$name'","AND Password = '$hashpass'",'');

    //print_r($result);

    $groupid=$result['GroupID'];
    
    if($groupid == 1){
        //echo 'admin';
        $_SESSION['username']=$name;
        $_SESSION['UserID']=$result['ID'];
        $_SESSION['GROUPID']=$groupid;
        $_SESSION['avatar']=$result['avatar'];/*<img src="uploads/<?php echo $_SESSION['avatar']?>"> 12%*/
        header("location:dashboard.php");
        exit();
    }elseif($groupid == 2){
         //echo 'teatcher';
         $_SESSION['username']=$name;
         $_SESSION['UserID']=$result['ID'];
         $_SESSION['GROUPID']=$groupid;
         $sessionid=$_SESSION['UserID'];
         header("location:profileS.php?userid=$sessionid");
         exit();

    }elseif($groupid == 3){
        //echo 'student';
        $_SESSION['username']=$name;
        $_SESSION['UserID']=$result['ID'];
        $_SESSION['GROUPID']=$groupid;
        $sessionid=$_SESSION['UserID'];
         header("location:profileS.php?userid=$sessionid");
        exit();

    }
  
}
?>
<form class="forWidth" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <h4 class="text-center"> Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <div class="d-grid gap-2">
        <input class="btn btn-primary btn-block" type="submit" value="login">
    </div>  
</form>

<?php 
}
include "inc/templates/footer.php";
?>