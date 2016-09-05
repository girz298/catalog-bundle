<?php

namespace CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
/**
 * @ORM\Table(name="products",indexes={
 *     @ORM\Index(name="name", columns={"name"}),
 *     @ORM\Index(name="creation_time", columns={"creation_time"})})
 * @ORM\Entity(repositoryClass="CatalogBundle\Entity\ProductRepository")
 */
//implements JsonSerializable
class Product
{

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_time", type="datetime")
     */
    private $creationTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modification", type="datetime")
     */
    private $lastModification;

    /**
     * @var bool
     *
     * @ORM\Column(name="state_flag", type="boolean")
     */
    private $stateFlag;


    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="similar_products",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="similar_id", referencedColumnName="id")}
     *      )
     */
    private $similar_products;

//    Waiting for fixes
//
//    /**
//     * @ORM\OneToMany(targetEntity="Product", mappedBy="similar_to")
//     */
//    private $similar_from;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Product", inversedBy="similar_from")
//     * @ORM\JoinColumn(name="similar_to", referencedColumnName="id")
//     */
//    private $similar_to;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=50, unique=true)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=50, nullable=true)
     */
    private $image;

//    public function __construct() {
//        $this->similar_from = new ArrayCollection();
//    }

//    function jsonSerialize()
//    {
//        return [
//            'id' => $this->id,
//            'name' => $this->name,
//            'category' => $this->category->getName(),
//            'description' => $this->description,
//            'sku' => $this->sku,
//            'image' => $this->image,
//            'creation_time' => $this->creationTime->getTimestamp(),
//            'last_modification_time' =>$this->lastModification->getTimestamp(),
//        ];
//    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->similar_products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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

    /**
     * Set creationTime
     *
     * @param \DateTime $creationTime
     *
     * @return Product
     */
    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;

        return $this;
    }

    /**
     * Get creationTime
     *
     * @return \DateTime
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }

    /**
     * Set lastModification
     *
     * @param \DateTime $lastModification
     *
     * @return Product
     */
    public function setLastModification($lastModification)
    {
        $this->lastModification = $lastModification;

        return $this;
    }

    /**
     * Get lastModification
     *
     * @return \DateTime
     */
    public function getLastModification()
    {
        return $this->lastModification;
    }

    /**
     * Set stateFlag
     *
     * @param boolean $stateFlag
     *
     * @return Product
     */
    public function setStateFlag($stateFlag)
    {
        $this->stateFlag = $stateFlag;

        return $this;
    }

    /**
     * Get stateFlag
     *
     * @return boolean
     */
    public function getStateFlag()
    {
        return $this->stateFlag;
    }

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \CatalogBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\CatalogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CatalogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category->getName();
    }

    /**
     * Add similarProduct
     *
     * @param \CatalogBundle\Entity\Product $similarProduct
     *
     * @return Product
     */
    public function addSimilarProduct(\CatalogBundle\Entity\Product $similarProduct)
    {
        $this->similar_products[] = $similarProduct;

        return $this;
    }

    /**
     * Remove similarProduct
     *
     * @param \CatalogBundle\Entity\Product $similarProduct
     */
    public function removeSimilarProduct(\CatalogBundle\Entity\Product $similarProduct)
    {
        $this->similar_products->removeElement($similarProduct);
    }

    /**
     * Get similarProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSimilarProducts()
    {
        return $this->similar_products;
    }
}
