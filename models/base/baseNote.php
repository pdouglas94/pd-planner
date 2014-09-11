<?php
/**
 *		Created by Dan Blaisdell's DABL
 *		Do not alter base files, as they will be overwritten.
 *		To alter the objects, alter the extended classes in
 *		the 'models' folder.
 *
 */
abstract class baseNote extends ApplicationModel {

	const USER_ID = 'note.userId';
	const COMMENT = 'note.comment';
	const UPDATED = 'note.updated';
	const CREATED = 'note.created';

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $_tableName = 'note';

	/**
	 * Cache of objects retrieved from the database
	 * @var Note[]
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
		'userId',
	);

	/**
	 * string name of the primary key column
	 * @var string
	 */
	protected static $_primaryKey = 'userId';

	/**
	 * true if primary key is an auto-increment column
	 * @var bool
	 */
	protected static $_isAutoIncrement = false;

	/**
	 * array of all fully-qualified(table.column) columns
	 * @var string[]
	 */
	protected static $_columns = array(
		Note::USER_ID,
		Note::COMMENT,
		Note::UPDATED,
		Note::CREATED,
	);

	/**
	 * array of all column names
	 * @var string[]
	 */
	protected static $_columnNames = array(
		'userId',
		'comment',
		'updated',
		'created',
	);

	/**
	 * array of all column types
	 * @var string[]
	 */
	protected static $_columnTypes = array(
		'userId' => Model::COLUMN_TYPE_INTEGER,
		'comment' => Model::COLUMN_TYPE_LONGVARCHAR,
		'updated' => Model::COLUMN_TYPE_INTEGER_TIMESTAMP,
		'created' => Model::COLUMN_TYPE_INTEGER_TIMESTAMP,
	);

	/**
	 * `userId` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $userId;

	/**
	 * `comment` LONGVARCHAR
	 * @var string
	 */
	protected $comment;

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
	 * Gets the value of the userId field
	 */
	function getUserId() {
		return $this->userId;
	}

	/**
	 * Sets the value of the userId field
	 * @return Note
	 */
	function setUserId($value) {
		return $this->setColumnValue('userId', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the comment field
	 */
	function getComment() {
		return $this->comment;
	}

	/**
	 * Sets the value of the comment field
	 * @return Note
	 */
	function setComment($value) {
		return $this->setColumnValue('comment', $value, Model::COLUMN_TYPE_LONGVARCHAR);
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
	 * @return Note
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
	 * @return Note
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
	 * @return Note
	 */
	 static function retrieveByPK($user_id) {
		return static::retrieveByPKs($user_id);
	}

	/**
	 * Searches the database for a row with the primary keys that match
	 * the ones input.
	 * @return Note
	 */
	static function retrieveByPKs($user_id) {
		if (null === $user_id) {
			return null;
		}
		if (static::$_poolEnabled) {
			$pool_instance = static::retrieveFromPool($user_id);
			if (null !== $pool_instance) {
				return $pool_instance;
			}
		}
		$q = new Query;
		$q->add('userId', $user_id);
		return static::doSelectOne($q);
	}

	/**
	 * Searches the database for a row with a userId
	 * value that matches the one provided
	 * @return Note
	 */
	static function retrieveByUserId($value) {
		return Note::retrieveByPK($value);
	}

	/**
	 * Searches the database for a row with a comment
	 * value that matches the one provided
	 * @return Note
	 */
	static function retrieveByComment($value) {
		return static::retrieveByColumn('comment', $value);
	}

	/**
	 * Searches the database for a row with a updated
	 * value that matches the one provided
	 * @return Note
	 */
	static function retrieveByUpdated($value) {
		return static::retrieveByColumn('updated', $value);
	}

	/**
	 * Searches the database for a row with a created
	 * value that matches the one provided
	 * @return Note
	 */
	static function retrieveByCreated($value) {
		return static::retrieveByColumn('created', $value);
	}


	/**
	 * Casts values of int fields to (int)
	 * @return Note
	 */
	function castInts() {
		$this->userId = (null === $this->userId) ? null : (int) $this->userId;
		$this->updated = (null === $this->updated) ? null : (int) $this->updated;
		$this->created = (null === $this->created) ? null : (int) $this->created;
		return $this;
	}

	/**
	 * @return Note
	 */
	function setUser(User $user = null) {
		return $this->setUserRelatedByUserId($user);
	}

	/**
	 * @return Note
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
	 * @return Note[]
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
	 * @return Note[]
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
	 * Returns true if the column values validate.
	 * @return bool
	 */
	function validate() {
		$this->_validationErrors = array();
		return 0 === count($this->_validationErrors);
	}

}