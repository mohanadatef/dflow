<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerCountry;

/**
 * @method static find(mixed $country_id)
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar', 'name_en', 'code','active','parent_id'
    ];
    protected $table = 'locations';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:locations',
        'name_en' => 'required|unique:locations',
        'code' => 'required_if:parent_id,!",0',
        'parent_id' => 'nullable|exists:locations,id',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en'=>'like','name_ar'=>'like'];
    public $searchRelationShip = [];
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

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_countries','influencer_id','country_id');
    }

    public function influencer_country()
    {
        return $this->hasMany(InfluencerCountry::class);
    }
    public function event()
    {
        return $this->hasMany(Event::class);
    }
    public function influencer_travel()
    {
        return $this->hasMany(InfluencerTravel::class);
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsTo(Location::class, 'parent_id', 'id');
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
}
