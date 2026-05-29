@extends('layouts.app')
@section('title','Mon tableau de bord')
@section('page-title','Mon espace')
@section('content')
<div style="margin-bottom:24px;">
  <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;">Bonjour, {{ auth()->user()->name }} 👋</div>
  <div style="color:var(--muted);font-size:.88rem;margin-top:4px;">Bienvenue sur votre espace DriveNow</div>
</div>
<div class="grid grid-4" style="margin-bottom:24px;">
  <div class="stat-card orange"><div class="stat-icon orange"><i class="fas fa-calendar-alt"></i></div><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">Réservations totales</div></div>
  <div class="stat-card purple"><div class="stat-icon purple"><i class="fas fa-car"></i></div><div class="stat-value">{{ $stats['actives'] }}</div><div class="stat-label">En cours</div></div>
  <div class="stat-card teal"><div class="stat-icon teal"><i class="fas fa-check"></i></div><div class="stat-value">{{ $stats['terminees'] }}</div><div class="stat-label">Terminées</div></div>
  <div class="stat-card yellow"><div class="stat-icon yellow"><i class="fas fa-coins"></i></div><div class="stat-value">{{ number_format($stats['depenses'],0,',',' ') }} DT</div><div class="stat-label">Total dépensé</div></div>
</div>
<div class="grid grid-2">
  <div class="card">
    <div class="section-header mb-0">
      <div class="card-title mb-0">Mes dernières réservations</div>
      <a href="{{ route('client.reservations.index') }}" class="btn btn-secondary btn-sm">Voir tout</a>
    </div>
    <div class="divider"></div>
    @forelse($reservations as $r)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--card-border);">
      <div>
        <div style="font-weight:600;font-size:.9rem;">{{ $r->voiture->marque }} {{ $r->voiture->modele }}</div>
        <div style="font-size:.78rem;color:var(--muted);">{{ $r->date_debut->format('d/m/Y') }} → {{ $r->date_fin->format('d/m/Y') }}</div>
      </div>
      <div style="text-align:right;">
        <span class="badge {{ $r->getStatutBadgeClass() }}">{{ $r->statut }}</span>
        <div style="font-size:.82rem;color:var(--accent);font-weight:700;margin-top:4px;">{{ $r->prix_total }} DT</div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:30px 0;">
      <i class="fas fa-calendar-xmark" style="font-size:2rem;color:var(--muted);display:block;margin-bottom:10px;"></i>
      <p style="color:var(--muted);">Aucune réservation pour l'instant</p>
      <a href="{{ route('client.catalogue') }}" class="btn btn-primary" style="margin-top:12px;"><i class="fas fa-car"></i> Voir le catalogue</a>
    </div>
    @endforelse
  </div>
  <div class="card">
    <div class="card-title">Actions rapides</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
      <a href="{{ route('client.catalogue') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:rgba(255,107,53,.08);border:1px solid rgba(255,107,53,.2);border-radius:12px;text-decoration:none;color:var(--text);transition:all .2s;">
        <div style="width:42px;height:42px;border-radius:10px;background:rgba(255,107,53,.15);display:flex;align-items:center;justify-content:center;color:var(--grad-1);"><i class="fas fa-car"></i></div>
        <div><div style="font-weight:600;">Parcourir le catalogue</div><div style="font-size:.78rem;color:var(--muted);">Voir toutes les voitures disponibles</div></div>
      </a>
      <a href="{{ route('client.reservations.index') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:rgba(108,99,255,.08);border:1px solid rgba(108,99,255,.2);border-radius:12px;text-decoration:none;color:var(--text);transition:all .2s;">
        <div style="width:42px;height:42px;border-radius:10px;background:rgba(108,99,255,.15);display:flex;align-items:center;justify-content:center;color:var(--accent-2);"><i class="fas fa-calendar-check"></i></div>
        <div><div style="font-weight:600;">Mes réservations</div><div style="font-size:.78rem;color:var(--muted);">Suivre mes locations</div></div>
      </a>
    </div>
  </div>
</div>
@endsection
