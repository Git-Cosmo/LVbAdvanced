@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Privacy Policy
            </h1>
            <p class="dark:text-dark-text-secondary text-light-text-secondary">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>

        <!-- Content -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8 space-y-8">
            
            <!-- Section 1: Introduction -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    1. Introduction
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        FPSociety ("we," "our," or "us") respects your privacy and is committed to protecting your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our gaming community platform.
                    </p>
                </div>
            </section>

            <!-- Section 2: Information We Collect -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    2. Information We Collect
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                            2.1 Personal Information
                        </h3>
                        <p class="mb-2">We collect information you provide directly to us, including:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Username and display name</li>
                            <li>Email address</li>
                            <li>Password (encrypted)</li>
                            <li>Profile information (avatar, bio, gaming preferences)</li>
                            <li>OAuth data from third-party services (Steam, Discord, Battle.net)</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                            2.2 Usage Information
                        </h3>
                        <p class="mb-2">We automatically collect certain information when you use the Platform:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>IP address and location data</li>
                            <li>Browser type and version</li>
                            <li>Device information</li>
                            <li>Pages visited and time spent</li>
                            <li>Interaction with forums, posts, and comments</li>
                            <li>Download activity</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                            2.3 Cookies and Tracking Technologies
                        </h3>
                        <p>
                            We use cookies and similar tracking technologies to track activity on our Platform and store certain information. You can instruct your browser to refuse cookies or indicate when a cookie is being sent.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 3: How We Use Your Information -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    3. How We Use Your Information
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>We use the collected information for various purposes:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>To provide, maintain, and improve our Platform</li>
                        <li>To authenticate users and maintain account security</li>
                        <li>To personalize your experience and recommend content</li>
                        <li>To send notifications about your account and activity</li>
                        <li>To communicate with you about updates, news, and promotions</li>
                        <li>To detect, prevent, and address technical issues and abuse</li>
                        <li>To analyze usage patterns and improve our services</li>
                        <li>To comply with legal obligations</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4: Information Sharing -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    4. Information Sharing and Disclosure
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>We do not sell your personal information. We may share your information in the following circumstances:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li><strong>Public Information:</strong> Your username, profile information, and public posts are visible to other users</li>
                        <li><strong>Service Providers:</strong> We may share data with third-party service providers who assist in operating our Platform</li>
                        <li><strong>Legal Requirements:</strong> We may disclose information if required by law or in response to legal requests</li>
                        <li><strong>Business Transfers:</strong> Information may be transferred in connection with a merger, sale, or acquisition</li>
                    </ul>
                </div>
            </section>

            <!-- Section 5: Data Security -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    5. Data Security
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        We implement appropriate technical and organizational measures to protect your personal data, including:
                    </p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Encryption of sensitive data (passwords, authentication tokens)</li>
                        <li>Secure HTTPS connections</li>
                        <li>Regular security audits and updates</li>
                        <li>Access controls and authentication requirements</li>
                        <li>Two-factor authentication (2FA) options</li>
                    </ul>
                    <p>
                        However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.
                    </p>
                </div>
            </section>

            <!-- Section 6: Your Rights -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    6. Your Privacy Rights
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>You have the following rights regarding your personal data:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li><strong>Access:</strong> Request a copy of the personal data we hold about you</li>
                        <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                        <li><strong>Deletion:</strong> Request deletion of your account and associated data</li>
                        <li><strong>Portability:</strong> Request a copy of your data in a portable format</li>
                        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                        <li><strong>Object:</strong> Object to certain processing of your data</li>
                    </ul>
                    <p>
                        To exercise these rights, please contact us through our <a href="{{ route('contact') }}" class="text-accent-blue hover:underline">Contact Page</a>.
                    </p>
                </div>
            </section>

            <!-- Section 7: Data Retention -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    7. Data Retention
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        We retain your personal data only for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required by law. When you delete your account, we will delete or anonymize your personal data within 30 days.
                    </p>
                </div>
            </section>

            <!-- Section 8: Children's Privacy -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    8. Children's Privacy
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        Our Platform is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us.
                    </p>
                </div>
            </section>

            <!-- Section 9: International Transfers -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    9. International Data Transfers
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        Your information may be transferred to and maintained on servers located outside of your country. We take appropriate measures to ensure that your data is treated securely and in accordance with this Privacy Policy.
                    </p>
                </div>
            </section>

            <!-- Section 10: Changes to Policy -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    10. Changes to This Privacy Policy
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date.
                    </p>
                </div>
            </section>

            <!-- Section 11: Contact -->
            <section>
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                    11. Contact Us
                </h2>
                <div class="dark:text-dark-text-primary text-light-text-primary space-y-3">
                    <p>
                        If you have any questions or concerns about this Privacy Policy or our data practices, please contact us through our <a href="{{ route('contact') }}" class="text-accent-blue hover:underline">Contact Page</a>.
                    </p>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
