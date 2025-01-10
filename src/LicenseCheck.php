<?php



namespace Mamdou7alhosary\LicenseProtection;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LicenseCheck {
    public function handle(Request $request, Closure $next) {
        $domain = $request->getHost();
        $licenseKey = env('LICENSE_KEY');

        $response = Http::get('https://icrm.com.tr/api/check-license', [
            'domain' => $domain,
            'license_key' => $licenseKey
        ]);

        if (!$response->json()['valid']) {
            abort(403, '🚨 الترخيص غير صالح 🚨');
        }

        return $next($request);
    }
}
