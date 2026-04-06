{{-- <x-app-layout> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<audio id="notificationSound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

<style>

/* ================= GLOBAL ================= */
*{
    box-sizing:border-box;
    font-family:Arial;
}

body{
    margin:0;
    background:#f4f6f9;
}

/* ================= LAYOUT ================= */
.full-dashboard{
    display:flex;
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:260px;
    background:#0f172a;
    color:white;
    height:100vh;
    padding:20px;
}

.sidebar nav a{
    display:block;
    padding:12px;
    margin-bottom:8px;
    color:#cbd5e1;
    text-decoration:none;
    border-radius:8px;
}

.sidebar nav a:hover{
    background:#2563eb;
    color:white;
}

/* ================= CONTENT ================= */
.content{
    flex:1;
    padding:20px;
}

/* ================= TOP BAR ================= */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

/* ================= BADGE ================= */
.badge{
    background-color:#e74c3c;
    color:white;
    padding:5px 8px;
    border-radius:50%;
    font-size:12px;
    position:absolute;
    top:-8px;
    right:-10px;
}

.badge.pulse{
    animation:pulse 1s infinite;
}

@keyframes pulse{
    0%{transform:scale(1);}
    70%{transform:scale(1.2);}
    100%{transform:scale(1);}
}

/* ================= STATS ================= */
.main-grid{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.stat-card{
    flex:1;
    min-width:200px;
    background:white;
    padding:20px;
    border-radius:12px;
}

/* ================= CHARTS ================= */
.charts-container{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
    margin-top:20px;
}

.chart-box{
    background:white;
    padding:20px;
    border-radius:12px;
}

/* ================= PROFIL MENU ================= */
.profile-wrapper{
    position:relative;
    display:inline-block;
}

.profile-menu{
    display:none;
    position:absolute;
    right:0;
    top:40px;
    background:white;
    width:160px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.15);
    z-index:9999;
}

.profile-menu a,
.profile-menu button{
    display:block;
    width:100%;
    padding:10px;
    text-align:left;
    border:none;
    background:none;
    cursor:pointer;
    text-decoration:none;
    color:#333;
}

.profile-menu button{
    color:red;
}

/* ================= MOBILE ================= */
.menu-toggle{
    display:none;
    font-size:24px;
    cursor:pointer;
}

.overlay{
    display:none;
}

@media(max-width:768px){

    .full-dashboard{
        flex-direction:column;
    }

    .menu-toggle{
        display:block;
    }

    .sidebar{
        position:fixed;
        left:-100%;
        width:75%;
        height:100%;
        z-index:999;
    }

    .sidebar.active{
        left:0;
    }

    .overlay.active{
        display:block;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.5);
        z-index:998;
    }

    .charts-container{
        grid-template-columns:1fr;
    }
}

</style>

<div class="full-dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <h3>🛒 Admin Panel</h3>

        <nav>
            <a href="{{ route('admin.bord') }}">Tableau de bord</a>
            <a href="{{ route('admin.commandes') }}">Commandes</a>
            <a href="{{ route('liste_client') }}">Clients</a>
            <a href="{{ route('liste_categorie') }}">Catégories</a>
            <a href="{{ route('liste_produit') }}">Produits</a>
            <a href="/admin/avis" class="btn btn-primary">
                ⭐ Voir les avis clients
            </a>
        </nav>

    </aside>

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- CONTENT -->
    <div class="content">

        <!-- TOP BAR -->
        <div class="top-bar">

            <div style="display:flex;gap:10px;align-items:center;">
                <div class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </div>

                <h2>Tableau de bord</h2>
            </div>

            <div style="display:flex;gap:20px;align-items:center;position:relative;">

                <!-- NOTIF -->
                <div style="position:relative;">
                    <a href="{{ route('admin.commandes') }}">
                        <i class="bi bi-bell-fill" style="font-size:20px;"></i>

                        <span class="badge" id="messagesBadge"
                              style="{{ $messagesNonLus > 0 ? '' : 'display:none' }}">
                            {{ $messagesNonLus ?? 0 }}
                        </span>
                    </a>
                </div>

                <!-- PROFIL 100% FIX -->
                <div class="profile-wrapper">

                    <i class="bi bi-person-circle"
                       style="font-size:22px; cursor:pointer;"
                       onclick="toggleProfileMenu()">
                    </i>

                    <div class="profile-menu" id="profileMenu">

                        <a href="{{ route('profile.edit') }}">
                            👤 Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                🚪 Déconnexion
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

        <!-- STATS -->
        <div class="main-grid">

            <div class="stat-card">
                <h3>Ventes</h3>
                <h2>24 500 €</h2>
            </div>

            <div class="stat-card">
                <h3>Commandes</h3>
                <h2>1240</h2>
            </div>

            <div class="stat-card">
                <h3>Clients</h3>
                <h2>860</h2>
            </div>

            <div class="stat-card">
                <h3>Produits</h3>
                <h2>320</h2>
            </div>

        </div>

        <!-- CHARTS -->
        <div class="charts-container">

            <div class="chart-box">
                <h3>Ventes</h3>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="chart-box">
                <h3>Produits</h3>
                <canvas id="productChart"></canvas>
            </div>

        </div>

    </div>

</div>

<script>

/* SIDEBAR */
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('overlay').classList.toggle('active');
}

/* PROFIL MENU */
function toggleProfileMenu(){
    const menu = document.getElementById('profileMenu');

    if(menu.style.display === 'block'){
        menu.style.display = 'none';
    }else{
        menu.style.display = 'block';
    }
}

/* fermer menu au clic dehors */
document.addEventListener('click', function(e){

    const menu = document.getElementById('profileMenu');
    const icon = document.querySelector('.bi-person-circle');

    if(!menu.contains(e.target) && !icon.contains(e.target)){
        menu.style.display = 'none';
    }

});

/* CHARTS */
new Chart(document.getElementById('salesChart'),{
    type:'bar',
    data:{
        labels:['Jan','Fev','Mar','Avr','Mai','Juin'],
        datasets:[{ label:'Ventes', data:[1200,1900,3000,2500,3200,2800] }]
    }
});

new Chart(document.getElementById('productChart'),{
    type:'doughnut',
    data:{
        labels:['Electronique','Mode','Maison'],
        datasets:[{ data:[40,30,30] }]
    }
});

/* NOTIF AJAX */
function verifierCommandesNonLues(){

    fetch("{{ route('admin.commandes.non-lues.count') }}")
    .then(res => res.json())
    .then(data => {

        const badge = document.getElementById('messagesBadge');

        if(data.count > 0){
            badge.style.display = 'inline-block';
            badge.textContent = data.count;
            badge.classList.add('pulse');
        } else {
            badge.style.display = 'none';
            badge.classList.remove('pulse');
        }

    });

}

setInterval(verifierCommandesNonLues, 5000);

</script>

{{-- </x-app-layout> --}}