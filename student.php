<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/18
 * Time: 16:45
 */

class Student{

    public $talk;

    public function __construct(ITalk $talk){ //这里表示必须继承自ITalk接口或类

        $this->talk=$talk;
    }

    public function say(){

        $this->talk->say();
    }

    public function test(){

        echo 222;
    }
}

interface ITalk{

    public function say();
}

class Stu1 implements ITalk{

    public function say(){

        echo 'i am stu1';
    }
}

class Stu2 implements ITalk{

    public function say(){

        echo 'i am stu2';
    }
}
class Stu3 implements ITalk{

    public function say(){

        echo 'i am not you really student';
    }
}
//
//$stu=new Student(new Stu3);
//
//$stu->say();


class Container{
//    存放匿名函数，需要被调用
    public  $binds;
//    存放实例
    public $instances;

    public function bind($abstract,$concrete){

        if($concrete instanceof  Closure){

//            echo 1;

            $this->binds[$abstract]=$concrete;
        }else{

//            echo 2;
            $this->instances[$abstract]=$concrete;
        }
    }

    public function make($abstract ,$parameters=[]){
//       如果是实例 则直接返回
        if(isset($this->instances[$abstract])){

//            echo 3;
            return $this->instances[$abstract];
        }
//        如果是匿名函数 则调用
        array_unshift($parameters,$this);
//        echo 4;
        return call_user_func_array($this->binds[$abstract],$parameters);
    }
}

$container=new Container();
//绑定 匿名函数
$container->bind('Student',function($container,$talkName){

    return new Student($container->make($talkName));
});
//绑定实例
$container->bind('Stu1',function(){

    return new Stu1;
});

$container->make('Student',['Stu1']);
//
$container->binds['Stu1']()->say();
//$container->binds['Student']()->test();

