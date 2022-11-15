<?php
/*
$ob = new dataConnection();
$id=$_POST['firstId'];
$result = $ob->oneJoin('subjects.*,categories.Name','subjects','categories','categories.ID = subjects.Cat_ID',"WHERE Cat_ID = '$id'",NULL,'');
foreach($result as $res)
{
    echo "<option value='" . $res['ID'] ."'>" . $res['Name'] . "</option>";
}
*/

/*
$connect = mysqli_connect("localhost","root","","center");
$output = '';
$sql = "SELECT * FROM subjects WHERE Cat_ID = '".$_POST['firstId']."' ORDER BY Name";
$result = mysqli_query($connect,$sql);
$output = '<option value="">Select Sub</option>';
while($row = mysqli_fetch_array($result))
{
    $output .= '<option value="'.$row["ID"].'">'.$row["Name"].'</option>';
}

echo $output;
*/

/*  this

if(isset($_POST['fir'])){
    //include "connect.php";
    $ob = new dataConnection();
    $id=$_POST['fir'];
    $result = $ob->oneJoin('subjects.*,categories.ID','subjects','categories','categories.ID = subjects.Cat_ID',"WHERE Cat_ID = '$id'",NULL,'');
    foreach($result as $res)
    {
        echo "<option value='" . $res['ID'] ."'>" . $res['Name'] . "</option>";
    }
}
*/
?>