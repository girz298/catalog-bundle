<?php
namespace CatalogBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="categories",indexes={
 *     @ORM\Index(name="title", columns={"title"}),
 *     @ORM\Index(name="state_flag", columns={"state_flag"})})
 *
 * @ORM\Entity(repositoryClass="CatalogBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(length=64, type="string", unique=true)
     */
    private $title;

    /**
     * @ORM\Column(name="state_flag", type="boolean")
     */
    private $state_flag;


    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getName()
    {
        return $this->title;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return Category
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return Category
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return Category
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param \CatalogBundle\Entity\Category $root
     *
     * @return Category
     */
    public function setRoot(\CatalogBundle\Entity\Category $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Add child
     *
     * @param \CatalogBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\CatalogBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \CatalogBundle\Entity\Category $child
     */
    public function removeChild(\CatalogBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set stateFlag
     *
     * @param boolean $stateFlag
     *
     * @return Category
     */


    /**
     * Set stateLag
     *
     * @param boolean $stateLag
     *
     * @return Category
     */


    /**
     * Set stateFlag
     *
     * @param boolean $stateFlag
     *
     * @return Category
     */
    public function setStateFlag($stateFlag)
    {
        $this->state_flag = $stateFlag;

        return $this;
    }

    /**
     * Get stateFlag
     *
     * @return boolean
     */
    public function getStateFlag()
    {
        return $this->state_flag;
    }

    /**
     * Add product
     *
     * @param \CatalogBundle\Entity\Product $product
     *
     * @return Category
     */
    public function addProduct(\CatalogBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \CatalogBundle\Entity\Product $product
     */
    public function removeProduct(\CatalogBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
