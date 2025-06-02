<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratSelesaiNotification extends Notification
{
    use Queueable;

    protected $surat;

    public function __construct($surat)
    {
        $this->surat = $surat;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Update Progres",
            'message' => 'Pengiriman surat dengan resi ' . $this->surat->no_resi . ' telah selesai oleh kurir ' . $this->surat->kurir->name,
            'surat_id' => $this->surat->id,
        ];
    }
}
