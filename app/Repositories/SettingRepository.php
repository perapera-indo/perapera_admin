<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{

    public function settingFindById($id)
    {
        return Setting::findOrFail($id);
    }

    public function update($data, $id)
    {
        $setting = $this->settingFindById($id);
        $setting->application_name = $data['application_name'];
        $setting->allow_public_register = $data['allow_public_register'] == 'false' ? false : true ;
        $setting->allow_full_sidebar = $data['allow_full_sidebar'] == 'false' ? false : true ;

        if (!empty($data['logo'])) {
            $logo = $data['logo'];
            @unlink(public_path().$setting->logo);
            $logoFilename = 'logo_'.time() . '.' . $logo->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/setting/attachment/';
            $logo->move($destinationPath, $logoFilename);
            $setting->logo = '/uploads/setting/attachment/'.$logoFilename;;
        }

        if (!empty($data['favicon'])) {
            $favicon = $data['favicon'];
            @unlink(public_path().$setting->favicon);
            $faviconFilename = 'favicon_'.time() . '.' . $favicon->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/setting/attachment/';
            $favicon->move($destinationPath, $faviconFilename);
            $setting->favicon = '/uploads/setting/attachment/'.$faviconFilename;;
        }
        $setting->update();

        return $setting;
    }
}
