<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace frontend\App\Proto;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>BaseModel</code>
 */
class BaseModel extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional uint64 id = 1;</code>
     */
    protected $id = null;
    /**
     * Generated from protobuf field <code>optional string created_at = 2;</code>
     */
    protected $created_at = null;
    /**
     * Generated from protobuf field <code>optional string updated_at = 3;</code>
     */
    protected $updated_at = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $id
     *     @type string $created_at
     *     @type string $updated_at
     * }
     */
    public function __construct($data = NULL) {
        \frontend\App\Proto\GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional uint64 id = 1;</code>
     * @return int|string
     */
    public function getId()
    {
        return isset($this->id) ? $this->id : 0;
    }

    public function hasId()
    {
        return isset($this->id);
    }

    public function clearId()
    {
        unset($this->id);
    }

    /**
     * Generated from protobuf field <code>optional uint64 id = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkUint64($var);
        $this->id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string created_at = 2;</code>
     * @return string
     */
    public function getCreatedAt()
    {
        return isset($this->created_at) ? $this->created_at : '';
    }

    public function hasCreatedAt()
    {
        return isset($this->created_at);
    }

    public function clearCreatedAt()
    {
        unset($this->created_at);
    }

    /**
     * Generated from protobuf field <code>optional string created_at = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCreatedAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->created_at = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string updated_at = 3;</code>
     * @return string
     */
    public function getUpdatedAt()
    {
        return isset($this->updated_at) ? $this->updated_at : '';
    }

    public function hasUpdatedAt()
    {
        return isset($this->updated_at);
    }

    public function clearUpdatedAt()
    {
        unset($this->updated_at);
    }

    /**
     * Generated from protobuf field <code>optional string updated_at = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setUpdatedAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->updated_at = $var;

        return $this;
    }

}

