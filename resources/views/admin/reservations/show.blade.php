@extends('layouts.app')
@section('title','Réservation '.$reservation->numero_reservation)
@section('page-title','Détail réservation')
@section('content')
<div class="section-header">
  <div class="section-title">{{ $reservation->numero_reservation }}</div>
  <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="grid grid-2" style="margin-bottom:20px;">
  <div class="card">
    <div class="card-title">Informations client</div>
    @php $u=$reservation->user; @endphp
    @foreach(['Nom'=>$u->name,'Email'=>$u->email,'Téléphone'=>$u->phone,'CIN'=>$u->cin,'Permis'=>$u->permis_conduire] as $k=>$v)
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--card-border);font-size:.88rem;">
      <span style="color:var(--muted);">{{ $k }}</span><span style="font-weight:600;">{{ $v ?? '–' }}</span>
    </div>
    @endforeach
  </div>
  <div class="card">
    <div class="card-title">Voiture</div>
    @php $v=$reservation->voiture; @endphp
    @foreach(['Véhicule'=>$v->marque.' '.$v->modele,'Immatriculation'=>$v->immatriculation,'Catégorie'=>$v->categorie,'Carburant'=>$v->carburant,'Transmission'=>$v->transmission] as $k=>$val)
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--card-border);font-size:.88rem;">
      <span style="color:var(--muted);">{{ $k }}</span><span style="font-weight:600;">{{ $val }}</span>
    </div>
    @endforeach
  </div>
</div>
<div class="card" style="margin-bottom:20px;">
  <div class="card-title">Détails de la réservation</div>
  <div class="grid grid-3">
    <div style="text-align:center;padding:16px;background:rgba(255,255,255,.03);border-radius:12px;">
      <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">DATE DÉBUT</div>
      <div style="font-size:1.1rem;font-weight:700;">{{ $reservation->date_debut->format('d/m/Y') }}</div>
    </div>
    <div style="text-align:center;padding:16px;background:rgba(255,255,255,.03);border-radius:12px;">
      <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">DATE FIN</div>
      <div style="font-size:1.1rem;font-weight:700;">{{ $reservation->date_fin->format('d/m/Y') }}</div>
    </div>
    <div style="text-align:center;padding:16px;background:rgba(255,107,53,.08);border-radius:12px;">
      <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">TOTAL</div>
      <div style="font-size:1.4rem;font-weight:800;color:var(--accent);">{{ $reservation->prix_total }} DT</div>
      <div style="font-size:.75rem;color:var(--muted);">{{ $reservation->nb_jours }} jour(s)</div>
    </div>
  </div>
  <div class="grid grid-2" style="margin-top:16px;">
    <div><span style="color:var(--muted);font-size:.82rem;">Lieu prise en charge :</span> <strong>{{ $reservation->lieu_prise_en_charge }}</strong></div>
    <div><span style="color:var(--muted);font-size:.82rem;">Lieu retour :</span> <strong>{{ $reservation->lieu_retour }}</strong></div>
  </div>
  @if($reservation->notes)
  <div style="margin-top:12px;padding:12px;background:rgba(255,255,255,.03);border-radius:10px;font-size:.85rem;color:var(--muted);">{{ $reservation->notes }}</div>
  @endif
</div>
{{-- Changer statut --}}
<div class="card">
  <div class="card-title">Changer le statut</div>
  <form method="POST" action="{{ route('admin.reservations.updateStatut',$reservation) }}" style="display:flex;gap:12px;align-items:flex-end;">
    @csrf @method('PATCH')
    <div style="flex:1;">
      <select name="statut" class="form-control">
        @foreach(['En attente','Confirmée','En cours','Terminée','Annulée'] as $s)
        <option value="{{ $s }}" {{ $reservation->statut==$s?'selected':'' }}>{{ $s }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Mettre à jour</button>
  </form>
</div>
@endsection
