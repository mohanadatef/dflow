<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerCategory;
use Modules\Acl\Entities\InfluencerFollowerPlatform;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\City;
use Modules\CoreData\Entities\Country;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Service;
use Modules\CoreData\Entities\Size;

class InfluencerImport implements ToModel, WithStartRow
{
    use SkipsFailures;

    public $rows;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        /*return DB::transaction(function () use ($row) {*/
            executionTime();

                $checkArray = true;
                $dataArray = true;
                if ($row[0] == null || $row[1] == null /*|| $row[7] == null || $row[8] == null*/) {
                    $checkArray = false;
                }
                /*if ($checkArray) {
                    if (!in_array(strtolower($row[8]), genderType())) {
                        $checkArray = false;
                    }
                }*/
                if ($checkArray) {
                    $handler = [$row[2], $row[3], $row[4], $row[5], $row[6]];
                   /* $size = [$row[16], $row[21], $row[26], $row[31], $row[35]];*/
                    if (count(array_filter($handler))/* && count(array_filter($size)) &&
                        (($row[2] != null && $row[16] != null) || ($row[3] != null && $row[21] != null) ||
                            ($row[4] != null && $row[26] != null) || ($row[5] != null && $row[31] != null) || ($row[6] != null && $row[35] != null))*/) {
                        if ($row[2]) {
                            $platform_id = Platform::where('name_en', 'like', '%Snapchat%')->first()->id;
                            $influencer = InfluencerFollowerPlatform::where('platform_id',$platform_id)->where('url', $row[2])->first();
                            if ($influencer) {
                                $dataArray = false;
                            }
                        }
                        if ($row[3]) {
                            $platform_id = Platform::where('name_en', 'like', '%Instagram%')->first()->id;
                            $influencer = InfluencerFollowerPlatform::where('platform_id',$platform_id)->where('url', $row[3])->first();
                            if ($influencer) {
                                $dataArray = false;
                            }
                        }
                        if ($row[4]) {
                            $platform_id = Platform::where('name_en', 'like', '%TikTok%')->first()->id;
                            $influencer = InfluencerFollowerPlatform::where('platform_id',$platform_id)->where('url', $row[4])->first();
                            if ($influencer) {
                                $dataArray = false;
                            }
                        }
                        if ($row[5]) {
                            $platform_id = Platform::where('name_en', 'like', '%Twitter%')->first()->id;
                            $influencer = InfluencerFollowerPlatform::where('platform_id',$platform_id)->where('url', $row[5])->first();
                            if ($influencer) {
                                $dataArray = false;
                            }
                        }
                        if ($row[6]) {
                            $platform_id = Platform::where('name_en', 'like', '%Facebook%')->first()->id;
                            $influencer = InfluencerFollowerPlatform::where('platform_id',$platform_id)->where('url', $row[6])->first();
                            if ($influencer) {
                                $dataArray = false;
                            }
                        }
                        /*$influencer = InfluencerFollowerPlatform::whereIn('url', $handler)->first();
                        if ($influencer) {
                            $dataArray = false;
                        }*/
                    } else {
                        $dataArray = false;
                    }

                }
                if ($checkArray && $dataArray) {
                    $country_id = null;
                    $city_found = false;
                    if ($row[11]) {
                        $city = City::where('name_en', $row[11])->orWhere('name_ar', $row[11])
                            ->orWhere('name_fr', $row[11])->first();
                        if ($city) {
                            $country_id = $city->country_id;
                            $city_id = $city->id;
                            $city_found = true;
                        }
                    }
                    if (!$city_found) {
                        $country = Country::where(
                            'code', strtolower($row[10])
                        )->first();
                        if ($country) {
                            $country_id = $country->id;
                        }

                    }
                   /* if ($country_id) {*/
                        $influencer = Influencer::create([
                            'name_en' => $row[0] ?? $row[1],
                            'name_ar' => $row[1],
                            'gender' => strtolower($row[8]) ?? null,
                            'birthdate' => "",
                            'country_id' => $country_id ?? 0,
                            'city_id' => $city_id ?? 0,
                            'nationality_id' => $row[9] ?? 0,
                            'active' =>  1,
                            'influencer_group_id' => 1,
                        ]);

                        // Platform import
                        $platform = [];
                        $influencer_service_platform = [];
                        $influencer_follower_platform = [];

                        // Snapchat
                        if ($row[2]) {
                            $platform_id = Platform::where('name_en', 'like', '%Snapchat%')->first()->id;
                            $platform [] = $platform_id;
                            if ($row[15]) {
                                $service_id = Service::where('name_en', 'like', '%Location Visit%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[15]) == 1 ? $row[15] : 0, 'service_id' => $service_id];
                            }
                            if ($row[14]) {
                                $service_id = Service::where('name_en', 'like', '%Home Endoresment%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[14]) == 1 ? $row[14] : 0, 'service_id' => $service_id];
                            }
                            if ($row[16]) {
                                $size = Size::where('name_en', $row[16])->first();
                                if (is_null($size)) {
                                    $size = Size::create(['name_en' => $row[16], 'name_ar' => $row[16]]);
                                }
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[2], 'size_id' => $size->id];
                            } else {
                                /*$this->rows[] = array_merge($row, ['size platfrom missing']);*/
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[2], 'size_id' => null];
                            }

                        }

                        // Instagram
                        if ($row[3]) {
                            $platform_id = Platform::where('name_en', 'like', '%Instagram%')->first()->id;
                            $platform [] = $platform_id;
                            if ($row[19]) {
                                $service_id = Service::where('name_en', 'like', '%Post%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[19]) == 1 ? $row[19] : 0, 'service_id' => $service_id];
                            }
                            if ($row[20]) {
                                $service_id = Service::where('name_en', 'like', '%Story%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[20]) == 1 ? $row[20] : 0, 'service_id' => $service_id];
                            }
                            if ($row[21]) {
                                $size = Size::where('name_en', $row[21])->first();
                                if (is_null($size)) {
                                    $size = Size::create(['name_en' => $row[21], 'name_ar' => $row[21]]);
                                }
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[3], 'size_id' => $size->id];
                            } else {
                                /*$this->rows[] = array_merge($row, ['size platfrom missing']);*/
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[3], 'size_id' => null];
                            }

                        }

                        // Tiktok
                        if ($row[4]) {
                            $platform_id = Platform::where('name_en', 'like', '%TikTok%')->first()->id;
                            $platform [] = $platform_id;
                            if ($row[24]) {
                                $service_id = Service::where('name_en', 'like', '%Post%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[24]) == 1 ? $row[24] : 0, 'service_id' => $service_id];
                            }
                            if ($row[25]) {
                                $service_id = Service::where('name_en', 'like', '%Live%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[25]) == 1 ? $row[25] : 0, 'service_id' => $service_id];
                            }
                            if ($row[26]) {
                                $size = Size::where('name_en', $row[26])->first();
                                if (is_null($size)) {
                                    $size = Size::create(['name_en' => $row[26], 'name_ar' => $row[26]]);
                                }
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[4], 'size_id' => $size->id];
                            } else {
                               /* $this->rows[] = array_merge($row, ['size platfrom missing']);*/
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[4], 'size_id' => null];
                            }

                        }

                        // Twitter
                        if ($row[5]) {
                            $platform_id = Platform::where('name_en', 'like', '%Twitter%')->first()->id;
                            $platform [] = $platform_id;
                            if ($row[29]) {
                                $service_id = Service::where('name_en', 'like', '%Tweet/Quote%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[29]) == 1 ? $row[29] : 0, 'service_id' => $service_id];
                            }
                            if ($row[30]) {
                                $service_id = Service::where('name_en', 'like', '%Retweet%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[30]) == 1 ? $row[30] : 0, 'service_id' => $service_id];
                            }
                            if ($row[31]) {
                                $size = Size::where('name_en', $row[31])->first();
                                if (is_null($size)) {
                                    $size = Size::create(['name_en' => $row[31], 'name_ar' => $row[31]]);
                                }
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[5], 'size_id' => $size->id];
                            } else {
                                /*$this->rows[] = array_merge($row, ['size platfrom missing']);*/
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[5], 'size_id' => null];
                            }

                        }

                        // Facebook data
                        if ($row[6]) {
                            $platform_id = Platform::where('name_en', 'like', '%Facebook%')->first()->id;
                            $platform [] = $platform_id;
                            if ($row[34]) {
                                $service_id = Service::where('name_en', 'like', '%Post%')->first()->id;
                                $influencer_service_platform [] = ['platform_id' => $platform_id, 'price' => is_numeric($row[34]) == 1 ? $row[34] : 0, 'service_id' => $service_id];
                            }
                            if ($row[35]) {
                                $size = Size::where('name_en', $row[35])->first();
                                if (is_null($size)) {
                                    $size = Size::create(['name_en' => $row[35], 'name_ar' => $row[35]]);
                                }
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[6], 'size_id' => $size->id];
                            } else {
                                /*$this->rows[] = array_merge($row, ['size platfrom missing']);*/
                                $influencer_follower_platform [] = ['platform_id' => $platform_id, 'followers' => 0, 'url' => $row[6], 'size_id' => null];
                            }

                        }

                        if (count($platform)) {
                            $influencer->platform()->sync($platform);
                            if (count($influencer_service_platform)) {
                                foreach ($influencer_service_platform as $service) {
                                    $influencer->influencer_service_platform()->create($service);
                                }
                            }
                            if (count($influencer_follower_platform)) {
                                foreach ($influencer_follower_platform as $follower) {
                                    $influencer->influencer_follower_platform()->create($follower);
                                }
                            }
                        }

                        // Category import
                        if ($row[7]) {
                            $category = Category::where('name_en', $row[7])->orWhere('name_ar', $row[7])->first();
                            if ($category) {
                                InfluencerCategory::updateORCreate([
                                    'influencer_id' => $influencer->id,
                                    'category_id' => $category->id
                                ]);
                            }
                        }
                    /*} else {
                        $this->rows[] = array_merge($row, ['wrong country']);
                    }*/
                } elseif (!$this->containsOnlyNull($row)) {
                    if ($row[0] == null) {
                        $row = array_merge($row, ['name missing']);
                    } elseif ($row[1] == null) {
                        $row = array_merge($row, ['name missing']);
                    } /*elseif ($row[7] == null) {
                        $row = array_merge($row, ['category missing']);
                    }  elseif ($row[10] == null) {
                        $row = array_merge($row, ['country missing']);
                    } elseif ($row[8] == null) {
                        $row = array_merge($row, ['gender missing']);
                    }*/ elseif ($dataArray == false) {
                        $handler = [$row[2], $row[3], $row[4], $row[5], $row[6]];
                        /*$size = [$row[16], $row[21], $row[26], $row[31], $row[35]];*/
                        if (count(array_filter($handler))) {
                            /*if (count(array_filter($handler)) *//*&& count(array_filter($size)) &&
                                (($row[2] != null && $row[16] != null) || ($row[3] != null && $row[21] != null) ||
                                    ($row[4] != null && $row[26] != null) || ($row[5] != null && $row[31] != null) || ($row[6] != null && $row[35] != null))*//*) {*/
                                $influencer = InfluencerFollowerPlatform::whereIn('url', $handler)->first();
                                if ($influencer) {
                                    $row = array_merge($row, ['duplicate influencer']);
                                }
                                else {
                                    $row = array_merge($row, ['wrong']);
                                }
                            /*}else{
                                $row = array_merge($row, ['wrong in size platform']);
                            }*/
                        } else {
                            $row = array_merge($row, ['All handler platform missing']);
                        }
                    }/* elseif (!in_array(strtolower($row[8]), genderType())) {
                        $row = array_merge($row, ['wrong gender']);
                    } */else {
                        $row = array_merge($row, ['wrong']);
                    }
                    $this->rows[] = $row;
                }

       /* });*/
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }
}
