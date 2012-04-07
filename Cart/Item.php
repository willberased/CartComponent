<?php

/**
 * Basic Cart Item object
 * This object is intended to represent a common shopping cart item.
 * A developer can load their own product objects, as needed, based on simple item data contained here
 *
 * (c) Jesse Hanson [jessehanson.com]
 */

class Item 
{
    /**
     * @var string|int
     */
    protected $_productId; // YOUR product Id

    /**
     * @var float
     */
    protected $_price;
    
    /**
     * @var int|float
     */
    protected $_qty;

    /**
     * @var int|float
     */
    protected $_weight;

    /**
     * @var bool
     */
    protected $_isTaxable;

    /**
     * @var bool
     */
    protected $_isDiscountable;
    
    /**
     * @var array
     */
    protected $_custom; // YOUR key/value product variables
    
    //array keys for import/export

    static $productId = 'product_id';

    static $price = 'price';
    
    static $qty = 'qty';
    
    static $custom = 'custom';

    static $isTaxable = 'is_taxable';

    static $isDiscountable = 'is_discountable';
    
    static $separator = '-';
    
    public function __construct($productId = 0, $price = '', $qty = 1, $isTaxable = false, $isDiscountable = true, $custom = array()) 
    {
        $this->_productId = $productId;
        $this->_price = $price;
        $this->_qty = $qty;
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;
        $this->_custom = $custom;
    }
    
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Encapsulate object as formatted json string
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Encapsulate object as formatted array
     *
     * @return array
     */
    public function toArray()
    {
        $data = array(
            self::$productId      => $this->getProductId(),
            self::$price          => $this->getPrice(),
            self::$qty            => $this->getQty(),
            self::$custom         => $this->getCustom(),
            self::$isTaxable      => $this->getIsTaxable(),
            self::$isDiscountable => $this->getIsDiscountable(),
        );
        return $data;
    }
        
    /**
     * Import object from json string
     *
     * @param string $json
     * @return $this
     */
    public function importJson($json, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }

        //automatically resets object
        $data = @ (array) json_decode($json);
        if (!isset($data[self::$productId]) || !isset($data[self::$qty])) {
            return false;
        }

        $productId = isset($data[self::$productId]) ? $data[self::$productId] : '';
        $price = isset($data[self::$price]) ? $data[self::$price] : 0;
        $qty = isset($data[self::$qty]) ? $data[self::$qty] : 0;
        $custom = isset($data[self::$custom]) ? $data[self::$custom] : array();
        $isTaxable = isset($data[self::$isTaxable]) ? $data[self::$isTaxable] : false;
        $isDiscountable = isset($data[self::$isDiscountable]) ? $data[self::$isDiscountable] : true;
        
        $this->_productId = $productId;
        $this->_price = $price;
        $this->_qty = $qty;
        $this->_custom = $custom;
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;
        
        return $this;
    }

    /**
     * Reset object to default values
     *
     * @return $this
     */
    public function reset()
    {
        $this->_productId = 0;
        $this->_price = 0;
        $this->_qty = 0;
        $this->_custom = array();
        $this->_isTaxable = false;
        $this->_isDiscountable = true;
        return $this;
    }
    
    /**
     * Accessor for productId
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->_productId;
    }

    /**
     * Set product id
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        $this->_productId = $productId;
        return $this;
    }

    /**
     * Set price of product
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->_price = $price;
        return $this;
    }

    /**
     * Accessor for product price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Mutator
     */
    public function setQty($qty)
    {
        $this->_qty = $qty;
        return $this;
    }

    /**
     * Accessor
     */
    public function getQty()
    {
        return $this->_qty;
    }

    /**
     * Accessor
     */
    public function getIsTaxable()
    {
        return $this->_isTaxable;
    }

    /**
     * Mutator
     * 
     * @param bool $isTaxable
     */
    public function setIsTaxable($isTaxable)
    {
        $this->_isTaxable = $isTaxable;
        return $this;
    }

    /**
     * Accessor
     */
    public function getIsDiscountable()
    {
        return $this->_isDiscountable;
    }

    /**
     * Mutator
     */
    public function setIsDiscountable($isDiscountable)
    {
        $this->_isDiscountable = $isDiscountable;
        return $this;
    }

    /**
     * Accessor for custom product variables
     *
     * @return array
     */
    public function getCustom()
    {
        return $this->_custom;
    }
    
    /**
     * Add custom product variable
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addCustom($key, $value)
    {
        $this->_custom[$key] = $value;
        return $this;
    }
    
    /**
     * Remove custom product variable
     *
     * @param string $key
     * @return $this
     */
    public function removeCustom($key)
    {
        if (isset($this->_custom[$key])) {
            unset($this->_custom[$key]);
        }
        return $this;
    }
    
}