@extends('layouts.app')
@section('title','Mes réservations')
@section('page-title','Mes réservations')
@section('content')
<div class="section-header">
  <div class="section-title">Mes réservations</div>
  <a href="{{ route('client.catalogue') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle réservation</a>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>N° Réservation</th><th>Voiture</th><th>Dates</th><th>Nb. jours</th><th>Total</th><th>Paiement</th><th>Statut</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($reservations as $r)
        <tr>
          <td><code style="background:rgba(255,255,255,.05);padding:3px 8px;border-radius:6px;font-size:.78rem;">{{ $r->numero_reservation }}</code></td>
          <td><div style="font-weight:600;">{{ $r->voiture->marque }} {{ $r->voiture->modele }}</div></td>
          <td style="font-size:.82rem;color:var(--muted);">{{ $r->date_debut->format('d/m/Y') }}<br>→ {{ $r->date_fin->format('d/m/Y') }}</td>
          <td style="text-align:center;">{{ $r->nb_jours }}j</td>
          <td style="font-weight:700;color:var(--accent);">{{ $r->prix_total }} DT</td>
          <td>
            @php $pc=match($r->statut_paiement){'Payé'=>'badge-success','Partiel'=>'badge-warning',default=>'badge-danger'}; @endphp
            <span class="badge {{ $pc }}">{{ $r->statut_paiement }}</span>
          </td>
          <td><span class="badge {{ $r->getStatutBadgeClass() }}">{{ $r->statut }}</span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('client.reservations.show',$r) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
              @if(in_array($r->statut,['En attente','Confirmée']))
              <form method="POST" action="{{ route('client.reservations.cancel',$r) }}" onsubmit="return confirm('Annuler cette réservation ?')">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px 0;">
          <i class="fas fa-calendar-xmark" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
          Aucune réservation. <a href="{{ route('client.catalogue') }}" style="color:var(--accent);">Voir le catalogue</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $reservations->withQueryString()->links('pagination::simple-tailwind') }}</div>
</div>
@endsection
