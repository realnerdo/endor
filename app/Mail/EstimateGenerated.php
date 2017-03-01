<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Estimate;

class EstimateGenerated extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * The data instance.
    *
    * @var array
    */
   public $estimate;
   public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Estimate $estimate, $request)
    {
        $this->estimate = $estimate;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.estimate')
                ->subject($this->request->input('subject'))
                ->attach($this->request->input('pdf'));
    }
}
