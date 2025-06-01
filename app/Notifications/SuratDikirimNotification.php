<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratDikirimNotification extends Notification
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
            'message' => 'Surat dengan resi ' . $this->surat->no_resi . ' sedang dikirim oleh kurir ' . $this->surat->kurir->name,
            'surat_id' => $this->surat->id,
        ];
    }
}
