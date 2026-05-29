@extends('layouts.app')
@section('title', 'Tableau de bord – Admin')
@section('page-title', 'Tableau de bord')

@section('content')
{{-- Stats --}}
<div class="grid grid-4" style="margin-bottom:24px;">
  <div class="stat-card orange">
    <div class="stat-icon orange"><i class="fas fa-car"></i></div>
    <div class="stat-value">{{ $stats['total_voitures'] }}</div>
    <div class="stat-label">Total voitures</div>
  </div>
  <div class="stat-card teal">
    <div class="stat-icon teal"><i class="fas fa-check-circle"></i></div>
    <div class="stat-value">{{ $stats['voitures_disponibles'] }}</div>
    <div class="stat-label">Disponibles</div>
  </div>
  <div class="stat-card purple">
    <div class="stat-icon purple"><i class="fas fa-users"></i></div>
    <div class="stat-value">{{ $stats['total_clients'] }}</div>
    <div class="stat-label">Clients inscrits</div>
  </div>
  <div class="stat-card yellow">
    <div class="stat-icon yellow"><i class="fas fa-coins"></i></div>
    <div class="stat-value">{{ number_format($stats['revenus_mois'], 0, ',', ' ') }} DT</div>
    <div class="stat-label">Revenus ce mois</div>
  </div>
</div>

<div class="grid grid-2" style="margin-bottom:24px;">
  {{-- Réservations récentes --}}
  <div class="card">
    <div class="section-header mb-0">
      <div class="card-title mb-0">Réservations récentes</div>
      <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary btn-sm">Voir tout</a>
    </div>
    <div class="divider"></div>
    <div class="table-wrapper">
      <table>
        <thead><tr><th>N°</th><th>Client</th><th>Voiture</th><th>Statut</th></tr></thead>
        <tbody>
          @forelse($reservations_recentes as $r)
          <tr>
            <td><span style="font-size:.78rem;color:var(--muted);">{{ $r->numero_reservation }}</span></td>
            <td>{{ $r->user->name }}</td>
            <td>{{ $r->voiture->marque }} {{ $r->voiture->modele }}</td>
            <td>
              <span class="badge {{ $r->getStatutBadgeClass() }}">{{ $r->statut }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:20px;">Aucune réservation</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Voitures populaires --}}
  <div class="card">
    <div class="card-title">Voitures les plus louées</div>
    @forelse($voitures_populaires as $v)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--card-border);">
      <div>
        <div style="font-weight:600;font-size:.9rem;">{{ $v->marque }} {{ $v->modele }}</div>
        <div style="font-size:.78rem;color:var(--muted);">{{ $v->categorie }} · {{ $v->prix_par_jour }} DT/j</div>
      </div>
      <span class="badge badge-info">{{ $v->reservations_count }} locations</span>
    </div>
    @empty
    <p style="color:var(--muted);text-align:center;padding:20px 0;">Aucune donnée</p>
    @endforelse
  </div>
</div>

{{-- Revenus mensuels --}}
<div class="card">
  <div class="card-title">Revenus des 6 derniers mois</div>
  <div style="display:flex;align-items:flex-end;gap:12px;height:160px;padding-top:10px;">
    @php $max = max(array_column($revenus_mensuels, 'revenu')) ?: 1; @endphp
    @foreach($revenus_mensuels as $m)
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
      <div style="font-size:.72rem;color:var(--muted);">{{ number_format($m['revenu'],0,'','') }}</div>
      <div style="width:100%;background:linear-gradient(180deg,var(--grad-1),var(--accent-2));border-radius:6px 6px 0 0;height:{{ max(4, ($m['revenu']/$max)*120) }}px;"></div>
      <div style="font-size:.7rem;color:var(--muted);white-space:nowrap;">{{ $m['mois'] }}</div>
    </div>
    @endforeach
  </div>
</div>
@endsection
