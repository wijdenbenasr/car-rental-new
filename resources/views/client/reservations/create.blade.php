@extends('layouts.app')
@section('title','Réserver – '.$voiture->marque.' '.$voiture->modele)
@section('page-title','Nouvelle réservation')
@push('scripts')
<script>
function calculerPrix() {
  const debut = document.getElementById('date_debut').value;
  const fin   = document.getElementById('date_fin').value;
  const prixJ = {{ $voiture->prix_par_jour }};
  if (debut && fin) {
    const d1 = new Date(debut), d2 = new Date(fin);
    const jours = Math.ceil((d2 - d1) / (1000*60*60*24));
    if (jours > 0) {
      document.getElementById('nb_jours').textContent = jours + ' jour(s)';
      document.getElementById('prix_total').textContent = (jours * prixJ).toFixed(2) + ' DT';
      document.getElementById('caution_val').textContent = (prixJ * 2).toFixed(2) + ' DT';
      document.getElementById('recap').style.display = 'block';
    }
  }
}
</script>
@endpush
@section('content')
<div class="section-header">
  <div class="section-title">Réserver : {{ $voiture->marque }} {{ $voiture->modele }}</div>
  <a href="{{ route('client.voiture.show',$voiture) }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="grid grid-2">
  {{-- Formulaire --}}
  <div class="card">
    @if($errors->any())<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('client.reservations.store',$voiture) }}">
      @csrf
      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Date de début *</label>
          <input type="date" id="date_debut" name="date_debut" class="form-control" value="{{ old('date_debut') }}" min="{{ date('Y-m-d') }}" required onchange="calculerPrix()">
        </div>
        <div class="form-group">
          <label class="form-label">Date de fin *</label>
          <input type="date" id="date_fin" name="date_fin" class="form-control" value="{{ old('date_fin') }}" min="{{ date('Y-m-d') }}" required onchange="calculerPrix()">
        </div>
      </div>
      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Lieu de prise en charge *</label>
          <input type="text" name="lieu_prise_en_charge" class="form-control" value="{{ old('lieu_prise_en_charge') }}" placeholder="Ex: Tunis centre" required>
        </div>
        <div class="form-group">
          <label class="form-label">Lieu de retour *</label>
          <input type="text" name="lieu_retour" class="form-control" value="{{ old('lieu_retour') }}" placeholder="Ex: Aéroport Tunis" required>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Notes / Demandes spéciales</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="Siège bébé, heure d'arrivée...">{{ old('notes') }}</textarea>
      </div>
      {{-- Récapitulatif --}}
      <div id="recap" style="display:none;background:rgba(255,107,53,.08);border:1px solid rgba(255,107,53,.2);border-radius:12px;padding:16px;margin-bottom:20px;">
        <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:10px;color:var(--accent);">Récapitulatif</div>
        <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:.88rem;"><span style="color:var(--muted);">Durée</span><span id="nb_jours" style="font-weight:600;"></span></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:.88rem;"><span style="color:var(--muted);">Caution</span><span id="caution_val" style="font-weight:600;"></span></div>
        <div style="display:flex;justify-content:space-between;padding-top:10px;border-top:1px solid rgba(255,107,53,.2);"><span style="font-weight:700;">Total estimé</span><span id="prix_total" style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:800;color:var(--accent);"></span></div>
      </div>
      <button type="submit" class="btn btn-primary w-full" style="justify-content:center;padding:13px;font-size:.95rem;">
        <i class="fas fa-calendar-check"></i> Confirmer la réservation
      </button>
    </form>
  </div>
  {{-- Info voiture --}}
  <div>
    <div class="card">
      <div style="height:180px;background:linear-gradient(135deg,rgba(255,107,53,.15),rgba(108,99,255,.15));border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;overflow:hidden;">
        @if($voiture->image)<img src="{{ asset('storage/'.$voiture->image) }}" style="width:100%;height:100%;object-fit:cover;">
        @else<i class="fas fa-car" style="font-size:3rem;color:rgba(255,255,255,.2);"></i>@endif
      </div>
      <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;">{{ $voiture->marque }} {{ $voiture->modele }}</div>
      <div style="color:var(--muted);font-size:.82rem;margin-bottom:12px;">{{ $voiture->categorie }} · {{ $voiture->annee }}</div>
      <div style="font-family:'Syne',sans-serif;font-size:1.6rem;font-weight:800;color:var(--accent);">{{ $voiture->prix_par_jour }} DT <span style="font-size:.9rem;font-weight:400;color:var(--muted);">/jour</span></div>
    </div>
  </div>
</div>
@endsection
