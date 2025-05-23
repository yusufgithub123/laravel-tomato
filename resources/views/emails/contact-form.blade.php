<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak Baru</title>
</head>
<body>
    <h2>Anda menerima pesan baru dari:</h2>
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Subjek:</strong> {{ $data['subject'] }}</p>
    <p><strong>Pesan:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>