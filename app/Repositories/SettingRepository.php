<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingRepository extends Repository
{
    public function model()
    {
        return Setting::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([
            'name' => $request->name,
            'value' => $request->value
        ]);
    }


    public function updateByRequest(Request $request, $settingId)
    {
        return $this->query()->findOrFail($settingId)->update([
                'name' => $request->name,
                'value' => $request->value
            ]);
    }

    public function deleteByRequest($settingId)
    {
        return $this->query()
            ->findOrFail($settingId)->delete();
    }

    public function getValueByName($name)
    {
        return $this->query()
            ->where('name', $name)
            ->first()
            ?->value;
    }

}
