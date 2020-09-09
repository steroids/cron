<?php

namespace steroids\cron\commands;

use Cron\CronExpression;
use steroids\cron\CronModule;
use yii\console\Controller;
use yii\helpers\StringHelper;

class CronCommand extends Controller
{
    public function actionIndex($ids = '')
    {
        $ids = StringHelper::explode($ids);

        $tasks = CronModule::getInstance()->getAllTasks();
        foreach ($tasks as $task) {
            if (!empty($ids) && !in_array($task->id, $ids)) {
                continue;
            }
            if (CronExpression::factory($task->expression)->isDue()) {
                $task->run();
            }
        }
    }
}
