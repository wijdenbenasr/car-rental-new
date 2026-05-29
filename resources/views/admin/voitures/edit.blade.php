@extends('layouts.app')
@section('title','Modifier – '.$voiture->marque.' '.$voiture->modele)
@section('page-title','Modifier la voiture')
@section('content')
<div class="section-header">
  <div class="section-title">{{ $voiture->marque }} {{ $voiture->modele }}</div>
  <a href="{{ route('admin.voitures.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="card">
  @if($errors->any())
  <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs.</div>
  @endif
  <form method="POST" action="{{ route('admin.voitures.update',$voiture) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Marque</label><input type="text" name="marque" class="form-control" value="{{ old('marque',$voiture->marque) }}" required></div>
      <div class="form-group"><label class="form-label">Modèle</label><input type="text" name="modele" class="form-control" value="{{ old('modele',$voiture->modele) }}" required></div>
      <div class="form-group"><label class="form-label">Année</label><input type="number" name="annee" class="form-control" value="{{ old('annee',$voiture->annee) }}" required></div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Immatriculation</label><input type="text" name="immatriculation" class="form-control" value="{{ old('immatriculation',$voiture->immatriculation) }}" required></div>
      <div class="form-group"><label class="form-label">Couleur</label><input type="text" name="couleur" class="form-control" value="{{ old('couleur',$voiture->couleur) }}" required></div>
      <div class="form-group"><label class="form-label">Catégorie</label>
        <select name="categorie" class="form-control">
          @foreach(['Économique','Compacte','Berline','SUV','Luxe','Utilitaire'] as $c)
          <option value="{{ $c }}" {{ old('categorie',$voiture->categorie)==$c?'selected':'' }}>{{ $c }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Nb. places</label><input type="number" name="nb_places" class="form-control" value="{{ old('nb_places',$voiture->nb_places) }}" required></div>
      <div class="form-group"><label class="form-label">Transmission</label>
        <select name="transmission" class="form-control">
          <option value="Manuelle" {{ old('transmission',$voiture->transmission)=='Manuelle'?'selected':'' }}>Manuelle</option>
          <option value="Automatique" {{ old('transmission',$voiture->transmission)=='Automatique'?'selected':'' }}>Automatique</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">Carburant</label>
        <select name="carburant" class="form-control">
          @foreach(['Essence','Diesel','Électrique','Hybride'] as $f)
          <option value="{{ $f }}" {{ old('carburant',$voiture->carburant)==$f?'selected':'' }}>{{ $f }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-3">
      <div class="form-group"><label class="form-label">Kilométrage</label><input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage',$voiture->kilometrage) }}" required></div>
      <div class="form-group"><label class="form-label">Prix / Jour (DT)</label><input type="number" name="prix_par_jour" class="form-control" value="{{ old('prix_par_jour',$voiture->prix_par_jour) }}" step="0.01" required></div>
      <div class="form-group"><label class="form-label">Statut</label>
        <select name="statut" class="form-control">
          @foreach(['Disponible','Louée','Maintenance','Hors service'] as $s)
          <option value="{{ $s }}" {{ old('statut',$voiture->statut)==$s?'selected':'' }}>{{ $s }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-2">
      <div class="form-group"><label class="form-label">Climatisation</label>
        <select name="climatisation" class="form-control">
          <option value="Oui" {{ $voiture->climatisation=='Oui'?'selected':'' }}>Oui</option>
          <option value="Non" {{ $voiture->climatisation=='Non'?'selected':'' }}>Non</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">GPS</label>
        <select name="gps" class="form-control">
          <option value="Non" {{ $voiture->gps=='Non'?'selected':'' }}>Non</option>
          <option value="Oui" {{ $voiture->gps=='Oui'?'selected':'' }}>Oui</option>
        </select>
      </div>
    </div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$voiture->description) }}</textarea></div>
    @if($voiture->image)
    <div style="margin-bottom:12px;">
      <label class="form-label">Image actuelle</label>
      <img src="{{ asset('storage/'.$voiture->image) }}" style="height:80px;border-radius:8px;display:block;margin-top:6px;">
    </div>
    @endif
    <div class="form-group"><label class="form-label">Nouvelle photo (optionnel)</label><input type="file" name="image" class="form-control" accept="image/*"></div>
    <div style="display:flex;gap:12px;margin-top:8px;">
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Mettre à jour</button>
      <a href="{{ route('admin.voitures.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
