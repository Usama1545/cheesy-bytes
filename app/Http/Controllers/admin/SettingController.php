<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterFeatures;
use App\Models\Order;
use App\Models\Pixcel;
use App\Models\Settings;
use App\Models\SocialLinks;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $getsettings = Settings::first();
        $getfooterfeatures = FooterFeatures::get();
        $getsociallink = SocialLinks::get();
        $pixelsettings = Pixcel::first();
        $order = Order::get();
        return view('admin.cms.settings', compact('getsettings', 'getfooterfeatures', 'getsociallink', 'pixelsettings', 'order'));
    }
    public function delete_feature(Request $request)
    {
        FooterFeatures::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_social_link(Request $request)
    {
        SocialLinks::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function settings_update(Request $request)
    {
        if ($request->contact_update) {
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->email = $request->email;
            $setting->mobile = $request->mobile;
            $setting->address = $request->address;
            $setting->address_url = $request->address_url;
            $setting->save();
        }
        if ($request->firebase_key_update) {
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->firebase = $request->firebase;
            $setting->save();
            return redirect('admin/notification')->with('success', trans('messages.success'));
        }
        if ($request->whychooseus_update) {
            if ($request->hasFile('why_choose_image')) {
                $why_choose_image = 'why_choose_image-' . uniqid() . '.' . $request->why_choose_image->getClientOriginalExtension();
                $request->why_choose_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $why_choose_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->why_choose_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->why_choose_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->why_choose_image);
                    }
                }
                $setting->why_choose_image = $why_choose_image;
                $setting->save();
            }
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->why_choose_title = $request->why_choose_title;
            $setting->why_choose_subtitle = $request->why_choose_subtitle;
            $setting->why_choose_description = $request->why_choose_description;
            $setting->save();
            return redirect('admin/choose_us')->with('success', trans('messages.success'));
        }
        if ($request->seo_update) {
            if ($request->hasFile('og_image')) {
                $og_image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $og_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->og_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->og_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->og_image);
                    }
                }
                $setting->og_image = $og_image;
                $setting->save();
            }
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->og_title = $request->og_title;
            $setting->og_description = $request->og_description;
            $setting->save();
        }

        if ($request->notification_update) {
            if ($request->hasFile('noti_tune')) {

                $validator = Validator::make($request->all(), [
                    'noti_tune' => 'required|mimes:mp3',
                ], [
                    "noti_tune.required" => trans('messages.noti_tune_required'),
                    "noti_tune.mimes" => trans('messages.noti_tune_must_mp3'),
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    $noti_tune = 'notification.' . $request->noti_tune->getClientOriginalExtension();
                    $setting = Settings::first();
                    if (empty($setting)) {
                        $setting = new Settings();
                    } else {
                        if ($setting->notification_tune != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/notification/' . $setting->notification_tune)) {
                            $file = env('ASSETSPATHURL') . 'admin-assets/notification/' . $setting->notification_tune;
                            unlink($file);
                        }
                        $request->noti_tune->move(env('ASSETSPATHURL') . 'admin-assets/notification', $noti_tune);
                    }
                    $setting->notification_tune = $noti_tune;
                    $setting->save();
                }
            }
        }

        if ($request->theme_update) {
            $setting = Settings::first();
            $setting->theme = !empty($request->template) ? $request->template : 1;
            $setting->save();
        }

        if ($request->business_update) {
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->currency = $request->currency;
            $setting->currency_position = $request->currency_position;
            $setting->currency_space = $request->currency_space;
            $setting->currency_formate = $request->currency_formate;
            $setting->decimal_separator = $request->decimal_separator;
            $setting->time_format = $request->time_format;
            $setting->date_format = $request->date_format;
            $setting->referral_amount = $request->referral_amount;
            $setting->max_order_qty = $request->max_order_qty;
            $setting->min_order_amount = $request->min_order_amount;
            $setting->max_order_amount = $request->max_order_amount;
            $setting->order_prefix = $request->order_prefix;
            $setting->timezone = $request->timezone;
            $order = Order::get();
            if ($order->count() == 0 && $request->order_number_start != null && $request->order_number_start != "") {
                $setting->order_number_start = $request->order_number_start;
            }
            $setting->maintenance_mode = isset($request->maintenance_mode) ? 1 : 2;
            $setting->online_table_booking = isset($request->online_table_booking) ? 1 : 2;
            $setting->login_required = isset($request->login_required) ? 1 : 2;
            $setting->is_checkout_login_required = isset($request->is_checkout_login_required) ? 1 : 2;
            $setting->pickup_delivery = $request->pickup_delivery;
            $setting->save();
        }
        if ($request->mobileapp_update) {
            if ($request->hasFile('app_bottom_image')) {
                $app_bottom_image = 'app_bottom_image-' . uniqid() . '.' . $request->app_bottom_image->getClientOriginalExtension();
                $request->app_bottom_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $app_bottom_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->app_bottom_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->app_bottom_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->app_bottom_image);
                    }
                }
                $setting->app_bottom_image = $app_bottom_image;
                $setting->save();
            }
            if ($request->hasFile('mobile_app_image')) {
                $mobile_app_image = 'mobile_app_image-' . uniqid() . '.' . $request->mobile_app_image->getClientOriginalExtension();
                $request->mobile_app_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $mobile_app_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->mobile_app_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->mobile_app_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->mobile_app_image);
                    }
                }
                $setting->mobile_app_image = $mobile_app_image;
                $setting->save();
            }
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->android = $request->android;
            $setting->ios = $request->ios;
            $setting->mobile_app_title = $request->mobile_app_title;
            $setting->mobile_app_description = $request->mobile_app_description;
            $setting->save();
        }
        if ($request->web_update) {
            if ($request->hasFile('favicon')) {
                $favicon = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $favicon);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->favicon != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->favicon)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->favicon);
                    }
                }
                $setting->favicon = $favicon;
                $setting->save();
            }
            if ($request->hasFile('logo')) {
                $logo = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $logo);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->logo != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->logo)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->logo);
                    }
                }
                $setting->logo = $logo;
                $setting->save();
            }
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->web_primary_color = $request->web_primary_color;
            $setting->web_secondary_color = $request->web_secondary_color;
            $setting->copyright = $request->copyright;
            $setting->title = $request->title;
            $setting->short_title = $request->short_title;
            $setting->save();
        }
        if ($request->social_link_update) {
            if (!empty($request->social_icon)) {
                foreach ($request->social_icon as $key => $icon) {
                    if (!empty($icon) && !empty($request->social_link[$key])) {
                        $sociallink = new SocialLinks();
                        $sociallink->icon = $icon;
                        $sociallink->link = $request->social_link[$key];
                        $sociallink->save();
                    }
                }
            }
            if (!empty($request->edit_icon_key)) {
                foreach ($request->edit_icon_key as $key => $id) {
                    $sociallink = SocialLinks::find($id);
                    $sociallink->icon = $request->edit_sociallink_icon[$id];
                    $sociallink->link = $request->edit_sociallink_link[$id];
                    $sociallink->save();
                }
            }
        }
        if ($request->footer_settings_update) {
            if ($request->hasFile('footer_logo')) {
                $footer_logo = 'footer-' . uniqid() . '.' . $request->footer_logo->getClientOriginalExtension();
                $request->footer_logo->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $footer_logo);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->footer_logo != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->footer_logo)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->footer_logo);
                    }
                }
                $setting->footer_logo = $footer_logo;
                $setting->save();
            }
            if (!empty($request->feature_icon)) {
                foreach ($request->feature_icon as $key => $icon) {
                    if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key])) {
                        $feature = new FooterFeatures;
                        $feature->icon = $icon;
                        $feature->title = $request->feature_title[$key];
                        $feature->description = $request->feature_description[$key];
                        $feature->save();
                    }
                }
            }
            if (!empty($request->edit_icon_key)) {
                foreach ($request->edit_icon_key as $key => $id) {
                    $feature = FooterFeatures::find($id);
                    $feature->icon = $request->edi_feature_icon[$id];
                    $feature->title = $request->edi_feature_title[$id];
                    $feature->description = $request->edi_feature_description[$id];
                    $feature->save();
                }
            }
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->footer_title = $request->footer_title;
            $setting->footer_description = $request->footer_description;
            $setting->save();
        }
        if ($request->admin_update) {
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->admin_primary_color = $request->admin_primary_color;
            $setting->admin_secondary_color = $request->admin_secondary_color;
            $setting->save();
        }
        if ($request->other_update) {
            if ($request->hasFile('faqs_image')) {
                $faqs_image = 'faqs_image-' . uniqid() . '.' . $request->faqs_image->getClientOriginalExtension();
                $request->faqs_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $faqs_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->faqs_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->faqs_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->faqs_image);
                    }
                }
                $setting->faqs_image = $faqs_image;
                $setting->save();
            }
            if ($request->hasFile('auth_bg_image')) {
                $auth_bg_image = 'auth_bg_image-' . uniqid() . '.' . $request->auth_bg_image->getClientOriginalExtension();
                $request->auth_bg_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $auth_bg_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->auth_bg_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->auth_bg_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->auth_bg_image);
                    }
                }
                $setting->auth_bg_image = $auth_bg_image;
                $setting->save();
            }
            if ($request->hasFile('booknow_bg_image')) {
                $booknow_bg_image = 'booknow_bg_image-' . uniqid() . '.' . $request->booknow_bg_image->getClientOriginalExtension();
                $request->booknow_bg_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $booknow_bg_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->booknow_bg_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->booknow_bg_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->booknow_bg_image);
                    }
                }
                $setting->booknow_bg_image = $booknow_bg_image;
                $setting->save();
            }
            if ($request->hasFile('refer_earn_bg_image')) {
                $refer_earn_bg_image = 'refer_earn_bg_image-' . uniqid() . '.' . $request->refer_earn_bg_image->getClientOriginalExtension();
                $request->refer_earn_bg_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $refer_earn_bg_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->refer_earn_bg_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->refer_earn_bg_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->refer_earn_bg_image);
                    }
                }
                $setting->refer_earn_bg_image = $refer_earn_bg_image;
                $setting->save();
            }
            if ($request->hasFile('subscribe_newsletter_image')) {
                $subscribe_newsletter_image = 'subscribe_newsletter_image-' . uniqid() . '.' . $request->subscribe_newsletter_image->getClientOriginalExtension();
                $request->subscribe_newsletter_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $subscribe_newsletter_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->subscribe_newsletter_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->subscribe_newsletter_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->subscribe_newsletter_image);
                    }
                }
                $setting->subscribe_newsletter_image = $subscribe_newsletter_image;
                $setting->save();
            }
            if ($request->hasFile('no_data_image')) {
                $no_data_image = 'no_data_image-' . uniqid() . '.' . $request->no_data_image->getClientOriginalExtension();
                $request->no_data_image->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $no_data_image);
                $setting = Settings::first();
                if (empty($setting)) {
                    $setting = new Settings();
                } else {
                    if ($setting->no_data_image != "" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->no_data_image)) {
                        unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $setting->no_data_image);
                    }
                }
                $setting->no_data_image = $no_data_image;
                $setting->save();
            }
            $setting = Settings::first();
            if (empty($setting)) {
                $setting = new Settings();
            }
            $setting->google_review_url = $request->google_review_url;
            $setting->save();
        }
        return redirect('admin/settings')->with('success', trans('messages.success'));
    }
}
