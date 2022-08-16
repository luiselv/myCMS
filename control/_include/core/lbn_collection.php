<?php
class Collection implements IteratorAggregate
{

  /**
   * Los elementos a coleccionar
   * 
   * @var array of mixed
   */
  protected $items = array();
  
  /**
   * Constructor
   * 
   * @param mixed $collection Collection o array
   */
  public function __construct($collection = null) 
  {
    if($collection instanceof Collection)
    {
        $this->addAll($collection);
    }
    elseif(is_array($collection)) 
    {
        $this->fromArray($collection);
    }
  }

  /**
   * Regresa el iterador del objeto
   * 
   * @return ArrayIterator 
   */
  public function getIterator()
  {
    return new ArrayIterator($this->items);
  }

  /**
   * Regresa all
   *
   * @return 
   */
  public function toArray()
    {
        return $this->items;
    } 
  
  /**
   * Agrega los elementos de una colección a esta colección
   * 
   * @param Collection $collection 
   */
  public function addAll(Collection $collection)
  {
    foreach ($collection as $key => $item) {
      $this->add($key, $item);
    }
  }
  
  /**
   * Regresa la cantidad de elementos
   * 
   * @return integer
   */
  public function count()
  {
    return count($this->items);
  }
  
  /**
   * Determina si el item existe en la colección
   * 
   * @param mixed $item
   * @return boolean 
   */
  public function contains($item)
  {
    foreach ($this->items as $key => $local_item) {
      if($local_item === $item) {
        return true;
      }
    }
    return false;
  }
  
  /**
   * Vacía la colección y la carga con el contenido del array
   * 
   * @param array $array 
   */
  public function fromArray($array)
  {
    $this->clear();
    foreach ($array as $key => $item) {
      $this->add($key, $item);
    }
  }

  /**
   * Agrega un item a la colección
   * 
   * @param scalar $key
   * @param mixed $item 
   */
  public function add($key, $item)
  {
    $this->items[$key] = $item;
  }

  /**
   * Elimina un item de la colleción
   * 
   * @param scalar $key 
   */
  public function delete($key)
  {
    unset($this->items[$key]);
  }

  /**
   * Vacía la colección
   */
  public function clear()
  {
    $this->items = array();
  }

  /**
   * Retorna un item
   * 
   * @param scalar $key
   * @return mixed
   */
  public function __get($key)
  {
    return isset($this->items[$key]) ? $this->items[$key] : null;
  }

  /**
   * Permite modificar o agregar un item
   * 
   * @param key $key
   * @param mixed $item 
   */
  public function __set($key, $item)
  {
    $this->items[$key] = $item;
  }

  /**
   * Determina si la clave existe
   * 
   * @param scalar $key
   * @return boolean
   */
  public function __isset($key)
  {
    return isset($this->items[$key]);
  }

  /**
   * Elimina un item
   * 
   * @param scalar $key 
   */
  public function __unset($key)
  {
    unset($this->items[$key]);
  }

  /**
   * Regresa una representación de los items contenidos
   * 
   * @return string
   */
  public function __tostring()
  {
    return print_r($this->items, true);
  }
}

?>