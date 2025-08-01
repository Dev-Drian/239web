<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Client;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(30);
        return view('board.index', compact('clients'));
    }

    public function allTaskBoard(){
        $clients = Client::all();
        return view('board.allTaskBoard', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::where('highlevel_id', $id)->first();
        if (!$client) {
            // Si no se encuentra el cliente, podemos buscar por board_id
            $board = Board::find($id); // Suponiendo que estás pasando el board_id
            if (!$board) {
                return view('clients.client_404');
            }
            $client = $board->client; // Si tienes una relación inversa en el modelo Board
        } else {
            // Si encontramos el cliente, buscamos el board
            $board = $client->board()->firstOrCreate([
                'name' => 'Board-' . $client->highlevel_id
            ]);
        }
        
        return view('board.show', compact('client'));
    }
}
