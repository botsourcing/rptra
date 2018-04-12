<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>RPTRA Dashboard Management</title>
	<link rel="icon" href="http://bot.sumapala.com/vkms/assets/headset.png" type="image/png">
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
	<script src="<?php echo base_url('assets/bootstrap/js/jQuery-2.1.4.min.js');?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		/*margin: 40px;*/
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 10px 0;
		padding: 10px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 0px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	<?php echo $map['js']; ?>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/chart.min.js'?>"></script>
</head>
<body>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="http://bot.sumapala.com/rptra">RPTRA Dashboard System</a>
	    </div>
	    <ul class="nav navbar-nav">
	      <li class="active"><a href="http://bot.sumapala.com/rptra">Home</a></li>
	      <li><a href="http://bot.sumapala.com/rptra/index.php/welcome/koordinator">List Koordinator</a></li>
	      <!-- <li><a class='btn btn-warning' href="http://bot.sumapala.com/rptra/index.php/welcome/koordinator">List Jurnal</a></li> 
	      <li><a href="#">Page 3</a></li>-->
	    </ul>
	  </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				Klik pin dan nama untuk melihat detail
				<?php echo $map['html']; ?>
			</div>
			<div class="col-md-6">
				<button class="btn btn-primary" style="width: 100%;" href="#chart_div" role="button" aria-expanded="false" aria-controls="collapseExample">Kinerja PKK Mart</button>
				<div id="kinerja_div"></div> 
				<button class="btn btn-primary" style="width: 100%;" href="#chart_div" role="button" aria-expanded="false" aria-controls="collapseExample">Ketersediaan Produk dan Barang PKK Mart</button>
				<div id="sediaan_div"></div> 
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<button class="btn btn-primary" style="width: 100%;" href="#chart_div" role="button" aria-expanded="false" aria-controls="collapseExample">Daya Tarik RPTRA ke PKK Mart</button>
				<div id="kunjung_div"></div>
			</div>
			<div class="col-md-6">
				 
				<button class="btn btn-primary" style="width: 100%;" href="#chart_div" role="button" aria-expanded="false" aria-controls="collapseExample">Kualitas Pengelolaan Operasional PKK Mart</button>
				<div id="operasional_div"></div> 
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<button class="btn btn-primary" style="width: 100%;" href="#chart_div" role="button" aria-expanded="false" aria-controls="collapseExample">Usia Pengunjung PKK Mart</button>
				<div id="usia_div"></div>
			</div>
			<div class="col-md-6">
				 
				<button class="btn btn-primary" style="width: 100%;" href="#chart_div" role="button" aria-expanded="false" aria-controls="collapseExample">Jenis Kelamin Pengunjung PKK Mart</button>
				<div id="sex_div"></div> 
			</div>
		</div>
		<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>

		<h2>
		<div class="container">
			
		</div>
	</div>
</body>
<script type="text/javascript"> 
     
    // Load the Visualization API and the piechart package. 
    google.charts.load('current', {'packages':['corechart']}); 
       
    // Set a callback to run when the Google Visualization API is loaded. 
    google.charts.setOnLoadCallback(drawChart); 
       
    function drawChart() { 
      var kinerja_div = $.ajax({ 
          url: "<?php echo base_url() . 'index.php/Welcome/getQuestionById/2' ?>", 
          dataType: "json", 
          async: false 
          }).responseText;

      var sediaan_div = $.ajax({ 
          url: "<?php echo base_url() . 'index.php/Welcome/getQuestionById/3' ?>", 
          dataType: "json", 
          async: false 
          }).responseText;

      var kunjung_div = $.ajax({ 
          url: "<?php echo base_url() . 'index.php/Welcome/getQuestionById/4' ?>", 
          dataType: "json", 
          async: false 
          }).responseText;

      var operasional_div = $.ajax({ 
          url: "<?php echo base_url() . 'index.php/Welcome/getQuestionById/5' ?>", 
          dataType: "json", 
          async: false 
          }).responseText;

      var usia_div = $.ajax({ 
          url: "<?php echo base_url() . 'index.php/Welcome/getQuestionById/6' ?>", 
          dataType: "json", 
          async: false 
          }).responseText;

      var sex_div = $.ajax({ 
          url: "<?php echo base_url() . 'index.php/Welcome/getQuestionById/7' ?>", 
          dataType: "json", 
          async: false 
          }).responseText;

           
      // Create our data table out of JSON data loaded from server. 
      var data = new google.visualization.DataTable(kinerja_div); 
 	  var data2 = new google.visualization.DataTable(sediaan_div);
 	  var data3 = new google.visualization.DataTable(kunjung_div); 
 	  var data4 = new google.visualization.DataTable(operasional_div); 
 	  var data5 = new google.visualization.DataTable(usia_div); 
 	  var data6 = new google.visualization.DataTable(sex_div); 

      // Instantiate and draw our chart, passing in some options. 
      var chart = new google.visualization.PieChart(document.getElementById('kinerja_div')); 
      chart.draw(data, {width: 500, height: 200}); 

      var chart2 = new google.visualization.PieChart(document.getElementById('sediaan_div')); 
      chart2.draw(data2, {width: 500, height: 200});

      var chart3 = new google.visualization.PieChart(document.getElementById('kunjung_div')); 
      chart3.draw(data3, {width: 500, height: 200});

      var chart4 = new google.visualization.PieChart(document.getElementById('operasional_div')); 
      chart4.draw(data4, {width: 500, height: 200});

      var chart5 = new google.visualization.PieChart(document.getElementById('usia_div')); 
      chart5.draw(data5, {width: 500, height: 200});

      var chart6 = new google.visualization.PieChart(document.getElementById('sex_div')); 
      chart6.draw(data6, {width: 500, height: 200}); 
    } 
    </script> 
</html>