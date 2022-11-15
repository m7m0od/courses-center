<?php
$pageTitle='Home';
include "init.php";
$ob = new dataConnection();
$members=$ob->threeJoin('members.*,categories.Name AS CATNAME,categories.Description AS description,subjects.Name AS SUBNAME,groups.Name AS GRONAME,groups.Date,groups.ID AS GROID','members','categories','categories.ID = members.Cat_ID','subjects','subjects.ID = members.Sub_ID','groups','groups.ID = members.gro_ID','','','ORDER BY gro_ID ASC');
?>

<div class="container mt-5">
    <div class="row">

    <?php
        foreach($members as $mem){
    ?>
        <div class="col-md-4 first">
            <div class="designIndex">
                <img src="admin/uploads/<?php echo $mem['avatar'];?>" class="ProfileImg img-fluid">
                <span><?php echo $mem['SUBNAME'];?></span>
                <p><?php echo $mem['GRONAME'];?></p>
                <p><?php echo $mem['Date'];?></p>
                <div class="son">
					<h2 class="mahmoud"><?php echo $mem['FullName'];?></h2>
					<p class="par"><?php echo $mem['description'] ."<br>";?><a class="btn btn-info" href='booking.php?id="<?php echo str_replace(" ","",$mem['GROID']) ?>"'>book</a></p>
				</div>
            </div>
        </div>
        <?php } ?>
        

    </div>
</div>

<?php
include "inc/templates/footer.php";
?>