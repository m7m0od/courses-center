<?php
ob_start();
session_start();
if(isset($_SESSION['username'])&& $_SESSION['GROUPID']==1)
{
    $pageTitle='Profile';
    include "init.php";
    $id=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    $ob=new dataConnection();
    $count=$ob->checkItem('ID','members',$id);
    if($count > 0){
        $value=$ob->threeJoin('categories.ID AS CATID,members.*,categories.Name AS CATNAME,categories.Description AS description,subjects.Name AS SUBNAME,groups.Name AS GRONAME,groups.Date AS GRODATE','members','categories','categories.ID = members.Cat_ID','subjects','subjects.ID = members.Sub_ID','groups','groups.ID = members.gro_ID',"WHERE members.ID = '$id'",'','ORDER BY gro_ID ASC');
        ?>
         <div class="container mt-5">
            <div class="row mt-5">
                <div class="col-md-4 mt-5">
                    <<?php foreach($value as $va){?> 
                    <img class="imgProfile" src="uploads/<?php echo $va['avatar'] ; ?>" class="w-75">
                    <?php } ?>
                </div>
                <div class="col-md-8">
                    <div class="container table-responsive mt-5">
                        <table class="table main-table text-center table-bordered">
                            <thead>
                            <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Category</th>
                                    <th>Subject</th>
                                    <th>Group</th>
                                    <th>Date</th>
                                    <th>settings</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($value as $va){?>
                                <tr>
                                    <td><?php echo $va['UserName']; ?></td>
                                    <td><?php echo $va['Email']; ?></td>
                                    <td><?php echo $va['CATNAME']; ?></td>
                                    <td><?php echo $va['SUBNAME']; ?></td>
                                    <td><?php echo $va['GRONAME']; ?></td>
                                    <td><?php echo $va['GRODATE']; ?></td>
                                    <td>
                                        <a href="logout.php" class="btn btn-danger">LogOut</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                            </tbody>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }else{
        header("location:logout.php");
    }




    include "inc/templates/footer.php";
}else{
   header("location:index.php");
   exit();
}
ob_end_flush();
?>