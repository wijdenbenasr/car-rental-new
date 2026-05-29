@extends('layouts.app')
@section('title','Ajouter une voiture')
@section('page-title','Nouvelle voiture')
@section('content')
<div class="section-header">
  <div class="section-title">Ajouter une voiture</div>
  <a href="{{ route('admin.voitures.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="card">
  @if($errors->any())
  <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs ci-dessous.</div>
  @endif
  <form method="POST" action="{{ route('admin.voitures.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Marque *</label><input type="text" name="marque" class="form-control" value="{{ old('marque') }}" required></div>
      <div class="form-group"><label class="form-label">Modèle *</label><input type="text" name="modele" class="form-control" value="{{ old('modele') }}" required></div>
      <div class="form-group"><label class="form-label">Année *</label><input type="number" name="annee" class="form-control" value="{{ old('annee', date('Y')) }}" min="1990" max="{{ date('Y')+1 }}" required></div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Immatriculation *</label><input type="text" name="immatriculation" class="form-control" value="{{ old('immatriculation') }}" required></div>
      <div class="form-group"><label class="form-label">Couleur *</label><input type="text" name="couleur" class="form-control" value="{{ old('couleur') }}" required></div>
      <div class="form-group"><label class="form-label">Catégorie *</label>
        <select name="categorie" class="form-control" required>
          @foreach(['Économique','Compacte','Berline','SUV','Luxe','Utilitaire'] as $c)
          <option value="{{ $c }}" {{ old('categorie')==$c?'selected':'' }}>{{ $c }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Nb. places *</label><input type="number" name="nb_places" class="form-control" value="{{ old('nb_places',5) }}" min="2" max="9" required></div>
      <div class="form-group"><label class="form-label">Transmission *</label>
        <select name="transmission" class="form-control" required>
          <option value="Manuelle" {{ old('transmission')=='Manuelle'?'selected':'' }}>Manuelle</option>
          <option value="Automatique" {{ old('transmission')=='Automatique'?'selected':'' }}>Automatique</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">Carburant *</label>
        <select name="carburant" class="form-control" required>
          @foreach(['Essence','Diesel','Électrique','Hybride'] as $f)
          <option value="{{ $f }}" {{ old('carburant')==$f?'selected':'' }}>{{ $f }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Kilométrage *</label><input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage',0) }}" min="0" required></div>
      <div class="form-group"><label class="form-label">Prix / Jour (DT) *</label><input type="number" name="prix_par_jour" class="form-control" value="{{ old('prix_par_jour') }}" step="0.01" min="0" required></div>
      <div class="form-group"><label class="form-label">Statut *</label>
        <select name="statut" class="form-control" required>
          @foreach(['Disponible','Louée','Maintenance','Hors service'] as $s)
          <option value="{{ $s }}" {{ old('statut','Disponible')==$s?'selected':'' }}>{{ $s }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-2">
      <div class="form-group"><label class="form-label">Climatisation</label>
        <select name="climatisation" class="form-control">
          <option value="Oui">Oui</option><option value="Non">Non</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">GPS</label>
        <select name="gps" class="form-control">
          <option value="Non">Non</option><option value="Oui">Oui</option>
        </select>
      </div>
    </div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
    <div class="form-group"><label class="form-label">Photo de la voiture</label><input type="file" name="image" class="form-control" accept="image/*"></div>
    <div style="display:flex;gap:12px;margin-top:8px;">
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
      <a href="{{ route('admin.voitures.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
