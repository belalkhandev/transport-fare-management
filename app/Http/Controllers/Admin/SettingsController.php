<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function __construct(
        protected SettingRepository $settingRepository
    )
    {
    }

    public function index()
    {
        $settings = $this->settingRepository->getByPaginate();

        return Inertia::render('Settings', [
            'settings' => $settings
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:settings,name'],
            'value' => ['required']
        ]);

        $this->settingRepository->storeByRequest($request);

        return to_route('settings.index');
    }

    public function update(Request $request, $settingId)
    {
        $request->validate([
            'name' => ['required', 'unique:settings,name,'.$settingId],
            'value' => ['required']
        ]);

        $this->settingRepository->updateByRequest($request, $settingId);

        return to_route('settings.index');
    }

    public function destroy($settingId)
    {
        $this->settingRepository->deleteByRequest($settingId);

        return to_route('settings.index');
    }
}
