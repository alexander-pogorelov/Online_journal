<?php

namespace Application\Sonata\UserBundle\Entity;

/**
 * Auditori
 */
class Auditori
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $nomer;

    /**
     * @var int
     */
    private $vmestimost;

    /**
     * @var string
     */
    private $description;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomer
     *
     * @param integer $nomer
     *
     * @return Auditori
     */
    public function setNomer($nomer)
    {
        $this->nomer = $nomer;

        return $this;
    }

    /**
     * Get nomer
     *
     * @return int
     */
    public function getNomer()
    {
        return $this->nomer;
    }

    /**
     * Set vmestimost
     *
     * @param integer $vmestimost
     *
     * @return Auditori
     */
    public function setVmestimost($vmestimost)
    {
        $this->vmestimost = $vmestimost;

        return $this;
    }

    /**
     * Get vmestimost
     *
     * @return int
     */
    public function getVmestimost()
    {
        return $this->vmestimost;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Auditori
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

