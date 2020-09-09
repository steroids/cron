<?php

namespace steroids\cron;

use steroids\core\helpers\ModuleHelper;
use yii\base\Component;
use steroids\core\base\Module;

class CronModule extends Module
{
    /**
     * @var bool
     */
    public bool $useQueue = false;

    /**
     * @var string|array|Component
     */
    public $queue = 'queue';

    /**
     * @var array
     */
    public array $tasks = [];

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public static function cron()
    {
        return static::getInstance()->tasks;
    }

    /**
     * @return CronTask[]
     */
    public function getAllTasks()
    {
        $tasks = [];
        foreach (ModuleHelper::findAppModuleClasses() as $moduleClass) {
            if (!method_exists($moduleClass, 'cron')) {
                continue;
            }

            $classFile = ModuleHelper::resolveModule($moduleClass);
            foreach ($moduleClass::cron() as $taskId => $taskConfig) {
                $tasks[] = new CronTask(array_merge(
                    [
                        'taskId' => is_string($taskId) ? $taskId : null,
                        'moduleId' => $classFile->moduleId,
                    ],
                    $taskConfig
                ));
            }
        }
        return $tasks;
    }
}
