@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Terms of Service
            </h1>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>

        <!-- Content -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8 space-y-8">
            
            <!-- Section 1: Acceptance of Terms -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    1. Acceptance of Terms
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        By accessing and using FPSociety ("the Platform"), you accept and agree to be bound by the terms and provisions of this agreement. If you do not agree to these Terms of Service, please do not use the Platform.
                    </p>
                    <p>
                        We reserve the right to modify these terms at any time. Your continued use of the Platform following any changes indicates your acceptance of the new terms.
                    </p>
                </div>
            </section>

            <!-- Section 2: User Accounts -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    2. User Accounts
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        To access certain features of the Platform, you must register for an account. When registering, you agree to:
                    </p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Provide accurate, current, and complete information</li>
                        <li>Maintain and update your information to keep it accurate and current</li>
                        <li>Maintain the security of your password</li>
                        <li>Accept responsibility for all activities under your account</li>
                        <li>Notify us immediately of any unauthorized use of your account</li>
                    </ul>
                </div>
            </section>

            <!-- Section 3: User Content and Conduct -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    3. User Content and Conduct
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        Users are responsible for all content they post on the Platform. You agree not to post content that:
                    </p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Violates any applicable laws or regulations</li>
                        <li>Infringes on intellectual property rights of others</li>
                        <li>Contains hate speech, harassment, or discriminatory content</li>
                        <li>Promotes violence or illegal activities</li>
                        <li>Contains malware, viruses, or malicious code</li>
                        <li>Is spam or unsolicited advertising</li>
                        <li>Impersonates another person or entity</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4: Intellectual Property -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    4. Intellectual Property Rights
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        The Platform and its original content, features, and functionality are owned by FPSociety and are protected by international copyright, trademark, and other intellectual property laws.
                    </p>
                    <p>
                        By posting content on the Platform, you grant FPSociety a worldwide, non-exclusive, royalty-free license to use, reproduce, modify, and display your content in connection with operating the Platform.
                    </p>
                </div>
            </section>

            <!-- Section 5: Gaming Content -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    5. Gaming Content and Downloads
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        FPSociety provides a platform for sharing gaming-related content including maps, mods, skins, and other resources. Users who upload content represent and warrant that:
                    </p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>They own or have the right to share the content</li>
                        <li>The content does not violate any third-party rights</li>
                        <li>The content does not contain malicious software</li>
                        <li>They will comply with applicable game terms of service</li>
                    </ul>
                </div>
            </section>

            <!-- Section 6: Moderation -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    6. Moderation and Enforcement
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        We reserve the right to:
                    </p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Remove or modify any content that violates these terms</li>
                        <li>Suspend or terminate accounts that violate these terms</li>
                        <li>Monitor and record user activity on the Platform</li>
                        <li>Report illegal activity to appropriate authorities</li>
                    </ul>
                </div>
            </section>

            <!-- Section 7: Disclaimer -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    7. Disclaimer of Warranties
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        THE PLATFORM IS PROVIDED "AS IS" AND "AS AVAILABLE" WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. WE DO NOT WARRANT THAT THE PLATFORM WILL BE UNINTERRUPTED, SECURE, OR ERROR-FREE.
                    </p>
                </div>
            </section>

            <!-- Section 8: Limitation of Liability -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    8. Limitation of Liability
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        TO THE MAXIMUM EXTENT PERMITTED BY LAW, FPSOCIETY SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES ARISING OUT OF YOUR USE OF THE PLATFORM.
                    </p>
                </div>
            </section>

            <!-- Section 9: Contact -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    9. Contact Information
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        If you have any questions about these Terms of Service, please contact us through our <a href="{{ route('contact') }}" class="text-accent-blue hover:underline">Contact Page</a>.
                    </p>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
