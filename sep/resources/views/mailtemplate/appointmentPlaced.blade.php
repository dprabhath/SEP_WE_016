<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
	<h1>Dear {{$name}}</h1>
	<h2>Information about your appointment with Dr {{$dName}}</h1>
	<p>Date : {{$Date}}
	</p>
	<p>Time : {{$Time}}
	</p>
	<p>Place : {{$doctor->address}}
	</p>
	<p>Doctor's Phone No : {{$doctor->phone}}
	</p>
	<p>Code : {{$code}}
</body>
</html>