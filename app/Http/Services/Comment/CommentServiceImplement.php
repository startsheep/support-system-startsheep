<?php

namespace App\Http\Services\Comment;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Comment\CommentRepository;
use Illuminate\Support\Facades\Storage;

class CommentServiceImplement extends Service implements CommentService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(CommentRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($data)
    {
        $data['user_id'] = auth()->user()->id;

        $comment = $this->mainRepository->create($data);

        if (isset($data['files']) && $data['files']) {
            $this->multipleUpload($data['files'], $comment);
        }

        return $comment;
    }

    public function update($id, $data)
    {
        $comment = $this->mainRepository->findOrFail($id);

        if ($comment->files) {
            $this->updateDocument($data, $comment);
        }

        if (isset($data['files']) && $data['files']) {
            $this->multipleUpload($data['files'], $comment);
        }

        return $comment->update($data);
    }

    protected function multipleUpload($files, $comment)
    {
        foreach ($files as $file) {
            $file = $this->storageFile($file, 'comments');
            $comment->files()->create($file);
        }
    }

    protected function updateDocument($data, $comment)
    {
        $modelFiles = $comment->files();
        if (isset($data['old_files'])) {
            $modelFiles = $modelFiles->whereNotIn('id', $data['old_files']);
        }

        $files = $modelFiles->get();

        foreach ($files as $file) {
            $path = str_replace(url('storage') . '/', '', $file->file_path);
            Storage::delete($path);
        }

        return $modelFiles->delete();
    }

    public function storageFile($file, $folder)
    {
        $path = $file->store($folder);

        return [
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ];
    }
}
