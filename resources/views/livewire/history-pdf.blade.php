<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Historique des visites</title>
    <style>
        body{font-family:Arial,sans-serif;font-size:12px;color:#111827}
        h1{font-size:20px;margin:0 0 6px}
        .meta{color:#6b7280;margin-bottom:18px}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #d1d5db;padding:8px;vertical-align:top;text-align:left}
        th{background:#111827;color:#fff}
    </style>
</head>
<body>
    <h1>Historique des visites</h1>
    <div class="meta">Généré le {{ $generatedAt->format('d/m/Y H:i') }}</div>
    <table>
        <thead>
            <tr>
                <th>Visiteur</th>
                <th>Société</th>
                <th>Hôte</th>
                <th>Service</th>
                <th>Date entrée</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    <td>{{ trim(($row->firstname ?? '') . ' ' . ($row->lastname ?? '')) }}</td>
                    <td>{{ $row->org_name ?? '' }}</td>
                    <td>{{ $row->emp_visited ?? '' }}</td>
                    <td>{{ $row->service_name ?? '' }}</td>
                    <td>{{ $row->entry_date ?? '' }}</td>
                    <td>
                        @switch((string) ($row->status ?? ''))
                            @case('0') En attente @break
                            @case('1') En cours @break
                            @case('2') Terminée @break
                            @default Inconnu
                        @endswitch
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucun résultat</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
