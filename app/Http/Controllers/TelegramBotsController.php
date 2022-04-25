<?php

namespace App\Http\Controllers;

use App\Models\TelegramBot;
use App\Models\TelegramChat;
use App\Models\TelegramChatMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TelegramBotsController extends Controller
{
    public function index()
    {
        $bots = TelegramBot::all();

        return Inertia::render('Telegram/Index')->with('bots', $bots);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:telegram_bots',
            'token' => 'required|unique:telegram_bots',
        ]);

        $bot = new TelegramBot;
        $bot->name = $request->name;
        $bot->token = $request->token;
        $bot->save();

        return Redirect::route('telegram.index')->with('message', 'Bot succesvol aangemaakt!');;
    }

    public function show(TelegramBot $telegramBot)
    {
        //
    }

    public function edit(TelegramBot $telegramBot)
    {
        //
    }

    public function update(Request $request, TelegramBot $telegramBot)
    {
        //
    }

    public function destroy(TelegramBot $telegramBot)
    {
        //
    }

    public function webhook(Request $request)
    {
//        $path = "https://api.telegram.org/bot5307159749:AAEiJzmNfY_sKqP8hH2Y8R2V2y5a7IBftSY";
        $response = Http::get('https://api.telegram.org/bot5307159749:AAEiJzmNfY_sKqP8hH2Y8R2V2y5a7IBftSY/sendmessage?chat_id=-737197277&text=Hallo!');

        try {
            $chat = TelegramChat::updateOrCreate(
                [
                    'chat_id' => $request['message']['chat']['id'],
                ],
                [
                    'title' => $request['message']['chat']['title'],
                    'type' => $request['message']['chat']['type'],
                    'all_members_are_administrators' => $request['message']['chat']['all_members_are_administrators'],
                ]
            );
        } catch (\Exception $e) {
            Log::error($e);
        }

        try {
        $messages = new TelegramChatMessages;
        $messages->update_id = $request['update_id'];
        $messages->message_id = $request['message']['message_id'];
        $messages->user_id = $request['message']['from']['id'];
        $messages->is_bot = $request['message']['from']['is_bot'];
        $messages->user_first_name = $request['message']['from']['first_name'];
        $messages->user_last_name = $request['message']['from']['last_name'];
        $messages->user_username = $request['message']['from']['username'];
        $messages->user_language_code = $request['message']['from']['language_code'];
        $messages->chat_id = $request['message']['chat']['id'];
        $messages->date = strftime("%Y-%m-%d %H:%M:%S", $request['message']['date']);
        $messages->text = $request['message']['text'];
        $messages->save();
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
