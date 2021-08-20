<!DOCTYPE html>
<html>
<head>
	<title>JS Plug</title>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-plugin.js"></script>
</head>
<body>

<script type="text/javascript">
$(function(){
	// Bir satırdan veri alır
	$.MySQL("fetch",{
		table: "tablo1",
		where: {
			id : 1
		}, finis: function(res){
			$("#consol").append(res);
		}
	});

	// Basit sorgu gönderir
	$.MySQL("query",{
		table: "tablo1",
		where: {
			bilesen1 : "veri 1",
			id: 1
		}, finis: function(res){
			$("#consol").append(res);
		}
	});
	
	// Yeni satır ekler
	$.MySQL("add",{
		table: "tablo1",
		data: {
			bilesen1: "veri 1",
			bilesen2: "veri 2"
		}, finis: function(res){
			$("#consol").append(res);
		}
	});

	// Satır günceller
	$.MySQL("update",{
		table: "tablo1",
		data: {
			bilesen1: "UPDATE 1",
			bilesen2: "UPDATE 2"
		},where: {
			id: 1
		}, finis: function(res){
			$("#consol").append(res);
		}
	});

	// Satır Siler
	$.MySQL("delete",{
		table: "tablo1",
		where: {
			id: 1
		}, finis: function(res){
			$("#consol").append(res);
		}
	});
});
</script>
<pre>
	<div id="consol"></div>
</pre>
</body>
</html>