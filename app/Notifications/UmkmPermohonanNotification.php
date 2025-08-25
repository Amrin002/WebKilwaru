<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UmkmPermohonanNotification extends Notification
{
    use Queueable;

    protected $umkm;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $umkm  Model Umkm yang baru dibuat
     * @return void
     */
    public function __construct($umkm)
    {
        $this->umkm = $umkm;
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
            'umkm_id' => $this->umkm->id,
            'nama_umkm' => $this->umkm->nama_umkm,
            'pesan' => 'Ada permohonan UMKM baru dari ' . $this->umkm->nama_umkm . '.',
        ];
    }
}
