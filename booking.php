<?php
ob_start();
session_start();
if(isset($_SESSION['username']))
{
    $noNav='';
    $pageTitle='ProfileS';
    include "init.php";
    $groid=$_GET['id'];
    $ob = new dataConnection();
    $groups=$ob->threeJoin('groups.*,categories.Name AS CATNAME,categories.ID AS CATID,subjects.Name AS SUBNAME,subjects.ID AS SUBID,place.Name AS PLANAME','groups','categories','categories.ID = groups.Cat_ID','subjects','subjects.ID = groups.Sub_ID','place','place.ID = groups.Pla_ID',"WHERE groups.ID = $groid",'','');
    foreach($groups as $gro){
        $CatName = $gro['CATID'];
        $subName = $gro['SUBID'] ;
        $groName = $groid;
        //echo $groName;
    }
    $idd= $_SESSION['UserID'];
    $members=$ob->select2('*','members',"WHERE ID = $idd",NULL,'');
    foreach($members as $mem){
        $id = $mem['ID'];
        $name = $mem['UserName'];
        $pass = $mem['Password'];
        $avatar = $mem['avatar'];
        $fname = $mem['FullName'];
        $email =  $mem['Email'];
        $GroupId = $mem['GroupID'];
        //echo $mem['gro_ID'];
    }

    //$count=$ob->checkItem('gro_ID','members',"WHERE gro_ID = $groid");

    if($mem['gro_ID'] != $groName && $GroupId != 1 && $GroupId != 2){
       $user = new dataConnection();
        $user->update('members',"UserName='$name',Password='$pass',avatar='$avatar',FullName='$fname',Email='$email',GroupID='$GroupId',Cat_ID='$CatName',Sub_ID='$subName',gro_ID='$groName'",'ID',$id);
        header("location:members.php");
        echo "book";
    }else{
         echo "This Course is exist";
    }
   
    include "inc/templates/footer.php";
}else{
   echo "you should register first";
}
ob_end_flush();
?>