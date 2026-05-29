@extends('layouts.app')
@section('title','Réservations – Admin')
@section('page-title','Gestion des réservations')
@section('content')
<div class="section-header">
  <div>
    <div class="section-title">Réservations</div>
    <div style="color:var(--muted);font-size:.85rem;margin-top:2px;">{{ $reservations->total() }} réservation(s)</div>
  </div>
  <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle</a>
</div>
<div class="card" style="margin-bottom:20px;">
  <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div style="flex:1;min-width:200px;"><label class="form-label">Recherche</label><input type="text" name="search" class="form-control" placeholder="N° réservation, client, voiture..." value="{{ request('search') }}"></div>
    <div style="min-width:160px;"><label class="form-label">Statut</label>
      <select name="statut" class="form-control">
        <option value="">Tous</option>
        @foreach(['En attente','Confirmée','En cours','Terminée','Annulée'] as $s)
        <option value="{{ $s }}" {{ request('statut')==$s?'selected':'' }}>{{ $s }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Reset</a>
  </form>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>N° Réservation</th><th>Client</th><th>Voiture</th><th>Dates</th><th>Total</th><th>Paiement</th><th>Statut</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($reservations as $r)
        <tr>
          <td><code style="background:rgba(255,255,255,.05);padding:3px 8px;border-radius:6px;font-size:.78rem;">{{ $r->numero_reservation }}</code></td>
          <td>{{ $r->user->name }}</td>
          <td>{{ $r->voiture->marque }} {{ $r->voiture->modele }}</td>
          <td style="font-size:.82rem;color:var(--muted);">{{ $r->date_debut->format('d/m/Y') }}<br>→ {{ $r->date_fin->format('d/m/Y') }}</td>
          <td style="font-weight:700;color:var(--accent);">{{ $r->prix_total }} DT</td>
          <td>
            @php $pc=match($r->statut_paiement){'Payé'=>'badge-success','Partiel'=>'badge-warning',default=>'badge-danger'}; @endphp
            <span class="badge {{ $pc }}">{{ $r->statut_paiement }}</span>
          </td>
          <td><span class="badge {{ $r->getStatutBadgeClass() }}">{{ $r->statut }}</span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.reservations.show',$r) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
              <form method="POST" action="{{ route('admin.reservations.destroy',$r) }}" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px 0;">Aucune réservation trouvée</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $reservations->withQueryString()->links('pagination::simple-tailwind') }}</div>
</div>
@endsection
