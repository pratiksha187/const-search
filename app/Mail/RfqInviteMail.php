<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RfqInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rfq;
    public $vendor;
    public $boq;

    public function __construct($rfq, $vendor, $boq)
    {
        $this->rfq = $rfq;
        $this->vendor = $vendor;
        $this->boq = $boq;
    }

    public function build()
    {
        $mail = $this->subject('New RFQ Invite - ' . ($this->rfq->rfq_no ?? ('RFQ#'.$this->rfq->id)))
            ->view('emails.rfq_invite');

        // Attach BOQ if exists
        if ($this->boq && $this->boq->file_path) {
            $absPath = Storage::disk('public')->path($this->boq->file_path);
            if (file_exists($absPath)) {
                $mail->attach($absPath, [
                    'as' => $this->boq->original_name ?? ('BOQ.' . ($this->boq->file_ext ?? 'xlsx')),
                ]);
            }
        }

        return $mail;
    }
}