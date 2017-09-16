<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 14/05/2015
 * Time: 11:09
 */

namespace CityByCitizen\Services;

use CityByCitizen\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\File as FileInfo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureManager {

	/**
	 * @param $data
	 * @return Picture
	 */
	public function Create($data) {
        return Picture::create([
			'source' => $data['source'],
			'album' => $data['album']
		]);
    }

	/**
	 * @param $data
	 * @param $picture
	 * @return Picture
	 */
	public function UpdateOrCreate($data, $picture) {
		if(isset($picture) && !$picture instanceof Collection) {
			$currentPictureSource = Picture::where('id', '=', $picture->id)->first()->source;
			if($data['source'] != $currentPictureSource) $this->DeletePicture($currentPictureSource);
			return Picture::updateOrCreate(['id' => $picture->id], $data);
		}
		return $this->Create($data);
	}

	/**
	 * @param Picture $picture
	 * @param Model $model
	 * @param string $relation
	 */
    public function AddPicture(Picture $picture, Model $model, $relation = '') {
        if ($relation === '') $model->pictures()->save($picture);
        else $model->$relation()->save($picture);
    }

	/**
	 * @param $filename
	 * @param $relativePath
	 * @param $data
	 * @param null $id
	 * @return string
	 */
	public function SavePicture($filename, $relativePath, $data, $id = null) {
		if ($data instanceof Collection) {
			$uid = time() . '_' . str_random(10);
			foreach ($data as $key => $pictureData) $this->SavePicture($filename, $relativePath, $pictureData, $uid . '_' . $key);
		}

		$path = public_path().'/'.$relativePath.'/';
		if (!file_exists($path)) mkdir($path, 0755, true);

		preg_match('/data:image\/(\w+);base64,(.+)$/', $data, $match);
		if($id) $filename .= '_' . $id;
		$filename .= '.'.$match[1];

		file_put_contents($path . $filename, base64_decode($match[2]));
		return $relativePath.'/'.$filename;
	}

	/**
	 * @param UploadedFile $file
	 * @return Picture
	 */
	public function Upload(UploadedFile $file) {
		if (!$file->isValid() || !preg_match('#^image#', $file->getMimeType())) return null;

		$filename = time().'_'.str_random(5).'.'.$file->getClientOriginalExtension();
		$file->move(public_path().'/pictures', $filename);

		$picture = Picture::create(['source' => $filename]);
		return $picture;
	}

	/**
	 * @param $filename
	 * @return null|\stdClass
	 */
	public function LoadPicture($filename) {
		$path = public_path().$filename;
		if (!file_exists($path)) return null;
		$fileInfo = new FileInfo($path);
		if (!preg_match('#^image#', $fileInfo->getMimeType())) return null;

		$file = new \stdClass();
		$file->mime = $fileInfo->getMimeType();
		$file->content = File::get($path);
		return $file;
	}

	/**
	 * @param $name
	 */
	public function DeletePicture($name) {
		$picture = Picture::whereSource($name);
		$picture->delete();
		File::delete(public_path().'/'.$name);
	}
}