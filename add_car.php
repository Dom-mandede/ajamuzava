<?php 
include('Conexao.php');
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$cor = $_POST['cor'];
$chassi= $_POST['chassi'];
$matricula= $_POST['matricula'];

$sql = "INSERT INTO `carros` (`marca`,`modelo`,`cor`,`chassi`, `matricula`) values ('$marca', '$modelo', '$cor', '$chassi', '$matricula' )";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>