<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function commandeIndex()
    {
        $commandes = Commande::orderBy('created_at', 'desc')->paginate(14);
        return view('admin.commandes', compact('commandes'));
    }
}
