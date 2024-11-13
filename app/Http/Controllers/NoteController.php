<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userId = Auth::id();
       // $notes = Note::where('user_id', $userId)->get();
       //$notes = Note::where('user_id', Auth::id())->latest()->get();
       $notes = Note::where('user_id', Auth::id())->latest('updated_at')->paginate(2);
       return view('notes.index')->with('notes', $notes);

        //dd($notes);
       /* $notes->each(function($note){
            dump($note->title);
        });*/

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
         $request->validate([
                'title' => 'required|string|max:255',
                'text' => 'required|string',
            ]);
    
            Note::create([
                'uuid' => Str::uuid(),
                'title' => $request->title,
                'text' => $request->text,
                'user_id' => auth()->id(),
            ]);
    
            return redirect()->route('notes.index')->with('success', 'Bejegyzés sikeresen hozzáadva.');
           // dd($request);
        }
    

    /**
     * Display the specified resource.
     */
    // Show metódus a teljes bejegyzés megjelenítéséhez
   /* public function show($uuid){
    // A note rekord keresése a uuid alapján és a user_id ellenőrzése
    $note = Note::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();

    return view('notes.show', ['note' => $note]);
}*/
public function show(Note $note)
    {
        if($note->user_id != Auth::id()){
            return abort(403);
        }

        return view('notes.show')->with('note', $note);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if($note->user_id != Auth::id()){
            return abort(403);
        }
        return view('notes.edit')->with('note', $note);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
       // dd($request);
       if($note->user_id != Auth::id()){
        return abort(403);
    }
       $request->validate([
        'title' => 'required|max:120',
        'text' => 'required'
    ]);
        $note->update([
        'title' => $request->title,
        'text' => $request->text
    ]);
    return to_route('notes.show', $note)->with('success', 'A bejegyzés frissítése megtörtént');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if($note->user_id != Auth::id()){
            return abort(403);
        }
        $note->delete();
        return to_route('notes.index')->with('success', 'A bejegyzés törölése sikeres');
    }

}
