<?php

namespace steroids\cron;

use yii\base\BaseObject;

/**
 * Class CronTask
 * @package steroids\cron
 * @property-read string $id
 */
class CronTask extends BaseObject
{
    /**
     * Unique task name in module
     * @var string
     */
    public ?string $taskId = '';

    /**
     * @var string
     */
    public string $moduleId;

    /**
     * Callable handler
     * @var array|string|callable
     */
    public $handler;

    /**
     * Cron expression
     * @example 15 * * * *
     * @var string
     */
    public string $expression;

    /**
     * @var array
     */
    public array $args = [];

    public function getId()
    {
        return $this->taskId ? $this->moduleId . '.' . $this->taskId : null;
    }

    public function run()
    {
        call_user_func($this->handler, ...$this->args);
    }
}
