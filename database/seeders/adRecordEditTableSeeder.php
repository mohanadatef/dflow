<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyIndustry;
use Modules\Acl\Entities\CompanyWebsite;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerCategory;
use Modules\Acl\Entities\InfluencerFollowerPlatform;
use Modules\Acl\Entities\InfluencerGender;
use Modules\Acl\Entities\InfluencerPlatform;
use Modules\Acl\Entities\InfluencerServicePlatform;
use Modules\Acl\Entities\UserWorkingTime;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\LinkTrackingClick;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\AdRecordCategory;
use Modules\Record\Entities\AdRecordLog;
use Modules\Record\Entities\AdRecordPromotionType;
use Modules\Record\Entities\AdRecordTargetMarket;

class adRecordEditTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adrecord = AdRecord::where('id','>=',236335)->orderBy('id','desc')->get();
        foreach($adrecord as $ad)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 25373;
            $id = $ad->id;
            $newId=$id+$new;
            if (\File::isDirectory(public_path('images/adrecord' . '/' . $id))) {
                rename(public_path('images/adrecord' . '/' . $id),public_path('images/adrecord' . '/' . $newId));
            }

            $AdRecordCategory=AdRecordCategory::where('ad_record_id',$id)->get();
            foreach($AdRecordCategory as $category)
            {
                $category->update(['ad_record_id'=>$newId]);
            }
            $AdRecordPromotionType=AdRecordPromotionType::where('ad_record_id',$id)->get();
            foreach($AdRecordPromotionType as $PromotionType)
            {
                $PromotionType->update(['ad_record_id'=>$newId]);
            }
            $AdRecordTargetMarket=AdRecordTargetMarket::where('ad_record_id',$id)->get();
            foreach($AdRecordTargetMarket as $TargetMarket)
            {
                $TargetMarket->update(['ad_record_id'=>$newId]);
            }
            $media = Media::where('category_type','Modules\Record\Entities\AdRecord')->where('category_id',$id)->get();
            foreach($media as $m)
            {
                $m->update(['category_id'=>$newId]);
            }
            $AdRecordLog=AdRecordLog::where('ad_record_id',$id)->get();
            foreach($AdRecordLog as $log)
            {
                $log->update(['ad_record_id'=>$newId]);
            }
            $ad->update(['id'=>$newId]);
        }
        $company = Company::where('id','>=',59105)->orderBy('id','desc')->get();
        foreach($company as $com)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 2279;
            $id = $com->id;
            $newId=$id+$new;
            if (\File::isDirectory(public_path('images/company' . '/' . $id))) {
                rename(public_path('images/company' . '/' . $id),public_path('images/company' . '/' . $newId));
            }
            $ComapnyCategory=CompanyIndustry::where('company_id',$id)->get();
            foreach($ComapnyCategory as $category)
            {
                $category->update(['company_id'=>$newId]);
            }
            $ComapnyWebsite=CompanyWebsite::where('company_id',$id)->get();
            foreach($ComapnyWebsite as $website)
            {
                $website->update(['company_id'=>$newId]);
            }
            $ComapnyAd=AdRecord::where('company_id',$id)->get();
            foreach($ComapnyAd as $ad)
            {
                $ad->update(['company_id'=>$newId]);
            }
            $media = Media::where('category_type','Modules\Acl\Entities\Company')->where('category_id',$id)->get();
            foreach($media as $m)
            {
                $m->update(['category_id'=>$newId]);
            }
            $com->update(['id'=>$newId]);
        }
        $influencers = Influencer::where('id','>=',1826)->orderBy('id','desc')->get();
        foreach($influencers as $influencer)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 2;
            $id = $influencer->id;
            $newId=$id+$new;
            $influencerCategory=InfluencerCategory::where('influencer_id',$id)->get();
            foreach($influencerCategory as $category)
            {
                $category->update(['influencer_id'=>$newId]);
            }
            $influencerAd=AdRecord::where('influencer_id',$id)->get();
            foreach($influencerAd as $ad)
            {
                $ad->update(['influencer_id'=>$newId]);
            }
            $influencerServicePlatform=InfluencerServicePlatform::where('influencer_id',$id)->get();
            foreach($influencerServicePlatform as $ServicePlatform)
            {
                $ServicePlatform->update(['influencer_id'=>$newId]);
            }
            $influencerFollowerPlatform=InfluencerFollowerPlatform::where('influencer_id',$id)->get();
            foreach($influencerFollowerPlatform as $FollowerPlatform)
            {
                $FollowerPlatform->update(['influencer_id'=>$newId]);
            }
            $influencerGender=InfluencerGender::where('influencer_id',$id)->get();
            foreach($influencerGender as $Gender)
            {
                $Gender->update(['influencer_id'=>$newId]);
            }
            $influencerPlatform=InfluencerPlatform::where('influencer_id',$id)->get();
            foreach($influencerPlatform as $Platform)
            {
                $Platform->update(['influencer_id'=>$newId]);
            }
            $influencer->update(['id'=>$newId]);
        }
        $LinkTrackingClick = LinkTrackingClick::where('id','>=',25693)->orderBy('id','desc')->get();
        foreach($LinkTrackingClick as $Link)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 1;
            $id = $Link->id;
            $newId=$id+$new;
            $Link->update(['id'=>$newId]);
        }
        $UserWorkingTime = UserWorkingTime::where('id','>=',1634)->orderBy('id','desc')->get();
        foreach($UserWorkingTime as $WorkingTime)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 63;
            $id = $WorkingTime->id;
            $newId=$id+$new;
            $WorkingTime->update(['id'=>$newId]);
        }
        $medias = Media::where('id','>=',509482)->orderBy('id','desc')->get();
        foreach($medias as $media)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 102410;
            $id = $media->id;
            $newId=$id+$new;
            $media->update(['id'=>$newId]);
        }
        $AdRecordCategory = AdRecordCategory::where('id','>=',452448)->orderBy('id','desc')->get();
        foreach($AdRecordCategory as $AdRecordCategor)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 29179;
            $id = $AdRecordCategor->id;
            $newId=$id+$new;
            $AdRecordCategor->update(['id'=>$newId]);
        }
        $AdRecordPromotionType=AdRecordPromotionType::where('id','>=',496465)->orderBy('id','desc')->get();
        foreach($AdRecordPromotionType as $PromotionType)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 30421;
            $id = $PromotionType->id;
            $newId=$id+$new;
            $PromotionType->update(['id'=>$newId]);
        }
        $AdRecordAdRecordLog=AdRecordLog::where('id','>=',306)->orderBy('id','desc')->get();
        foreach($AdRecordAdRecordLog as $log)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 24002;
            $id = $log->id;
            $newId=$id+$new;
            $log->update(['id'=>$newId]);
        }
        $AdRecordTargetMarket=AdRecordTargetMarket::where('id','>=',411648)->orderBy('id','desc')->get();
        foreach($AdRecordTargetMarket as $AdRecordTargetMarke)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 27567;
            $id = $AdRecordTargetMarke->id;
            $newId=$id+$new;
            $AdRecordTargetMarke->update(['id'=>$newId]);
        }
        $CompanyWebsite=CompanyWebsite::where('id','>=',50095)->orderBy('id','desc')->get();
        foreach($CompanyWebsite as $CompanyWebsit)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 2411;
            $id = $CompanyWebsit->id;
            $newId=$id+$new;
            $CompanyWebsit->update(['id'=>$newId]);
        }
        $CompanyIndustry=CompanyIndustry::where('id','>=',34117)->orderBy('id','desc')->get();
        foreach($CompanyIndustry as $CompanyIndustr)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 2681;
            $id = $CompanyIndustr->id;
            $newId=$id+$new;
            $CompanyIndustr->update(['id'=>$newId]);
        }
        $InfluencerCategory=InfluencerCategory::where('id','>=',1456)->orderBy('id','desc')->get();
        foreach($InfluencerCategory as $InfluencerCategor)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 4;
            $id = $InfluencerCategor->id;
            $newId=$id+$new;
            $InfluencerCategor->update(['id'=>$newId]);
        }
        $InfluencerFollowerPlatform=InfluencerFollowerPlatform::where('id','>=',4066)->orderBy('id','desc')->get();
        foreach($InfluencerFollowerPlatform as $InfluencerFollowerPlatfor)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 44;
            $id = $InfluencerFollowerPlatfor->id;
            $newId=$id+$new;
            $InfluencerFollowerPlatfor->update(['id'=>$newId]);
        }
        $InfluencerGender=InfluencerGender::where('id','>=',1702)->orderBy('id','desc')->get();
        foreach($InfluencerGender as $InfluencerGende)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 54;
            $id = $InfluencerGende->id;
            $newId=$id+$new;
            $InfluencerGende->update(['id'=>$newId]);
        }
        $InfluencerPlatform=InfluencerPlatform::where('id','>=',3713)->orderBy('id','desc')->get();
        foreach($InfluencerPlatform as $InfluencerPlatfor)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 6;
            $id = $InfluencerPlatfor->id;
            $newId=$id+$new;
            $InfluencerPlatfor->update(['id'=>$newId]);
        }
        $InfluencerServicePlatform=InfluencerServicePlatform::where('id','>=',2356)->orderBy('id','desc')->get();
        foreach($InfluencerServicePlatform as $InfluencerServicePlatfor)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $new = 116;
            $id = $InfluencerServicePlatfor->id;
            $newId=$id+$new;
            $InfluencerServicePlatfor->update(['id'=>$newId]);
        }
    }
}

