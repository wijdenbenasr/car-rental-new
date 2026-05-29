@extends('layouts.app')
@section('title','Catalogue – DriveNow')
@section('page-title','Catalogue de voitures')
@section('content')
<div class="section-header">
  <div>
    <div class="section-title">Nos voitures disponibles</div>
    <div style="color:var(--muted);font-size:.85rem;margin-top:2px;">{{ $voitures->total() }} voiture(s) trouvée(s)</div>
  </div>
</div>
{{-- Filtres --}}
<div class="card" style="margin-bottom:24px;">
  <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div style="flex:1;min-width:180px;"><label class="form-label">Recherche</label><input type="text" name="search" class="form-control" placeholder="Marque ou modèle..." value="{{ request('search') }}"></div>
    <div style="min-width:140px;"><label class="form-label">Catégorie</label>
      <select name="categorie" class="form-control">
        <option value="">Toutes</option>
        @foreach(['Économique','Compacte','Berline','SUV','Luxe','Utilitaire'] as $c)
        <option value="{{ $c }}" {{ request('categorie')==$c?'selected':'' }}>{{ $c }}</option>
        @endforeach
      </select>
    </div>
    <div style="min-width:140px;"><label class="form-label">Transmission</label>
      <select name="transmission" class="form-control">
        <option value="">Toutes</option>
        <option value="Manuelle" {{ request('transmission')=='Manuelle'?'selected':'' }}>Manuelle</option>
        <option value="Automatique" {{ request('transmission')=='Automatique'?'selected':'' }}>Automatique</option>
      </select>
    </div>
    <div style="min-width:140px;"><label class="form-label">Prix max (DT/j)</label>
      <input type="number" name="prix_max" class="form-control" placeholder="ex: 150" value="{{ request('prix_max') }}">
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button>
    <a href="{{ route('client.catalogue') }}" class="btn btn-secondary">Reset</a>
  </form>
</div>

{{-- Grille voitures --}}
<div class="grid grid-3">
  @forelse($voitures as $v)
  <div style="background:var(--card);border:1px solid var(--card-border);border-radius:18px;overflow:hidden;transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,.4)'" onmouseout="this.style.transform='none';this.style.boxShadow='none'">
    {{-- Image --}}
    <div style="height:160px;background:linear-gradient(135deg,rgba(255,107,53,.15),rgba(108,99,255,.15));display:flex;align-items:center;justify-content:center;position:relative;">
      @if($v->image)
      <img src="{{ asset('storage/'.$v->image) }}" style="width:100%;height:100%;object-fit:cover;">
      @else
      <i class="fas fa-car" style="font-size:3.5rem;color:rgba(255,255,255,.2);"></i>
      @endif
      <div style="position:absolute;top:12px;right:12px;">
        <span class="badge badge-success"><i class="fas fa-circle" style="font-size:.5rem;"></i> Disponible</span>
      </div>
      <div style="position:absolute;top:12px;left:12px;">
        <span class="badge badge-secondary">{{ $v->categorie }}</span>
      </div>
    </div>
    {{-- Infos --}}
    <div style="padding:18px;">
      <div style="font-family:'Syne',sans-serif;font-size:1.05rem;font-weight:700;margin-bottom:4px;">{{ $v->marque }} {{ $v->modele }}</div>
      <div style="color:var(--muted);font-size:.82rem;margin-bottom:14px;">{{ $v->annee }} · {{ $v->couleur }}</div>
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
        <span style="font-size:.75rem;background:rgba(255,255,255,.05);padding:4px 8px;border-radius:6px;"><i class="fas fa-users" style="margin-right:3px;"></i>{{ $v->nb_places }} places</span>
        <span style="font-size:.75rem;background:rgba(255,255,255,.05);padding:4px 8px;border-radius:6px;"><i class="fas fa-cog" style="margin-right:3px;"></i>{{ $v->transmission }}</span>
        <span style="font-size:.75rem;background:rgba(255,255,255,.05);padding:4px 8px;border-radius:6px;"><i class="fas fa-gas-pump" style="margin-right:3px;"></i>{{ $v->carburant }}</span>
        @if($v->climatisation=='Oui')<span style="font-size:.75rem;background:rgba(0,217,181,.08);color:var(--success);padding:4px 8px;border-radius:6px;"><i class="fas fa-snowflake" style="margin-right:3px;"></i>Clim</span>@endif
      </div>
      <div style="display:flex;align-items:center;justify-content:space-between;">
        <div>
          <span style="font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:800;color:var(--accent);">{{ $v->prix_par_jour }} DT</span>
          <span style="color:var(--muted);font-size:.78rem;">/jour</span>
        </div>
        <a href="{{ route('client.voiture.show',$v) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Détails</a>
      </div>
    </div>
  </div>
  @empty
  <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--muted);">
    <i class="fas fa-car" style="font-size:3rem;display:block;margin-bottom:16px;"></i>
    <div style="font-size:1.1rem;font-weight:600;margin-bottom:8px;">Aucune voiture disponible</div>
    <p>Essayez de modifier vos filtres de recherche.</p>
  </div>
  @endforelse
</div>
<div style="margin-top:24px;" class="pagination">{{ $voitures->withQueryString()->links('pagination::simple-tailwind') }}</div>
@endsection
