<?php

namespace App\Notifications;

use App\Models\Preventivo;
use App\Models\VocePExtraPerPersona;
use App\Models\VocePExtraUnaTantum;
use App\Models\VocePHotel;
use App\Models\VocePTrasportoPerPersona;
use App\Models\VocePTrasportoUnaTantum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Barryvdh\DomPDF\Facade\Pdf;

class InvioPreventivo extends Notification
{
    use Queueable;
    protected $preventivo;
    protected $pdf;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Preventivo $preventivo)
    {
        $this->preventivo = $preventivo;

        $vociPExtraPerPersona = VocePExtraPerPersona::where('preventivo_id', $preventivo->id)->get();
        $vociPExtraUnaTantum = VocePExtraUnaTantum::where('preventivo_id', $preventivo->id)->get();
        $vociPTrasportoPerPersona = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'trasporti')->get();
        $vociPTrasportoUnaTantum = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'trasporti')->get();

        $vociHotel = VocePHotel::where('preventivo_id', $preventivo->id)->get();

        $trasportoPrincipaleAndata = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        $trasportoPrincipaleRientro = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();

        if (!$trasportoPrincipaleAndata) {
            $trasportoPrincipaleAndata = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        }

        if (!$trasportoPrincipaleRientro) {
            $trasportoPrincipaleRientro = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();
        }

        $ciSonoHotel = VocePHotel::where('preventivo_id', $preventivo->id)->count();
        if ($ciSonoHotel > 0) {
            $ciSonoHotel = true;
        } else {
            $ciSonoHotel = false;
        }

        $this->pdf =  Pdf::loadView('frontend.pdfnew', compact('ciSonoHotel', 'preventivo', 'vociHotel', 'vociPExtraPerPersona', 'vociPExtraUnaTantum', 'vociPTrasportoPerPersona', 'vociPTrasportoUnaTantum', 'trasportoPrincipaleAndata', 'trasportoPrincipaleRientro'));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        $message = (new MailMessage())
            ->subject('Preventivo ' . $this->preventivo->numero . '/' . $this->preventivo->anno . ' - La Bussola')
            ->greeting('Gentile ' .  $this->preventivo->cliente->nome . " " .  $this->preventivo->cliente->cognome . ",")
            ->line(new HtmlString($this->preventivo->corpo_email))
            ->action('Visualizza preventivo', route('preventivo', $this->preventivo->guid) . "?view_key=" . $this->preventivo->guid)
            ->line(new HtmlString('<div style="margin-bottom:20px;display:flex;  align-items: center;justify-content: center;"><div style="text-align:center;"><a  href="' . route('accetta.preventivo', ['uuid' => $this->preventivo->guid]) . '" class="button button-success">Accetta preventivo</a></div><div style="padding-left:3pt;text-align:center;"><a style="text-align:center;" href="' . route('rifiuta.preventivo', ['uuid' => $this->preventivo->guid]) . '" class="button button-error">Rifiuta preventivo</a></div></div>'))
            ->line('Cordiali saluti,')
            ->line($this->preventivo->created_by->name)
            ->line($this->preventivo->created_by->telefono)
            ->line(new HtmlString('<br><br>'))
            ->line(new HtmlString('La Bussola srl<br>
            Via Altaguardia, 1 - 20135 MI ITALY<br>
            preventivi@labussola.it<br>P.iva 08114120960 <br> Rea MI-2003676'))
            ->salutation(' ')->attachData(
                $this->pdf->output(),
                'Preventivo ' . $this->preventivo->numero . '/' . $this->preventivo->anno .  ' LaBussola Srl.pdf'
            );

        if ( isset($this->preventivo->cc_email) ) {
            if ( $this->preventivo->cc_email ) {
                $message->cc($this->preventivo->cc_email);
            }
        }

        return $message;
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
