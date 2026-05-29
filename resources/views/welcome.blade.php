@extends('layouts.app')
@section('title','DriveNow – Location de voitures')
@push('styles')
<style>
body{background:var(--dark);}
.hero{min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:40px 24px;position:relative;overflow:hidden;}
.hero::before{content:'';position:absolute;width:800px;height:800px;border-radius:50%;background:radial-gradient(circle,rgba(255,107,53,.12) 0%,transparent 70%);top:-300px;left:50%;transform:translateX(-50%);}
.hero::after{content:'';position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(108,99,255,.1) 0%,transparent 70%);bottom:-200px;right:-100px;}
.hero-content{position:relative;z-index:1;max-width:700px;}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,107,53,.1);border:1px solid rgba(255,107,53,.3);border-radius:20px;padding:6px 16px;font-size:.8rem;color:var(--accent);margin-bottom:24px;}
.hero-title{font-family:'Syne',sans-serif;font-size:clamp(2.5rem,6vw,4.5rem);font-weight:800;line-height:1.1;margin-bottom:20px;}
.hero-title span{background:linear-gradient(135deg,var(--grad-1),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.hero-sub{font-size:1.05rem;color:var(--muted);line-height:1.7;margin-bottom:36px;}
.cars-section{padding:80px 24px;max-width:1100px;margin:0 auto;}
.nav-top{position:fixed;top:0;left:0;right:0;z-index:200;background:rgba(13,13,26,.8);backdrop-filter:blur(12px);border-bottom:1px solid var(--card-border);padding:14px 40px;display:flex;align-items:center;justify-content:space-between;}
.logo-top{font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:800;background:linear-gradient(135deg,var(--grad-1),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
</style>
@endpush
@section('content')
{{-- Navbar --}}
<nav class="nav-top">
  <div class="logo-top">🚗 DriveNow</div>
  <div style="display:flex;gap:10px;">
    @auth
      @if(auth()->user()->isAdmin())
      <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Tableau de bord</a>
      @else
      <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-sm">Mon espace</a>
      @endif
    @else
      <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Connexion</a>
      <a href="{{ route('register') }}" class="btn btn-primary btn-sm">S'inscrire</a>
    @endauth
  </div>
</nav>

{{-- Hero --}}
<div class="hero" style="padding-top:100px;">
  <div class="hero-content">
    <div class="hero-badge"><i class="fas fa-star" style="color:var(--warning);"></i> Plateforme N°1 en Tunisie</div>
    <h1 class="hero-title">Louez la voiture <span>de vos rêves</span> en quelques clics</h1>
    <p class="hero-sub">Des centaines de véhicules disponibles, des prix compétitifs, une réservation simple et rapide. Démarrez l'aventure dès aujourd'hui.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      @auth
      <a href="{{ route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'client.catalogue') }}" class="btn btn-primary" style="padding:14px 28px;font-size:1rem;">
        <i class="fas fa-car"></i> Voir les voitures
      </a>
      @else
      <a href="{{ route('register') }}" class="btn btn-primary" style="padding:14px 28px;font-size:1rem;"><i class="fas fa-rocket"></i> Commencer</a>
      <a href="{{ route('login') }}" class="btn btn-secondary" style="padding:14px 28px;font-size:1rem;">Se connecter</a>
      @endauth
    </div>
    {{-- Chiffres --}}
    <div style="display:flex;gap:40px;justify-content:center;margin-top:48px;">
      @foreach(['500+'=>'Voitures','98%'=>'Satisfaction','24/7'=>'Support','50+'=>'Villes'] as $nb=>$label)
      <div style="text-align:center;">
        <div style="font-family:'Syne',sans-serif;font-size:1.6rem;font-weight:800;color:var(--accent);">{{ $nb }}</div>
        <div style="font-size:.78rem;color:var(--muted);">{{ $label }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Voitures disponibles --}}
@if($voitures->count())
<div class="cars-section">
  <div style="text-align:center;margin-bottom:40px;">
    <div style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;margin-bottom:8px;">Voitures disponibles</div>
    <p style="color:var(--muted);">Découvrez notre sélection de véhicules</p>
  </div>
  <div class="grid grid-3">
    @foreach($voitures as $v)
    <div style="background:var(--card);border:1px solid var(--card-border);border-radius:18px;overflow:hidden;">
      <div style="height:150px;background:linear-gradient(135deg,rgba(255,107,53,.12),rgba(108,99,255,.12));display:flex;align-items:center;justify-content:center;">
        @if($v->image)<img src="{{ asset('storage/'.$v->image) }}" style="width:100%;height:100%;object-fit:cover;">
        @else<i class="fas fa-car" style="font-size:3rem;color:rgba(255,255,255,.2);"></i>@endif
      </div>
      <div style="padding:16px;">
        <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:4px;">{{ $v->marque }} {{ $v->modele }}</div>
        <div style="color:var(--muted);font-size:.8rem;margin-bottom:12px;">{{ $v->categorie }} · {{ $v->annee }}</div>
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <span style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:800;color:var(--accent);">{{ $v->prix_par_jour }} DT<span style="font-size:.75rem;font-weight:400;color:var(--muted);">/j</span></span>
          @auth
          <a href="{{ route('client.voiture.show',$v) }}" class="btn btn-primary btn-sm">Réserver</a>
          @else
          <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Réserver</a>
          @endauth
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @auth @else
  <div style="text-align:center;margin-top:36px;">
    <a href="{{ route('register') }}" class="btn btn-primary" style="padding:13px 28px;">Créer un compte pour réserver</a>
  </div>
  @endauth
</div>
@endif
@endsection
