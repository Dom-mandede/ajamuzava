<?php 
include('Conexao.php');
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$cor = $_POST['cor'];
$chassi= $_POST['chassi'];
$matricula= $_POST['matricula'];

$sql = "UPDATE `carros` SET  `marca`='$marca' , `modelo`= '$modelo', `cor`='$cor',  `chassi`='$chassi', `matricula`='$matricula' WHERE id='$id' ";
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