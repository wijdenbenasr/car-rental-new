@extends('layouts.app')
@section('title',$client->name)
@section('page-title','Profil client')
@section('content')
<div class="section-header">
  <div class="section-title">{{ $client->name }}</div>
  <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="grid grid-2" style="margin-bottom:20px;">
  <div class="card">
    <div class="card-title">Informations personnelles</div>
    @foreach(['Nom'=>$client->name,'Email'=>$client->email,'Téléphone'=>$client->phone,'CIN'=>$client->cin,'Permis de conduire'=>$client->permis_conduire,'Adresse'=>$client->address,'Inscrit le'=>$client->created_at->format('d/m/Y')] as $k=>$v)
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--card-border);font-size:.88rem;">
      <span style="color:var(--muted);">{{ $k }}</span><span style="font-weight:600;">{{ $v ?? '–' }}</span>
    </div>
    @endforeach
  </div>
  <div class="card">
    <div class="card-title">Réservations</div>
    @forelse($client->reservations as $r)
    <div style="padding:10px 0;border-bottom:1px solid var(--card-border);">
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <div>
          <div style="font-weight:600;font-size:.88rem;">{{ $r->voiture->marque }} {{ $r->voiture->modele }}</div>
          <div style="font-size:.78rem;color:var(--muted);">{{ $r->date_debut->format('d/m/Y') }} → {{ $r->date_fin->format('d/m/Y') }}</div>
        </div>
        <div style="text-align:right;">
          <span class="badge {{ $r->getStatutBadgeClass() }}">{{ $r->statut }}</span>
          <div style="font-size:.82rem;color:var(--accent);font-weight:700;margin-top:4px;">{{ $r->prix_total }} DT</div>
        </div>
      </div>
    </div>
    @empty
    <p style="color:var(--muted);text-align:center;padding:20px 0;">Aucune réservation</p>
    @endforelse
  </div>
</div>
@endsection
