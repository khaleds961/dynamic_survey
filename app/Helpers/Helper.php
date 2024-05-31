<?php

namespace App\Helpers;

use App;
use App\Models\CulbLog;
use Auth;
use App\Models\ClubPermission;


use \stdClass;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function check_permission($function_id, $permission_type)
    {
        $club_type = Auth::guard('club')->user()->type_id;
        if ($club_type) {
            $club_permission = ClubPermission::where('type_id', '=', $club_type)->where('function_id', '=', $function_id)
            ->first();
            return $club_permission->$permission_type;
        } else {
            return false;
        }
    }

    public static function insert_log($log_action, $log_description, $log_table_name, $log_object_id)
    {
        $now = \Carbon\Carbon::now();
        CulbLog::insert(
            [
                'club_id'          => Auth::id(),
                'log_date'         => $now,
                'log_action'       => $log_action,
                'log_description'  => $log_description,
                'log_object_id'    => $log_object_id,
                'log_table_name'   => $log_table_name
            ]
        );
    }

    public static function check_read_permission($function_id)
    {
        $read_permission = UserPermission::where("type_id", '=', Auth::user()->type_id)->where("function_id", '=', $function_id)->get();
        return count($read_permission) > 0 ? $read_permission[0]->is_read : 0;

    }

    public static function check_write_permission($function_id)
    {
        $write_permission = UserPermission::where("type_id", '=', Auth::user()->type_id)->where("function_id", '=', $function_id)->get();
        return count($write_permission) > 0 ? $write_permission[0]->is_write : 0;

    }

    public static function check_update_permission($function_id)
    {
        $update_permission = UserPermission::where("type_id", '=', Auth::user()->type_id)->where("function_id", '=', $function_id)->get();
        return count($update_permission) > 0 ? $update_permission[0]->is_update : 0;

    }

    public static function check_delete_permission($function_id)
    {
        $delete_permission = UserPermission::where("type_id", '=', Auth::user()->type_id)->where("function_id", '=', $function_id)->get();
        return count($delete_permission) > 0 ? $delete_permission[0]->is_delete : 0;

    }

    public static function get_social_links()
    {
        $social_links = ASetting::get(['facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link'])[0];
        $links = new stdClass;
        $links->facebook_link = $social_links->facebook_link;
        $links->instagram_link = $social_links->instagram_link;
        $links->twitter_link = $social_links->twitter_link;
        $links->linkedin_link = $social_links->linkedin_link;
        $links->youtube_link = $social_links->youtube_link;

        return $links;
    }

    public static function get_banner_img()
    {
        $banner_img = ASetting::get(['banner_img'])[0]->banner_img;
        return $banner_img;
    }

    public static function get_contact_info()
    {
        $contact_info = new stdClass;
        $email = ContactEmail::where('is_active', '=', 1)->where('is_deleted', '=', 0)->where('is_default', '=', 1)->get();
        $address = ContactAddress::where('is_active', '=', 1)->where('is_deleted', '=', 0)->where('is_default', '=', 1)->get();
        $phone = ContactPhone::where('is_active', '=', 1)->where('is_deleted', '=', 0)->where('is_default', '=', 1)->get();
        $contact_info->email = count($email) > 0 ? $email[0]->email : "";
        $contact_info->address = count($address) > 0 ? $address[0]->address_details : "";
        $contact_info->phone = count($phone) > 0 ? $phone[0]->phone : "";
        return $contact_info;
    }

    public static function dateToFrench($date, $format)
    {

        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date))));
    }

    public static function get_guard()
    {
        $current_guard = "";
        if (Auth::guard('teacher')->check()) {
            $current_guard = "teacher";
        } elseif (Auth::guard('family')->check()) {
            $current_guard = "family";
        } elseif (Auth::guard('student')->check()) {
            $current_guard = "student";
        } elseif (Auth::guard('alumni')->check()) {
            $current_guard = "alumni";
        } elseif (Auth::guard('inscription')->check()) {
            $current_guard = "inscription";
        }
        return $current_guard;
    }

    public static function get_random_quotes()
    {
        $quotes = ACitation::where('is_active', '1')->where('is_deleted', 0)->inRandomOrder()->limit(3)->get();
        return $quotes;
    }

    public static function get_partner_logo()
    {
        $partner_logos = PartnerLogo::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $partner_logo_arr = array();
        foreach ($partner_logos as $partner_logo) {
            $logo = new stdClass;
            $logo->title = $partner_logo->title;
            $logo->image = $partner_logo->image;

            array_push($partner_logo_arr, $logo);
        }
        return $partner_logo_arr;
        $contact_info = new stdClass;
        $email = ContactEmail::where('is_active', '=', 1)->where('is_deleted', '=', 0)->where('is_default', '=', 1)->get();
        $address = ContactAddress::where('is_active', '=', 1)->where('is_deleted', '=', 0)->where('is_default', '=', 1)->get();
        $phone = ContactPhone::where('is_active', '=', 1)->where('is_deleted', '=', 0)->where('is_default', '=', 1)->get();
        $contact_info->email = count($email) > 0 ? $email[0]->email : "";
        $contact_info->address = count($address) > 0 ? $address[0]->address_details : "";
        $contact_info->phone = count($phone) > 0 ? $phone[0]->phone : "";
        return $contact_info;
    }
}
?>