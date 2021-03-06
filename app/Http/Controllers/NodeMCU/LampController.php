<?php

namespace App\Http\Controllers\NodeMCU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NodeMCU\Lamp;
use PhpMqtt\Client\Facades\MQTT;

class LampController extends Controller
{
    /*
    * Função para ligar e desligar a lâmpada.
    */
    public function toggleLamp()
    {
        $lamp = Lamp::get()->first();

        $this->publish($lamp->on);

        $status = $this->validateToggleLamp();

        if($status == "success"){
            $lamp->on = !$lamp->on;
    
            $lamp->save();

            return redirect()->back();
        } else {
            return redirect()->back()->with("error-message", "Falha ao executar a ação!");
        }
    }

    /**
     * Função responsável por publicar o estado da lâmpada para o tópico.
     * @param bool        $ledControl
     */
    private function publish($ledControl)
    {
        $mqtt = MQTT::connection();
        $mqtt->publish('lampInTopic', '{"LED_Control": '.$ledControl.',}');
    }

    /**
     * Função responsável por validar se a ação foi realiada com sucesso.
     * @return string
     */
    private function validateToggleLamp()
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe('lampMessage', function (string $topic, string $message, bool $retained) use ($mqtt) {
            $this->message = $message;
            
            $mqtt->interrupt();
        }, 0);

        $mqtt->loop(true);
        $mqtt->disconnect();

        return $this->message;
    }
}
