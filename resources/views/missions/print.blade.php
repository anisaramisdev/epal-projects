<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mission_{{ $mission->id }}</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .company-name { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .doc-title { font-size: 24px; text-decoration: underline; margin: 20px 0; }
        
        .info-section { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .info-section td { padding: 10px; border: 1px solid #ddd; }
        .label { font-weight: bold; background-color: #f5f5f5; width: 30%; }
        
        .footer { margin-top: 50px; }
        .signature { float: right; width: 200px; text-align: center; border-top: 1px solid #000; padding-top: 5px; }
        
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; cursor: pointer; border-radius: 5px;">
            🖨️ Imprimer le Bon d'Affectation
        </button>
        <a href="{{ route('missions.index') }}" style="margin-left: 10px; text-decoration: none; color: #666;">Retour</a>
    </div>

    <div class="header">
        <div class="company-name">Entreprise Portuaire d'Alger (EPAL)</div>
        <div>Direction de la Conduite et de la Logistique (DCL)</div>
        <div class="doc-title">BON D'AFFECTATION N° {{ $mission->id }}</div>
    </div>

    <table class="info-section">
        <tr>
            <td class="label">Date de Mission</td>
            <td>{{ \Carbon\Carbon::parse($mission->date_mission)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Période (Shift)</td>
            <td style="font-weight: bold; color: #d97706;">{{ $mission->shift }}</td>
        </tr>
        <tr>
            <td class="label">Zone d'Intervention</td>
            <td style="text-transform: uppercase; font-weight: bold;">{{ $mission->zone }}</td>
        </tr>
        <tr>
            <td class="label">Destination Précise</td>
            <td>{{ $mission->destination }}</td>
        </tr>
        <tr>
            <td class="label">Engin / Matériel</td>
            <td>{{ $mission->engin->designation }} (Code: <strong>{{ $mission->engin->code }}</strong>)</td>
        </tr>
        <tr>
            <td class="label">Conducteur Affecté</td>
            <td>{{ $mission->conducteur->nom }} {{ $mission->conducteur->prenom }} (Spécialité: {{ $mission->conducteur->specialite }})</td>
        </tr>
        <tr>
            <td class="label">Instructions / Notes</td>
            <td>{{ $mission->description ?? 'Néant' }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Fait à Alger, le {{ now()->format('d/m/Y à H:i') }}</p>
        
        <div class="signature">
            Cachet et Signature DCL
        </div>
    </div>

</body>
</html>