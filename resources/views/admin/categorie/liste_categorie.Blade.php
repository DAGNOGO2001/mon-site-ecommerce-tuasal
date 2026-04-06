{{-- resources/views/categories/index.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des catégories</title>
<style>
/* container */
.category-page{
    font-family:Segoe UI;
    padding:20px;
}

/* titre */
h2{
    font-weight:600;
    text-align:center;
    margin-bottom:20px;
}

/* message */
.alert-success-box{
    background:#4CAF50;
    color:white;
    padding:10px;
    border-radius:5px;
    margin-bottom:20px;
}

/* top bar */
.top-bar{
    display:flex;
    justify-content:flex-end;
    margin-bottom:20px;
}

.btn-add{
    background:#2f6b4a;
    color:white;
    padding:10px 20px;
    border-radius:6px;
    text-decoration:none;
}
.btn-add:hover{
    background:#1f5035;
}

/* search bar */
#searchInput{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    margin-bottom:15px;
    font-size:14px;
}

/* tableau */
.category-table{
    width:100%;
    border-collapse:collapse;
}

.category-table th{
    background:#2f6b4a;
    color:white;
    padding:12px;
    text-align:center;
}

.category-table td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
    vertical-align:middle;
}

.category-table tr:hover{
    background:#f5f5f5;
}

/* cellule action */
.action-cell{
    white-space:nowrap;
}

/* bouton modifier */
.btn-edit{
    background:#2196F3;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    text-decoration:none;
    margin-right:5px;
}
.btn-edit:hover{
    background:#0b7dda;
}

/* bouton supprimer */
.btn-delete{
    background:#e53935;
    color:white;
    border:none;
    padding:6px 12px;
    border-radius:5px;
    cursor:pointer;
}
.btn-delete:hover{
    background:#c62828;
}

/* lien categorie */
.category-link{
    font-weight:bold;
    color:#2f6b4a;
    text-decoration:none;
    padding:4px 6px;
    border-radius:4px;
    transition:0.3s;
}
.category-link:hover{
    background:#2f6b4a;
    color:white;
}

/* image categorie */
.category-img {
    width: 80px;
    height: 80px;
    object-fit: contain; /* <-- garde toute l'image visible */
    background: #f5f5f5; /* fond clair */
    border-radius:6px;
    padding:5px;
}

</style>
</head>
<body>

<div class="container category-page">

    <h2>Liste des catégories</h2>

    @if(session('success'))
    <div class="alert-success-box">
        {{ session('success') }}
    </div>
    @endif

    <div class="top-bar">
        <a href="{{ route('categories.create') }}" class="btn-add">
            + Ajouter une catégorie
        </a>
    </div>

    <!-- SEARCH BAR -->
    <input type="text" id="searchInput" placeholder="🔍 Rechercher une catégorie...">

    <div class="table-container">
        <table class="category-table" id="categoriesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>
                        @if($cat->image)
                        <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" class="category-img">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.show', $cat->id) }}" class="category-link">
                            {{ $cat->name }}
                        </a>
                    </td>
                    <td>{{ $cat->description }}</td>
                    <td class="action-cell">
                        <a href="{{ route('categories.edit', $cat->id) }}" class="btn-edit">
                            ✏ Modifier
                        </a>
                        <form action="{{ route('categories.delete', $cat->id) }}" method="POST" class="delete-form" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Supprimer cette catégorie ?')" class="btn-delete">
                                🗑 Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');
const table = document.getElementById('categoriesTable').getElementsByTagName('tbody')[0];

searchInput.addEventListener('keyup', function(){
    const query = this.value.toLowerCase();
    const rows = table.getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const name = row.cells[2].innerText.toLowerCase();
        const desc = row.cells[3].innerText.toLowerCase();
        if(name.includes(query) || desc.includes(query)){
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</body>
</html>