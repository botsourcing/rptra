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
	<div data-role="content">
	    <label for="textarea-1">Terima kasih telah melakukan survey, silakan tutup browser untuk kembali ke Tiny Bot</label>
	</div>
</body>