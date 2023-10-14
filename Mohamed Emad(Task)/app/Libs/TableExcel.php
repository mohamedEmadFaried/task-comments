<?php

namespace App\Libs;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromArray;
class TableExcel{

    public $model;

    private $columns = [];
    private $footer = [];
    private $headColumns = [];

    public function setHeadColumns(array $columns){
        $this->headColumns = $columns;
        return $this;
    }

    public function eloquent($model){
        $this->model = $model;
        return $this;
    }
    public function setFooterColumns(array $footer){
        $this->footerColumns = $footer;
        return $this;
    }
    public function addColumn($name,$callback = null){
        $this->columns[$name] = $callback;
        return $this;
    }

    public function render($fileName){

        $result = [];
        $result['headColumns'] = $this->headColumns;

        foreach ($this->model->get() as $key => $value){
            $result[$key] = [];
            foreach ($this->columns as $CKey => $CValue){
                if(is_null($CValue)){
                    $result[$key][] = $value->$CKey;
                }else{
                    $result[$key][] = $CValue($value);
                }
            }
        }
        $result['footerColumns'] = $this->footerColumns;
        return \Excel::download(
            new class($result) implements FromArray{
                private $data;
                public function __construct($data){
                    $this->data = $data;
                }
                public function array():array {
                    return $this->data;
                }
            },
            $fileName.'-'.date('Y-m-d h i A').'.xlsx'
        );


    }
}
