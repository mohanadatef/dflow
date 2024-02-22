<?php

use Illuminate\Support\Facades\App;

/**
 * @Target this file to make function to help about language for all system
 * @note can call it in all system
 */
/**
 * @throws Exception
 * @note cache this query 60*60*60
 * @result get all language in database
 */
function languageAll()
{
    return [['name'=>'English','code'=>'en'],['name'=>'عربي','code'=>'ar']];
}

/**
 * @result get locale from app file
 */
function languageLocale()
{
    return App::getLocale();
}

function getCustomTranslation($key)
{
    return  trans('lang.' . str_replace(" ","_",strtolower($key))) ?? 'lang'.str_replace(" ","_",strtolower($key));
}