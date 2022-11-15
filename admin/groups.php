<?php
ob_start();
session_start();
$noNav='';
if(isset($_SESSION['username'])&& $_SESSION['GROUPID']==1)
{
    $pageTitle='groups';
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
        $groups=$ob->threeJoin('groups.*,categories.Name AS CATNAME,subjects.Name AS SUBNAME,place.Name AS PLANAME','groups','categories','categories.ID = groups.Cat_ID','subjects','subjects.ID = groups.Sub_ID','place','place.ID = groups.Pla_ID','','','');

        ?>
            <div class="container table-responsive mt-5">
                <table class="table main-table text-center table-bordered">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Cat Name</th>
                            <th>Sub Name</th>
                            <th>Pla Name</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($groups as $gro){
                                echo "<tr>";
                                    echo "<td>" . $gro['ID'] . "</td>";
                                    echo "<td>" . $gro['Name'] . "</td>";
                                    echo "<td>" . $gro['Date'] . "</td>";
                                    echo "<td>" . $gro['CATNAME'] . "</td>";
                                    echo "<td>" . $gro['SUBNAME'] . "</td>";
                                    echo "<td>" . $gro['PLANAME'] . "</td>";
                                    echo "<td><a class='btn btn-info' href='groups.php?do=edit&id=". $gro['ID'] ."'>editt </a> <a class='btn btn-danger confirm' href='groups.php?do=delete&id=" . $gro['ID'] . "'>Delete </a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <a class='btn btn-primary' href='groups.php?do=add'>Add New Sub</a>
            </div>
        <?php
    } elseif($do=='add'){
        ?>
            <div class="container mt-5">
                <form action="groups.php?do=insert" method="POST" class="form">

                    <div class="form-group">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="text" name="name" requierd placeholder="type name of group" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of category must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Date :</label>
                        <div class="forRes">
                            <input type="datetime-local" name="Date" requierd class="req form-control">
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
                                            echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] . "</option>";
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
                                            echo "<option value='" . $sub['ID'] ."'>" . $sub['Name'] . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pla Name :</label>
                        <div class="forRes">
                            <select name='plaName'>
                                    <option value='0'>...</option>
                                    <?php
                                        $ob = new dataConnection();
                                        $plas=$ob->select2('*','place',NULL,NULL,'');
                                        foreach($plas as $pla)
                                        {
                                            echo "<option value='" . $pla['ID'] ."'>" . $pla['Name'] . "</option>";
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
            $date = $_POST['Date'];
            $CatName = filter_var($_POST['catName'],FILTER_SANITIZE_NUMBER_INT);
            $subName = filter_var($_POST['subName'],FILTER_SANITIZE_NUMBER_INT);
            $plaName = filter_var($_POST['plaName'],FILTER_SANITIZE_NUMBER_INT);


            $ob = new validator();
            $ob->check('name',$name,['req','str']);
            $ob->check('date',$date,['req']);
            $ob->check('catName',$CatName,['req','num']);
            $ob->check('subName',$subName,['req','num']);
            $ob->check('plaName',$plaName,['req','num']);

            if($ob->checkerrors())
            {
                $user = new dataConnection();
                $user->insert('groups','Name,Date,Cat_ID,Sub_ID,Pla_ID',"'$name','$date','$CatName','$subName','$plaName'");
                header("location:groups.php");
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
               //some edits
            }
        }else{
            echo "<div class='container mt-5'>Not Allow To you</div>";
            header("location:groups.php");
        }


    } elseif($do=='edit'){
        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob=new dataConnection();
        $count=$ob->checkItem('ID','groups',$id);
        if($count > 0){
            $value=$ob->select('*','groups',"WHERE ID = '$id'",NULL,'');
        ?>
        <div class="container mt-5">
                <form action="groups.php?do=update" method="POST" class="form">

                <div class="form-group">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="hidden" name="groid" value="<?php echo $id; ?>">
                            <input type="text" name="name" value="<?php echo $value['Name']; ?>" requierd placeholder="type name of group" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of group must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Date :</label>
                        <div class="forRes">
                            <input type="datetime-local" name="Date" value="<?php echo $value['Date']; ?>" requierd class="req form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Cat Name :</label>
                        <div class="forRes">
                            <select name='catName'>
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
                        <label>Pla Name :</label>
                        <div class="forRes">
                            <select name='plaName'>
                                    <?php
                                        $ob = new dataConnection();
                                        $plas=$ob->select2('*','place',NULL,NULL,'');
                                        foreach($plas as $pla)
                                        {
                                            echo "<option value='" . $pla['ID'] ."'"; if($value['Pla_ID']==$pla['ID']){echo 'selected';}echo">" . $pla['Name'] . "</option>";
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
            $id   = filter_var($_POST['groid'],FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date = $_POST['Date'];
            $CatName = filter_var($_POST['catName'],FILTER_SANITIZE_NUMBER_INT);
            $subName = filter_var($_POST['subName'],FILTER_SANITIZE_NUMBER_INT);
            $plaName = filter_var($_POST['plaName'],FILTER_SANITIZE_NUMBER_INT);


            $ob = new validator();
            $ob->check('name',$name,['req','str']);
            $ob->check('date',$date,['req']);
            $ob->check('CatName',$CatName,['req','num']);
            $ob->check('SubName',$subName,['req','num']);
            $ob->check('PlaName',$plaName,['req','num']);


            if($ob->checkerrors())
            {
                $user = new dataConnection();
                $count=$user->checkItem('ID','groups',$id);

                if($count > 0){
                    $user = new dataConnection();
                    $user->update('groups',"Name='$name',Date='$date',Cat_ID='$CatName',Sub_ID='$subName',Pla_ID='$plaName'",'ID',$id);
                    header("location:groups.php");
                }else{
                    echo "Sorry This id is not exist";
                }
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
                //// some edits
            }
        }else{
            echo "<div class='container mt-5'>Not Allow To you</div>";
            header("location:groups.php");
        }

    } elseif($do=='delete'){
        
        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob = new dataConnection();
        $count=$ob->checkItem('ID','groups',$id);

        if($count > 0){
            $ob->delete('groups','ID',$id);
            header("location:groups.php");
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