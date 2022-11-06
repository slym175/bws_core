<?php

namespace Bws\Core\Traits;

use Bws\Core\Models\ActivityLog;

trait ModelLogging
{
    protected static function bootModelLogging()
    {
        foreach (static::getRecordActivityEvents() as $eventName) {
            static::$eventName(function ($model) use ($eventName) {
                try {
                    $reflect = new \ReflectionClass($model);
                    return ActivityLog::create([
                        'user_id' => auth()->id(),
                        'model_id' => $model->attributes[$model->primaryKey],
                        'model_type' => get_class($model),
                        'action' => static::getActionName($eventName),
                        'description' => ucfirst($eventName) . " a " . $reflect->getShortName(),
                        'old_details' => json_encode($model->getRawOriginal()),
                        'details' => json_encode($model->getDirty()),
                        'ip_address' => request()->ip()
                    ]);
                } catch (\Exception $e) {
                    debug($e->getMessage());
                }
            });
        }
    }

    /**
     * Set the default events to be recorded if the $recordEvents
     * property does not exist on the model.
     *
     * @return array
     */
    protected static function getRecordActivityEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return (method_exists(self::class, 'trashed') ? ['restored'] : []) + [
                'created',
                'updated',
                'deleted'
            ];
    }

    /**
     * Return Suitable action name for Supplied Event
     *
     * @param $event
     * @return string
     */
    protected static function getActionName($event)
    {
        switch (strtolower($event)) {
            case 'created':
                return 'create';
                break;
            case 'updated':
                return 'update';
                break;
            case 'deleted':
                return 'delete';
                break;
            case 'restored':
                return 'restore';
                break;
            default:
                return 'unknown';
        }
    }
}
