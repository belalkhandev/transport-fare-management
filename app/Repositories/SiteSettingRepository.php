<?php

namespace App\Repositories;

use App\Models\SiteSetting;
use Illuminate\Support\Str;

class SiteSettingRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return SiteSetting::class;
    }

    public function getSettings()
    {
        return $this->query()
            ->with([
                'siteLogo',
                'siteFavicon',
                'footerLogo'
            ])->first();
    }

    public function savedByRequest($request)
    {
        $settings = $this->query()->first();

        if (!$settings) {
            return $this->query()->create([
                'ref' => Str::random(10),
                'site_title' => $request->input('site_title', null),
                'footer_summary' => $request->input('footer_summary', null),
                'copyright_text' => $request->input('copyright_text', null),
                'facebook' => $request->input('facebook', null),
                'twitter' => $request->input('twitter', null),
                'youtube' => $request->input('youtube', null),
                'linkedin' => $request->input('linkedin', null),
                'instagram' => $request->input('instagram', null),
            ]);
        }

        $settings->update([
            'site_title' => $request->input('site_title', null),
            'footer_summary' => $request->input('footer_summary', null),
            'copyright_text' => $request->input('copyright_text', null),
            'facebook' => $request->input('facebook', null),
            'twitter' => $request->input('twitter', null),
            'youtube' => $request->input('youtube', null),
            'linkedin' => $request->input('linkedin', null),
            'instagram' => $request->input('instagram', null),
        ]);

        return $settings->refresh();
    }
}
