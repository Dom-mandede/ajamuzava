<?php include('Conexao.php');?>
<!doctype html>
<html lang="pt-br">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.css"/>
  <title>Ajax</title>
  <style type="text/css">
    .btnAdd {
      text-align: right;
      width: 83%;
      margin-bottom: 20px;
    }

    
  </style>
</head>
<body>
  <div class="container-fluid">
    <h2 class="text-center">Parque Ajax</h2>
    <p class="datatable design text-center"></p>
    <div class="row">
      <div class="container">
        <div class="btnAdd">
         <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addCarModal"   class="btn btn-success btn-sm" >Adicionar Veiculo</a>
       </div>
       <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <table id="example" class="table">
          <thead>
          <th>id</th>
            <th>Marca</th>  
            <th>Modelo</th>
            <th>Cor</th>
            <th>Chassi</th>
            <th>Matricula</th>
            <th>Opcoes</th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
</div>
</div>
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.js"></script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
          $(nRow).attr('id', aData[0]);
        },
        'serverSide':'true',
        'processing':'true',
        'paging':'true',
        'order':[],
        'ajax': {
          'url':'fetch.php',
          'type':'post',
        },
        "columnDefs": [{
          'target':[5],
          'orderable' :false,
        }]
      });
    } );
    $(document).on('submit','#addC',function(e){
      e.preventDefault();
        
        var marca = $('#addmarca').val();
        var modelo = $('#addmodelo').val();
        var cor = $('#addcor').val();
        var chassi = $('#addchassi').val();
        var matricula = $('#addmatricula').val();
        
      if(marca!='')
      {
       $.ajax({
         url:"add_car.php",
         type:"post",
         data:{marca:marca,modelo:modelo,cor:cor,chassi:chassi, matricula:matricula},
         success:function(data)
         {
           var json = JSON.parse(data);
           var status = json.status;
           if(status=='true')
           {
            mytable =$('#example').DataTable();
            mytable.draw();
            $('#addCarModal').modal('hide');
          }
          else
          {
            alert('falha');
          }
        }
      });
     }
     else {
      alert('Preencha os Campos Vazios');
    }
  });
    $(document).on('submit','#updateCar',function(e){
      e.preventDefault();
       //alert("Executa, mas qual eh o problema ja???");
       
        var marca = $('#marca').val();
        var modelo = $('#modelo').val();
        var cor = $('#cor').val();
        var chassi = $('#chassi').val();
        var matricula = $('#matricula').val();
        var trid= $('#trid').val();
        var id = $('#id').val();
        if(marca!= '' )
       {
         $.ajax({
           url:"update_car.php",
           type:"post",
           data:{marca:marca,modelo:modelo,cor:cor,chassi:chassi, matricula:matricula},
           success:function(data)
           {
             var json = JSON.parse(data);
             var status = json.status;
             if(status=='true')
             {
              table =$('#example').DataTable();              
              var button =   '<td><a href="javascript:void();" data-id="' +id + '" class="btn btn-info btn-sm editbtn">Editar</a>  <a href="#!"  data-id="' +id + '"  class="btn btn-danger btn-sm deleteBtn">Excluir</a></td>';
              var row = table.row("[id='"+trid+"']");
              row.row("[id='" + trid + "']").data([id,marca,modelo,cor,chassi,matricula]);
              $('#exampleModal').modal('hide');
            }
            else
            {
              alert('failed');
            }
          }
        });
        $('#exampleModal').modal('close');
       }
       else {
        alert('Preencha os Campos Vazios');
      }
    });
    $('#example').on('click','.editbtn ',function(event){
      var table = $('#example').DataTable();
      var trid = $(this).closest('tr').attr('id');
     
     var id = $(this).data('id');
     $('#exampleModal').modal('show');

     $.ajax({
      url:"get_single_data.php",
      data:{id:id},
      type:'post',
      success:function(data)
      {
       var json = JSON.parse(data);
       $('#marca').val(json.marca);
       $('#modelo').val(json.modelo);
       $('#cor').val(json.cor);
       $('#chassi').val(json.chassi);
       $('#matricula').val(json.matricula);
       $('#id').val(id);
       $('#trid').val(trid);
     }
   })
   });

    $(document).on('click','.deleteBtn',function(event){
       var table = $('#example').DataTable();
      event.preventDefault();
      var id = $(this).data('id');
      if(confirm("Tem Certeza Que Pretende Eliminar? "))
      {
      $.ajax({
        url:"delete_car.php",
        data:{id:id},
        type:"post",
        success:function(data)
        {
          var json = JSON.parse(data);
          status = json.status;
          if(status=='success')
          {
            
             $("#"+id).closest('tr').remove();
          }
          else
          {
            alert('Falha');
            return;
          }
        }
      });
      }
      else
      {
        return null;
      }



    })
 </script>
 <!-- Edit Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Dados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateCar" >
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="trid" id="trid" value="">
          <div class="mb-3 row">
          <label for="marca" class="col-md-3 form-label">Marca</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="marca" name="marcaNe" >
            </div>
          </div>
          <div class="mb-3 row">
            <label for="modelo" class="col-md-3 form-label">Modelo</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="modelo" name="modeloNe">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="cor" class="col-md-3 form-label">Cor</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="cor" name="corNe">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="chassi" class="col-md-3 form-label">Chassi</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="chassi" name="chassiNe">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="matricula" class="col-md-3 form-label">Matricula</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="matricula" name="matriculaNe">
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Carro Modal -->
<div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Carro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addC" action="">
          <div class="mb-3 row">
          <label for="marca" class="col-md-3 form-label">Marca</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="addmarca" name="marcaN" >
            </div>
          </div>
          <div class="mb-3 row">
            <label for="modelo" class="col-md-3 form-label">Modelo</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="addmodelo" name="modeloN">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="cor" class="col-md-3 form-label">Cor</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="addcor" name="corN">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="chassi" class="col-md-3 form-label">Chassi</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="addchassi" name="chassiN">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="matricula" class="col-md-3 form-label">Matricula</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="addmatricula" name="matriculaN">
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script type="text/javascript">
  
</script>
