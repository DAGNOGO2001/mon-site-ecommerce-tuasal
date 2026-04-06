<?php

namespace App\Http\Controllers;
use App\Models\Avis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    //
    //     public function index()
    // {
    //     $avis = Avis::latest()->get();

    //     return view('client.avis', compact('avis'));
public function store(Request $request)
{
    $request->validate([
        'note' => 'required|integer|min:1|max:5',
        'commentaire' => 'required|string'
    ]);

    $user = Auth::guard('web')->user();

    Avis::create([
        'note' => $request->note,
        'commentaire' => $request->commentaire,
        'utilisateur' => $user ? $user->name : 'Anonyme'
    ]);

    return back()->with('success', 'Merci pour votre avis 👍');
}
    public function adminIndex()
{
    $avis = Avis::latest()->get();

    return view('admin.avis', compact('avis'));
}
public function index()
{
    $avis = Avis::latest()->get();
    $moyenne = Avis::avg('note');

    return view('client.avis', compact('avis', 'moyenne'));
}
    public function destroy($id)
{
    Avis::findOrFail($id)->delete();

    return back()->with('success', 'Avis supprimé 👍');
}
}