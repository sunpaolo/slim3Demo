<?php
namespace Test\Lib;

class StaticModelTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        /*
       $model = new StaticModel(1, 'test');
       $model->update(['name' => 'paolo']);
       $model->update(['age' => '35']);
       $model->update(['like' => ['a','b']]);
       $model->update(['$set' => ['age' => 80]]);
       $model->update(['$inc' => ['age' => 10]]);
       $model->update(['$push' => ['like' => 'c']]);
       $model->update(['$addToSet' => ['like' => 'c']]);
       $model->update(['$pull' => ['like' => 'a']]);
       $model->update(['$pop' => ['like' => -1]]);
       */
        //$model->flush();
        $model2 = new StaticModel(3, 'test2');
        //$model2->findOne();
        //$model2->update([
        //    'name' => ['a'],
        //    'age' => 30,
        //    '$inc' => ['age' => 10]
        //]);
        //$model2->update(['$set' => ['name.0' => 1]]);
        $model2->update(['$unset' => ['name.0' => 1]]);
        //$model2->update(['$unset' => ['age' => 1]]);
        StaticModel::flushAll();
    }
}
