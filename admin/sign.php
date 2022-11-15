<?php
session_start();
$noNav='';
$pageTitle="SignUp";
include "init.php";
if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $name = filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fname = filter_var($_POST['fname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass=sha1($_POST['pass']);
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $GroupId = filter_var($_POST['Groupid'],FILTER_SANITIZE_NUMBER_INT);
            /*$CatName = filter_var($_POST['catName'],FILTER_SANITIZE_NUMBER_INT);
            $subName = filter_var($_POST['subName'],FILTER_SANITIZE_NUMBER_INT);
            $groName = filter_var($_POST['GroName'],FILTER_SANITIZE_NUMBER_INT);*/

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
            /*$ob->check('catName',$CatName,['req','num']);
            $ob->check('subName',$subName,['req','num']);
            $ob->check('GroName',$groName,['req','num']);*/
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
                $user->insert('members','UserName,Password,avatar,Email,FullName,GroupID,Cat_ID,Sub_ID,gro_ID',"'$name','$pass','$avatar','$email','$fname','$GroupId',NULL,NULL,NULL");
                $_SESSION['username'] = $name;
                header("location:admin/index.php");
            }else{
                $bigErrors=$ob->geterrors();
                print_r($bigErrors);
                print_r($errors);
               //some edits
            }
        }



?>

<div class="container mt-5">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form" enctype="multipart/form-data">

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
                                    <option value='3'>Student</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <input type="submit" value="submit" class="sub btn btn-primary btn-lg">
                    </div>

                </form>
            </div>
            

<?php 
include "inc/templates/footer.php";
?>