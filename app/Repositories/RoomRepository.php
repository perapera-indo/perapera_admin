<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository
{
    public function create($data)
    {
        $room = new Room();

        $room->title = $data['title'];
        $room->desc = $data['desc'];
        $room->is_active = true;

        if (!empty($data['path'])) {
            $uploadImage = upload_file($data['path'], 'uploads/room/', 'video');
            $room->path = $uploadImage['original'];
        }

        $room->save();

        return $room;
    }

    public function update($data, $id)
    {
        $room = Room::find($id);

        $room->title = $data['title'];
        $room->desc = $data['desc'];
        $room->is_active = true;

        if (!empty($data['path'])) {
            @delete_file($room->path);
            $uploadImage = upload_file($data['path'], 'uploads/room/', 'video');
            $room->path = $uploadImage['original'];
        }

        return $room->update();
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return $room;
    }
}
