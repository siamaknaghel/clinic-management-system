
<div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:0.5rem;">
    @foreach (\Spatie\Permission\Models\Permission::whereIn('id', $get('inherited_permissions') ?? [])->get() as $permission)
        <div style="display:flex; align-items:center; gap:0.25rem;">
            <span style="color:green; font-size:0.75rem;">&#10003;</span>
            <span>{{ $permission->name }}</span>
        </div>
    @endforeach
</div>
