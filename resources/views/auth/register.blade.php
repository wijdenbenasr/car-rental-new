@extends('layouts.app')
@section('title', 'Inscription – DriveNow')
@push('styles')
<style>
body{background:var(--dark);}
.auth-wrapper{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;}
.auth-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;padding:40px;width:100%;max-width:540px;}
.logo-g{font-family:'Syne',sans-serif;font-size:1.8rem;font-weight:800;background:linear-gradient(135deg,var(--grad-1),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.auth-footer{text-align:center;margin-top:20px;font-size:.85rem;color:var(--muted);}
.auth-footer a{color:var(--accent);text-decoration:none;font-weight:600;}
</style>
@endpush
@section('content')
<div class="auth-wrapper">
  <div class="auth-card">
    <div style="text-align:center;margin-bottom:28px;">
      <div class="logo-g">🚗 DriveNow</div>
      <p style="color:var(--muted);font-size:.85rem;margin-top:4px;">Créez votre compte client</p>
    </div>
    @if($errors->any())
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="grid grid-2">
        <div class="form-group"><label class="form-label">Nom complet</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="form-group"><label class="form-label">Téléphone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required></div>
      </div>
      <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
      <div class="grid grid-2">
        <div class="form-group"><label class="form-label">N° CIN</label><input type="text" name="cin" class="form-control" value="{{ old('cin') }}" required></div>
        <div class="form-group"><label class="form-label">N° Permis de conduire</label><input type="text" name="permis_conduire" class="form-control" value="{{ old('permis_conduire') }}" required></div>
      </div>
      <div class="grid grid-2">
        <div class="form-group"><label class="form-label">Mot de passe</label><input type="password" name="password" class="form-control" required></div>
        <div class="form-group"><label class="form-label">Confirmer le mot de passe</label><input type="password" name="password_confirmation" class="form-control" required></div>
      </div>
      <button type="submit" class="btn btn-primary w-full" style="justify-content:center;padding:12px;">
        <i class="fas fa-user-plus"></i> Créer mon compte
      </button>
    </form>
    <div class="auth-footer">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></div>
  </div>
</div>
@endsection
