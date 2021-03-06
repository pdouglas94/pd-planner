<?php
/**
 *		Created by Dan Blaisdell's DABL
 *		Do not alter base files, as they will be overwritten.
 *		To alter the objects, alter the extended classes in
 *		the 'models' folder.
 *
 */
abstract class baseUser extends ApplicationModel {

	const ID = 'user.id';
	const TYPE = 'user.type';
	const USERNAME = 'user.username';
	const EMAIL = 'user.email';
	const PASSWORD = 'user.password';
	const IMAGE = 'user.image';
	const UPDATED = 'user.updated';
	const CREATED = 'user.created';

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $_tableName = 'user';

	/**
	 * Cache of objects retrieved from the database
	 * @var User[]
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
		User::ID,
		User::TYPE,
		User::USERNAME,
		User::EMAIL,
		User::PASSWORD,
		User::IMAGE,
		User::UPDATED,
		User::CREATED,
	);

	/**
	 * array of all column names
	 * @var string[]
	 */
	protected static $_columnNames = array(
		'id',
		'type',
		'username',
		'email',
		'password',
		'image',
		'updated',
		'created',
	);

	/**
	 * array of all column types
	 * @var string[]
	 */
	protected static $_columnTypes = array(
		'id' => Model::COLUMN_TYPE_INTEGER,
		'type' => Model::COLUMN_TYPE_INTEGER,
		'username' => Model::COLUMN_TYPE_VARCHAR,
		'email' => Model::COLUMN_TYPE_VARCHAR,
		'password' => Model::COLUMN_TYPE_VARCHAR,
		'image' => Model::COLUMN_TYPE_VARCHAR,
		'updated' => Model::COLUMN_TYPE_INTEGER_TIMESTAMP,
		'created' => Model::COLUMN_TYPE_INTEGER_TIMESTAMP,
	);

	/**
	 * `id` INTEGER NOT NULL DEFAULT ''
	 * @var int
	 */
	protected $id;

	/**
	 * `type` INTEGER DEFAULT 1
	 * @var int
	 */
	protected $type = 1;

	/**
	 * `username` VARCHAR NOT NULL
	 * @var string
	 */
	protected $username;

	/**
	 * `email` VARCHAR
	 * @var string
	 */
	protected $email;

	/**
	 * `password` VARCHAR NOT NULL
	 * @var string
	 */
	protected $password;

	/**
	 * `image` VARCHAR
	 * @var string
	 */
	protected $image;

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
	 * @return User
	 */
	function setId($value) {
		return $this->setColumnValue('id', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the type field
	 */
	function getType() {
		return $this->type;
	}

	/**
	 * Sets the value of the type field
	 * @return User
	 */
	function setType($value) {
		return $this->setColumnValue('type', $value, Model::COLUMN_TYPE_INTEGER);
	}

	/**
	 * Gets the value of the username field
	 */
	function getUsername() {
		return $this->username;
	}

	/**
	 * Sets the value of the username field
	 * @return User
	 */
	function setUsername($value) {
		return $this->setColumnValue('username', $value, Model::COLUMN_TYPE_VARCHAR);
	}

	/**
	 * Gets the value of the email field
	 */
	function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the value of the email field
	 * @return User
	 */
	function setEmail($value) {
		return $this->setColumnValue('email', $value, Model::COLUMN_TYPE_VARCHAR);
	}

	/**
	 * Gets the value of the password field
	 */
	function getPassword() {
		return $this->password;
	}

	/**
	 * Sets the value of the password field
	 * @return User
	 */
	function setPassword($value) {
		return $this->setColumnValue('password', $value, Model::COLUMN_TYPE_VARCHAR);
	}

	/**
	 * Gets the value of the image field
	 */
	function getImage() {
		return $this->image;
	}

	/**
	 * Sets the value of the image field
	 * @return User
	 */
	function setImage($value) {
		return $this->setColumnValue('image', $value, Model::COLUMN_TYPE_VARCHAR);
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
	 * @return User
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
	 * @return User
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
	 * @return User
	 */
	 static function retrieveByPK($id) {
		return static::retrieveByPKs($id);
	}

	/**
	 * Searches the database for a row with the primary keys that match
	 * the ones input.
	 * @return User
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
	 * @return User
	 */
	static function retrieveById($value) {
		return User::retrieveByPK($value);
	}

	/**
	 * Searches the database for a row with a type
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByType($value) {
		return static::retrieveByColumn('type', $value);
	}

	/**
	 * Searches the database for a row with a username
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByUsername($value) {
		return static::retrieveByColumn('username', $value);
	}

	/**
	 * Searches the database for a row with a email
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByEmail($value) {
		return static::retrieveByColumn('email', $value);
	}

	/**
	 * Searches the database for a row with a password
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByPassword($value) {
		return static::retrieveByColumn('password', $value);
	}

	/**
	 * Searches the database for a row with a image
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByImage($value) {
		return static::retrieveByColumn('image', $value);
	}

	/**
	 * Searches the database for a row with a updated
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByUpdated($value) {
		return static::retrieveByColumn('updated', $value);
	}

	/**
	 * Searches the database for a row with a created
	 * value that matches the one provided
	 * @return User
	 */
	static function retrieveByCreated($value) {
		return static::retrieveByColumn('created', $value);
	}


	/**
	 * Casts values of int fields to (int)
	 * @return User
	 */
	function castInts() {
		$this->id = (null === $this->id) ? null : (int) $this->id;
		$this->type = (null === $this->type) ? null : (int) $this->type;
		$this->updated = (null === $this->updated) ? null : (int) $this->updated;
		$this->created = (null === $this->created) ? null : (int) $this->created;
		return $this;
	}

	/**
	 * @return User[]
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

		$q->setColumns($columns);
		return static::doSelect($q, $classes);
	}

	/**
	 * Returns a Query for selecting category Objects(rows) from the category table
	 * with a userId that matches $this->id.
	 * @return Query
	 */
	function getCategorysRelatedByUserIdQuery(Query $q = null) {
		return $this->getForeignObjectsQuery('category', 'userId', 'id', $q);
	}

	/**
	 * Returns the count of Category Objects(rows) from the category table
	 * with a userId that matches $this->id.
	 * @return int
	 */
	function countCategorysRelatedByUserId(Query $q = null) {
		if (null === $this->getid()) {
			return 0;
		}
		return Category::doCount($this->getCategorysRelatedByUserIdQuery($q));
	}

	/**
	 * Deletes the category Objects(rows) from the category table
	 * with a userId that matches $this->id.
	 * @return int
	 */
	function deleteCategorysRelatedByUserId(Query $q = null) {
		if (null === $this->getid()) {
			return 0;
		}
		$this->CategorysRelatedByUserId_c = array();
		return Category::doDelete($this->getCategorysRelatedByUserIdQuery($q));
	}

	protected $CategorysRelatedByUserId_c = array();

	/**
	 * Returns an array of Category objects with a userId
	 * that matches $this->id.
	 * When first called, this method will cache the result.
	 * After that, if $this->id is not modified, the
	 * method will return the cached result instead of querying the database
	 * a second time(for performance purposes).
	 * @return Category[]
	 */
	function getCategorysRelatedByUserId(Query $q = null) {
		if (null === $this->getid()) {
			return array();
		}

		if (
			null === $q
			&& $this->getCacheResults()
			&& !empty($this->CategorysRelatedByUserId_c)
			&& !$this->isColumnModified('id')
		) {
			return $this->CategorysRelatedByUserId_c;
		}

		$result = Category::doSelect($this->getCategorysRelatedByUserIdQuery($q));

		if ($q !== null) {
			return $result;
		}

		if ($this->getCacheResults()) {
			$this->CategorysRelatedByUserId_c = $result;
		}
		return $result;
	}

	/**
	 * Returns a Query for selecting note Objects(rows) from the note table
	 * with a userId that matches $this->id.
	 * @return Query
	 */
	function getNotesRelatedByUserIdQuery(Query $q = null) {
		return $this->getForeignObjectsQuery('note', 'userId', 'id', $q);
	}

	/**
	 * Returns the count of Note Objects(rows) from the note table
	 * with a userId that matches $this->id.
	 * @return int
	 */
	function countNotesRelatedByUserId(Query $q = null) {
		if (null === $this->getid()) {
			return 0;
		}
		return Note::doCount($this->getNotesRelatedByUserIdQuery($q));
	}

	/**
	 * Deletes the note Objects(rows) from the note table
	 * with a userId that matches $this->id.
	 * @return int
	 */
	function deleteNotesRelatedByUserId(Query $q = null) {
		if (null === $this->getid()) {
			return 0;
		}
		$this->NotesRelatedByUserId_c = array();
		return Note::doDelete($this->getNotesRelatedByUserIdQuery($q));
	}

	protected $NotesRelatedByUserId_c = array();

	/**
	 * Returns an array of Note objects with a userId
	 * that matches $this->id.
	 * When first called, this method will cache the result.
	 * After that, if $this->id is not modified, the
	 * method will return the cached result instead of querying the database
	 * a second time(for performance purposes).
	 * @return Note[]
	 */
	function getNotesRelatedByUserId(Query $q = null) {
		if (null === $this->getid()) {
			return array();
		}

		if (
			null === $q
			&& $this->getCacheResults()
			&& !empty($this->NotesRelatedByUserId_c)
			&& !$this->isColumnModified('id')
		) {
			return $this->NotesRelatedByUserId_c;
		}

		$result = Note::doSelect($this->getNotesRelatedByUserIdQuery($q));

		if ($q !== null) {
			return $result;
		}

		if ($this->getCacheResults()) {
			$this->NotesRelatedByUserId_c = $result;
		}
		return $result;
	}

	/**
	 * Convenience function for User::getCategorysRelatedByuserId
	 * @return Category[]
	 * @see User::getCategorysRelatedByUserId
	 */
	function getCategorys($extra = null) {
		return $this->getCategorysRelatedByUserId($extra);
	}

	/**
	  * Convenience function for User::getCategorysRelatedByuserIdQuery
	  * @return Query
	  * @see User::getCategorysRelatedByuserIdQuery
	  */
	function getCategorysQuery(Query $q = null) {
		return $this->getForeignObjectsQuery('category', 'userId','id', $q);
	}

	/**
	  * Convenience function for User::deleteCategorysRelatedByuserId
	  * @return int
	  * @see User::deleteCategorysRelatedByuserId
	  */
	function deleteCategorys(Query $q = null) {
		return $this->deleteCategorysRelatedByUserId($q);
	}

	/**
	  * Convenience function for User::countCategorysRelatedByuserId
	  * @return int
	  * @see User::countCategorysRelatedByUserId
	  */
	function countCategorys(Query $q = null) {
		return $this->countCategorysRelatedByUserId($q);
	}

	/**
	 * Convenience function for User::getNotesRelatedByuserId
	 * @return Note[]
	 * @see User::getNotesRelatedByUserId
	 */
	function getNotes($extra = null) {
		return $this->getNotesRelatedByUserId($extra);
	}

	/**
	  * Convenience function for User::getNotesRelatedByuserIdQuery
	  * @return Query
	  * @see User::getNotesRelatedByuserIdQuery
	  */
	function getNotesQuery(Query $q = null) {
		return $this->getForeignObjectsQuery('note', 'userId','id', $q);
	}

	/**
	  * Convenience function for User::deleteNotesRelatedByuserId
	  * @return int
	  * @see User::deleteNotesRelatedByuserId
	  */
	function deleteNotes(Query $q = null) {
		return $this->deleteNotesRelatedByUserId($q);
	}

	/**
	  * Convenience function for User::countNotesRelatedByuserId
	  * @return int
	  * @see User::countNotesRelatedByUserId
	  */
	function countNotes(Query $q = null) {
		return $this->countNotesRelatedByUserId($q);
	}

	/**
	 * Returns true if the column values validate.
	 * @return bool
	 */
	function validate() {
		$this->_validationErrors = array();
		if (null === $this->getusername()) {
			$this->_validationErrors[] = 'username must not be null';
		}
		if (null === $this->getpassword()) {
			$this->_validationErrors[] = 'password must not be null';
		}
		return 0 === count($this->_validationErrors);
	}

}