@extends('layouts.app')
@section('title','Clients – Admin')
@section('page-title','Gestion des clients')
@section('content')
<div class="section-header">
  <div class="section-title">Clients inscrits</div>
  <div style="color:var(--muted);font-size:.85rem;">{{ $clients->total() }} client(s)</div>
</div>
<div class="card" style="margin-bottom:20px;">
  <form method="GET" style="display:flex;gap:12px;">
    <div style="flex:1;"><label class="form-label">Recherche</label><input type="text" name="search" class="form-control" placeholder="Nom, email, téléphone..." value="{{ request('search') }}"></div>
    <div style="align-self:flex-end;"><button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button></div>
    <div style="align-self:flex-end;"><a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Reset</a></div>
  </form>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>Client</th><th>Email</th><th>Téléphone</th><th>CIN</th><th>Réservations</th><th>Inscrit le</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($clients as $c)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--grad-1),var(--accent-2));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">{{ strtoupper(substr($c->name,0,1)) }}</div>
              <div><div style="font-weight:600;">{{ $c->name }}</div></div>
            </div>
          </td>
          <td style="color:var(--muted);font-size:.85rem;">{{ $c->email }}</td>
          <td>{{ $c->phone ?? '–' }}</td>
          <td>{{ $c->cin ?? '–' }}</td>
          <td><span class="badge badge-info">{{ $c->reservations_count }}</span></td>
          <td style="color:var(--muted);font-size:.82rem;">{{ $c->created_at->format('d/m/Y') }}</td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.clients.show',$c) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
              <form method="POST" action="{{ route('admin.clients.destroy',$c) }}" onsubmit="return confirm('Supprimer ce client ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:40px 0;">Aucun client trouvé</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $clients->withQueryString()->links('pagination::simple-tailwind') }}</div>
</div>
@endsection
