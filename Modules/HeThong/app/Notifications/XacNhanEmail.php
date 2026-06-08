<?php

namespace Modules\HeThong\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class XacNhanEmail extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Xác nhận địa chỉ email — STU Tuyển Sinh')
            ->greeting('Chào ' . $notifiable->ho_ten . '!')
            ->line('Cảm ơn bạn đã đăng ký tài khoản tại hệ thống tuyển sinh STU.')
            ->line('Tài khoản của bạn đã được tạo thành công.')
            ->action('Vào hệ thống', url('/thi-sinh/dashboard'))
            ->line('Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, STU Tuyển Sinh');
    }
}