<?php
/**
 *		Created by Dan Blaisdell's DABL
 *		Do not alter base files, as they will be overwritten.
 *		To alter the objects, alter the extended classes in
 *		the 'models' folder.
 *
 */
abstract class baseCategory extends ApplicationModel {

	const ID = 'category.id';
	const USER_ID = 'category.userId';
	const NAME = 'category.name';

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $_tableName = 'category';

	/**
	 * Cache of objects retrieved from the database
	 * @var Category[]
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
		Category::ID,
		Category::USER_ID,
		Category::NAME,
	);

	/**
	 * array of all column names
	 * @var string[]
	 */
	protected static $_columnNames = array(
		'id',
		'userId',
		'name',
	);

	/**
	 * array of all column types
	 * @var string[]
	 */
	protected static $_columnTypes = array(
		'id' => Model::COLUMN_TYPE_INTEGER,
		'userId' => Model::COLUMN_TYPE_INTEGER,
		'name' => Model::COLUMN_TYPE_VARCHAR,
	);

	/**
	 * `id` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $id;

	/**
	 * `userId` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $userId;

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
	 * @return Category
	 */
	function setId($value) {
		return $this->setColumnValue('id', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the userId field
	 */
	function getUserId() {
		return $this->userId;
	}

	/**
	 * Sets the value of the userId field
	 * @return Category
	 */
	function setUserId($value) {
		return $this->setColumnValue('userId', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the name field
	 */
	function getName() {
		return $this->name;
	}

	/**
	 * Sets the value of the name field
	 * @return Category
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
	 * @return Category
	 */
	 static function retrieveByPK($id) {
		return static::retrieveByPKs($id);
	}

	/**
	 * Searches the database for a row with the primary keys that match
	 * the ones input.
	 * @return Category
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
	 * @return Category
	 */
	static function retrieveById($value) {
		return Category::retrieveByPK($value);
	}

	/**
	 * Searches the database for a row with a userId
	 * value that matches the one provided
	 * @return Category
	 */
	static function retrieveByUserId($value) {
		return static::retrieveByColumn('userId', $value);
	}

	/**
	 * Searches the database for a row with a name
	 * value that matches the one provided
	 * @return Category
	 */
	static function retrieveByName($value) {
		return static::retrieveByColumn('name', $value);
	}


	/**
	 * Casts values of int fields to (int)
	 * @return Category
	 */
	function castInts() {
		$this->id = (null === $this->id) ? null : (int) $this->id;
		$this->userId = (null === $this->userId) ? null : (int) $this->userId;
		return $this;
	}

	/**
	 * @return Category
	 */
	function setUser(User $user = null) {
		return $this->setUserRelatedByUserId($user);
	}

	/**
	 * @return Category
	 */
	function setUserRelatedByUserId(User $user = null) {
		if (null === $user) {
			$this->setuserId(null);
		} else {
			if (!$user->getid()) {
				throw new Exception('Cannot connect a User without a id');
			}
			$this->setuserId($user->getid());
		}
		return $this;
	}

	/**
	 * Returns a user object with a id
	 * that matches $this->userId.
	 * @return User
	 */
	function getUser() {
		return $this->getUserRelatedByUserId();
	}

	/**
	 * Returns a user object with a id
	 * that matches $this->userId.
	 * @return User
	 */
	function getUserRelatedByUserId() {
		$fk_value = $this->getuserId();
		if (null === $fk_value) {
			return null;
		}
		return User::retrieveByPK($fk_value);
	}

	static function doSelectJoinUser(Query $q = null, $join_type = Query::LEFT_JOIN) {
		return static::doSelectJoinUserRelatedByUserId($q, $join_type);
	}

	/**
	 * @return Category[]
	 */
	static function doSelectJoinUserRelatedByUserId(Query $q = null, $join_type = Query::LEFT_JOIN) {
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

		$to_table = User::getTableName();
		$q->join($to_table, $this_table . '.userId = ' . $to_table . '.id', $join_type);
		foreach (User::getColumns() as $column) {
			$columns[] = $column;
		}
		$q->setColumns($columns);

		return static::doSelect($q, array('User'));
	}

	/**
	 * @return Category[]
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

		$to_table = User::getTableName();
		$q->join($to_table, $this_table . '.userId = ' . $to_table . '.id', $join_type);
		foreach (User::getColumns() as $column) {
			$columns[] = $column;
		}
		$classes[] = 'User';
	
		$q->setColumns($columns);
		return static::doSelect($q, $classes);
	}

	/**
	 * Returns a Query for selecting item Objects(rows) from the item table
	 * with a categoryId that matches $this->id.
	 * @return Query
	 */
	function getItemsRelatedByCategoryIdQuery(Query $q = null) {
		return $this->getForeignObjectsQuery('item', 'categoryId', 'id', $q);
	}

	/**
	 * Returns the count of Item Objects(rows) from the item table
	 * with a categoryId that matches $this->id.
	 * @return int
	 */
	function countItemsRelatedByCategoryId(Query $q = null) {
		if (null === $this->getid()) {
			return 0;
		}
		return Item::doCount($this->getItemsRelatedByCategoryIdQuery($q));
	}

	/**
	 * Deletes the item Objects(rows) from the item table
	 * with a categoryId that matches $this->id.
	 * @return int
	 */
	function deleteItemsRelatedByCategoryId(Query $q = null) {
		if (null === $this->getid()) {
			return 0;
		}
		$this->ItemsRelatedByCategoryId_c = array();
		return Item::doDelete($this->getItemsRelatedByCategoryIdQuery($q));
	}

	protected $ItemsRelatedByCategoryId_c = array();

	/**
	 * Returns an array of Item objects with a categoryId
	 * that matches $this->id.
	 * When first called, this method will cache the result.
	 * After that, if $this->id is not modified, the
	 * method will return the cached result instead of querying the database
	 * a second time(for performance purposes).
	 * @return Item[]
	 */
	function getItemsRelatedByCategoryId(Query $q = null) {
		if (null === $this->getid()) {
			return array();
		}

		if (
			null === $q
			&& $this->getCacheResults()
			&& !empty($this->ItemsRelatedByCategoryId_c)
			&& !$this->isColumnModified('id')
		) {
			return $this->ItemsRelatedByCategoryId_c;
		}

		$result = Item::doSelect($this->getItemsRelatedByCategoryIdQuery($q));

		if ($q !== null) {
			return $result;
		}

		if ($this->getCacheResults()) {
			$this->ItemsRelatedByCategoryId_c = $result;
		}
		return $result;
	}

	/**
	 * Convenience function for Category::getItemsRelatedBycategoryId
	 * @return Item[]
	 * @see Category::getItemsRelatedByCategoryId
	 */
	function getItems($extra = null) {
		return $this->getItemsRelatedByCategoryId($extra);
	}

	/**
	  * Convenience function for Category::getItemsRelatedBycategoryIdQuery
	  * @return Query
	  * @see Category::getItemsRelatedBycategoryIdQuery
	  */
	function getItemsQuery(Query $q = null) {
		return $this->getForeignObjectsQuery('item', 'categoryId','id', $q);
	}

	/**
	  * Convenience function for Category::deleteItemsRelatedBycategoryId
	  * @return int
	  * @see Category::deleteItemsRelatedBycategoryId
	  */
	function deleteItems(Query $q = null) {
		return $this->deleteItemsRelatedByCategoryId($q);
	}

	/**
	  * Convenience function for Category::countItemsRelatedBycategoryId
	  * @return int
	  * @see Category::countItemsRelatedByCategoryId
	  */
	function countItems(Query $q = null) {
		return $this->countItemsRelatedByCategoryId($q);
	}

	/**
	 * Returns true if the column values validate.
	 * @return bool
	 */
	function validate() {
		$this->_validationErrors = array();
		if (null === $this->getuserId()) {
			$this->_validationErrors[] = 'userId must not be null';
		}
		if (null === $this->getname()) {
			$this->_validationErrors[] = 'name must not be null';
		}
		return 0 === count($this->_validationErrors);
	}

}