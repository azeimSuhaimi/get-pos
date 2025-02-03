<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class send_receipt extends Mailable
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
        if(auth()->check())
        {
            return new Envelope(
                from: new Address(auth()->user()->email, auth()->user()->name),
                subject: 'Delivery Receipt',
            );
        }
        else
        {
            return new Envelope(
                from: new Address('noreply@gmail.com', 'noreply'),
                subject: 'Delivery Receipt',
            );
        }

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.payment_receipt',
            with: [
                'company' => $this->datas['company'],
                'payment_type' => $this->datas['payment_type'],
                'invoice' => $this->datas['invoice'],
                'invoice_detail' => $this->datas['invoice_detail'],
                'payment_method' => $this->datas['payment_method'],
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
