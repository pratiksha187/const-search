<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class AgreementController extends Controller
{
    private string $version = 'v1.0';

    public function vendorshow(Request $request)
    {
        $vendorId = session('vendor_id'); // as per your header logic

        if(!$vendorId){
            return redirect()->route('login_register');
        }

        $vendor = DB::table('vendor_reg')->where('id', $vendorId)->first();

        return view('web.agreement', [
            'version' => $this->version,
            'vendor' => $vendor,
            'alreadyAccepted' => !empty($vendor->agreement_accepted_at) && $vendor->agreement_version === $this->version
        ]);
    }


    public function customershow(Request $request)
    {
        $customer_id = Session::get('customer_id');
        // dd($customer_id);
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');

                    
        $notifications = DB::table('vendor_interests as vi')
                ->whereIn('vi.customer_id', $postIds)
                ->get();
        $notificationCount = $notifications->count();
        if(!$customer_id){
            return redirect()->route('login_register');
        }

        $customer = DB::table('users')->where('id', $customer_id)->first();
        // dd($customer);

        return view('web.custagreement', [
            'version' => $this->version,'cust_data' => $cust_data,'notifications'=>$notifications,'notificationCount'=>$notificationCount,
            'customer' => $customer,
            'alreadyAccepted' => !empty($customer->agreement_accepted_at) && $customer->agreement_version === $this->version
        ]);
    }
    

 
   public function vendoraccept(Request $request)
    {
        $vendorId = session('vendor_id');
        if(!$vendorId){
            return redirect()->route('login_register');
        }

        $request->validate([
            'agree' => 'required|in:1',
            'version' => 'required|string',
        ]);

        $ua = strtolower((string) $request->userAgent());

        // ✅ Device type detection
        $deviceType = 'PC';
        if (preg_match('/ipad|tablet|kindle|playbook|silk/', $ua)) {
            $deviceType = 'Tablet';
        } elseif (preg_match('/mobi|android|iphone|ipod|blackberry|phone|opera mini|iemobile/', $ua)) {
            $deviceType = 'Mobile';
        }

        // ✅ Browser (optional, basic)
        $browser = 'Unknown';
        if (str_contains($ua, 'edg/')) $browser = 'Edge';
        elseif (str_contains($ua, 'opr/') || str_contains($ua, 'opera')) $browser = 'Opera';
        elseif (str_contains($ua, 'chrome/') && !str_contains($ua, 'edg/') && !str_contains($ua, 'opr/')) $browser = 'Chrome';
        elseif (str_contains($ua, 'safari/') && !str_contains($ua, 'chrome/')) $browser = 'Safari';
        elseif (str_contains($ua, 'firefox/')) $browser = 'Firefox';

        // ✅ Real IP (handles proxy/CDN)
        $ip = $request->header('CF-Connecting-IP')
            ?? $request->header('X-Real-IP')
            ?? $request->header('X-Forwarded-For');

        if ($ip && str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }
        $ip = $ip ?: $request->ip();

        DB::table('vendor_reg')->where('id', $vendorId)->update([
            'agreement_accepted_at' => now(),
            'agreement_version' => $request->version,
            'agreement_ip' => $ip,
            'agreement_user_agent' => (string) $request->userAgent(),

            // ✅ new fields
            'agreement_device_type' => $deviceType,
            'agreement_browser' => $browser,

            'updated_at' => now(),
        ]);

        return redirect()->route('vendordashboard')->with('success', 'Agreement accepted successfully.');
    }


    
 public function customeraccept(Request $request)
    {
        $customer_id = Session::get('customer_id');
        if(!$customer_id){
            return redirect()->route('login_register');
        }

        $request->validate([
            'agree' => 'required|in:1',
            'version' => 'required|string',
        ]);

        $ua = strtolower((string) $request->userAgent());
        // dd( $ua );
        // ✅ Device type detection
        $deviceType = 'PC';
        if (preg_match('/ipad|tablet|kindle|playbook|silk/', $ua)) {
            $deviceType = 'Tablet';
        } elseif (preg_match('/mobi|android|iphone|ipod|blackberry|phone|opera mini|iemobile/', $ua)) {
            $deviceType = 'Mobile';
        }

        // ✅ Browser (optional, basic)
        $browser = 'Unknown';
        if (str_contains($ua, 'edg/')) $browser = 'Edge';
        elseif (str_contains($ua, 'opr/') || str_contains($ua, 'opera')) $browser = 'Opera';
        elseif (str_contains($ua, 'chrome/') && !str_contains($ua, 'edg/') && !str_contains($ua, 'opr/')) $browser = 'Chrome';
        elseif (str_contains($ua, 'safari/') && !str_contains($ua, 'chrome/')) $browser = 'Safari';
        elseif (str_contains($ua, 'firefox/')) $browser = 'Firefox';

        // ✅ Real IP (handles proxy/CDN)
        $ip = $request->header('CF-Connecting-IP')
            ?? $request->header('X-Real-IP')
            ?? $request->header('X-Forwarded-For');

        if ($ip && str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }
        $ip = $ip ?: $request->ip();

        DB::table('users')->where('id', $customer_id)->update([
            'agreement_accepted_at' => now(),
            'agreement_version' => $request->version,
            'agreement_ip' => $ip,
            'agreement_user_agent' => (string) $request->userAgent(),

            // ✅ new fields
            'agreement_device_type' => $deviceType,
            'agreement_browser' => $browser,

            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Agreement accepted successfully.');
    }
}