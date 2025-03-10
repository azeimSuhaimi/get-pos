<?php

namespace App\Mail;

use App\Models\user;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class toyyibpay_link extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private $datas = '';
    public function __construct(
        $datas = '',
    )
    {
        $this->datas = $datas;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $user = user::find($this->datas['company']['user_id']);

        return new Envelope(
            from: new Address($user->email, $user->name),
            subject: 'Delivery Toyyibpay Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.payment_link',
            with: [
                'company' => $this->datas['company'],
                'invoice' => $this->datas['invoice'],
                'invoice_detail' => $this->datas['invoice_detail'],
                
                'billcode' => $this->datas['billcode'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
