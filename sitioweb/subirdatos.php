<?php
  session_start();
  
  if ($_SESSION['nivel']==""){
    header ("Location: index.php");
  }
  
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>TELCEL EVONET</title>
	<link href="css/evonetcss.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    .archivo{
      font-size: 12px;
    }
    
    .archivo h1{
      text-align: center;
      font-size: 24px;
      color: #0d6e0d;
    }
    
    .archivo label{
      color: #F00;
      display: block;
      margin: 10px 5px;
    }

    input[type="file"] {
      z-index: -1;
      color: rgb(153,153,153);
    }

    input[type="submit"] {
      display: block;
      margin: 15px 0;
    }

    select {
      display: block;
      margin: 15px 0;
    }
  </style>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/custom.js"></script>
  <script>
    var op=0;
    function _(el) {
      return document.getElementById(el);
    }

    function uploadFile(arch,destino,param) {
      op = param;
      if (op==5){
        destino = destino + "?evonetiktan="+document.getElementById("evonetiktan").value;
        destino = destino + "&tiporeporte="+document.getElementById("tiporeporte").value;
      }
      var file = _(arch).files[0];
      // alert(file.name+" | "+file.size+" | "+file.type);
      var formdata = new FormData();
      formdata.append(arch, file);
      var ajax = new XMLHttpRequest();
      ajax.upload.addEventListener("progress", progressHandler, false);
      ajax.addEventListener("load", completeHandler, false);
      ajax.addEventListener("error", errorHandler, false);
      ajax.addEventListener("abort", abortHandler, false);
      ajax.open("POST", destino); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
      //use file_upload_parser.php from above url
      ajax.send(formdata);
    }

    function progressHandler(event) {
      var progressBar = "progressBar" + op.toString();
      var status = "status" + op.toString();
      var loaded_n_total = "loaded_n_total" + op.toString();
      // _(loaded_n_total).innerHTML = "<p>Subiendo " + event.loaded + " bytes de " + event.total + "</p>";
      var percent = (event.loaded / event.total) * 100;
      _(progressBar).value = Math.round(percent);
      _(status).innerHTML = "<p>" + Math.round(percent) + "% avance... por favor espere</p>";
    }

    function completeHandler(event) {
      var progressBar = "progressBar" + op.toString();
      var status = "status" + op.toString();
      _(status).innerHTML = event.target.responseText;
      _(progressBar).value = 0; //wil clear progress bar after successful upload
    }

    function errorHandler(event) {
      var status = "status" + op.toString();
      _(status).innerHTML = "Fallo al subir archivo";
    }

    function abortHandler(event) {
      var status = "status" + op.toString();
      _(status).innerHTML = "Subida cancelada";
    }
  </script>

</head>
	
<body>

<div class="w3-container w3-green">
  <?php
    echo '<h1>Trabajando con: '.$_SESSION['instancia'].'</h1>';
    echo '<p>Usuario: '.$_SESSION['usuario'].'</p>';
  ?>
</div>


<div class="w3-row-padding">
  <div class="w3-third caja">
    <form id="frmiccid" name="frmiccid" enctype="multipart/form-data" method="post" action="registra_chips.php?id=1">
      <div class="archivo">
          <h1>Catalogo ICCID</h1>
          <label for="titulo">Archivo ICCID .xlsx Columnas (iccid18, iccid19, factura, fecha_compra)</label>
          <input name="iccid" type="file" id="iccid" accept=".xlsx" onchange="uploadFile('iccid','registra_chips.php?id=1',1)">
          <progress id="progressBar1" value="0" max="100" style="width:300px;"></progress>
          <p id="status1"></p>
          <!-- <p id="loaded_n_total1"></p> -->
      </div>
    </form>
  </div>

  <div class="w3-third caja">
    <form id="frmfamilia" name="frmfamilia" enctype="multipart/form-data" method="post" action="registra_familias.php?id=2">
      <div class="archivo">
        <h1>Nodos venta ICCID</h1>
        <label for="titulo">Archivo FAMILIAS .xlsx Columnas (Nombre, Usuario, Jearquía) **Archivo ordenado ascendente por columna Jerarquía</label>
        <input name="familias" type="file" id="familias" accept=".xlsx" onchange="uploadFile('familias','registra_familias.php?id=2',2)">
        <progress id="progressBar2" value="0" max="100" style="width:300px;"></progress>
        <p id="status2"><br />
        <!-- <p id="loaded_n_total2"></p> -->
      </div>
    </form>
  </div>

  <div class="w3-third caja">
    <form id="frmactivaciones" name="frmactivaciones" enctype="multipart/form-data" method="post" action="reg_preactivaciones.php">
      <div class="archivo">
        <h1>Preactivaciones ICCID</h1>
        <label for="titulo">Reporte pre activaciones .xlsx Columnas (Número telefónico, ICCID18, Producto cargado, Fecha de carga, Fecha activación, Estado de SIM)</label>
        <input name="activaciones" type="file" id="activaciones" accept=".xlsx" onchange="uploadFile('activaciones','reg_preactivaciones.php',3)">
        <progress id="progressBar3" value="0" max="100" style="width:300px;"></progress>
        <p id="status3"></p>
      </div>
    </form>
  </div>
</div>

<div class="w3-row-padding">
  <div class="w3-third caja">
    <form id="frmorigdestino" name="frmorigdestino" enctype="multipart/form-data" method="post" action="activ_orig_dest.php">
      <div class="archivo">
        <h1>Activaciones Diarias</h1>
        <label for="titulo">Reporte activaciones .xlsx Columnas(Fecha,Hora,Origen,Destino)</label>
        <input name="activaorigdest" type="file" id="activaorigdest" accept=".xlsx" onchange="uploadFile('activaorigdest','activ_orig_dest.php',4)">
        <progress id="progressBar4" value="0" max="100" style="width:300px;"></progress>
        <p id="status4"></p>
      </div>
    </form>
  </div>

  <div class="w3-third caja">
    <form id="frmrepeval" name="frmrepeval" enctype="multipart/form-data" method="post" action="reg_reporteeval.php">
      <div class="archivo">
        <h1>Reportes</h1>
		    <label for="evonetiktan">Análisis Reportes Evaluación .xlsx Columnas(fza_vta, fza_padre, clave_reporte, concepto, periodo_evaluación, plan,  semana, celular, serie, iccid, fecha_acti, comentario, tipo_de_tramite)</label>
        <label for="tiporeporte" style="float: left;">Reporte</label>
        <select name="evonetiktan" id="evonetiktan" style="float: left;">
            <option value="1">Evonet</option>
            <option value="2">IKTAN</option>
        </select>
        <label for="tiporeporte" style="float: left;">Reporte</label>
        <select name="tiporeporte" id="tiporeporte" style="float: left;">
            <option value="1">30 días</option>
            <option value="2">60 días</option>
            <option value="3">90 días</option>
            <option value="4">120 días</option>
        </select>
		    <input name="repeval" type="file" id="repeval" accept=".xlsx" onchange="uploadFile('repeval','reg_reporteeval.php',5)">
        <progress id="progressBar5" value="0" max="100" style="width:300px;"></progress>
        <p id="status5"></p>
      </div>
    </form>
  </div>

  <div class="w3-third caja">
      <div class="archivo">
        <h1>Regresar</h1>
        <p style="text-align: center;"><a href="pcontrol.php"><img src="imgs/regresar.jpg" alt="Evonet" /></a></p>
      </div>
  </div>
</div>
	

</body>
</html>
