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
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/chart.min.js'?>"></script>
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
		<h3>Detail Survey Koordinator</h3>
		<br>
		<div class="row">
			<div class="col-md-6">
				
				<p><b>Mainan atau fasilitas apa saja yang dibutuhkan oleh RPTRA Anda untuk meningkatkan kepuasan pengguna dan keberlangsungan kegiatan?</b><p>
				<p><i><?php echo $answer[0]->Answer; ?></i><p>

				<br>
				<p><b>Bagaimana kinerja keseluruhan PKK Mart?</b><p>
				<p><i><?php echo $answer[1]->Answer; ?></i><p>

				<br>
				<p><b>Bagaimana untuk ketersediaan produk/barang di dalam PKK Mart?</b><p>
				<p><i><?php echo $answer[2]->Answer; ?></i><p>

				<br>
				<p><b>Bagaimana ketertarikan pengunjung RPTRA terhadap PKK Mart?</b><p>
				<p><i><?php echo $answer[3]->Answer; ?></i><p>

				<br>
				<p><b>Untuk kualitas pengelolaan operasional PKK Mart, bagaimana menurut Anda sebagai koordinator RPTRA?</b><p>
				<p><i><?php echo $answer[4]->Answer; ?></i><p>

				<br>
				<p><b>Untuk kawasan RPTRA Anda, siapa saja sih yang paling banyak mengunjungi RPTRA?</b><p>
				<p><i><?php echo $answer[5]->Answer; ?></i><p>

				<br>
				<p><b>Lebih banyak laki-laki atau perempuan?</b><p>
				<p><i><?php echo $answer[6]->Answer; ?></i><p>

				<br>
				<p><b>Dari kalangan ekonomi sosial yang seperti apa yang sering mengunjungi RPTRA?</b><p>
				<p><i><?php echo $answer[7]->Answer; ?></i><p>

				<br>
				<p><b>Apa saja 3 kegiatan yang paling sering dilakukan di RPTRA?</b><p>
				<p><i><?php echo $answer[8]->Answer; ?></i><p>

				<br>
				<p><b>Lalu 3 kegiatan apa yang paling digemari pengunjung?</b><p>
				<p><i><?php echo $answer[9]->Answer; ?></i><p>

				<br>
				<p><b>Menurut hasil survey RPTRA Anda (apabila ada) atau respon dari masyarakat, manfaat apa saja yang dirasakan dengan adanya RPTRA?</b><p>
				<p><i><?php echo $answer[10]->Answer; ?></i><p>

				<br>
				<p><b>Seandainya pemberian dana untuk RPTRA dihentikan dan Anda tidak digaji oleh pemda DKI lagi, kira-kira hal apa saja yang akan Anda lakukan agar kegiatan operasional RPTRA tetap berjalan?</b><p>
				<p><i><?php echo $answer[11]->Answer; ?></i><p>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				    <div class="panel-body">
				    	<p><?php echo $koordinator[0]->KoordinatorName; ?></p>
				    	<p><?php echo $koordinator[0]->KoordinatorLokasi; ?></p>

				    	<div class="form-group">
						  <label for="comment">Pesan:</label>
						  <input id="tid" type="hidden" name="" value="<?php echo $koordinator[0]->KoordinatorTelegram; ?>">
						  <textarea class="form-control" rows="5" id="comment"></textarea>
						</div>
				    	<button class="btn-success" onclick="myFunction()">Kirim</button>
				    </div>
				 </div>
				 <div class="panel panel-default">
				    <div class="panel-body">

						<div class="row">
							<div class="col-md-6"><b>Tanggal Jurnal</b></div>
							<div class="col-md-6"><b>Isi Jurnal</b></div>
						</div>
						<br>


						<?php
							foreach($jurnal as $i):
							
								$tanggal_jurnal=$i->JurnalTimeStamp;
								$desc_jurnal=$i->JurnalDesc;
								$telegram = $i->JurnalKoordinatorTelegram;
							
						?>

						<div class="row">
							<div class="col-md-6"><?php echo $tanggal_jurnal;?></div>
							<div class="col-md-6"><?php echo $desc_jurnal;?></div>
						</div>

						<?php endforeach;?>
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
	function myFunction() {
    var tid = document.getElementById("tid").value;
    var msg = document.getElementById("comment").value;
    $.get(
	    "https://api.telegram.org/bot551359175:AAGG6LYJON8m702RygBUXnH5kP_ddZ7qC14/sendMessage",
	    {chat_id : tid, text : msg},
	    function(data) {
	       	alert('Pesan berhasil dikirim');
	       	$('#comment').val('');
	       	$('#tid').val('');
	    }
	);
}

</script>
</html>