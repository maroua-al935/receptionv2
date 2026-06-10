<div><style>
    .history-page{max-width:1200px;margin:0 auto;padding:24px}
    .history-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin:24px 0}
    .history-card,.history-panel{background:#fff;border:1px solid #e2ddd5;border-radius:12px;box-shadow:0 4px 20px rgba(15,30,53,.08)}
    .history-card{padding:18px}
    .history-value{display:block;font-size:1.8rem;font-weight:700;color:#0f1e35}
    .history-label{color:#6b6b80;font-size:.8rem}
    .search-card{display:flex;flex-wrap:wrap;gap:12px;align-items:center;padding:18px 20px;margin-bottom:24px}
    .search-card input,.search-card select,.search-card button{border:1px solid #e2ddd5;border-radius:8px;padding:10px 12px;font:inherit}
    .search-card input,.search-card select{background:#f8f5ef}
    .search-card input{min-width:220px}
    .search-card select{min-width:180px}
    .date-picker{display:flex;align-items:center;gap:10px}
    .date-trigger{cursor:pointer;background:#f8f5ef}
    .date-native{min-width:220px}
    .results-table{width:100%;border-collapse:collapse}
    .results-table th,.results-table td{padding:14px 16px;border-bottom:1px solid #e2ddd5;text-align:left;vertical-align:middle}
    .results-table thead{background:#0f1e35;color:#fff}
    .badge{display:inline-flex;padding:4px 10px;border-radius:999px;font-size:.72rem;font-weight:700}
    .badge.pending{background:#fef3dc;color:#92600a}
    .badge.active{background:#e8f5ee;color:#1a7a4a}
    .badge.done{background:#ebebf0;color:#4a4a5a}
    .empty-state{padding:42px 16px;text-align:center;color:#6b6b80}
</style>

<div class="history-page">
    <div class="history-stats">
        <div class="history-card"><span class="history-value">{{ $totalVisits ?? 0 }}</span><span class="history-label">Visites totales</span></div>
        <div class="history-card"><span class="history-value">{{ $todayVisits ?? 0 }}</span><span class="history-label">Aujourd'hui</span></div>
        <div class="history-card"><span class="history-value">{{ $companiesCount ?? 0 }}</span><span class="history-label">Sociétés</span></div>
        <div class="history-card"><span class="history-value">{{ $activeVisitors ?? 0 }}</span><span class="history-label">Présents</span></div>
    </div>

    <div class="history-panel search-card">
        <span class="search-label">Recherche par</span>
        <select wire:model.live="cat">
            <option value="1">Nom & Prénom</option>
            <option value="2">Société</option>
            <option value="4">Permis minier</option>
            <option value="3">Date</option>
        </select>

        @if($cat == '3')
            <div id="date_input" class="date-picker">
                <input type="date" 
       class="date-native" 
       wire:model.live="date" 
       wire:change="search">
            </div>
        @else
            <div id="search_box">
                <input type="text" placeholder="Rechercher..." wire:model.live.debounce.500ms="query" wire:keydown.enter.prevent="search">
            </div>
        @endif

        <select wire:model.live="status">
            <option value="">Tous les statuts</option>
            <option value="0">En attente</option>
            <option value="1">En cours</option>
            <option value="2">Terminée</option>
        </select>

        <button type="button" wire:click="search">Rechercher</button>
        <button type="button" wire:click="exportExcel">Exporter Excel</button>
        <button type="button" wire:click="exportPDF">Exporter PDF</button>
    </div>

    @if(!empty($results) && $results->isNotEmpty())
        <div class="history-panel">
            <table class="results-table" aria-label="Liste des visites">
                <thead>
                    <tr>
                        <th>Visiteur</th>
                        <th>Hôte</th>
                        <th>Date d'entrée</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $row)
                        <tr>
                            <td>
                                <div>{{ $row->firstname }} {{ $row->lastname }}</div>
                                <div class="history-label">{{ $row->org_name }}</div>
                            </td>
                            <td>
                                <div>{{ $row->emp_visited }}</div>
                                <div class="history-label">{{ $row->service_name ?? $row->ant_name ?? '' }}</div>
                            </td>
                            <td>{{ to_normal_date($row->entry_date) }}</td>
                            <td>
                                @switch($row->status)
                                    @case(0)
                                        <span class="badge pending">En attente</span>
                                        @break
                                    @case(1)
                                        <span class="badge active">En cours</span>
                                        @break
                                    @case(2)
                                        <span class="badge done">Terminée</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('i_ant_p_info', $row->id) }}">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($noresults)
        <div class="history-panel empty-state">Aucun résultat.</div>
    @endif
</div>
</div>