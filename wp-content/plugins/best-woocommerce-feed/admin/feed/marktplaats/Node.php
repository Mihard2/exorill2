<?php

namespace RexTheme\MarktPlaatsShoppingFeed;

class Node
{
    /**
     * [$name description]
     * @var string
     */
    protected $name = null;

    /**
     * [$namespace description]
     * @var string
     */
    protected $_namespace = null;

    /**
     * [$value description]
     * @var string
     */
    protected $value = '';

    /**
     * [$cdata description]
     * @var boolean
     */
    protected $cdata = false;

    /**
     * Node constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Sets Node namespace
     * @param string $value
     * @return $this
     */
    public function _namespace($value)
    {
        $this->_namespace = $value;
        return $this;
    }

    /**
     * @return $this
     */
    public function addCdata()
    {
        $this->cdata = true;
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->{$key};
    }

    /**
     * Attachs actual node to a parent node
     * @param \SimpleXMLElement $parent
     */
    public function attachNodeTo(\SimpleXMLElement $parent)
    {
        if ( preg_match("#^<!\[CDATA#is", $this->value)) {
            $this->value = str_replace("<![CDATA [","",$this->value);
            $this->value = str_replace("]]>","",$this->value);
            $new_child = $parent->addChild($this->name);
            $node = dom_import_simplexml($new_child);
            $no=$node->ownerDocument;
            $node->appendChild($no->createCDATASection($this->value));
        }else {
            $parent->addChild($this->name, htmlspecialchars($this->value), $this->_namespace);
        }
    }
}
