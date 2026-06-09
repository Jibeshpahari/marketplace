<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index(){
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
}
