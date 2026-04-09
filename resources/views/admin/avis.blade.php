<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des avis</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            margin:0;
            padding:20px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        .table-container{
            width:95%;
            margin:auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:700px;
        }

        th, td{
            padding:12px;
            border-bottom:1px solid #ddd;
            text-align:left;
        }

        th{
            background:#ff6600;
            color:white;
        }

        tr:hover{
            background:#f9f9f9;
        }

        .stars{
            color:#ffb400;
            font-size:16px;
        }

        button{
            background:red;
            color:white;
            border:none;
            padding:6px 10px;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:darkred;
        }

        @media screen and (max-width:768px){
            .table-container{
                padding:10px;
            }

            th, td{
                font-size:14px;
                padding:8px;
            }
        }
    </style>
</head>

<body>

<h2>⭐ Gestion des avis clients</h2>

<div class="table-container">

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach($avis as $a)
        <tr>
            <td>{{ $a->id }}</td>

            <!-- UTILISATEUR -->
            <td>{{ $a->utilisateur ?? 'Anonyme' }}</td>

            <!-- NOTE -->
            <td class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    {{ $i <= $a->note ? '⭐' : '☆' }}
                @endfor
            </td>

            <!-- COMMENTAIRE -->
            <td>{{ $a->commentaire }}</td>

            <!-- DATE -->
            <td>{{ $a->created_at->format('d/m/Y H:i') }}</td>

            <!-- ACTION -->
            <td>
                <form action="{{ url('/admin/avis/'.$a->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Supprimer cet avis ?')">
                        🗑 Supprimer
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>

</table>

</div>

</body>
</html>