@extends('layouts.app')
@section('title','Nouvelle réservation')
@section('page-title','Créer une réservation')
@section('content')
<div class="section-header">
  <div class="section-title">Nouvelle réservation</div>
  <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="card">
  @if($errors->any())<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>@endif
  <form method="POST" action="{{ route('admin.reservations.store') }}">
    @csrf
    <div class="grid grid-2">
      <div class="form-group"><label class="form-label">Client *</label>
        <select name="user_id" class="form-control" required>
          <option value="">-- Sélectionner --</option>
          @foreach($clients as $c)<option value="{{ $c->id }}" {{ old('user_id')==$c->id?'selected':'' }}>{{ $c->name }} ({{ $c->email }})</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Voiture *</label>
        <select name="voiture_id" class="form-control" required>
          <option value="">-- Sélectionner --</option>
          @foreach($voitures as $v)<option value="{{ $v->id }}" {{ old('voiture_id')==$v->id?'selected':'' }}>{{ $v->marque }} {{ $v->modele }} – {{ $v->prix_par_jour }} DT/j</option>@endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-2">
      <div class="form-group"><label class="form-label">Date début *</label><input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required></div>
      <div class="form-group"><label class="form-label">Date fin *</label><input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}" required></div>
    </div>
    <div class="grid grid-2">
      <div class="form-group"><label class="form-label">Lieu de prise en charge *</label><input type="text" name="lieu_prise_en_charge" class="form-control" value="{{ old('lieu_prise_en_charge') }}" required></div>
      <div class="form-group"><label class="form-label">Lieu de retour *</label><input type="text" name="lieu_retour" class="form-control" value="{{ old('lieu_retour') }}" required></div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Mode de paiement</label>
        <select name="mode_paiement" class="form-control">
          <option value="">--</option>
          @foreach(['Espèces','Carte bancaire','Virement'] as $m)<option value="{{ $m }}" {{ old('mode_paiement')==$m?'selected':'' }}>{{ $m }}</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Statut paiement</label>
        <select name="statut_paiement" class="form-control">
          @foreach(['Non payé','Partiel','Payé'] as $s)<option value="{{ $s }}" {{ old('statut_paiement','Non payé')==$s?'selected':'' }}>{{ $s }}</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Caution (DT)</label><input type="number" name="caution" class="form-control" value="{{ old('caution',0) }}" step="0.01" min="0"></div>
    </div>
    <div class="form-group"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea></div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Créer la réservation</button>
  </form>
</div>
@endsection
