<?php

namespace Modules\CoreData\Entities;

use Modules\Acl\Entities\Influencer;
use Modules\Record\Entities\AdRecord;
use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\CompanyIndustry;
use Modules\Acl\Entities\InfluencerCategory;
use Modules\Acl\Entities\UserCategory;
use Modules\Record\Entities\AdRecordCategory;

/**
 * @method static whereNull(string $string)
 * @method static create(array $array)
 * @method static where(string $string, mixed $int, string $string)
 */
class Category extends Model
{
    protected $fillable = [
        'parent_id', 'name_ar', 'name_en', 'group', 'active'
    ];
    protected $table = 'categories';
    public $timestamps = true;
    public static $rules = [
        'name_ar' => 'required|regex:/^[\p{Arabic} ]+$/u|unique:categories',
        'name_en' => 'required|regex:/^[A-Za-z ]+$/|unique:categories',
        'group' => 'required',
        'parent_id' => 'required_if:group,industry_child',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en' => 'like', 'name_ar' => 'like'];
    public $searchRelationShip = [
        'influencer' => 'influencer_category->influencer_id',
        'company' => 'company_industry->company_id',
        'ad_record' => 'ad_record_category->ad_record_id',
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function parentsTree()
    {
        $all = collect([]);
        $parent = $this->parents;
        if($parent)
        {
            $all->push($parent);
            $all = $all->merge($parent->parentsTree());
        }
        return $all;
    }

    public function childs()
    {
        $all = collect([]);
        $childs = $this->children;
        if(!$childs->isEmpty())
        {
            foreach($childs as $children)
            {
                $all->push($children);
                $all = $all->merge($children->childs());
            }
        }
        return $all;
    }

    public function parentAndChildrenTree()
    {
        $childs = $this->childs();
        $parents = $this->parentsTree();
        $all = $parents->merge($childs);
        return $all;
    }

    public function industry()
    {
        return $this->belongsToMany(Category::class, 'company_industries');
    }

    public function company_industry()
    {
        return $this->hasMany(CompanyIndustry::class, 'industry_id');
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_categories');
    }

    public function influencer_category()
    {
        return $this->hasMany(InfluencerCategory::class);
    }

    public function user_category()
    {
        return $this->hasMany(UserCategory::class);
    }

    public function ad_record()
    {
        return $this->belongsToMany(AdRecord::class, 'ad_record_categories');
    }

    public function ad_record_category()
    {
        return $this->hasMany(AdRecordCategory::class);
    }
    public function event()
    {
        return $this->belongsToMany(Event::class, 'event_categories');
    }

    public function event_category()
    {
        return $this->hasMany(EventCategory::class);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->company_industry()->delete();
            $data->event_category()->delete();
        });
        static::updating(function($data)
        {
            if($data->active === false)
            {
                foreach($data->children as $child)
                {
                    $child->update([
                        'active' => false
                    ]);
                }
            }
        });
    }

    public static function getCategoriesIdsByUserId(): array
    {
        $categories = Category::WhereHas('user_category', function($query)
        {
            $query->where('user_id', user()->id);
        })->with(['children', 'parents'])->get();
        $categoriesIds = [];
        foreach($categories as $category)
        {
            $categoriesIds[] = $category->id;
            if(!empty($category->children))
            {
                $categoriesIds = array_merge($categoriesIds, $category->children->pluck('id')->toArray());
            }
        }
        return array_unique($categoriesIds);
    }

    public static function getonlybyCategoriesIdsByUserId(): array
    {
        $categories = Category::WhereHas('user_category', function($query)
        {
            $query->where('user_id', user()->id);
        })->get();
        $categoriesIds = [];
        foreach($categories as $category)
        {
            $categoriesIds[] = $category->id;
        }
        return array_unique($categoriesIds);
    }

    public static function getCategoriesnamesByUserId(): array
    {
        $categories = Category::WhereHas('user_category', function($query)
        {
            $query->where('user_id', user()->id);
        })->with(['children', 'parents'])->get();
        $categoriesIds = [];
        foreach($categories as $category)
        {
            $categoriesIds[] = str_replace('\"', '', $category->name_en);
            if(!empty($category->children))
            {
                $categoriesIds = array_merge($categoriesIds, $category->children->pluck('name_en')->toArray());
            }
        }
        return array_unique($categoriesIds);
    }

    public function updateChildCategories($category, $active)
    {
        $children = $category->children()->update(['active' => !$active]);
        return $children;
    }
}
