<?php

namespace Modules\Setting\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Setting\Entities\Notification;

class NotificationRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'receiver_id',
        'action',
        'action_category',
        'action_id',
        'is_read',
        'pusher_id'
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return Notification::class;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10,$limit = null,$latest="")
    {
        return $this->all($request->all(), pagination:$pagination , perPage:$perPage ,limit:$limit,latest:$latest );
    }

    public function findOne(int $id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function () use ($request, $id) {
            if ($id) {
                $data = $this->update($request->all(), $id);
            } else {
                $data = $this->create(array_merge(['user_id' => Auth::user()->id], $request->all()));
            }
            return $data;
        });
    }

    public function list(Request $request)
    {
        return $this->all($request->all());
    }
}
