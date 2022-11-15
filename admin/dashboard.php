<?php 
session_start();
$noNav='';
$pageTitle="Dashboard";
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

                    <div class="search">
                        <h2 class="hhh" data-text="Dashboard Details">Dashboard Details</h2>
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

                <!--down cards-->
                <div class="cardBox">
                    <div class="Card">
                        <div>
                            <?php
                                     $ob = new dataConnection();
                                     $cats=$ob->countItems('ID','categories','');

                            ?>
                            <div class="numbers"><?php echo $cats; ?></div>
                            <div class="cardName">Categories</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="pricetags-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="Card">
                        <div>
                        <?php
                                     $ob = new dataConnection();
                                     $mems=$ob->countItems('ID','members','');

                            ?>
                            <div class="numbers"><?php echo $mems; ?></div>
                            <div class="cardName">members</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="people-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="Card">
                        <div>
                        <?php
                                     $ob = new dataConnection();
                                     $gros=$ob->countItems('ID','groups','');

                            ?>
                            <div class="numbers"><?php echo $gros; ?></div>
                            <div class="cardName">Groups</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="person-add-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="Card">
                        <div>
                        <?php
                                     $ob = new dataConnection();
                                     $plas=$ob->countItems('ID','place','');

                            ?>
                            <div class="numbers"><?php echo $plas; ?></div>
                            <div class="cardName">places</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="storefront-outline"></ion-icon>
                        </div>
                    </div>
                </div>

                <!-- down list-->
                <div class="details">
                    <!--down list one-->
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Recent Groups</h2>
                            <a href="groups.php" class="bttn">View All</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <td>Group</td>
                                    <td>Category</td>
                                    <td>Subject</td>
                                    <td>Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $ob = new dataConnection();
                                    $groups=$ob->threeJoin('groups.*,categories.Name AS CATNAME,subjects.Name AS SUBNAME,place.Name AS PLANAME','groups','categories','categories.ID = groups.Cat_ID','subjects','subjects.ID = groups.Sub_ID','place','place.ID = groups.Pla_ID','','','');
                                    foreach($groups as $gro){                              
                                ?>
                                <tr>
                                    <td><?php echo $gro['Name']; ?></td>
                                    <td><?php echo  $gro['CATNAME']; ?></td>
                                    <td><?php echo $gro['SUBNAME']; ?></td>
                                    <td><span class="status return"><?php echo $gro['Date']; ?></span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- down list two-->
                    <div class="recentCustomers">
                        <div class="cardHeader">
                            <h2>Recent Members</h2>
                            <?php 
                                $ob = new dataConnection();
                                $members=$ob->select2('*','members','WHERE GroupID = 2',NULL,'');
                            ?>
                        </div>
                        <table>
                        <?php foreach($members as $mem){ ?>
                            <tr>
                                <td width="60px"><div class="imgBx"><?php echo "<img src='uploads/" . $mem['avatar'] . "'>"?></div></td>
                                <td><h5><?php echo $mem['UserName'] ; ?><br><span><?php echo $mem['FullName'] ?></span></h5></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>

                </div>

            </div>
        </div>

<?php
 include "inc/templates/footer.php";
?>
