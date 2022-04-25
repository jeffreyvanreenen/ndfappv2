<?php

namespace App\Http\Controllers;

use App\Models\TelegramBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $path = "https://api.telegram.org/bot5307159749:AAEiJzmNfY_sKqP8hH2Y8R2V2y5a7IBftSY";

        $response = Http::get('https://api.telegram.org/bot5307159749:AAEiJzmNfY_sKqP8hH2Y8R2V2y5a7IBftSY/sendmessage?chat_id=5307159749&text='.$request);


        exit;

        $request = json_decode($request);


        $chatId = $request->message->chat->id;
        $message = $request->message->text;

        if (strpos($message, "/weather") === 0) {
            $location = substr($message, 9);
            $weather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$location."&appid=mytoken"), TRUE)["weather"][0]["main"];
            file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Here's the weather in ".$location.": ". $weather);
        }
    }
}
