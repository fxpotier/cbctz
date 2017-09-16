<?php

namespace CityByCitizen\Services;

use CityByCitizen\Slug;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugManager {
    /**
     * @param $data
     * @return Slug
     */
    public function Create($data) {
		$slugData = $this->PreventDouble(Str::slug($data['name']), $data['type']);
		$slug = Slug::create([
			'name' => $slugData['name'],
			'reference' => $slugData['reference']
		]);
        return $slug;
    }

	/**
	 * @param Model $model
	 * @param $name
	 */
	public function Update(Model $model, $name) {
		$slugName = Str::slug($name);
		if($slugName != $model->slug[0]->name) $slugData = $this->PreventDouble($slugName, get_class($model));
		else $slugData = ['name' => $slugName, 'reference' => $slugName];
		$model->slug[0]->name = $slugData['name'];
		$model->slug[0]->reference = $slugData['reference'];
		$model->slug[0]->save();
	}

    /**
     * @param Model $model
     * @param $name
     * @return mixed|static
     */
    public function CreateOrUpdate(Model $model, $name) {
        $slugName = Str::slug($name);
        $currentSlugs = $model->slug;
        if($currentSlugs->isEmpty()) {
            $slugData = $this->PreventDouble($slugName, get_class($model));
            $slug = Slug::create([
                'name' => $slugData['name'],
                'reference' => $slugData['reference']
            ]);
            $model->slug()->save($slug);
            return $slug;
        }
        else if($slugName != $currentSlugs[0]->name) $slugData = $this->PreventDouble($slugName, get_class($model));
        else $slugData = ['name' => $slugName, 'reference' => $slugName];
        $model->slug[0]->name = $slugData['name'];
        $model->slug[0]->reference = $slugData['reference'];
        $model->slug[0]->save();
        return $model->slug[0];
    }

	/**
	 * @param $slugName
	 * @param $type
	 * @return array
	 */
	private function PreventDouble($slugName, $type) {
		$count = Slug::where('sluggable_type', '=', $type)->where('reference','=', $slugName)->count();
		if($count == 0) return ['name' => $slugName, 'reference' => $slugName];
		else return ['name' => $slugName.'-'.$count, 'reference' => $slugName];
	}

    /**
     * @param Slug $slug
     * @param Model $model
     * @param string $relation
     */
    public function AddSlug(Slug $slug, Model $model, $relation = '') {
        if ($relation === '') $model->slug()->save($slug);
        else $model->$relation()->save($slug);
    }

    /**
     * @param $slug
     * @param $type
     * @return mixed
     */
    public function GetBySlug($slug, $type) {
        return $this->FindSlug($slug, $type)->sluggable()->first();
    }

	/**
	 * @param $slug
	 * @param $type
	 * @return mixed
	 */
    public function FindSlug($slug, $type) {
        return Slug::where('name', '=', $slug)->where('sluggable_type', '=', $type)->first();
    }

    public function delete($slugs) {
        if (is_array($slugs)) $slugs = collect($slugs);
        if ($slugs instanceof Collection) {
            foreach ($slugs as $slug)
                $this->delete($slug);
            return;
        }

        $slugs->delete();
    }
}