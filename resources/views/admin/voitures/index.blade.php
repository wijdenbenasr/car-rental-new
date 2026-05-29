@extends('layouts.app')
@section('title','Voitures – Admin')
@section('page-title','Gestion des voitures')
@section('content')
<div class="section-header">
  <div>
    <div class="section-title">Parc automobile</div>
    <div style="color:var(--muted);font-size:.85rem;margin-top:2px;">{{ $voitures->total() }} voiture(s) au total</div>
  </div>
  <a href="{{ route('admin.voitures.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter</a>
</div>

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px;">
  <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div style="flex:1;min-width:180px;">
      <label class="form-label">Recherche</label>
      <input type="text" name="search" class="form-control" placeholder="Marque, modèle, immat..." value="{{ request('search') }}">
    </div>
    <div style="min-width:150px;">
      <label class="form-label">Statut</label>
      <select name="statut" class="form-control">
        <option value="">Tous</option>
        @foreach(['Disponible','Louée','Maintenance','Hors service'] as $s)
        <option value="{{ $s }}" {{ request('statut')==$s?'selected':'' }}>{{ $s }}</option>
        @endforeach
      </select>
    </div>
    <div style="min-width:150px;">
      <label class="form-label">Catégorie</label>
      <select name="categorie" class="form-control">
        <option value="">Toutes</option>
        @foreach(['Économique','Compacte','Berline','SUV','Luxe','Utilitaire'] as $c)
        <option value="{{ $c }}" {{ request('categorie')==$c?'selected':'' }}>{{ $c }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button>
    <a href="{{ route('admin.voitures.index') }}" class="btn btn-secondary">Réinitialiser</a>
  </form>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead>
        <tr><th>Voiture</th><th>Immatriculation</th><th>Catégorie</th><th>Prix/Jour</th><th>Kilométrage</th><th>Statut</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($voitures as $v)
        <tr>
          <td>
            <div style="font-weight:600;">{{ $v->marque }} {{ $v->modele }}</div>
            <div style="font-size:.78rem;color:var(--muted);">{{ $v->annee }} · {{ $v->couleur }} · {{ $v->transmission }}</div>
          </td>
          <td><code style="background:rgba(255,255,255,.05);padding:3px 8px;border-radius:6px;font-size:.82rem;">{{ $v->immatriculation }}</code></td>
          <td>{{ $v->categorie }}</td>
          <td><span style="font-weight:700;color:var(--accent);">{{ $v->prix_par_jour }} DT</span></td>
          <td>{{ number_format($v->kilometrage,0,',',' ') }} km</td>
          <td>
            @php
              $cls = match($v->statut){
                'Disponible'=>'badge-success','Louée'=>'badge-primary',
                'Maintenance'=>'badge-warning','Hors service'=>'badge-danger',default=>'badge-secondary'};
            @endphp
            <span class="badge {{ $cls }}">{{ $v->statut }}</span>
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.voitures.show',$v) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
              <a href="{{ route('admin.voitures.edit',$v) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{ route('admin.voitures.destroy',$v) }}" onsubmit="return confirm('Supprimer cette voiture ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:40px 0;"><i class="fas fa-car" style="font-size:2rem;display:block;margin-bottom:10px;"></i>Aucune voiture trouvée</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $voitures->withQueryString()->links('pagination::simple-tailwind') }}</div>
</div>
@endsection
