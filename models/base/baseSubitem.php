<?php
/**
 *		Created by Dan Blaisdell's DABL
 *		Do not alter base files, as they will be overwritten.
 *		To alter the objects, alter the extended classes in
 *		the 'models' folder.
 *
 */
abstract class baseSubitem extends ApplicationModel {

	const ID = 'subitem.id';
	const ITEM_ID = 'subitem.itemId';
	const NAME = 'subitem.name';
	const DESCRIPTION = 'subitem.description';
	const UPDATED = 'subitem.updated';
	const CREATED = 'subitem.created';

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $_tableName = 'subitem';

	/**
	 * Cache of objects retrieved from the database
	 * @var Subitem[]
	 */
	protected static $_instancePool = array();

	protected static $_instancePoolCount = 0;

	protected static $_poolEnabled = true;

	/**
	 * Array of objects to batch insert
	 */
	protected static $_insertBatch = array();

	/**
	 * Maximum size of the insert batch
	 */
	protected static $_insertBatchSize = 500;

	/**
	 * Array of all primary keys
	 * @var string[]
	 */
	protected static $_primaryKeys = array(
		'id',
	);

	/**
	 * string name of the primary key column
	 * @var string
	 */
	protected static $_primaryKey = 'id';

	/**
	 * true if primary key is an auto-increment column
	 * @var bool
	 */
	protected static $_isAutoIncrement = true;

	/**
	 * array of all fully-qualified(table.column) columns
	 * @var string[]
	 */
	protected static $_columns = array(
		Subitem::ID,
		Subitem::ITEM_ID,
		Subitem::NAME,
		Subitem::DESCRIPTION,
		Subitem::UPDATED,
		Subitem::CREATED,
	);

	/**
	 * array of all column names
	 * @var string[]
	 */
	protected static $_columnNames = array(
		'id',
		'itemId',
		'name',
		'description',
		'updated',
		'created',
	);

	/**
	 * array of all column types
	 * @var string[]
	 */
	protected static $_columnTypes = array(
		'id' => Model::COLUMN_TYPE_INTEGER,
		'itemId' => Model::COLUMN_TYPE_INTEGER,
		'name' => Model::COLUMN_TYPE_VARCHAR,
		'description' => Model::COLUMN_TYPE_VARCHAR,
		'updated' => Model::COLUMN_TYPE_INTEGER_TIMESTAMP,
		'created' => Model::COLUMN_TYPE_INTEGER_TIMESTAMP,
	);

	/**
	 * `id` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $id;

	/**
	 * `itemId` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $itemId;

	/**
	 * `name` VARCHAR
	 * @var string
	 */
	protected $name;

	/**
	 * `description` VARCHAR
	 * @var string
	 */
	protected $description;

	/**
	 * `updated` INTEGER_TIMESTAMP DEFAULT ''
	 * @var int
	 */
	protected $updated;

	/**
	 * `created` INTEGER_TIMESTAMP DEFAULT ''
	 * @var int
	 */
	protected $created;

	/**
	 * Gets the value of the id field
	 */
	function getId() {
		return $this->id;
	}

	/**
	 * Sets the value of the id field
	 * @return Subitem
	 */
	function setId($value) {
		return $this->setColumnValue('id', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the itemId field
	 */
	function getItemId() {
		return $this->itemId;
	}

	/**
	 * Sets the value of the itemId field
	 * @return Subitem
	 */
	function setItemId($value) {
		return $this->setColumnValue('itemId', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the name field
	 */
	function getName() {
		return $this->name;
	}

	/**
	 * Sets the value of the name field
	 * @return Subitem
	 */
	function setName($value) {
		return $this->setColumnValue('name', $value, Model::COLUMN_TYPE_VARCHAR);
	}

	/**
	 * Gets the value of the description field
	 */
	function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the value of the description field
	 * @return Subitem
	 */
	function setDescription($value) {
		return $this->setColumnValue('description', $value, Model::COLUMN_TYPE_VARCHAR);
	}

	/**
	 * Gets the value of the updated field
	 */
	function getUpdated($format = 'Y-m-d H:i:s') {
		if (null === $this->updated || null === $format) {
			return $this->updated;
		}
		return date($format, $this->updated);
	}

	/**
	 * Sets the value of the updated field
	 * @return Subitem
	 */
	function setUpdated($value) {
		return $this->setColumnValue('updated', $value, Model::COLUMN_TYPE_INTEGER_TIMESTAMP);
	}

	/**
	 * Gets the value of the created field
	 */
	function getCreated($format = 'Y-m-d H:i:s') {
		if (null === $this->created || null === $format) {
			return $this->created;
		}
		return date($format, $this->created);
	}

	/**
	 * Sets the value of the created field
	 * @return Subitem
	 */
	function setCreated($value) {
		return $this->setColumnValue('created', $value, Model::COLUMN_TYPE_INTEGER_TIMESTAMP);
	}

	/**
	 * @return DABLPDO
	 */
	static function getConnection() {
		return DBManager::getConnection('default_connection');
	}

	/**
	 * Searches the database for a row with the ID(primary key) that matches
	 * the one input.
	 * @return Subitem
	 */
	 static function retrieveByPK($id) {
		return static::retrieveByPKs($id);
	}

	/**
	 * Searches the database for a row with the primary keys that match
	 * the ones input.
	 * @return Subitem
	 */
	static function retrieveByPKs($id) {
		if (null === $id) {
			return null;
		}
		if (static::$_poolEnabled) {
			$pool_instance = static::retrieveFromPool($id);
			if (null !== $pool_instance) {
				return $pool_instance;
			}
		}
		$q = new Query;
		$q->add('id', $id);
		return static::doSelectOne($q);
	}

	/**
	 * Searches the database for a row with a id
	 * value that matches the one provided
	 * @return Subitem
	 */
	static function retrieveById($value) {
		return Subitem::retrieveByPK($value);
	}

	/**
	 * Searches the database for a row with a itemId
	 * value that matches the one provided
	 * @return Subitem
	 */
	static function retrieveByItemId($value) {
		return static::retrieveByColumn('itemId', $value);
	}

	/**
	 * Searches the database for a row with a name
	 * value that matches the one provided
	 * @return Subitem
	 */
	static function retrieveByName($value) {
		return static::retrieveByColumn('name', $value);
	}

	/**
	 * Searches the database for a row with a description
	 * value that matches the one provided
	 * @return Subitem
	 */
	static function retrieveByDescription($value) {
		return static::retrieveByColumn('description', $value);
	}

	/**
	 * Searches the database for a row with a updated
	 * value that matches the one provided
	 * @return Subitem
	 */
	static function retrieveByUpdated($value) {
		return static::retrieveByColumn('updated', $value);
	}

	/**
	 * Searches the database for a row with a created
	 * value that matches the one provided
	 * @return Subitem
	 */
	static function retrieveByCreated($value) {
		return static::retrieveByColumn('created', $value);
	}


	/**
	 * Casts values of int fields to (int)
	 * @return Subitem
	 */
	function castInts() {
		$this->id = (null === $this->id) ? null : (int) $this->id;
		$this->itemId = (null === $this->itemId) ? null : (int) $this->itemId;
		$this->updated = (null === $this->updated) ? null : (int) $this->updated;
		$this->created = (null === $this->created) ? null : (int) $this->created;
		return $this;
	}

	/**
	 * @return Subitem
	 */
	function setItem(Item $item = null) {
		return $this->setItemRelatedByItemId($item);
	}

	/**
	 * @return Subitem
	 */
	function setItemRelatedByItemId(Item $item = null) {
		if (null === $item) {
			$this->setitemId(null);
		} else {
			if (!$item->getid()) {
				throw new Exception('Cannot connect a Item without a id');
			}
			$this->setitemId($item->getid());
		}
		return $this;
	}

	/**
	 * Returns a item object with a id
	 * that matches $this->itemId.
	 * @return Item
	 */
	function getItem() {
		return $this->getItemRelatedByItemId();
	}

	/**
	 * Returns a item object with a id
	 * that matches $this->itemId.
	 * @return Item
	 */
	function getItemRelatedByItemId() {
		$fk_value = $this->getitemId();
		if (null === $fk_value) {
			return null;
		}
		return Item::retrieveByPK($fk_value);
	}

	static function doSelectJoinItem(Query $q = null, $join_type = Query::LEFT_JOIN) {
		return static::doSelectJoinItemRelatedByItemId($q, $join_type);
	}

	/**
	 * @return Subitem[]
	 */
	static function doSelectJoinItemRelatedByItemId(Query $q = null, $join_type = Query::LEFT_JOIN) {
		$q = $q ? clone $q : new Query;
		$columns = $q->getColumns();
		$alias = $q->getAlias();
		$this_table = $alias ? $alias : static::getTableName();
		if (!$columns) {
			if ($alias) {
				foreach (static::getColumns() as $column_name) {
					$columns[] = $alias . '.' . $column_name;
				}
			} else {
				$columns = static::getColumns();
			}
		}

		$to_table = Item::getTableName();
		$q->join($to_table, $this_table . '.itemId = ' . $to_table . '.id', $join_type);
		foreach (Item::getColumns() as $column) {
			$columns[] = $column;
		}
		$q->setColumns($columns);

		return static::doSelect($q, array('Item'));
	}

	/**
	 * @return Subitem[]
	 */
	static function doSelectJoinAll(Query $q = null, $join_type = Query::LEFT_JOIN) {
		$q = $q ? clone $q : new Query;
		$columns = $q->getColumns();
		$classes = array();
		$alias = $q->getAlias();
		$this_table = $alias ? $alias : static::getTableName();
		if (!$columns) {
			if ($alias) {
				foreach (static::getColumns() as $column_name) {
					$columns[] = $alias . '.' . $column_name;
				}
			} else {
				$columns = static::getColumns();
			}
		}

		$to_table = Item::getTableName();
		$q->join($to_table, $this_table . '.itemId = ' . $to_table . '.id', $join_type);
		foreach (Item::getColumns() as $column) {
			$columns[] = $column;
		}
		$classes[] = 'Item';
	
		$q->setColumns($columns);
		return static::doSelect($q, $classes);
	}

	/**
	 * Returns true if the column values validate.
	 * @return bool
	 */
	function validate() {
		$this->_validationErrors = array();
		if (null === $this->getitemId()) {
			$this->_validationErrors[] = 'itemId must not be null';
		}
		return 0 === count($this->_validationErrors);
	}

}