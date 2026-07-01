<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Affiche le formulaire pour envoyer un message
     */
    public function create(User $receiver)
    {
        return view('FAQBS.envoyer-message', compact('receiver'));
    }

    /**
     * Envoie un message à un utilisateur
     */
    public function store(Request $request, User $receiver)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $receiver->id;
        $message->subject = $validatedData['subject'];
        $message->content = $validatedData['content'];
        $message->is_read = false;

        $message->save();

        return redirect()->route('membres.manage')->with('success', 'Message envoyé avec succès !');
    }

    /**
     * Liste des messages reçus par l'utilisateur
     */
    public function inbox()
    {
        $receivedMessages = Message::where('receiver_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('FAQBS.boite-reception', compact('receivedMessages'));
    }

    /**
     * Affiche un message spécifique
     */
    public function show(Message $message)
    {
        // Marquer comme lu si le message est destiné à l'utilisateur connecté
        if ($message->receiver_id == Auth::id() && !$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return view('FAQBS.voir-message', compact('message'));
    }
}
