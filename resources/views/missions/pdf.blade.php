<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport EPAL</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #1a5c8a; }
    </style>
</head>
<body>
    <h1>EPAL - État des Missions</h1>
    <p>Généré le : {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Engin</th>
                <th>Conducteur</th>
                <th>Destination</th>
            </tr>
        </thead>
        <tbody>
            @foreach($missions as $m)
                <tr>
                    <td>{{ $m->date_mission }}</td>
                    <td>{{ $m->engin->code }}</td>
                    <td>{{ $m->conducteur->nom }} {{ $m->conducteur->prenom }}</td>
                    <td>{{ $m->destination }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>