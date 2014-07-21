<?php

abstract class baseUserQuery extends Query {

	function __construct($table_name = null, $alias = null) {
		if (null === $table_name) {
			$table_name = User::getTableName();
		}
		return parent::__construct($table_name, $alias);
	}

	/**
	 * Returns new instance of self by passing arguments directly to constructor.
	 * @param string $alias
	 * @return UserQuery
	 */
	static function create($table_name = null, $alias = null) {
		return new UserQuery($table_name, $alias);
	}

	/**
	 * @return User[]
	 */
	function select() {
		return User::doSelect($this);
	}

	/**
	 * @return User
	 */
	function selectOne() {
		$records = User::doSelect($this);
		return array_shift($records);
	}

	/**
	 * @return int
	 */
	function delete(){
		return User::doDelete($this);
	}

	/**
	 * @return int
	 */
	function count(){
		return User::doCount($this);
	}

	/**
	 * @return UserQuery
	 */
	function addAnd($column, $value=null, $operator=self::EQUAL, $quote = null, $type = null) {
		if (null !== $type && User::isTemporalType($type)) {
			$value = User::coerceTemporalValue($value, $type);
		}
		if (null === $value && is_array($column) && Model::isTemporalType($type)) {
			$column = User::coerceTemporalValue($column, $type);
		}
		return parent::addAnd($column, $value, $operator, $quote);
	}

	/**
	 * @return UserQuery
	 */
	function addOr($column, $value=null, $operator=self::EQUAL, $quote = null, $type = null) {
		if (null !== $type && User::isTemporalType($type)) {
			$value = User::coerceTemporalValue($value, $type);
		}
		if (null === $value && is_array($column) && Model::isTemporalType($type)) {
			$column = User::coerceTemporalValue($column, $type);
		}
		return parent::addOr($column, $value, $operator, $quote);
	}

	/**
	 * @return UserQuery
	 */
	function andId($integer) {
		return $this->addAnd(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdNot($integer) {
		return $this->andNot(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdLike($integer) {
		return $this->andLike(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdNotLike($integer) {
		return $this->andNotLike(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdGreater($integer) {
		return $this->andGreater(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdGreaterEqual($integer) {
		return $this->andGreaterEqual(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdLess($integer) {
		return $this->andLess(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdLessEqual($integer) {
		return $this->andLessEqual(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdNull() {
		return $this->andNull(User::ID);
	}

	/**
	 * @return UserQuery
	 */
	function andIdNotNull() {
		return $this->andNotNull(User::ID);
	}

	/**
	 * @return UserQuery
	 */
	function andIdBetween($integer, $from, $to) {
		return $this->andBetween(User::ID, $integer, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andIdBeginsWith($integer) {
		return $this->andBeginsWith(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdEndsWith($integer) {
		return $this->andEndsWith(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andIdContains($integer) {
		return $this->andContains(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orId($integer) {
		return $this->or(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdNot($integer) {
		return $this->orNot(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdLike($integer) {
		return $this->orLike(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdNotLike($integer) {
		return $this->orNotLike(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdGreater($integer) {
		return $this->orGreater(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdGreaterEqual($integer) {
		return $this->orGreaterEqual(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdLess($integer) {
		return $this->orLess(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdLessEqual($integer) {
		return $this->orLessEqual(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdNull() {
		return $this->orNull(User::ID);
	}

	/**
	 * @return UserQuery
	 */
	function orIdNotNull() {
		return $this->orNotNull(User::ID);
	}

	/**
	 * @return UserQuery
	 */
	function orIdBetween($integer, $from, $to) {
		return $this->orBetween(User::ID, $integer, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orIdBeginsWith($integer) {
		return $this->orBeginsWith(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdEndsWith($integer) {
		return $this->orEndsWith(User::ID, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orIdContains($integer) {
		return $this->orContains(User::ID, $integer);
	}


	/**
	 * @return UserQuery
	 */
	function orderByIdAsc() {
		return $this->orderBy(User::ID, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByIdDesc() {
		return $this->orderBy(User::ID, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupById() {
		return $this->groupBy(User::ID);
	}

	/**
	 * @return UserQuery
	 */
	function andType($integer) {
		return $this->addAnd(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeNot($integer) {
		return $this->andNot(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeLike($integer) {
		return $this->andLike(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeNotLike($integer) {
		return $this->andNotLike(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeGreater($integer) {
		return $this->andGreater(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeGreaterEqual($integer) {
		return $this->andGreaterEqual(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeLess($integer) {
		return $this->andLess(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeLessEqual($integer) {
		return $this->andLessEqual(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeNull() {
		return $this->andNull(User::TYPE);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeNotNull() {
		return $this->andNotNull(User::TYPE);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeBetween($integer, $from, $to) {
		return $this->andBetween(User::TYPE, $integer, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeBeginsWith($integer) {
		return $this->andBeginsWith(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeEndsWith($integer) {
		return $this->andEndsWith(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function andTypeContains($integer) {
		return $this->andContains(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orType($integer) {
		return $this->or(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeNot($integer) {
		return $this->orNot(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeLike($integer) {
		return $this->orLike(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeNotLike($integer) {
		return $this->orNotLike(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeGreater($integer) {
		return $this->orGreater(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeGreaterEqual($integer) {
		return $this->orGreaterEqual(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeLess($integer) {
		return $this->orLess(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeLessEqual($integer) {
		return $this->orLessEqual(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeNull() {
		return $this->orNull(User::TYPE);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeNotNull() {
		return $this->orNotNull(User::TYPE);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeBetween($integer, $from, $to) {
		return $this->orBetween(User::TYPE, $integer, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeBeginsWith($integer) {
		return $this->orBeginsWith(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeEndsWith($integer) {
		return $this->orEndsWith(User::TYPE, $integer);
	}

	/**
	 * @return UserQuery
	 */
	function orTypeContains($integer) {
		return $this->orContains(User::TYPE, $integer);
	}


	/**
	 * @return UserQuery
	 */
	function orderByTypeAsc() {
		return $this->orderBy(User::TYPE, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByTypeDesc() {
		return $this->orderBy(User::TYPE, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupByType() {
		return $this->groupBy(User::TYPE);
	}

	/**
	 * @return UserQuery
	 */
	function andUsername($varchar) {
		return $this->addAnd(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameNot($varchar) {
		return $this->andNot(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameLike($varchar) {
		return $this->andLike(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameNotLike($varchar) {
		return $this->andNotLike(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameGreater($varchar) {
		return $this->andGreater(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameGreaterEqual($varchar) {
		return $this->andGreaterEqual(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameLess($varchar) {
		return $this->andLess(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameLessEqual($varchar) {
		return $this->andLessEqual(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameNull() {
		return $this->andNull(User::USERNAME);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameNotNull() {
		return $this->andNotNull(User::USERNAME);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameBetween($varchar, $from, $to) {
		return $this->andBetween(User::USERNAME, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameBeginsWith($varchar) {
		return $this->andBeginsWith(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameEndsWith($varchar) {
		return $this->andEndsWith(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andUsernameContains($varchar) {
		return $this->andContains(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsername($varchar) {
		return $this->or(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameNot($varchar) {
		return $this->orNot(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameLike($varchar) {
		return $this->orLike(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameNotLike($varchar) {
		return $this->orNotLike(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameGreater($varchar) {
		return $this->orGreater(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameGreaterEqual($varchar) {
		return $this->orGreaterEqual(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameLess($varchar) {
		return $this->orLess(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameLessEqual($varchar) {
		return $this->orLessEqual(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameNull() {
		return $this->orNull(User::USERNAME);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameNotNull() {
		return $this->orNotNull(User::USERNAME);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameBetween($varchar, $from, $to) {
		return $this->orBetween(User::USERNAME, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameBeginsWith($varchar) {
		return $this->orBeginsWith(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameEndsWith($varchar) {
		return $this->orEndsWith(User::USERNAME, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orUsernameContains($varchar) {
		return $this->orContains(User::USERNAME, $varchar);
	}


	/**
	 * @return UserQuery
	 */
	function orderByUsernameAsc() {
		return $this->orderBy(User::USERNAME, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByUsernameDesc() {
		return $this->orderBy(User::USERNAME, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupByUsername() {
		return $this->groupBy(User::USERNAME);
	}

	/**
	 * @return UserQuery
	 */
	function andEmail($varchar) {
		return $this->addAnd(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailNot($varchar) {
		return $this->andNot(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailLike($varchar) {
		return $this->andLike(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailNotLike($varchar) {
		return $this->andNotLike(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailGreater($varchar) {
		return $this->andGreater(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailGreaterEqual($varchar) {
		return $this->andGreaterEqual(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailLess($varchar) {
		return $this->andLess(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailLessEqual($varchar) {
		return $this->andLessEqual(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailNull() {
		return $this->andNull(User::EMAIL);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailNotNull() {
		return $this->andNotNull(User::EMAIL);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailBetween($varchar, $from, $to) {
		return $this->andBetween(User::EMAIL, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailBeginsWith($varchar) {
		return $this->andBeginsWith(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailEndsWith($varchar) {
		return $this->andEndsWith(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andEmailContains($varchar) {
		return $this->andContains(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmail($varchar) {
		return $this->or(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailNot($varchar) {
		return $this->orNot(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailLike($varchar) {
		return $this->orLike(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailNotLike($varchar) {
		return $this->orNotLike(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailGreater($varchar) {
		return $this->orGreater(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailGreaterEqual($varchar) {
		return $this->orGreaterEqual(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailLess($varchar) {
		return $this->orLess(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailLessEqual($varchar) {
		return $this->orLessEqual(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailNull() {
		return $this->orNull(User::EMAIL);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailNotNull() {
		return $this->orNotNull(User::EMAIL);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailBetween($varchar, $from, $to) {
		return $this->orBetween(User::EMAIL, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailBeginsWith($varchar) {
		return $this->orBeginsWith(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailEndsWith($varchar) {
		return $this->orEndsWith(User::EMAIL, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orEmailContains($varchar) {
		return $this->orContains(User::EMAIL, $varchar);
	}


	/**
	 * @return UserQuery
	 */
	function orderByEmailAsc() {
		return $this->orderBy(User::EMAIL, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByEmailDesc() {
		return $this->orderBy(User::EMAIL, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupByEmail() {
		return $this->groupBy(User::EMAIL);
	}

	/**
	 * @return UserQuery
	 */
	function andPassword($varchar) {
		return $this->addAnd(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordNot($varchar) {
		return $this->andNot(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordLike($varchar) {
		return $this->andLike(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordNotLike($varchar) {
		return $this->andNotLike(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordGreater($varchar) {
		return $this->andGreater(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordGreaterEqual($varchar) {
		return $this->andGreaterEqual(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordLess($varchar) {
		return $this->andLess(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordLessEqual($varchar) {
		return $this->andLessEqual(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordNull() {
		return $this->andNull(User::PASSWORD);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordNotNull() {
		return $this->andNotNull(User::PASSWORD);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordBetween($varchar, $from, $to) {
		return $this->andBetween(User::PASSWORD, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordBeginsWith($varchar) {
		return $this->andBeginsWith(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordEndsWith($varchar) {
		return $this->andEndsWith(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andPasswordContains($varchar) {
		return $this->andContains(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPassword($varchar) {
		return $this->or(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordNot($varchar) {
		return $this->orNot(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordLike($varchar) {
		return $this->orLike(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordNotLike($varchar) {
		return $this->orNotLike(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordGreater($varchar) {
		return $this->orGreater(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordGreaterEqual($varchar) {
		return $this->orGreaterEqual(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordLess($varchar) {
		return $this->orLess(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordLessEqual($varchar) {
		return $this->orLessEqual(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordNull() {
		return $this->orNull(User::PASSWORD);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordNotNull() {
		return $this->orNotNull(User::PASSWORD);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordBetween($varchar, $from, $to) {
		return $this->orBetween(User::PASSWORD, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordBeginsWith($varchar) {
		return $this->orBeginsWith(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordEndsWith($varchar) {
		return $this->orEndsWith(User::PASSWORD, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orPasswordContains($varchar) {
		return $this->orContains(User::PASSWORD, $varchar);
	}


	/**
	 * @return UserQuery
	 */
	function orderByPasswordAsc() {
		return $this->orderBy(User::PASSWORD, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByPasswordDesc() {
		return $this->orderBy(User::PASSWORD, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupByPassword() {
		return $this->groupBy(User::PASSWORD);
	}

	/**
	 * @return UserQuery
	 */
	function andImage($varchar) {
		return $this->addAnd(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageNot($varchar) {
		return $this->andNot(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageLike($varchar) {
		return $this->andLike(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageNotLike($varchar) {
		return $this->andNotLike(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageGreater($varchar) {
		return $this->andGreater(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageGreaterEqual($varchar) {
		return $this->andGreaterEqual(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageLess($varchar) {
		return $this->andLess(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageLessEqual($varchar) {
		return $this->andLessEqual(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageNull() {
		return $this->andNull(User::IMAGE);
	}

	/**
	 * @return UserQuery
	 */
	function andImageNotNull() {
		return $this->andNotNull(User::IMAGE);
	}

	/**
	 * @return UserQuery
	 */
	function andImageBetween($varchar, $from, $to) {
		return $this->andBetween(User::IMAGE, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andImageBeginsWith($varchar) {
		return $this->andBeginsWith(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageEndsWith($varchar) {
		return $this->andEndsWith(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function andImageContains($varchar) {
		return $this->andContains(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImage($varchar) {
		return $this->or(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageNot($varchar) {
		return $this->orNot(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageLike($varchar) {
		return $this->orLike(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageNotLike($varchar) {
		return $this->orNotLike(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageGreater($varchar) {
		return $this->orGreater(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageGreaterEqual($varchar) {
		return $this->orGreaterEqual(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageLess($varchar) {
		return $this->orLess(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageLessEqual($varchar) {
		return $this->orLessEqual(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageNull() {
		return $this->orNull(User::IMAGE);
	}

	/**
	 * @return UserQuery
	 */
	function orImageNotNull() {
		return $this->orNotNull(User::IMAGE);
	}

	/**
	 * @return UserQuery
	 */
	function orImageBetween($varchar, $from, $to) {
		return $this->orBetween(User::IMAGE, $varchar, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orImageBeginsWith($varchar) {
		return $this->orBeginsWith(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageEndsWith($varchar) {
		return $this->orEndsWith(User::IMAGE, $varchar);
	}

	/**
	 * @return UserQuery
	 */
	function orImageContains($varchar) {
		return $this->orContains(User::IMAGE, $varchar);
	}


	/**
	 * @return UserQuery
	 */
	function orderByImageAsc() {
		return $this->orderBy(User::IMAGE, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByImageDesc() {
		return $this->orderBy(User::IMAGE, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupByImage() {
		return $this->groupBy(User::IMAGE);
	}

	/**
	 * @return UserQuery
	 */
	function andCreated($timestamp) {
		return $this->addAnd(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedNot($timestamp) {
		return $this->andNot(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedLike($timestamp) {
		return $this->andLike(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedNotLike($timestamp) {
		return $this->andNotLike(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedGreater($timestamp) {
		return $this->andGreater(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedGreaterEqual($timestamp) {
		return $this->andGreaterEqual(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedLess($timestamp) {
		return $this->andLess(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedLessEqual($timestamp) {
		return $this->andLessEqual(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedNull() {
		return $this->andNull(User::CREATED);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedNotNull() {
		return $this->andNotNull(User::CREATED);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedBetween($timestamp, $from, $to) {
		return $this->andBetween(User::CREATED, $timestamp, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedBeginsWith($timestamp) {
		return $this->andBeginsWith(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedEndsWith($timestamp) {
		return $this->andEndsWith(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function andCreatedContains($timestamp) {
		return $this->andContains(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreated($timestamp) {
		return $this->or(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedNot($timestamp) {
		return $this->orNot(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedLike($timestamp) {
		return $this->orLike(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedNotLike($timestamp) {
		return $this->orNotLike(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedGreater($timestamp) {
		return $this->orGreater(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedGreaterEqual($timestamp) {
		return $this->orGreaterEqual(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedLess($timestamp) {
		return $this->orLess(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedLessEqual($timestamp) {
		return $this->orLessEqual(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedNull() {
		return $this->orNull(User::CREATED);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedNotNull() {
		return $this->orNotNull(User::CREATED);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedBetween($timestamp, $from, $to) {
		return $this->orBetween(User::CREATED, $timestamp, $from, $to);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedBeginsWith($timestamp) {
		return $this->orBeginsWith(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedEndsWith($timestamp) {
		return $this->orEndsWith(User::CREATED, $timestamp);
	}

	/**
	 * @return UserQuery
	 */
	function orCreatedContains($timestamp) {
		return $this->orContains(User::CREATED, $timestamp);
	}


	/**
	 * @return UserQuery
	 */
	function orderByCreatedAsc() {
		return $this->orderBy(User::CREATED, self::ASC);
	}

	/**
	 * @return UserQuery
	 */
	function orderByCreatedDesc() {
		return $this->orderBy(User::CREATED, self::DESC);
	}

	/**
	 * @return UserQuery
	 */
	function groupByCreated() {
		return $this->groupBy(User::CREATED);
	}


}