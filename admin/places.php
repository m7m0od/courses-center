<?php
ob_start();
session_start();
$noNav='';
if(isset($_SESSION['username'])&& $_SESSION['GROUPID']==1)
{
    $pageTitle='Places';
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
        $places=$ob->select2('*','place',NULL,NULL,'');

        ?>
            <div class="container table-responsive mt-5">
                <table class="table main-table text-center table-bordered">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($places as $pla){
                                echo "<tr>";
                                    echo "<td>" . $pla['ID'] . "</td>";
                                    echo "<td>" . $pla['Name'] . "</td>";
                                    echo "<td>" . $pla['Description'] . "</td>";
                                    echo "<td><a class='btn btn-info' href='places.php?do=edit&id=". $pla['ID'] ."'>editt </a> <a class='btn btn-danger confirm' href='places.php?do=delete&id=" . $pla['ID'] . "'>Delete </a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <a class='btn btn-primary' href='places.php?do=add'>Add New pla</a>
            </div>
        <?php
    } elseif($do =='add'){
        ?>
            <div class="container mt-5">
                <form action="categories.php?do=insert" method="POST" class="form">

                    <div class="form-group">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="text" name="name" requierd placeholder="type name of place" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of place must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Desc :</label>
                        <div class="forRes">
                            <input type="text" name="Desc" requierd placeholder="type Desc of place" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Desc of place is required and must be logic</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="submit" class="sub btn btn-primary btn-lg">
                    </div>

                </form>
            </div>
            
        <?php
    } elseif($do == 'insert'){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $desc = filter_var($_POST['Desc'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $ob = new validator();
            $ob->check('name',$name,['req','str']);
            $ob->check('Desc',$desc,['req','str']);

            if($ob->checkerrors())
            {
                $user = new dataConnection();
                $user->insert('place','Name,Description',"'$name','$desc'");
                header("location:places.php");
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
               //some edits
            }
        }else{
            echo "<div class='container mt-5'>Not Allow To you</div>";
            header("location:places.php");
        }

    } elseif($do=='edit'){
        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob=new dataConnection();
        $count=$ob->checkItem('ID','place',$id);
        if($count > 0){
            $value=$ob->select('*','place',"WHERE ID = '$id'",NULL,'');
            ?>
            <div class="container mt-5">
                <form action="places.php?do=update" method="POST" class="form">

                    <div class="form-group">
                        <input type="hidden" name="plaid" value="<?php echo $id; ?>">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="text" name="name" value="<?php echo $value['Name']; ?>" requierd placeholder="type name of place" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of place must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Desc :</label> 
                        <div class="forRes">
                            <input type="text" name="Desc" value="<?php echo $value['Description']; ?>" requierd placeholder="type Desc of place" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Desc of place is required and must be logic</p>
                            </div>
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
            $id   = filter_var($_POST['plaid'],FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $desc = filter_var($_POST['Desc'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $ob = new validator();
            $ob->check('name',$name,['req','str']);
            $ob->check('desc',$desc,['req','str']);

            if($ob->checkerrors())
            {
                $user = new dataConnection();
                $count=$user->checkItem('ID','place',$id);

                if($count > 0){
                    $user = new dataConnection();
                    $user->update('place',"Name='$name',Description='$desc'",'ID',$id);
                    header("location:places.php");
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
            header("location:places.php");
        }

    } elseif($do=='delete'){

        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob = new dataConnection();
        $count=$ob->checkItem('ID','place',$id);

        if($count > 0){
            $ob->delete('place','ID',$id);
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