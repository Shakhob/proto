<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace frontend\App\Proto;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>Person</code>
 */
class Person extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional .BaseModel base_model = 1;</code>
     */
    protected $base_model = null;
    /**
     * Generated from protobuf field <code>optional string name = 2;</code>
     */
    protected $name = null;
    /**
     * Generated from protobuf field <code>optional string address = 3;</code>
     */
    protected $address = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \frontend\App\Proto\BaseModel $base_model
     *     @type string $name
     *     @type string $address
     * }
     */
    public function __construct($data = NULL) {
        \frontend\App\Proto\GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional .BaseModel base_model = 1;</code>
     * @return \frontend\App\Proto\BaseModel|null
     */
    public function getBaseModel()
    {
        return $this->base_model;
    }

    public function hasBaseModel()
    {
        return isset($this->base_model);
    }

    public function clearBaseModel()
    {
        unset($this->base_model);
    }

    /**
     * Generated from protobuf field <code>optional .BaseModel base_model = 1;</code>
     * @param \frontend\App\Proto\BaseModel $var
     * @return $this
     */
    public function setBaseModel($var)
    {
        GPBUtil::checkMessage($var, \frontend\App\Proto\BaseModel::class);
        $this->base_model = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return isset($this->name) ? $this->name : '';
    }

    public function hasName()
    {
        return isset($this->name);
    }

    public function clearName()
    {
        unset($this->name);
    }

    /**
     * Generated from protobuf field <code>optional string name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string address = 3;</code>
     * @return string
     */
    public function getAddress()
    {
        return isset($this->address) ? $this->address : '';
    }

    public function hasAddress()
    {
        return isset($this->address);
    }

    public function clearAddress()
    {
        unset($this->address);
    }

    /**
     * Generated from protobuf field <code>optional string address = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->address = $var;

        return $this;
    }

}

