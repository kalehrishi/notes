<?php
namespace Notes\Exception;

use \RuntimeException;

class ModelNotFoundException extends RuntimeException
{
    /**
     * @var string
     */
    public $model;
    public $message;
    /**
     * Set the affected Eloquent model.
     *
     * @param  string   $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model   = $model;
        $this->message = "No query results for Note model.";
        return $this->message;
    }
    /**
     * @return string
     */
    public function getModel()
    {
        return $this->message;
    }
}
