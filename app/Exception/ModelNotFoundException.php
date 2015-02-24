<?php
namespace Notes\Exception;

class ModelNotFoundException extends \RuntimeException
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model;
    protected $message;
    /**
     * Set the affected Eloquent model.
     *
     * @param  string   $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model   = $model;
        $this->message = "Can Not Found Given Model In Database";
        return $this;
    }
    /**
     * Get the affected Eloquent model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }
}
