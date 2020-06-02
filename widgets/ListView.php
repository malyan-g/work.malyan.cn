<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/6/2
 * Time: 15:17
 */

namespace app\widgets;

use Closure;

class ListView extends \yii\widgets\ListView
{
    /**
     * Renders all data models.
     * @return string the rendering result
     */
    public function renderItems()
    {
        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        $total = $this->dataProvider->getPagination()->offset * $this->dataProvider->getPagination()->limit;
        foreach (array_values($models) as $index => $model) {
            $number = $total + $index + 1;
            $key = $keys[$index];
            if (($before = $this->renderBeforeItem($model, $key, $index, $number)) !== null) {
                $rows[] = $before;
            }

            $rows[] = $this->renderItem($model, $key, $index);

            if (($after = $this->renderAfterItem($model, $key, $index, $number)) !== null) {
                $rows[] = $after;
            }
        }

        return implode($this->separator, $rows);
    }

    /**
     * Calls [[beforeItem]] closure, returns execution result.
     * If [[beforeItem]] is not a closure, `null` will be returned.
     *
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key value associated with the data model
     * @param int $index the zero-based index of the data model in the model array returned by [[dataProvider]].
     * @param int $number
     * @return string|null [[beforeItem]] call result or `null` when [[beforeItem]] is not a closure
     * @see beforeItem
     * @since 2.0.11
     */
    protected function renderBeforeItem($model, $key, $index, $number)
    {
        if ($this->beforeItem instanceof Closure) {
            return call_user_func($this->beforeItem, $model, $key, $index, $number, $this);
        }

        return null;
    }

    /**
     * Calls [[afterItem]] closure, returns execution result.
     * If [[afterItem]] is not a closure, `null` will be returned.
     *
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key value associated with the data model
     * @param int $index the zero-based index of the data model in the model array returned by [[dataProvider]].
     * @return string|null [[afterItem]] call result or `null` when [[afterItem]] is not a closure
     * @see afterItem
     * @since 2.0.11
     */
    protected function renderAfterItem($model, $key, $index, $number)
    {
        if ($this->afterItem instanceof Closure) {
            return call_user_func($this->afterItem, $model, $key, $index, $number, $this);
        }

        return null;
    }
}