<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<p>
		@if(Session::has("noidung"))
			{{Session::get("noidung")}}
		@endif
	</p>
</body>
</html>