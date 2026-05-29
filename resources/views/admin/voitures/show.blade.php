@extends('layouts.app')
@section('title',$voiture->marque.' '.$voiture->modele)
@section('page-title','Détail voiture')
@section('content')
<div class="section-header">
  <div class="section-title">{{ $voiture->marque }} {{ $voiture->modele }} ({{ $voiture->annee }})</div>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.voitures.edit',$voiture) }}" class="btn btn-secondary"><i class="fas fa-edit"></i> Modifier</a>
    <a href="{{ route('admin.voitures.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
  </div>
</div>
<div class="grid grid-2" style="margin-bottom:20px;">
  <div class="card">
    <div class="card-title">Informations</div>
    @php
      $infos = ['Immatriculation'=>$voiture->immatriculation,'Couleur'=>$voiture->couleur,'Catégorie'=>$voiture->categorie,'Places'=>$voiture->nb_places,'Transmission'=>$voiture->transmission,'Carburant'=>$voiture->carburant,'Kilométrage'=>number_format($voiture->kilometrage,0,',',' ').' km','Climatisation'=>$voiture->climatisation,'GPS'=>$voiture->gps];
    @endphp
    @foreach($infos as $k=>$v)
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--card-border);font-size:.88rem;">
      <span style="color:var(--muted);">{{ $k }}</span>
      <span style="font-weight:600;">{{ $v }}</span>
    </div>
    @endforeach
    <div style="display:flex;justify-content:space-between;padding:10px 0;font-size:.88rem;">
      <span style="color:var(--muted);">Prix / Jour</span>
      <span style="font-weight:700;color:var(--accent);font-size:1.1rem;">{{ $voiture->prix_par_jour }} DT</span>
    </div>
  </div>
  <div class="card">
    <div class="card-title">Historique des réservations</div>
    @forelse($voiture->reservations->take(6) as $r)
    <div style="padding:8px 0;border-bottom:1px solid var(--card-border);font-size:.85rem;">
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <span style="font-weight:600;">{{ $r->user->name }}</span>
        <span class="badge {{ $r->getStatutBadgeClass() }}">{{ $r->statut }}</span>
      </div>
      <div style="color:var(--muted);font-size:.78rem;margin-top:2px;">{{ $r->date_debut->format('d/m/Y') }} → {{ $r->date_fin->format('d/m/Y') }} · {{ $r->prix_total }} DT</div>
    </div>
    @empty
    <p style="color:var(--muted);text-align:center;padding:20px 0;">Aucune réservation</p>
    @endforelse
  </div>
</div>
@endsection
