<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function getContacts(): JsonResponse
    {
        $contacts = User::query()->where('id', '!=', auth()->id())->get();

        $unreadMessages = Message::query()->selectRaw('`from` as sender_id, count(`from`) as message_count')
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')->get();

        $contacts = $contacts->map(function ($contact) use ($unreadMessages) {
            $unreadContactMessages = $unreadMessages->where('sender_id', $contact->id)->first();

            $contact->unread = $unreadContactMessages ? $unreadContactMessages->message_count : 0;

            return $contact;
        });

        return response()->json($contacts);
    }

    public function conversations($id): JsonResponse
    {
        Message::query()->where('from', $id)
            ->where('to', auth()->id())->update([
                'read' => true
            ]);

        $messages = Message::query()->where(function (Builder $builder) use ($id) {
            $builder->where('from', auth()->id())
                ->where('to', $id);
        })->orWhere(function (Builder $builder) use ($id) {
            $builder->where('from', $id)
                ->where('to', auth()->id());
        })->get();

        return response()->json($messages);
    }

    public function messageSend(): JsonResponse
    {
        $message = Message::create([
            'from' => auth()->id(),
            'to' => \request('contact_id'),
            'text' => \request('text'),
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }
}
