<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratBaruNotification extends Notification
{
    use Queueable;

    protected $surat;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $surat  Model Surat yang baru dibuat
     * @return void
     */
    public function __construct($surat)
    {
        $this->surat = $surat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'surat_id' => $this->surat->id,
            'jenis_surat' => class_basename($this->surat),
            'pesan' => 'Surat baru dengan nomor ' . $this->surat->no_surat . ' telah dibuat.',
        ];
    }
}
