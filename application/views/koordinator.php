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

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

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
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
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
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="http://bot.sumapala.com/rptra">RPTRA Dashboard System</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li><a href="http://bot.sumapala.com/rptra">Home</a></li>
		      <li class="active"><a href="http://bot.sumapala.com/rptra/index.php/welcome/koordinator">List Koordinator</a></li>
		      <!-- <li><a class='btn btn-warning' href="http://bot.sumapala.com/rptra/index.php/welcome/koordinator">List Jurnal</a></li> 
		      <li><a href="#">Page 3</a></li>-->
		    </ul>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
				    <div class="panel-body">

						<div class="row">
							<div class="col-md-4"><b>Nama Koordinator</b></div>
							<div class="col-md-3"><b>Lokasi RPTRA</b></div>
							<div class="col-md-3"><b>Area RPTRA</b></div>
							<div class="col-md-2"><b>Aksi</b></div>
						</div>
						<br>


						<?php
							foreach($koordinator as $i):
							
								$nama_koordinator=$i->KoordinatorName;
								$lokasi_rptra=$i->KoordinatorLokasi;
								$telegram = $i->KoordinatorTelegram;
								$area = $i->KoordinatorRegion;
							
						?>

						<div class="row">
							<div class="col-md-4"><?php echo $nama_koordinator;?></div>
							<div class="col-md-3"><?php echo $lokasi_rptra;?></div>
							<div class="col-md-3"><?php echo $area;?></div>
							<div class="col-md-2"><?php echo "<a href='DetailAnswer/".$telegram."'>Detail</a>"; ?></div>
						</div>

						<?php endforeach;?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
				    <div class="panel-body">
				    	<div class="form-group">
						  <label for="sel1">Pilih area yang akan disebar pesan:</label>
						  <select class="form-control" id="sel1">
						    <option value="Jakarta Utara">Jakarta Utara</option>
						    <option value="Jakarta Barat">Jakarta Barat</option>
						    <option value="Jakarta Pusat">Jakarta Pusat</option>
						    <option value="Jakarta Timur">Jakarta Timur</option>
						    <option value="Jakarta Selatan">Jakarta Selatan</option>
						  </select>
						  <br>
						  <label for="textarea1">Isi Pesan:</label>
						  <textarea class="form-control" rows="5" id="textarea1"></textarea>
						</div>
						<button class="btn-primary" onclick="Search()">Kirim</button>
					</div>
				</div>
			</div>
		</div>

		

		<div class="row">
			<br>
			<a href="<?php echo base_url().'index.php/Welcome/Home' ?>" class="btn btn-primary">Kembali ke Dashboard</a>
			<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div>
	</div>
</body>
<script type="text/javascript">
	function Search() {
	    var area = document.getElementById("sel1").value;
	    var msg = document.getElementById("textarea1").value;
		$.ajax({
		    url: "http://bot.sumapala.com/rptra/welcome/GetKoordinatorByArea/" + area,
		    type: "GET",
		    dataType: "JSON",
		    success: function(data) {
		      if (data[0] === undefined) return;
		      for (var i = data.length - 1; i >= 0; i--) {
		      	$.get(
				    "https://api.telegram.org/bot551359175:AAGG6LYJON8m702RygBUXnH5kP_ddZ7qC14/sendMessage",
				    {chat_id : data[i].Telegram, text : msg},
				    function(res) {
				    	console.log(res);
				       	console.log(res.result.chat.first_name + ' ' + res.result.chat.last_name);
				       	$('#textarea1').val('');

				       	$.notify('Berhasil dikirim ke ' + res.result.chat.first_name + ' ' + res.result.chat.last_name, "success");
				    }
				);
		      }
		      	
		      
		    }
		  });
	}

</script>
</html>