<?php
/**
 * @Target  this file to make enum for all system
 * @note can call it in all system if give it key we return only we send
 */
/**
 * @Target this all type media in system
 */
function mediaType()
{
    return ['im' => 'icon', 'lm' => 'logo', 'mm' => 'image', 'mml' => 'mawthooq_license', 'am' => 'avatar', 'vm' => 'video', 'dm' => 'medias', 's3' => 's3'];
}

/**
 * @Target this path type we can save in it
 * images
 * uploads
 */
function pathType()
{
    return ['ip' => 'images', 'up' => 'uploads'];
}

/**
 * @Target this path type we can save in it
 */
function groupType()
{
    return ['igp' => 'industry_parent', 'fg' => 'influencer', 'igc' => 'industry_child'];
}

/**
 * @Target this path type we can save in it
 */
function genderType()
{
    return ['mg' => 'male', 'fm' => 'female', 'nh' => 'Neutral'];
}

function audienceImpressionType()
{
    return ['nai' => 'negative', 'pai' => 'positive'];
}

function activeType()
{
    return ['as' => 1, 'us' => 0];
}

function requestAccessType()
{
    return ['upr' => 1, 'apr' => 2, 'rjr' => 3, 'cur' => 4, 'car' => 5];
}

function requestAccessText()
{
    return [1 => 'Sent', 2 => 'Approved', 3 => 'Rejected', 4 => 'Cancellation', 5 => 'Canceled'];
}

function requestAccessTextMessge()
{
    return [1 => 'Sent', 2 => 'Approved', 3 => 'Unavailable media', 4 => 'canceled by you', 5 => 'Canceled'];
}

function weekSchedule()
{
    return [1 => 'Saturday', 2 => 'Sunday', 3 => 'Monday', 4 => 'Tuesday', 5 => 'Wednesday', 6 => 'Thursday', 7 => 'Friday'];
}

function weekScheduleKey()
{
    return ['saturday' => 1, 'sunday' => 2, 'monday' => 3, 'tuesday' => 4, 'wednesday' => 5, 'thursday' => 6, 'friday' => 7];
}

function adReocrdLogText()
{
    return [0 => 'Create', 1 => 'Edit', 2 => 'Show', 3 => 'Create Error',
        4 => 'Solve Error', 5 => 'Create Draft', 6 => 'Edit Draft', 7 => 'Convert To Ad', 8 => 'Cancel Error', 9 => 'Edit From Draft'];
}

function externalDashboardLogText()
{
    return [
        0 => 'Create', 1 => 'Edit', 2 => 'Change Version',3=>'Add Client',4=>'Edit Client',5=>"Delete Client"
    ];
}

function influencerGroupLogText()
{
    return [0 => 'remove', 1 => 'add', 2 => 'move to'];
}

function urlType()
{
    return [1 => "https://www.snapchat.com/add/", '2' => "https://www.instagram.com/", '3' => "https://www.tiktok.com/@",
        '4' => "https://twitter.com/", '5' => "https://www.facebook.com/", '6' => "https://www.youtube.com/"];
}

function platformType()
{
    $platforms = \Modules\CoreData\Entities\Platform::all();
    foreach($platforms as $platform)
    {
        $data['platform'][] = $platform->name_en;
        foreach($platform->service as $service)
        {
            $data['service'][] = $platform->name_en . '_' . $service->name_en;
        }
    }
    return $data;
}

function modelPermission()
{
    return [
        'users',
        'clients',
        'roles',
        'influencers',
        'platforms',
        'companies',
        'services',
        'promotions',
        'categories',
        'websites',
        'campaigns',
        'linktracking',
        'calender',
        'content_record',
        'ad_record',
        'ad_record_draft',
        'influencer_group',
        'fqs',
        'influencer_group_schedule',
        'support_center',
        'tag',
        'influencer_travel',
        'event',
        'brand_activity',
        'influencer_trend',
        'external_dashboard',
        'location',
    ];
}

