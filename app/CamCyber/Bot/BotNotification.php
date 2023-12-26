<?php

namespace App\CamCyber\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;
use App\Models\Telegram\Telegram;

class BotNotification extends Controller
{

    // =========================================================================================>> Order
    public static function survey($survey){

        $totalProduct = ''; 
        $i = 1; 
        $total = 0; 

        if($survey){

            //$chatID = env('FORGET_PASSWORD_CHANNEL_CHAT_ID'); 
            $chatID = Telegram::where('slug', 'CHANNEL_SURVEY_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => '<b> </b>

<b>អគ្គលេខាធិការដ្ឋាន  អាជ្ញាធរសេវាហិរញ្ញវត្ថុមិនមែនធនាគារ</b>
-------------------------------------------------
<b>ពត៍មាននៃការវាយតម្លៃ</b>
- កាលបរិច្ឆេទ: '.$survey->updated_at.'
- និយ័តករ: '.$survey->regulator->name.'
- កម្រិតវាយតម្លៃ: '.$survey->type->name.'
- ការផ្ដល់មតិយោបល់: '.$survey->comment.'
-------------------------------------------------
',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }

    // =========================================================================================>> Order
    public static function expense($expense){

        if($expense){

            //$chatID = env('FORGET_PASSWORD_CHANNEL_CHAT_ID'); 
            $chatID = Telegram::where('slug', 'CHANNEL_ORDER_UAT_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => '<b> វិក័យបត្រការចំណាយ</b>
* ប្រភេទការចំណាយ: '.$expense->type->name.'
* អ្នកបង្កើត: '.$expense->creator->name.'
* ចំនួនទឹកប្រាក់: '.$expense->amount.'
* ការពិពណ៌នាផ្សេងៗ: '.$expense->description.'
* កាលបរិច្ឆេទការចំណាយ: '.$expense->created_at.'
',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }

}