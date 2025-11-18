<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuw contactbericht</title>
</head>
<body>
<h2>Nieuw bericht via het contactformulier</h2>

<p><strong>Naam:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Onderwerp:</strong> {{ $subject }}</p>

<h3>Bericht</h3>
<p>{!! nl2br(e($body)) !!}</p>
</body>
</html>
