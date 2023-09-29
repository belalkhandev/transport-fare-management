<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Media::class;
    }

    public function uploadFile(UploadedFile $file, $path, $mediable = null, $type = null)
    {
        $path = $file->store('/'.trim($path, '/'));
        $extension = $file->extension();

        if (! $type) {
            $type = in_array($extension, ['jpeg', 'png', 'jpg', 'gif']) ? 'image' : $extension;
        }

        if ($mediable) {
            $name = mb_strtolower(class_basename($mediable)).'_'.$mediable->id.'_'.Str::random().'.'.$extension;
        } else {
            $name = Str::random().'_'.time().'.'.$extension;
        }

        return $this->query()->create([
            'type' => $type,
            'name' => $name ?? $file->getClientOriginalName(),
            'src' => $path,
            'extension' => $extension,
            'mediable_type' => is_null($mediable) ? null : get_class($mediable),
            'mediable_id' => is_null($mediable) ? null : $mediable->id,
        ]);
    }

    public function mapFile(Media $media, $mediable): Media
    {
        $newMedia = $media->replicate()->fill([
            'mediable_type' => get_class($mediable),
            'mediable_id' => $mediable->id,
        ]);

        $newMedia->save();

        return $newMedia;
    }

    public function getByMediable($mediable)
    {
        return $this->query()
            ->where('mediable_id', $mediable->id)
            ->where('mediable_type', get_class($mediable))
            ->first();
    }

    public function deleteByMediable($mediable)
    {
        $media = $this->query()
            ->where('mediable_id', $mediable->id)
            ->where('mediable_type', get_class($mediable))
            ->first();

        if ($media) {
            Storage::delete($media->src);
        }

        return $media->delete();
    }

    public function deleteByMediaId($id)
    {
        $media = $this->query()->findOrFail($id);

        if ($media) {
            Storage::delete($media->src);
        }

        return $media->delete();
    }

    public function deleteAllByMediable($photos)
    {
        if ($photos->isNotEmpty()) {
            foreach ($photos as $photo) {
                $this->deleteByMediaId($photo->id);
            }
        }
    }
}
