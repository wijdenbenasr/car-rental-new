@extends('layouts.app')
@section('title','Réservation '.$reservation->numero_reservation)
@section('page-title','Détail réservation')
@section('content')
<div class="section-header">
  <div>
    <div class="section-title">{{ $reservation->numero_reservation }}</div>
    <span class="badge {{ $reservation->getStatutBadgeClass() }}" style="margin-top:6px;">{{ $reservation->statut }}</span>
  </div>
  <div style="display:flex;gap:8px;">
    @if(in_array($reservation->statut,['En attente','Confirmée']))
    <form method="POST" action="{{ route('client.reservations.cancel',$reservation) }}" onsubmit="return confirm('Annuler cette réservation ?')">
      @csrf @method('PATCH')
      <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Annuler</button>
    </form>
    @endif
    <a href="{{ route('client.reservations.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
  </div>
</div>
<div class="grid grid-2" style="margin-bottom:20px;">
  <div class="card">
    <div class="card-title">Voiture réservée</div>
    <div style="height:160px;background:linear-gradient(135deg,rgba(255,107,53,.1),rgba(108,99,255,.1));border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;overflow:hidden;">
      @if($reservation->voiture->image)<img src="{{ asset('storage/'.$reservation->voiture->image) }}" style="width:100%;height:100%;object-fit:cover;">
      @else<i class="fas fa-car" style="font-size:2.5rem;color:rgba(255,255,255,.2);"></i>@endif
    </div>
    <div style="font-family:'Syne',sans-serif;font-size:1.05rem;font-weight:700;">{{ $reservation->voiture->marque }} {{ $reservation->voiture->modele }}</div>
    <div style="color:var(--muted);font-size:.82rem;">{{ $reservation->voiture->categorie }} · {{ $reservation->voiture->annee }}</div>
  </div>
  <div class="card">
    <div class="card-title">Détails</div>
    @foreach(['Date début'=>$reservation->date_debut->format('d/m/Y'),'Date fin'=>$reservation->date_fin->format('d/m/Y'),'Durée'=>$reservation->nb_jours.' jour(s)','Lieu prise en charge'=>$reservation->lieu_prise_en_charge,'Lieu retour'=>$reservation->lieu_retour,'Mode paiement'=>($reservation->mode_paiement ?? 'Non défini'),'Statut paiement'=>$reservation->statut_paiement,'Caution'=>$reservation->caution.' DT'] as $k=>$v)
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--card-border);font-size:.87rem;">
      <span style="color:var(--muted);">{{ $k }}</span><span style="font-weight:600;">{{ $v }}</span>
    </div>
    @endforeach
    <div style="display:flex;justify-content:space-between;padding:12px 0;font-size:.9rem;">
      <span style="font-weight:700;">Total</span>
      <span style="font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:800;color:var(--accent);">{{ $reservation->prix_total }} DT</span>
    </div>
    @if($reservation->notes)
    <div style="padding:12px;background:rgba(255,255,255,.03);border-radius:10px;font-size:.83rem;color:var(--muted);">
      <div style="font-weight:600;color:var(--text);margin-bottom:4px;">Notes :</div>{{ $reservation->notes }}
    </div>
    @endif
  </div>
</div>
@endsection
