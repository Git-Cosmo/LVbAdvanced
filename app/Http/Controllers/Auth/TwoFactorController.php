<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    /**
     * Show the 2FA challenge page.
     */
    public function challenge(): View
    {
        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the 2FA code.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = $request->user();

        if (!$user || !$user->two_factor_secret) {
            return redirect()->route('login')->withErrors(['code' => '2FA is not enabled for this account.']);
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey(decrypt($user->two_factor_secret), $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'The provided code is invalid.']);
        }

        session()->put('2fa_verified', true);

        return redirect()->intended(route('home'));
    }

    /**
     * Show the 2FA setup page.
     */
    public function setup(): View
    {
        $user = auth()->user();
        
        if ($user->two_factor_confirmed_at) {
            return view('auth.two-factor-manage');
        }

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        
        session()->put('2fa_secret', $secret);
        
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('auth.two-factor-setup', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $secret,
        ]);
    }

    /**
     * Enable 2FA for the user.
     */
    public function enable(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $secret = session()->get('2fa_secret');
        
        if (!$secret) {
            return redirect()->route('2fa.setup')->withErrors(['code' => 'Session expired. Please try again.']);
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'The provided code is invalid.']);
        }

        $user = auth()->user();
        
        // Generate 8 cryptographically secure recovery codes, each a 10-character hexadecimal string (generated from 5 random bytes)
        $recoveryCodes = Collection::times(8, function () {
            return bin2hex(random_bytes(5));
        });

        $user->forceFill([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes->all())),
            'two_factor_confirmed_at' => now(),
        ])->save();

        session()->forget('2fa_secret');

        return redirect()->route('profile.edit')->with('status', '2FA has been enabled successfully!')->with('recovery_codes', $recoveryCodes);
    }

    /**
     * Disable 2FA for the user.
     */
    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = auth()->user();
        
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return redirect()->route('profile.edit')->with('status', '2FA has been disabled.');
    }
}
