<?php
/**
 *		Created by Dan Blaisdell's DABL
 *		Do not alter base files, as they will be overwritten.
 *		To alter the objects, alter the extended classes in
 *		the 'models' folder.
 *
 */
abstract class baseItem extends ApplicationModel {

	const ID = 'item.id';
	const CATEGORY_ID = 'item.categoryId';
	const COMPLETE = 'item.complete';
	const DESCRIPTION = 'item.description';
	const PRIORITY = 'item.priority';
	const PROGRESS = 'item.progress';
	const NAME = 'item.name';

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $_tableName = 'item';

	/**
	 * Cache of objects retrieved from the database
	 * @var Item[]
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
		Item::ID,
		Item::CATEGORY_ID,
		Item::COMPLETE,
		Item::DESCRIPTION,
		Item::PRIORITY,
		Item::PROGRESS,
		Item::NAME,
	);

	/**
	 * array of all column names
	 * @var string[]
	 */
	protected static $_columnNames = array(
		'id',
		'categoryId',
		'complete',
		'description',
		'priority',
		'progress',
		'name',
	);

	/**
	 * array of all column types
	 * @var string[]
	 */
	protected static $_columnTypes = array(
		'id' => Model::COLUMN_TYPE_INTEGER,
		'categoryId' => Model::COLUMN_TYPE_INTEGER,
		'complete' => Model::COLUMN_TYPE_TINYINT,
		'description' => Model::COLUMN_TYPE_LONGVARCHAR,
		'priority' => Model::COLUMN_TYPE_INTEGER,
		'progress' => Model::COLUMN_TYPE_INTEGER,
		'name' => Model::COLUMN_TYPE_VARCHAR,
	);

	/**
	 * `id` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $id;

	/**
	 * `categoryId` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $categoryId;

	/**
	 * `complete` TINYINT NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $complete;

	/**
	 * `description` LONGVARCHAR
	 * @var string
	 */
	protected $description;

	/**
	 * `priority` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $priority;

	/**
	 * `progress` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $progress;

	/**
	 * `name` VARCHAR NOT NULL
	 * @var string
	 */
	protected $name;

	/**
	 * Gets the value of the id field
	 */
	function getId() {
		return $this->id;
	}

	/**
	 * Sets the value of the id field
	 * @return Item
	 */
	function setId($value) {
		return $this->setColumnValue('id', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the categoryId field
	 */
	function getCategoryId() {
		return $this->categoryId;
	}

	/**
	 * Sets the value of the categoryId field
	 * @return Item
	 */
	function setCategoryId($value) {
		return $this->setColumnValue('categoryId', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the complete field
	 */
	function getComplete() {
		return $this->complete;
	}

	/**
	 * Sets the value of the complete field
	 * @return Item
	 */
	function setComplete($value) {
		return $this->setColumnValue('complete', $value, Model::COLUMN_TYPE_TINYINT);
	}

	/**
	 * Gets the value of the description field
	 */
	function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the value of the description field
	 * @return Item
	 */
	function setDescription($value) {
		return $this->setColumnValue('description', $value, Model::COLUMN_TYPE_LONGVARCHAR);
	}

	/**
	 * Gets the value of the priority field
	 */
	function getPriority() {
		return $this->priority;
	}

	/**
	 * Sets the value of the priority field
	 * @return Item
	 */
	function setPriority($value) {
		return $this->setColumnValue('priority', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the progress field
	 */
	function getProgress() {
		return $this->progress;
	}

	/**
	 * Sets the value of the progress field
	 * @return Item
	 */
	function setProgress($value) {
		return $this->setColumnValue('progress', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the name field
	 */
	function getName() {
		return $this->name;
	}

	/**
	 * Sets the value of the name field
	 * @return Item
	 */
	function setName($value) {
		return $this->setColumnValue('name', $value, Model::COLUMN_TYPE_VARCHAR);
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
	 * @return Item
	 */
	 static function retrieveByPK($id) {
		return static::retrieveByPKs($id);
	}

	/**
	 * Searches the database for a row with the primary keys that match
	 * the ones input.
	 * @return Item
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
	 * @return Item
	 */
	static function retrieveById($value) {
		return Item::retrieveByPK($value);
	}

	/**
	 * Searches the database for a row with a categoryId
	 * value that matches the one provided
	 * @return Item
	 */
	static function retrieveByCategoryId($value) {
		return static::retrieveByColumn('categoryId', $value);
	}

	/**
	 * Searches the database for a row with a complete
	 * value that matches the one provided
	 * @return Item
	 */
	static function retrieveByComplete($value) {
		return static::retrieveByColumn('complete', $value);
	}

	/**
	 * Searches the database for a row with a description
	 * value that matches the one provided
	 * @return Item
	 */
	static function retrieveByDescription($value) {
		return static::retrieveByColumn('description', $value);
	}

	/**
	 * Searches the database for a row with a priority
	 * value that matches the one provided
	 * @return Item
	 */
	static function retrieveByPriority($value) {
		return static::retrieveByColumn('priority', $value);
	}

	/**
	 * Searches the database for a row with a progress
	 * value that matches the one provided
	 * @return Item
	 */
	static function retrieveByProgress($value) {
		return static::retrieveByColumn('progress', $value);
	}

	/**
	 * Searches the database for a row with a name
	 * value that matches the one provided
	 * @return Item
	 */
	static function retrieveByName($value) {
		return static::retrieveByColumn('name', $value);
	}


	/**
	 * Casts values of int fields to (int)
	 * @return Item
	 */
	function castInts() {
		$this->id = (null === $this->id) ? null : (int) $this->id;
		$this->categoryId = (null === $this->categoryId) ? null : (int) $this->categoryId;
		$this->complete = (null === $this->complete) ? null : (int) $this->complete;
		$this->priority = (null === $this->priority) ? null : (int) $this->priority;
		$this->progress = (null === $this->progress) ? null : (int) $this->progress;
		return $this;
	}

	/**
	 * @return Item
	 */
	function setCategory(Category $category = null) {
		return $this->setCategoryRelatedByCategoryId($category);
	}

	/**
	 * @return Item
	 */
	function setCategoryRelatedByCategoryId(Category $category = null) {
		if (null === $category) {
			$this->setcategoryId(null);
		} else {
			if (!$category->getid()) {
				throw new Exception('Cannot connect a Category without a id');
			}
			$this->setcategoryId($category->getid());
		}
		return $this;
	}

	/**
	 * Returns a category object with a id
	 * that matches $this->categoryId.
	 * @return Category
	 */
	function getCategory() {
		return $this->getCategoryRelatedByCategoryId();
	}

	/**
	 * Returns a category object with a id
	 * that matches $this->categoryId.
	 * @return Category
	 */
	function getCategoryRelatedByCategoryId() {
		$fk_value = $this->getcategoryId();
		if (null === $fk_value) {
			return null;
		}
		return Category::retrieveByPK($fk_value);
	}

	static function doSelectJoinCategory(Query $q = null, $join_type = Query::LEFT_JOIN) {
		return static::doSelectJoinCategoryRelatedByCategoryId($q, $join_type);
	}

	/**
	 * @return Item[]
	 */
	static function doSelectJoinCategoryRelatedByCategoryId(Query $q = null, $join_type = Query::LEFT_JOIN) {
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

		$to_table = Category::getTableName();
		$q->join($to_table, $this_table . '.categoryId = ' . $to_table . '.id', $join_type);
		foreach (Category::getColumns() as $column) {
			$columns[] = $column;
		}
		$q->setColumns($columns);

		return static::doSelect($q, array('Category'));
	}

	/**
	 * @return Item[]
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

		$to_table = Category::getTableName();
		$q->join($to_table, $this_table . '.categoryId = ' . $to_table . '.id', $join_type);
		foreach (Category::getColumns() as $column) {
			$columns[] = $column;
		}
		$classes[] = 'Category';
	
		$q->setColumns($columns);
		return static::doSelect($q, $classes);
	}

	/**
	 * Returns true if the column values validate.
	 * @return bool
	 */
	function validate() {
		$this->_validationErrors = array();
		if (null === $this->getcategoryId()) {
			$this->_validationErrors[] = 'categoryId must not be null';
		}
		if (null === $this->getcomplete()) {
			$this->_validationErrors[] = 'complete must not be null';
		}
		if (null === $this->getpriority()) {
			$this->_validationErrors[] = 'priority must not be null';
		}
		if (null === $this->getprogress()) {
			$this->_validationErrors[] = 'progress must not be null';
		}
		if (null === $this->getname()) {
			$this->_validationErrors[] = 'name must not be null';
		}
		return 0 === count($this->_validationErrors);
	}

}