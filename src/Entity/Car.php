<?php
namespace Concrete\Package\SymfonyFormsExample\Src\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Concrete\Package\SymfonyFormsExample\Src\Entity;

defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @Entity
 * @Table(name="SymfonyFormsExampleCars")
 */
class Car extends Entity
{

    const TYPE_HATCHBACK     = 1;
    const TYPE_SEDAN         = 2;
    const TYPE_STATION_WAGON = 3;
    const TYPE_SPORT         = 4;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $carID;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @Column(type="datetime", nullable=false)
     */
    protected $manufacturingDate;

    /**
     * @Column(type="integer")
     */
    protected $type;

    /**
     * @Column(type="integer")
     */
    protected $numberOfDoors;

    /**
     * @Column(type="decimal", precision=18, scale=2)
     */
    protected $retailPrice;

    /**
     * @OneToOne(targetEntity="Concrete\Core\File\File")
     * @JoinColumn(name="imageFID", referencedColumnName="fID")
     */
    protected $image;

    public function getTypeName()
    {
        $types = static::getTypes();
        return $types[$this->type];
    }

    public static function getTypes()
    {
        return array(
            static::TYPE_HATCHBACK => t("Hatchback"),
            static::TYPE_SEDAN => t("Sedan"),
            static::TYPE_STATION_WAGON => t("Station Wagon"),
            static::TYPE_SPORT => t("Sport"),
        );
    }

}
