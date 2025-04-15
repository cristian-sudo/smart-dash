<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Log;
use Exception;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $showSuccess = false;
    public $showError = false;
    public $errorMessage = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|min:10|max:1000',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'name.min' => 'Your name must be at least 3 characters.',
        'name.max' => 'Your name cannot exceed 255 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Your email cannot exceed 255 characters.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Your message must be at least 10 characters.',
        'message.max' => 'Your message cannot exceed 1000 characters.',
    ];

    public function submit()
    {
        $this->validate();
        $this->resetErrorBag();
        $this->showError = false;
        $this->showSuccess = false;

        try {
            // Debug mail configuration
            $mailConfig = [
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
                'admin_email' => config('mail.admin_email'),
            ];
            Log::info('Mail configuration', $mailConfig);

            // Check mail configuration
            if (!config('mail.from.address')) {
                throw new Exception('Mail from address is not configured.');
            }

            // Get admin email from config
            $adminEmail = config('mail.admin_email');
            if (!$adminEmail) {
                throw new Exception('Admin email is not configured.');
            }

            Log::info('Attempting to send email', [
                'to' => $adminEmail,
                'from' => $mailConfig['from_address'],
                'name' => $this->name,
                'email' => $this->email
            ]);

            // Create and send the email
            $mailable = new ContactFormSubmission(
                $this->name,
                $this->email,
                $this->message
            );

            Mail::to($adminEmail)->send($mailable);

            // Log success
            Log::info('Contact form submitted successfully', [
                'to' => $adminEmail,
                'from' => $this->email,
                'name' => $this->name
            ]);

            // Reset form and show success message
            $this->reset(['name', 'email', 'message']);
            $this->showSuccess = true;

        } catch (Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'from' => $this->email,
                'name' => $this->name,
                'mail_config' => $mailConfig ?? null
            ]);

            $this->showError = true;
            if (app()->environment('local')) {
                $this->errorMessage = 'Error: ' . $e->getMessage();
            } else {
                $this->errorMessage = 'Sorry, there was an error sending your message. Please try again later.';
            }
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
} 