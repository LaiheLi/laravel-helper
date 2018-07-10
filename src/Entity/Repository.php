<?php

namespace LaiheLi\LaravelHelper\Entity;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class Repository extends BaseRepository
{
	use DispatchesJobs;

	protected static $autoCriteria = TRUE;

	/**
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function boot()
	{
		if(static::$autoCriteria){
			$this->pushCriteria(app(RequestCriteria::class));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function model()
	{
		$paths = config('repository.generator.paths');

		return substr(str_replace($paths['repositories'], $paths['models'], static::class), 0, -10);
	}

	/**
	 * @inheritdoc
	 */
	public function validator()
	{
		$paths = config('repository.generator.paths');
		$valid = substr(str_replace($paths['repositories'], $paths['validators'], static::class), 0, -10) . 'Validator';

		return class_exists($valid) ? $valid : NULL;
	}


	/**
	 * @param array  $where
	 * @param string $columns
	 *
	 * @throws
	 * @return bool
	 */
	public function exists(array $where = [], $columns = '*')
	{
		$this->applyCriteria();
		$this->applyScope();
		$this->applyConditions($where);
		$model = $this->model->exists($columns);
		$this->resetModel();

		return (boolean)$model;
	}

	/**
	 * @param array  $where
	 * @param string $columns
	 *
	 * @throws
	 * @return integer
	 */
	public function count(array $where = [], $columns = '*')
	{
		$this->applyCriteria();
		$this->applyScope();
		$this->applyConditions($where);
		$count = $this->model->count($columns);
		$this->resetModel();

		return (integer)$count;
	}

	/**
	 * @inheritdoc
	 */
	public function paginate($limit = NULL, $columns = ['*'], $method = "paginate")
	{
		$limit = $limit ?: request('pageSize');

		return parent::paginate($limit, $columns, $method);
	}
}