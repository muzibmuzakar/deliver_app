<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SuratBaruNotification extends Notification
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
            'title' => 'Surat Baru Ditugaskan',
            'message' => 'Anda menerima surat baru dengan No. Resi: ' . $this->surat->no_resi,
            'surat_id' => $this->surat->id,
        ];
    }
}
