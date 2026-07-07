<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteSetting;
use Illuminate\Http\Request;

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

        return view('admin.site-settings', compact('title', 'nav'));
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

        return $this->{$methodMap[$tab]}($request);
    }

    public function storeSiteIdentity(Request $request)
    {
        try {
            $validated = $request->validate([
                'site_title'       => ['required', 'string', 'max:255'],
                'site_email'       => ['nullable', 'email', 'max:255'],
                'site_phone'       => ['nullable', 'string', 'max:20'],
                'site_logo'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
                'site_favicon'     => ['nullable', 'file', 'mimes:ico,png,svg', 'max:1024'],
                'timezone'         => ['nullable', 'string', 'timezone'],
                'language'         => ['nullable', 'string', 'max:10'],
                'currency'         => ['nullable', 'string', 'max:10'],
                'site_currency_symbol'  => ['required', 'string', 'max:5'],
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

            foreach ($validated as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return redirect()->back()->with('success', 'Site identity settings updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // This is what fires if a field fails validation (e.g. svg rejected, bad email, etc.)
            dd('VALIDATION ERROR:', $e->errors());
        } catch (\Illuminate\Database\QueryException $e) {
            // This is what fires if the DB write fails (wrong column, missing table, etc.)
            dd('DATABASE ERROR:', $e->getMessage());
        } catch (\Throwable $e) {
            // Catches anything else — file storage errors, undefined method, etc.
            dd('GENERAL ERROR:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
        }
    }

    public function storeAddress(Request $request) {}

    public function storeSocialLinks(Request $request) {}

    public function storeSEO(Request $request) {}
}
