<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Employee;

class NewEmployeeNotification extends Notification
{
    use Queueable;
    public $employee;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
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
        return (new MailMessage)
            ->subject('New Employee Added')
            ->greeting('Hello,')
            ->line('A new employee has been added to your company.')
            ->line('**Name:** ' . $this->employee->first_name . ' ' . $this->employee->last_name)
            ->line('**Email:** ' . ($this->employee->email ?? 'N/A'))
            ->line('**Phone:** ' . ($this->employee->phone ?? 'N/A'))
            ->action('View Employees', url('/employees'))
            ->line('Thank you for using our application!');
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
