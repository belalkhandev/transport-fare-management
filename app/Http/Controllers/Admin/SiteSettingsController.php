<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\MediaRepository;
use App\Repositories\SiteSettingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteSettingsController extends Controller
{
    public function __construct(
        protected SiteSettingRepository $settingRepository,
        protected MediaRepository $mediaRepository
    )
    {
    }

    public function index()
    {
        $settings = $this->settingRepository->getSettings();

        return Inertia::render('SiteSettings', [
            'settings' => $settings
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|mimes:jpeg,jpg,png|max:512',
            'favicon' => 'nullable|mimes:jpeg,jpg,png|max:200',
            'footer_logo' => 'nullable|mimes:jpeg,jpg,png|max:512',
        ]);

        $settings = $this->settingRepository->savedByRequest($request);

        if ($request->hasFile('logo')) {
            $logo = $this->mediaRepository->uploadFile($request->logo, 'settings', $settings);

            if ($settings && $settings->logo) {
                $this->mediaRepository->deleteByMediaId($settings->logo);
            }

            $settings->logo = $logo->id;
            $settings->save();
        }

        if ($request->hasFile('favicon')) {
            $favicon = $this->mediaRepository->uploadFile($request->favicon, 'settings', $settings);
            if ($settings && $settings->favicon) {
                $this->mediaRepository->deleteByMediaId($settings->favicon);
            }
            $settings->favicon = $favicon->id;
            $settings->save();
        }

        if ($request->hasFile('footer_logo')) {
            $footerLogo = $this->mediaRepository->uploadFile($request->footer_logo, 'settings', $settings);
            if ($settings && $settings->footer_logo) {
                $this->mediaRepository->deleteByMediaId($settings->footer_logo);
            }
            $settings->footer_logo = $footerLogo->id;
            $settings->save();
        }

        return to_route('site.settings');
    }
}
