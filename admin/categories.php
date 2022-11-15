<?php
ob_start();
session_start();
$noNav='';
if(isset($_SESSION['username'])&& $_SESSION['GROUPID']==1)
{
    $pageTitle='categories';
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
        $cats=$ob->select2('*','categories',NULL,NULL,'');

        ?>
            <div class="container table-responsive mt-5">
                <table class="table main-table text-center table-bordered">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($cats as $cat){
                                echo "<tr>";
                                    echo "<td>" . $cat['ID'] . "</td>";
                                    echo "<td>" . $cat['Name'] . "</td>";
                                    echo "<td>" . $cat['Description'] . "</td>";//chunk_split($sub['Description'],0,5)
                                    echo "<td>"; 
                                        if($cat['Status']==1){echo 'available';}else{echo 'not available yet';}
                                    echo "</td>";
                                    echo "<td><a class='btn btn-info' href='categories.php?do=edit&id=". $cat['ID'] ."'>editt </a> <a class='btn btn-danger confirm' href='categories.php?do=delete&id=" . $cat['ID'] . "'>Delete </a> ";
                                    if($cat['Status']==0){echo "<a class='btn btn-info' href='categories.php?do=Activate&id=". $cat['ID'] ."'>activate</a>";}
                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <a class='btn btn-primary' href='categories.php?do=add'>Add New Cat</a>
            </div>
        <?php
    } elseif($do =='add'){
        ?>
            <div class="container mt-5">
                <form action="categories.php?do=insert" method="POST" class="form">

                    <div class="form-group">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="text" name="name" requierd placeholder="type name of category" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Name of category must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Desc :</label>
                        <div class="forRes">
                            <input type="text" name="Desc" requierd placeholder="type Desc of category" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-danger mt-1">
                                <p>Desc of category is required and must be logic</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="submit" class="sub btn btn-primary btn-lg">
                    </div>

                </form>
                <?php
                    if(isset($bigErrors))
                    {
                        foreach($bigErrors as $err)
                        {
                            echo $err . "<br>";
                        }
                    }
                ?>
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
                $user->insert('categories','Name,Description,Status',"'$name','$desc',1");
                header("location:categories.php");
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
               //some edits
            }
        }else{
            echo "<div class='container mt-5'>Not Allow To you</div>";
            header("location:categories.php");
        }

    } elseif($do=='edit'){
        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob=new dataConnection();
        $count=$ob->checkItem('ID','categories',$id);
        if($count > 0){
            $value=$ob->select('*','categories',"WHERE ID = '$id'",NULL,'');
            ?>
            <div class="container mt-5">
                <form action="categories.php?do=update" method="POST" class="form">

                    <div class="form-group">
                        <input type="hidden" name="catid" value="<?php echo $id; ?>">
                        <label>Name :</label>
                        <div class="forRes">
                            <input type="text" name="name" value="<?php echo $value['Name']; ?>" requierd placeholder="type name of category" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-dangermt-1">
                                <p>Name of category must be atleast 2 letters</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Desc :</label>
                        <div class="forRes">
                            <input type="text" name="Desc" value="<?php echo $value['Description']; ?>" requierd placeholder="type Desc of category" autocomplete="off" class="req form-control">
                            <i class="fa fa-asterisk"></i>
                            <div class="custom-alert alert alert-dangermt-1">
                                <p>Desc of category is required and must be logic</p>
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
            $id   = filter_var($_POST['catid'],FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $desc = filter_var($_POST['Desc'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $ob = new validator();
            $ob->check('name',$name,['req','str']);
            $ob->check('desc',$desc,['req','str']);

            if($ob->checkerrors())
            {
                $user = new dataConnection();
                $count=$user->checkItem('ID','categories',$id);

                if($count > 0){
                    $user = new dataConnection();
                    $user->update('categories',"Name='$name',Description='$desc'",'ID',$id);
                    header("location:categories.php");
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
            header("location:categories.php");
        }

    } elseif($do=='delete'){

        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob = new dataConnection();
        $count=$ob->checkItem('ID','categories',$id);

        if($count > 0){
            $ob->delete('categories','ID',$id);
        }else{
            echo "Sorry This id is not exist";
        }

    } elseif($do=='Activate'){

        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $ob = new dataConnection();
        $count=$ob->checkItem('ID','categories',$id);
        
        if($count > 0){
            $ob->update('categories','Status = 1','ID',$id);
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