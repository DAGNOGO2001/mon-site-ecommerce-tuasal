{{-- <x-app-layout> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
:root{
    --primary:#3b71ca;
    --danger:#e63946;
    --bg:#eef5f1;
    --header:#3a5a40;
    --radius:12px;
}

body{
    background:var(--bg);
    font-family:Segoe UI,Roboto,Arial;
}

/* CONTAINER */
.dashboard-container{
    width:100%;
    padding:25px;
}

/* HEADER */
.dashboard-header{
    background:var(--header);
    color:white;
    padding:25px;
    border-radius:var(--radius);
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.dashboard-title{
    font-size:22px;
    font-weight:700;
}

.dashboard-subtitle{
    font-size:14px;
    opacity:0.8;
}

.user-count{
    background:#1b4332;
    padding:10px 20px;
    border-radius:30px;
    font-weight:bold;
}

/* SEARCH BAR */
#searchInput{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    margin-bottom:15px;
}

/* CARD */
.card-table{
    background:white;
    border-radius:var(--radius);
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
    overflow:hidden;
}

/* TABLE */
.table{
    width:100%;
    border-collapse:collapse;
}

.table thead{
    background:#f1f5f9;
}

.table th{
    text-transform:uppercase;
    font-size:13px;
    padding:15px;
    text-align:left;
}

.table td{
    padding:15px;
    vertical-align:middle;
}

.table tbody tr{
    border-top:1px solid #eee;
}

.table tbody tr:hover{
    background:#f9fafb;
}

/* USER */
.user-info{
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#e6f0ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    color:var(--primary);
}

/* ROLE BADGE */
.role-badge{
    background:#e8f3ff;
    color:var(--primary);
    padding:5px 12px;
    border-radius:20px;
    font-size:13px;
}

/* ACTIONS */
.action-box{
    display:flex;
    flex-direction:column;
    gap:8px;
    align-items:center;
}

/* BUTTONS */
.btn-edit{
    background:var(--primary);
    color:white;
    border:none;
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    text-decoration:none;
}

.btn-edit:hover{
    background:#2f5db3;
}

.btn-delete{
    background:var(--danger);
    color:white;
    border:none;
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    text-decoration:none;
}

.btn-delete:hover{
    background:#c1121f;
}

/* RESPONSIVE */
@media(max-width:768px){
    .table-responsive{
        overflow-x:auto;
    }
}
</style>

<div class="dashboard-container">

    <!-- HEADER -->
    <div class="dashboard-header">
        <div>
            <div class="dashboard-title">
                <i class="bi bi-people-fill"></i>
                Gestion des utilisateurs
            </div>
            <div class="dashboard-subtitle">
                Liste complète des utilisateurs et gestion des rôles
            </div>
        </div>
        <div class="user-count">
            👥 {{ $users->count() }} utilisateurs
        </div>
    </div>

    <!-- SEARCH -->
    <input type="text" id="searchInput" placeholder="🔍 Rechercher utilisateur...">

    <!-- TABLE -->
    <div class="card-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Rôles</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="avatar">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                                <div>
                                    {{ $user->name }}
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse($user->roles as $role)
                                <span class="role-badge">{{ $role->name }}</span>
                            @empty
                                <span style="color:#888">Aucun rôle</span>
                            @endforelse
                        </td>
                        <td class="text-center">
                            <div class="action-box">
                                <a href="{{ route('roles.edit',$user->id) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <a href="{{ route('supprimer',$user->id) }}" class="btn-delete">
                                    <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');
const tableBody = document.getElementById('usersTableBody');

searchInput.addEventListener('keyup', function() {
    const query = this.value.toLowerCase();
    const rows = tableBody.getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const name = row.cells[0].innerText.toLowerCase();
        const email = row.cells[1].innerText.toLowerCase();
        const roles = row.cells[2].innerText.toLowerCase();

        if(name.includes(query) || email.includes(query) || roles.includes(query)){
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

{{-- </x-app-layout> --}}