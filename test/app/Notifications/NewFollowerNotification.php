<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class NewFollowerNotification extends Notification
{
    use Queueable;

    protected $follower;

    /**
     * Crée une nouvelle instance de notification
     */
    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }

    /**
     * Canaux de notification (ici base de données)
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Contenu de la notification stockée en base
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->follower->name . ' vous suit maintenant !',
            'follower_id' => $this->follower->id,
        ];
    }
}

