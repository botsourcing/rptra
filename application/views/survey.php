<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
	<script type="text/javascript">
        $(document).on("mobileinit", function () {
            $.mobile.selectmenu.prototype.options.hidePlaceholderMenuItems = true;
        });
	</script>
</head>
<body>
	<form action="<?php base_url()?>" method="post" id=survey>
	<input type="hidden" name="0" value="<?php echo $id ?>">
	<div data-role="content">
	    <label for="textarea-1">Mainan atau fasilitas apa saja yang dibutuhkan oleh RPTRA Anda untuk meningkatkan kepuasan pengguna dan keberlangsungan kegiatan?</label>
	    <textarea cols="40" rows="8" name="1" id="1" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Bagaimana kinerja keseluruhan PKK Mart?</label>
	    <select data-native-menu="false" id="2" name="2">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Bagaimana untuk ketersediaan produk/barang di dalam PKK Mart?</label>
	    <select data-native-menu="false" id="3" name="3">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Bagaimana ketertarikan pengunjung RPTRA terhadap PKK Mart?</label>
	    <select data-native-menu="false" id="4" name="4">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Untuk kualitas pengelolaan operasional PKK Mart, bagaimana menurut Anda sebagai koordinator RPTRA?</label>
	    <select data-native-menu="false" id="5" name="5">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Untuk kawasan RPTRA Anda, siapa saja sih yang paling banyak mengunjungi RPTRA?</label>
	    <select data-native-menu="false" id="6" name="6">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Anak umur 5-7 tahun">Anak umur 5-7 tahun</option>
	        <option value="Anak umur 7-12 tahun">Anak umur 7-12 tahun</option>
	        <option value="Remaja umur 12-17 tahun">Remaja umur 12-17 tahun</option>
	        <option value="Dewasa">Dewasa</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Lebih banyak laki-laki atau perempuan?</label>
	    <select data-native-menu="false" id="7" name="7">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Laki-laki">Laki-laki</option>
	        <option value="Perempuan">Perempuan</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Berapa orang rata-rata pengunjung RPTRA per hari? </label>
	    <select data-native-menu="false" id="8" name="8">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="kurang dari 50 orang">kurang dari 50 orang</option>
	        <option value="50-150 orang">50-150 orang</option>
	        <option value="150-300 orang">150-300 orang</option>
	        <option value="300-500 orang">300-500 orang</option>
	        <option value="lebih dari 500 orang">lebih dari 500 orang</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Dari kalangan ekonomi sosial yang seperti apa yang sering mengunjungi RPTRA?</label>
	    <select data-native-menu="false" id="9" name="9">
	    	<option value="" data-placeholder="true">Klik dan Pilih</option>
	        <option value="Penghasilan jauh lebih banyak dari pemenuhan kebutuhan pokok">Penghasilan jauh lebih banyak dari pemenuhan kebutuhan pokok</option>
	        <option value="Penghasilan sedikit lebih banyak dari pemenuhan kebutuhan pokok">Penghasilan sedikit lebih banyak dari pemenuhan kebutuhan pokok</option>
	        <option value="Penghasilan sama dengan pemenuhan kebutuhan pokok">Penghasilan sama dengan pemenuhan kebutuhan pokok</option>
	        <option value="Penghasilan kurang dari pemenuhan kebutuhan pokok">Penghasilan kurang dari pemenuhan kebutuhan pokok</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Kegiatan apa yang paling sering dilakukan di RPTRA  anda?</label>
	    <textarea cols="40" rows="8" name="10" id="10" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Adakah ide kegiatan untuk diaplikasikan di RPTRA?</label>
	    <textarea cols="40" rows="8" name="11" id="11" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Menurut anda apa kelebihan yang ada pada RPTRA selama ini?</label>
	    <textarea cols="40" rows="8" name="12" id="12" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Apa hal yang masih kurang atau bisa ditingkatkan pada RPTRA saat ini?</label>
	    <textarea cols="40" rows="8" name="13" id="13" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Menurut hasil survey RPTRA anda (apabila ada) atau respon dari masyarakat, manfaat apa saja yang dirasakan dengan adanya RPTRA?</label>
	    <textarea cols="40" rows="8" name="14" id="14" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Seandainya pemberian dana untuk RPTRA dihentikan dan anda tidak digaji oleh pemda DKI lagi, kira-kira hal apa saja yang akan anda lakukan agar kegiatan operasional RPTRA tetap berjalan?</label>
	    <textarea cols="40" rows="8" name="15" id="15" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <input type="submit" name="submit" value="Kirim Survey" onclick="Submit()">
	</div>
	
	</form>

	<!-- <div data-role="content">
		<button onclick="myFunction()">Try it</button>
	</div> -->
</body>

<script type="text/javascript">
	function Submit() {
		var z = $('form').serializeArray();
		console.log(z);
	    x = confirm("Kirim survey sekarang?");
	    var jqxhr = $.post( "http://bot.sumapala.com/rptra/index.php/botinterface/thank", z )
		.done(function(data) {
		    var chat_id = $("input[name=0]").val();
		    var msg = 'Terima kasih telah mengisi survey. Silakan ketik apapun untuk memulai aktivitas';
		    $.get(
			    "https://api.telegram.org/bot551359175:AAGG6LYJON8m702RygBUXnH5kP_ddZ7qC14/sendMessage",
			    {chat_id : chat_id, text : msg},
			    function(data) {
			       	alert('Survey berhasil dikirim');
			       	window.location.href = "http://bot.sumapala.com/rptra/index.php/botinterface/thank";
			    }
			);
		})
		.fail(function(error) {
		    alert('Survey gagal disimpan. Silakan hubungi 021-14045');
		});
	    
	}
</script>