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
	<form action="form.php" method="post" id=survey>
	<div data-role="content">
	    <label for="textarea-1">Mainan atau fasilitas apa saja yang dibutuhkan oleh RPTRA Anda untuk meningkatkan kepuasan pengguna dan keberlangsungan kegiatan?</label>
	    <textarea cols="40" rows="8" name="1" id="1" placeholder="Free Text"></textarea>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Bagaimana kinerja keseluruhan PKK Mart?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Bagaimana untuk ketersediaan produk/barang di dalam PKK Mart?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Bagaimana ketertarikan pengunjung RPTRA terhadap PKK Mart?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Untuk kualitas pengelolaan operasional PKK Mart, bagaimana menurut Anda sebagai koordinator RPTRA?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Sangat Buruk">Sangat Buruk</option>
	        <option value="Buruk">Buruk</option>
	        <option value="Baik">Baik</option>
	        <option value="Sangat Baik">Sangat Baik</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Untuk kawasan RPTRA Anda, siapa saja sih yang paling banyak mengunjungi RPTRA?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Anak umur 5-7 tahun">Anak umur 5-7 tahun</option>
	        <option value="Anak umur 7-12 tahun">Anak umur 7-12 tahun</option>
	        <option value="Remaja umur 12-17 tahun">Remaja umur 12-17 tahun</option>
	        <option value="Dewasa">Dewasa</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Lebih banyak laki-laki atau perempuan?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Laki-laki">Laki-laki</option>
	        <option value="Perempuan">Perempuan</option>
	    </select>
	</div>
	<div data-role="content">
	    <label for="textarea-1">Dari kalangan ekonomi sosial yang seperti apa yang sering mengunjungi RPTRA?</label>
	    <select data-native-menu="false">
	    	<option data-placeholder="true">Klik dan Pilih</option>
	        <option value="Menengah ke bawah">Menengah ke bawah</option>
	        <option value="Menengah ke atas">Menengah ke atas</option>
	    </select>
	</div>
	
	</form>

	<div data-role="content">
		<button onclick="myFunction()">Try it</button>
	</div>
</body>

<script type="text/javascript">
	function myFunction() {
	    x = confirm("Kirim survey sekarang?");
	    if(x)
	    {
	    	//window.open('','_parent','');
        	window.close();

	    }
	}
</script>