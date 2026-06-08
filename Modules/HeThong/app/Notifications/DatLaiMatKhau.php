<?php

namespace Modules\HeThong\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DatLaiMatKhau extends Notification
{
    public function __construct(private string $token) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('admin.dat-lai-mat-khau', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu — STU Tuyển Sinh')
            ->greeting('Chào ' . $notifiable->ho_ten . '!')
            ->line('Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
            ->action('Đặt lại mật khẩu', $url)
            ->line('Link đặt lại có hiệu lực trong **60 phút**.')
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, STU Tuyển Sinh');
    }
}