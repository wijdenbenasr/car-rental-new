@extends('layouts.app')
@section('title',$voiture->marque.' '.$voiture->modele)
@section('page-title',$voiture->marque.' '.$voiture->modele)
@section('content')
<div class="section-header">
  <div class="section-title">{{ $voiture->marque }} {{ $voiture->modele }} ({{ $voiture->annee }})</div>
  <a href="{{ route('client.catalogue') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="grid grid-2" style="margin-bottom:20px;">
  <div>
    <div style="height:280px;background:linear-gradient(135deg,rgba(255,107,53,.15),rgba(108,99,255,.15));border-radius:18px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;overflow:hidden;">
      @if($voiture->image)
      <img src="{{ asset('storage/'.$voiture->image) }}" style="width:100%;height:100%;object-fit:cover;">
      @else
      <i class="fas fa-car" style="font-size:5rem;color:rgba(255,255,255,.2);"></i>
      @endif
    </div>
    @if($voiture->description)
    <div class="card"><div class="card-title">Description</div><p style="color:var(--muted);font-size:.88rem;line-height:1.7;">{{ $voiture->description }}</p></div>
    @endif
  </div>
  <div class="card">
    <div class="card-title">Caractéristiques</div>
    @foreach(['Catégorie'=>$voiture->categorie,'Places'=>$voiture->nb_places,'Transmission'=>$voiture->transmission,'Carburant'=>$voiture->carburant,'Couleur'=>$voiture->couleur,'Kilométrage'=>number_format($voiture->kilometrage,0,',',' ').' km','Climatisation'=>$voiture->climatisation,'GPS'=>$voiture->gps] as $k=>$v)
    <div style="display:flex;justify-content:space-between;padding:9px 0;border-bottom:1px solid var(--card-border);font-size:.88rem;">
      <span style="color:var(--muted);">{{ $k }}</span>
      <span style="font-weight:600;">{{ $v }}</span>
    </div>
    @endforeach
    <div style="margin-top:20px;text-align:center;padding:16px;background:rgba(255,107,53,.08);border-radius:12px;border:1px solid rgba(255,107,53,.2);">
      <div style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;color:var(--accent);">{{ $voiture->prix_par_jour }} DT</div>
      <div style="color:var(--muted);font-size:.82rem;">par jour</div>
    </div>
    @if($voiture->isDisponible())
    <a href="{{ route('client.reservations.create',$voiture) }}" class="btn btn-primary w-full" style="justify-content:center;padding:14px;margin-top:16px;font-size:.95rem;">
      <i class="fas fa-calendar-check"></i> Réserver maintenant
    </a>
    @else
    <div style="text-align:center;padding:14px;margin-top:16px;background:rgba(255,71,87,.08);border-radius:10px;color:var(--danger);font-weight:600;">
      <i class="fas fa-times-circle"></i> Non disponible actuellement
    </div>
    @endif
  </div>
</div>
@endsection
