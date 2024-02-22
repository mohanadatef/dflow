<?php

namespace Modules\Basic\Service;

use Illuminate\Support\Carbon;

class BasicService
{
    public function show($id)
    {
        return $this->repo->findOne($id);
    }

    public function delete($id)
    {
        $data = false;
        if(is_array($id))
        {
            foreach($id as $i)
            {
                $data = $this->repo->delete($i);
            }
        }else
        {
            $data = $this->repo->delete($id);
        }
        return $data;
    }

    public function range_start_date()
    {
        $start_access = user()->start_access;
        $start = request('start');
        if($start)
        {
            if($start_access)
            {
                return Carbon::parse($start)
                    ->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::parse($start);
            }else
            {
                return Carbon::parse($start);
            }
        }
        if($start_access)
        {
            return Carbon::now()->subDay()->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()
                ->subDay();
        }else
        {
            return Carbon::now()->subDay();
        }
    }

    public function range_end_date()
    {
        $end_access = user()->end_access;
        $end = request('end');
        if($end)
        {
            if($end_access)
            {
                return Carbon::parse($end)->isAfter($end_access) ? Carbon::parse($end_access) : Carbon::parse($end);
            }else
            {
                return Carbon::parse($end);
            }
        }
        if($end_access)
        {
            return Carbon::now()->isAfter($end_access) ? Carbon::parse($end_access) : Carbon::now();
        }else
        {
            return Carbon::now();
        }
    }

    public function range_creation_start_date()
    {
        $start_access = user()->start_access;
        $creationD_start = request('creationD_start');
        $creation_start = request('creation_start');
        if($creationD_start)
        {
            if($start_access)
            {
                if(Carbon::parse($creationD_start)->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                   return Carbon::parse($start_access)->startOfDay();
                }else
                {
                    return  Carbon::parse($creationD_start)->setTime(9,0,0);
                }
            }else
            {
                return Carbon::parse($creationD_start)->setTime(9,0,0);
            }
        }elseif($creation_start)
        {
            if($start_access)
            {
                if(Carbon::parse($creation_start)->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return  Carbon::parse($start_access)->startOfDay();
                }else
                {
                    return Carbon::parse($creation_start)->startOfDay();
                }
            }else
            {
                return Carbon::parse($creation_start)->startOfDay();
            }
        }elseif($start_access)
        {
            return Carbon::now()->subDay()->isBefore($start_access) ? Carbon::parse($start_access)->startOfDay() : Carbon::now()
                ->subDay()->startOfDay();
        }else
        {
            return Carbon::now()->subDay()->startOfDay();
        }
    }

    public function range_creation_end_date()
    {
        $end_access = user()->end_access;
        $creationD_end = request('creationD_end');
        $creation_end = request('creation_end');
        if($creationD_end)
        {
            if($end_access)
            {
                if(Carbon::parse($creationD_end)->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation("this_ad_record_out_of_your_dates_range")]);
                    return  Carbon::parse($end_access)->endOfDay();
                }else
                {
                    return Carbon::parse($creationD_end)->setTime(9,0,0);
                }
            }else
            {
                return Carbon::parse($creationD_end)->setTime(9,0,0);
            }
        }elseif($creation_end)
        {
            if($end_access)
            {
                if(Carbon::parse($creation_end)->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation("this_ad_record_out_of_your_dates_range")]);
                    return  Carbon::parse($end_access)->endOfDay();
                }else
                {
                    return  Carbon::parse($creation_end)->endOfDay();
                }
            }else
            {
                return Carbon::parse($creation_end)->endOfDay();
            }
        }elseif($end_access)
        {
            return Carbon::now()->isAfter($end_access) ?  Carbon::parse($end_access)->endOfDay() : Carbon::now();
        }else
        {
            return Carbon::now();
        }
    }

    public function toggleActive()
    {
        return $this->repo->toggleActive();
    }
}
