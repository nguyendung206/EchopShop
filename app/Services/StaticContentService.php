<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\StaticContent;
use Exception;

class StaticContentService
{
    public function index($request)
    {
        $query = StaticContent::query();
        if (! empty($request['search'])) {
            $query->where('description', 'like', '%'.$request['search'].'%');
        }
        if (isset($request['status'])) {
            $query->where('status', $request['status']);
        }
        if (isset($request['type'])) {
            $query->where('type', $request['type']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function store($request)
    {
        $data = [
            'description' => $request['description'],
            'status' => $request['status'],
            'type' => $request['type'],
            'title' => $request['title'] ?? null,
        ];

        return StaticContent::create($data);
    }

    public function update($request, $id)
    {
        $content = StaticContent::findOrFail($id);

        $data = [
            'description' => $request['description'],
            'status' => $request['status'],
            'title' => $request['title'] ?? null,
            'type' => $request['type'],
        ];
        $content->update($data);

        return $content;
    }

    public function destroy($id)
    {
        try {
            $content = StaticContent::findOrFail($id);
            $check = $content->delete();

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getStaticContentHome($type)
    {
        $contents = StaticContent::query()->where('status', Status::ACTIVE)->where('type', $type)->get();

        return $contents;
    }
}
