@component('mail::message')
# New Contact Form Submission

**From:** {{ $name }} ({{ $email }})

**Message:**
{{ $message }}

---
This is an automated message from your website's contact form.
Reply to this email to respond to {{ $name }}.
@endcomponent 