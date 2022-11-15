<?php
ob_start();
session_start();
$noNav='';
if(isset($_SESSION['username'])&& $_SESSION['GROUPID']==1)
{
    $pageTitle='members';
    include "init.php";

    ?>
    <div class="container-fluid">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="logo-apple"></ion-icon></span>
                            <span class="title">Brand Name</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php">
                            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="categories.php">
                            <span class="icon"><ion-icon name="pricetags-outline"></ion-icon></span>
                            <span class="title">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="subjects.php">
                            <span class="icon"><ion-icon name="chatbubble-outline"></ion-icon></span>
                            <span class="title">Subjects</span>
                        </a>
                    </li>
                    <li>
                        <a href="groups.php">
                            <span class="icon"><ion-icon name="person-add-outline"></ion-icon></span>
                            <span class="title">Groups</span>
                        </a>
                    </li>
                    <li>
                        <a href="places.php">
                            <span class="icon"><ion-icon name="storefront-outline"></ion-icon></span>
                            <span class="title">Places</span>
                        </a>
                    </li>
                    <li>
                        <a href="members.php">
                            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                            <span class="title">Members</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                            <span class="title">LogOut</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- main -->
            <div class="main">
                <!--top-->
                <div class="topbar">

                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>

                    <div class="user">
                        
                        <?php
                            $id=$_SESSION['UserID'];
                            $ob = new dataConnection();
                            $members=$ob->select('*','members',"WHERE ID = '$id'",NULL,'');
                            echo "<a href='../index.php'><img src='uploads/" . $members['avatar'] . "'></a>";
                           
                        ?>
                       
                    </div>

                </div>


    <?php

    $do=isset($_GET['do']) ? $_GET['do'] : 'manage';

    if($do=='manage'){

        $ob = new dataConnection();
        $members=$ob->select2('*','members',NULL,NULL,'');
        ?>
            <div class="container table-responsive mt-5">
                <table class="table main-table text-center table-bordered">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>avatar</th>
                            <th>Email</th>
                            <th>FullName</th>
                            <th>Kind</th>
                            <th>Cat</th>
                            <th>Sub</th>
                            <th>Gro</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($members as $mem){
                                echo "<tr>";
                                    echo "<td>" . $mem['ID'] . "</td>";
                                    echo "<td>" . $mem['UserName'] . "</td>";
                                    echo "<td><img src='uploads/" . $mem['avatar'] . "'></td>";
                                    echo "<td>" . $mem['Email'] . "</td>";
                                    echo "<td>" . $mem['FullName'] . "</td>";
                                    echo "<td>"; 
                                        if($mem['GroupID']==1){echo "admin";}elseif($mem['GroupID']==2){echo "Teacher";}elseif($mem['GroupID']==3){echo "Student";} 
                                    echo "</td>";
                                    echo "<td>";
                                        $catsName=$ob->select2('Name','categories','WHERE ID =' . $mem['Cat_ID'] .'',NULL,'');
                                        foreach($catsName as $Name){
                                            echo $Name['Name'];
                                        }
                                    echo "</td>";
                                    echo "<td>";
                                        $subsName=$ob->select2('Name','subjects','WHERE ID =' . $mem['Sub_ID'] .'',NULL,'');
                                        foreach($subsName as $Name){
                                            echo $Name['Name'];
                                        }
                                    echo "</td>";
                                    echo "<td>";
                                        $grosName=$ob->select2('Name','groups','WHERE ID =' . $mem['gro_ID'] .'',NULL,'');
                                        foreach($grosName as $Name){
                                            echo $Name['Name'];
                                        }
                                    echo "</td>";
                                    echo "<td><a class='btn btn-info' href='members.php?do=edit&id=". $mem['ID'] ."'>editt </a> <a class='btn btn-danger confirm' href='members.php?do=delete&id=" . $mem['ID'] . "'>Delete </a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <a class='btn btn-primary' href='members.php?do=add'>Add New Member</a>
            </div>
        <?php
    } elseif($do=='add'){
        ?>
            <div class="container mt-5">
                <form action="members.php?do=insert" method="POST" class="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="text" name="name" requierd placeholder="type name of member" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of member must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Full Name :</label>
                        <div class="forRes">
                            <input type="text" name="fname" requierd placeholder="type Full name of member" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Full Name of member must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password :</label>
                        <div class="forRes">
                            <input type="password" name="pass" requierd placeholder="type strong password" autocomplete="new-password" class="passs inputForShow form-control">
                            <i class="show fa fa-eye"></i>
                            <div class="custom-alert alert alert-dangermt-1">
                                <p>Password of member must be atleast 8 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email :</label>
                        <div class="forRes">
                            <input type="email" name="email" requierd placeholder="type name of category" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-dangermt-1">
                                <p>email is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>img :</label>
                        <div class="forRes">
                            <input type="file" name="avatar" requierd class="req form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>GroupId :</label>
                        <div class="forRes">
                            <select name='Groupid'>
                                    <option value='0'>...</option>
                                    <option value='1'>Admin</option>
                                    <option value='2'>Teacher</option>
                                    <option value='3'>Student</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Cat Name :</label>
                        <div class="forRes">
                            <select name='catName' id="first">
                                    <option value='0'>...</option>
                                    <?php
                                        $ob = new dataConnection();
                                        $cats=$ob->select2('*','categories',NULL,NULL,'');
                                        foreach($cats as $cat)
                                        {
                                            echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sub Name :</label>
                        <div class="forRes">
                            <select name='subName' id="second">
                                <option value='0'>...</option>
                                <?php
                                        $ob = new dataConnection();
                                        $groups=$ob->select2('*','subjects',NULL,NULL,'');
                                        foreach($groups as $gro)
                                        {
                                            echo "<option value='" . $gro['ID'] ."'>" . $gro['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Gro Name :</label>
                        <div class="forRes">
                            <select name='GroName'>
                                    <option value='0'>...</option>
                                    <?php
                                        $ob = new dataConnection();
                                        $groups=$ob->select2('*','groups',NULL,NULL,'');
                                        foreach($groups as $gro)
                                        {
                                            echo "<option value='" . $gro['ID'] ."'>" . $gro['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="submit" class="sub btn btn-primary btn-lg">
                    </div>

                </form>
            </div>
            
        <?php

    } elseif($do=='insert'){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fname = filter_var($_POST['fname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass=sha1($_POST['pass']);
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $GroupId = filter_var($_POST['Groupid'],FILTER_SANITIZE_NUMBER_INT);
            $CatName = filter_var($_POST['catName'],FILTER_SANITIZE_NUMBER_INT);
            $subName = filter_var($_POST['subName'],FILTER_SANITIZE_NUMBER_INT);
            $groName = filter_var($_POST['GroName'],FILTER_SANITIZE_NUMBER_INT);

            $avatarName=$_FILES['avatar']['name'];
            $avatarTempName=$_FILES['avatar']['tmp_name'];
            $avatarSize=$_FILES['avatar']['size'];
            $avatarType=$_FILES['avatar']['type'];

           $avatarMineExtension=["jpeg","jpg","png","gif"];
           $avatarExtension=pathinfo($avatarName,PATHINFO_EXTENSION);


            $errors = [];

            $ob = new validator();
            $ob->check('name',$name,['req','str']);
            $ob->check('fullName',$fname,['req','str']);
            $ob->check('Pass',$pass,['req']);
            $ob->check('Email',$email,['req']);
            $ob->check('GroupId',$GroupId,['req','num']);
            $ob->check('catName',$CatName,['req','num']);
            $ob->check('subName',$subName,['req','num']);
            $ob->check('GroName',$groName,['req','num']);
            $ob->check('avatar',$avatarSize,['size']);
            if(!empty($avatarName) && ! in_array(strtolower($avatarExtension),$avatarMineExtension))
            {
                $errors[]="avatar ext not allowed";
            }

            if($ob->checkerrors() && empty($errors))
            {
                $avatar=rand(0,100000) . '_' . $avatarName ;
                 move_uploaded_file($avatarTempName,"uploads\\".$avatar);

                $user = new dataConnection();
                $user->insert('members','UserName,Password,avatar,Email,FullName,GroupID,Cat_ID,Sub_ID,gro_ID',"'$name','$pass','$avatar','$email','$fname','$GroupId','$CatName','$subName','$groName'");
                header("location:members.php");
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
                print_r($errors);
               //some edits
            }
        }else{
            echo "<div class='container mt-5'>Not Allow To you</div>";
            header("location:members.php");
        }


    } elseif($do=='edit'){
        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob=new dataConnection();
        $count=$ob->checkItem('ID','members',$id);
        if($count > 0){
            $value=$ob->select('*','members',"WHERE ID = '$id'",NULL,'');
        ?>
        <div class="container mt-5">
                <form action="members.php?do=update" method="POST" class="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="hidden" name="memid" value="<?php echo $id; ?>">
                            <input type="text" name="name" value="<?php echo $value['UserName']; ?>" requierd placeholder="type name of member" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of member must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Full Name :</label>
                        <div class="forRes">
                            <input type="text" name="fname" value="<?php echo $value['FullName']; ?>" requierd placeholder="type Full name of member" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Full Name of member must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password :</label>
                        <div class="forRes">
                            <input type="hidden" name="oldPass" value="<?php echo $value['Password']; ?>" placeholder="type strong password" autocomplete="new-password" class="form-control">
                            <input type="password" name="newPass" placeholder="type strong password" autocomplete="new-password" class="inputForShow form-control">
                            <i class="show fa fa-eye"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Password of member must be atleast 8 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email :</label>
                        <div class="forRes">
                            <input type="email" name="email" value="<?php echo $value['Email']; ?>" requierd placeholder="type email of member" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Email is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>img :</label>
                        <div class="forRes">
                            <input type="file" name="avatar" requierd class="req form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>GroupId :</label>
                        <div class="forRes">
                            <select name='Groupid'>
                                    <option value='0' <?php if($value['GroupID']==0){echo 'selected';}?> >...</option>
                                    <option value='1' <?php if($value['GroupID']==1){echo 'selected';}?> >Admin</option>
                                    <option value='2' <?php if($value['GroupID']==2){echo 'selected';}?> >Teacher</option>
                                    <option value='3' <?php if($value['GroupID']==3){echo 'selected';}?> >Student</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Cat Name :</label>
                        <div class="forRes">
                            <select name='catName'>
                                    <option value='0'>...</option>
                                    <?php
                                        $ob = new dataConnection();
                                        $cats=$ob->select2('*','categories',NULL,NULL,''); 
                                        foreach($cats as $cat)
                                        {
                                            echo "<option value='" . $cat['ID'] ."'"; if($value['Cat_ID']==$cat['ID']){echo 'selected';}echo">" . $cat['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sub Name :</label>
                        <div class="forRes">
                            <select name='subName'>
                                    <option value='0'>...</option>
                                    <?php
                                        $ob = new dataConnection();
                                        $subs=$ob->select2('*','subjects',NULL,NULL,'');
                                        foreach($subs as $sub)
                                        {
                                            echo "<option value='" . $sub['ID'] ."'"; if($value['Sub_ID']==$sub['ID']){echo 'selected';}echo">" . $sub['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Gro Name :</label>
                        <div class="forRes">
                            <select name='GroName'>
                                    <option value='0'>...</option>
                                    <?php
                                        $ob = new dataConnection();
                                        $groups=$ob->select2('*','groups',NULL,NULL,'');
                                        foreach($groups as $gro)
                                        {
                                            echo "<option value='" . $gro['ID'] ."'"; if($value['gro_ID']==$gro['ID']){echo 'selected';}echo">" . $gro['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="submit" class="sub btn btn-primary btn-lg">
                    </div>

                </form>
            </div>

        <?php }
    } elseif($do=='update'){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $id=filter_var($_POST['memid'],FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fname = filter_var($_POST['fname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass=empty($_POST['newPass'])?$_POST['oldPass']:sha1($_POST['newPass']);
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $GroupId = filter_var($_POST['Groupid'],FILTER_SANITIZE_NUMBER_INT);
            $CatName = filter_var($_POST['catName'],FILTER_SANITIZE_NUMBER_INT);
            $subName = filter_var($_POST['subName'],FILTER_SANITIZE_NUMBER_INT);
            $groName = filter_var($_POST['GroName'],FILTER_SANITIZE_NUMBER_INT);

            $avatarName=$_FILES['avatar']['name'];
            $avatarTempName=$_FILES['avatar']['tmp_name'];
            $avatarSize=$_FILES['avatar']['size'];
            $avatarType=$_FILES['avatar']['type'];

           $avatarMineExtension=["jpeg","jpg","png","gif"];
           $avatarExtension=pathinfo($avatarName,PATHINFO_EXTENSION);

           $errors = [];

           $ob = new validator();
           $ob->check('name',$name,['req','str']);
           $ob->check('fullName',$fname,['req','str']);
           $ob->check('Pass',$pass,['req']);
           $ob->check('Email',$email,['req']);
           $ob->check('GroupId',$GroupId,['req','num']);
           $ob->check('catName',$CatName,['req','num']);
           $ob->check('subName',$subName,['req','num']);
           $ob->check('GroName',$groName,['req','num']);
           $ob->check('avatar',$avatarSize,['size']);
           if(!empty($avatarName) && ! in_array(strtolower($avatarExtension),$avatarMineExtension))
           {
               $errors[]="avatar ext not allowed";
           }
           if($ob->checkerrors() && empty($errors))
           {
                $avatar=rand(0,100000) . '_' . $avatarName ;
                move_uploaded_file($avatarTempName,"uploads\\".$avatar);

                $user = new dataConnection();
                $count=$user->checkItem('ID','members',$id);

                if($count > 0){
                    $user = new dataConnection();
                    $user->update('members',"UserName='$name',Password='$pass',avatar='$avatar',FullName='$fname',Email='$email',GroupID='$GroupId',Cat_ID='$CatName',Sub_ID='$subName',gro_ID='$groName'",'ID',$id);
                    header("location:members.php");
                }else{
                    echo "Sorry This id is not exist";
                }
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
                print_r($errors);
                //// some edits
            }
        }else{
            echo "<div class='container mt-5'>Not Allow To you</div>";
            header("location:members.php");
        }

    } elseif($do=='delete'){

        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob = new dataConnection();
        $count=$ob->checkItem('ID','members',$id);

        if($count > 0){
            $ob->delete('members','ID',$id);
            header("location:members.php");
        }else{
            echo "Sorry This id is not exist";
        }
    } 

    include "inc/templates/footer.php";
}else{
    header("location:index.php");
    exit();
}
ob_end_flush();
?>

</div>