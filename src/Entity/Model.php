<?php

namespace LaiheLi\LaravelHelper\Entity;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	protected static $dispatchToParent = TRUE;

	/**
	 * @inheritdoc
	 */
	protected function castAttribute($key, $value)
	{
		switch($this->getCastType($key)){
			case 'url':
				return $value ? url($value) : NULL;
			case 'image':
				return $value ? asset($value) : NULL;
			case 'serialize':
				return @unserialize($value);
			case 'microtime':
				$time      = substr($value, 0, -3);
				$microtime = substr($value, -3);

				return date('Y-m-d H:i:s', $time) . " $microtime";
			default:
				return parent::castAttribute($key, $value);
		}
	}

	/**
	 * 子类触发事件时，父类也触发
	 *
	 * @inheritdoc
	 */
	protected function fireModelEvent($event, $halt = TRUE)
	{
		$result = parent::fireModelEvent($event, $halt);
		if(isset(static::$dispatcher) && static::$dispatchToParent){
			$method = $halt ? 'until' : 'fire';
			static::$dispatcher->{$method}("eloquent.{$event}: " . self::class, $this);
		}

		return $result;
	}


}