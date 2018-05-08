<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 20:00
 */

namespace Entity;

class Project
{
    private $id;

    private $createdAt;

    private $updatedAt;

    private $deletedAt;

    private $title;

    private $script;

    private $readDefault;

    private $readOriginal;

    private $voiceBunnyId;

    private $audioIsReady;

    private $referenceCode;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param mixed $script
     */
    public function setScript($script)
    {
        $this->script = $script;
    }

    /**
     * @return mixed
     */
    public function getReadDefault()
    {
        return $this->readDefault;
    }

    /**
     * @param mixed $readDefault
     */
    public function setReadDefault($readDefault)
    {
        $this->readDefault = $readDefault;
    }

    /**
     * @return mixed
     */
    public function getReadOriginal()
    {
        return $this->readOriginal;
    }

    /**
     * @param mixed $readOriginal
     */
    public function setReadOriginal($readOriginal)
    {
        $this->readOriginal = $readOriginal;
    }

    /**
     * @return mixed
     */
    public function getVoiceBunnyId()
    {
        return $this->voiceBunnyId;
    }

    /**
     * @param mixed $voiceBunnyId
     */
    public function setVoiceBunnyId($voiceBunnyId)
    {
        $this->voiceBunnyId = $voiceBunnyId;
    }

    /**
     * @return mixed
     */
    public function getAudioIsReady()
    {
        return $this->audioIsReady;
    }

    /**
     * @param mixed $audioIsReady
     */
    public function setAudioIsReady($audioIsReady)
    {
        $this->audioIsReady = $audioIsReady;
    }

    /**
     * @return mixed
     */
    public function getReferenceCode()
    {
        return $this->referenceCode;
    }

    /**
     * @param mixed $referenceCode
     */
    public function setReferenceCode($referenceCode)
    {
        $this->referenceCode = $referenceCode;
    }
}