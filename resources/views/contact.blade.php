@extends('layouts.app')
@section('title', 'Contact Us')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@section('content')

    <section class="contact-hero">
        <span>CONTACT US</span>
        <h1>Get in Touch</h1>
        <p>If you have any questions, concerns, or orders, feel free to reach out to us. We will get back to you as soon as possible.</p>
    </section>

    <section class="contact-wrap">
        <div class="contact-card">

            <div class="contact-info">
                <h2>Contact Information</h2>
                <p>You can also reach us through the options below.</p>

                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div>
                        <small>Address</small>
                        <strong>Multan, Punjab, Pakistan</strong>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div>
                        <small>Phone</small>
                        <strong>+92 300 0000000</strong>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">✉️</div>
                    <div>
                        <small>Email</small>
                        <strong>info@yourstore.com</strong>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">🕒</div>
                    <div>
                        <small>Working Hours</small>
                        <strong>Mon - Sat, 10am - 8pm</strong>
                    </div>
                </div>

                <div class="socials">
                    <a href="#">f</a>
                    <a href="#">in</a>
                    <a href="#">ig</a>
                    <a href="#">wa</a>
                </div>
            </div>

            <div class="contact-form">
                <h2>Send a Message</h2>
                <p>Fill out the form and we will reply within 24 hours.</p>

                @if (session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="field">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ali Khan" required>
                            @error('name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="ali@example.com" required>
                            @error('email') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="What is your message about?">
                        @error('subject') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Enter your message here..." required>{{ old('message') }}</textarea>
                        @error('message') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn-send">Send Message →</button>
                </form>
            </div>

        </div>
    </section>

@endsection