@extends('layouts.app')
@section('title', 'Connexion – DriveNow')
@push('styles')
<style>
body{background:var(--dark);}
.auth-wrapper{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;position:relative;overflow:hidden;}
.auth-wrapper::before{content:'';position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(255,107,53,.15) 0%,transparent 70%);top:-200px;right:-200px;}
.auth-wrapper::after{content:'';position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(108,99,255,.12) 0%,transparent 70%);bottom:-100px;left:-100px;}
.auth-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;padding:40px;width:100%;max-width:420px;position:relative;z-index:1;}
.logo-g{font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;background:linear-gradient(135deg,var(--grad-1),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.auth-footer{text-align:center;margin-top:24px;font-size:.85rem;color:var(--muted);}
.auth-footer a{color:var(--accent);text-decoration:none;font-weight:600;}
</style>
@endpush
@section('content')
<div class="auth-wrapper">
  <div class="auth-card">
    <div style="text-align:center;margin-bottom:32px;">
      <div class="logo-g">🚗 DriveNow</div>
      <p style="color:var(--muted);font-size:.85rem;margin-top:4px;">Plateforme de location de voitures</p>
    </div>
    <div style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:700;margin-bottom:4px;">Connexion</div>
    <div style="color:var(--muted);font-size:.85rem;margin-bottom:28px;">Content de vous revoir !</div>
    @if($errors->any())
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Adresse email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="exemple@email.com" required autofocus>
      </div>
      <div class="form-group">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <input type="checkbox" name="remember" id="remember" style="accent-color:var(--accent);">
        <label for="remember" style="font-size:.85rem;color:var(--muted);">Se souvenir de moi</label>
      </div>
      <button type="submit" class="btn btn-primary w-full" style="justify-content:center;padding:12px;">
        <i class="fas fa-sign-in-alt"></i> Se connecter
      </button>
    </form>
    <div class="auth-footer">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></div>
  </div>
</div>
@endsection
