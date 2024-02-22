<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanySearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $industries = '';
        foreach($this->industry as $industry) {
            $industries .= $industry->name_en . ', ';
        }

        return [
            'id' => $this->id,
            'name_en' => $this->name_en ,
            'html' => '
                <div >'. $this->name_en .'</div>
                <div>
                    <small style="color: blue">' . $industries . '</small>
                </div>',
            'link'=>$this->link
        ];
    }
}
