<?php 
namespace App\Repository\Transformers;

/**
 * Created by PhpStorm.
 * User: d.adelekan
 * Date: 24/08/2016
 * Time: 01:53
 */
abstract class Transformer {

    /*
     * Transforms a collection of lessons
     * @param $lessons
     * @return array
     */
    public function transformCollection(array $items){

        return array_map([$this, 'transform'], $items);

    }

    public abstract function transform($item);

}