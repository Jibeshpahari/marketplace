<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $title = "Site Settings";
        $nav = [
            [
                'url' => route('admin.login.view'),
                'name' => 'Locations'
            ],
            [
                'name' => $title
            ]
        ];

        $setting = SiteSetting::all();

        // dd($setting);

        return view('admin.site-settings', compact('title', 'nav', 'setting'));
    }

    public function storeSiteSettings(Request $request)
    {
        $tab = $request->input('tab_name', 'site_identity');

        $methodMap = [
            'site_identity' => 'storeSiteIdentity',
            'address'       => 'storeAddress',
            'social_links'  => 'storeSocialLinks',
            'seo'           => 'storeSEO',
        ];

        if (!array_key_exists($tab, $methodMap)) {
            abort(404, "Unknown settings tab: {$tab}");
        }

        // Which tab is active  
        session()->flash('active_tab', $tab);

        return $this->{$methodMap[$tab]}($request);
    }

    public function storeSiteIdentity(Request $request)
    {
        $validated = $request->validate([
            'site_title'           => ['required', 'string', 'max:255'],
            'site_email'           => ['nullable', 'email', 'max:255'],
            'site_phone'           => ['nullable', 'string', 'max:20'],
            'site_logo'            => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'site_favicon'         => ['nullable', 'file', 'mimes:ico,png,svg', 'max:1024'],
            'site_timezone'        => ['nullable', 'string', 'timezone'],
            'site_language'        => ['nullable', 'string', 'max:10'],
            'site_currency'        => ['nullable', 'string', 'max:10'],
            'site_currency_symbol' => ['required', 'string', 'max:5'],
        ]);

        if ($request->hasFile('site_logo')) {
            $validated['site_logo'] = $request->file('site_logo')->store('site', 'public');
        } else {
            unset($validated['site_logo']);
        }

        if ($request->hasFile('site_favicon')) {
            $validated['site_favicon'] = $request->file('site_favicon')->store('site', 'public');
        } else {
            unset($validated['site_favicon']);
        }

        DB::beginTransaction();

        try {
            foreach ($validated as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Site identity settings updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Something went wrong, no changes were saved.')
                ->withInput();
        }
    }

    public function storeAddress(Request $request) {
        $validated = $request->validate([  //TODO - Remove rules from here and add Requests
            'address'  => ['required', 'string', 'max:255'],
            'city'     => ['required', 'string', 'max:100'],
            'state'    => ['required', 'string', 'max:100'],
            'country'  => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:20'],
            'map_link' => ['nullable', 'url', 'max:500'],    
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Site identity settings updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Something went wrong, no changes were saved.')
                ->withInput();
        }
    }

    public function storeSocialLinks(Request $request) {
        $validated = $request->validate([ //TODO - Remove rules from here and add Requests
            'facebook_link'  => ['nullable', 'url', 'max:500'],
            'instagram_link' => ['nullable', 'url', 'max:500'],
            'twitter_link'   => ['nullable', 'url', 'max:500'],
            'youtube_link'   => ['nullable', 'url', 'max:500'],
            'linkedin_link'  => ['nullable', 'url', 'max:500'],
            'whatsapp_link'  => ['nullable', 'url', 'max:500'],
            'tiktok_link'    => ['nullable', 'url', 'max:500'],
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Social links updated successfully.');
            
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong, no changes were saved.')->withInput();
        }
    }

    public function storeSEO(Request $request) {}  //TODO - Site setting Seo When needed
}
