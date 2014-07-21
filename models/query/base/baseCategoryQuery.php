<?php

abstract class baseCategoryQuery extends Query {

	function __construct($table_name = null, $alias = null) {
		if (null === $table_name) {
			$table_name = Category::getTableName();
		}
		return parent::__construct($table_name, $alias);
	}

	/**
	 * Returns new instance of self by passing arguments directly to constructor.
	 * @param string $alias
	 * @return CategoryQuery
	 */
	static function create($table_name = null, $alias = null) {
		return new CategoryQuery($table_name, $alias);
	}

	/**
	 * @return Category[]
	 */
	function select() {
		return Category::doSelect($this);
	}

	/**
	 * @return Category
	 */
	function selectOne() {
		$records = Category::doSelect($this);
		return array_shift($records);
	}

	/**
	 * @return int
	 */
	function delete(){
		return Category::doDelete($this);
	}

	/**
	 * @return int
	 */
	function count(){
		return Category::doCount($this);
	}

	/**
	 * @return CategoryQuery
	 */
	function addAnd($column, $value=null, $operator=self::EQUAL, $quote = null, $type = null) {
		if (null !== $type && Category::isTemporalType($type)) {
			$value = Category::coerceTemporalValue($value, $type);
		}
		if (null === $value && is_array($column) && Model::isTemporalType($type)) {
			$column = Category::coerceTemporalValue($column, $type);
		}
		return parent::addAnd($column, $value, $operator, $quote);
	}

	/**
	 * @return CategoryQuery
	 */
	function addOr($column, $value=null, $operator=self::EQUAL, $quote = null, $type = null) {
		if (null !== $type && Category::isTemporalType($type)) {
			$value = Category::coerceTemporalValue($value, $type);
		}
		if (null === $value && is_array($column) && Model::isTemporalType($type)) {
			$column = Category::coerceTemporalValue($column, $type);
		}
		return parent::addOr($column, $value, $operator, $quote);
	}

	/**
	 * @return CategoryQuery
	 */
	function andId($integer) {
		return $this->addAnd(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdNot($integer) {
		return $this->andNot(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdLike($integer) {
		return $this->andLike(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdNotLike($integer) {
		return $this->andNotLike(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdGreater($integer) {
		return $this->andGreater(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdGreaterEqual($integer) {
		return $this->andGreaterEqual(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdLess($integer) {
		return $this->andLess(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdLessEqual($integer) {
		return $this->andLessEqual(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdNull() {
		return $this->andNull(Category::ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdNotNull() {
		return $this->andNotNull(Category::ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdBetween($integer, $from, $to) {
		return $this->andBetween(Category::ID, $integer, $from, $to);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdBeginsWith($integer) {
		return $this->andBeginsWith(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdEndsWith($integer) {
		return $this->andEndsWith(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andIdContains($integer) {
		return $this->andContains(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orId($integer) {
		return $this->or(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdNot($integer) {
		return $this->orNot(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdLike($integer) {
		return $this->orLike(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdNotLike($integer) {
		return $this->orNotLike(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdGreater($integer) {
		return $this->orGreater(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdGreaterEqual($integer) {
		return $this->orGreaterEqual(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdLess($integer) {
		return $this->orLess(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdLessEqual($integer) {
		return $this->orLessEqual(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdNull() {
		return $this->orNull(Category::ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdNotNull() {
		return $this->orNotNull(Category::ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdBetween($integer, $from, $to) {
		return $this->orBetween(Category::ID, $integer, $from, $to);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdBeginsWith($integer) {
		return $this->orBeginsWith(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdEndsWith($integer) {
		return $this->orEndsWith(Category::ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orIdContains($integer) {
		return $this->orContains(Category::ID, $integer);
	}


	/**
	 * @return CategoryQuery
	 */
	function orderByIdAsc() {
		return $this->orderBy(Category::ID, self::ASC);
	}

	/**
	 * @return CategoryQuery
	 */
	function orderByIdDesc() {
		return $this->orderBy(Category::ID, self::DESC);
	}

	/**
	 * @return CategoryQuery
	 */
	function groupById() {
		return $this->groupBy(Category::ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserId($integer) {
		return $this->addAnd(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdNot($integer) {
		return $this->andNot(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdLike($integer) {
		return $this->andLike(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdNotLike($integer) {
		return $this->andNotLike(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdGreater($integer) {
		return $this->andGreater(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdGreaterEqual($integer) {
		return $this->andGreaterEqual(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdLess($integer) {
		return $this->andLess(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdLessEqual($integer) {
		return $this->andLessEqual(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdNull() {
		return $this->andNull(Category::USER_ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdNotNull() {
		return $this->andNotNull(Category::USER_ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdBetween($integer, $from, $to) {
		return $this->andBetween(Category::USER_ID, $integer, $from, $to);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdBeginsWith($integer) {
		return $this->andBeginsWith(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdEndsWith($integer) {
		return $this->andEndsWith(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function andUserIdContains($integer) {
		return $this->andContains(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserId($integer) {
		return $this->or(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdNot($integer) {
		return $this->orNot(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdLike($integer) {
		return $this->orLike(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdNotLike($integer) {
		return $this->orNotLike(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdGreater($integer) {
		return $this->orGreater(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdGreaterEqual($integer) {
		return $this->orGreaterEqual(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdLess($integer) {
		return $this->orLess(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdLessEqual($integer) {
		return $this->orLessEqual(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdNull() {
		return $this->orNull(Category::USER_ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdNotNull() {
		return $this->orNotNull(Category::USER_ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdBetween($integer, $from, $to) {
		return $this->orBetween(Category::USER_ID, $integer, $from, $to);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdBeginsWith($integer) {
		return $this->orBeginsWith(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdEndsWith($integer) {
		return $this->orEndsWith(Category::USER_ID, $integer);
	}

	/**
	 * @return CategoryQuery
	 */
	function orUserIdContains($integer) {
		return $this->orContains(Category::USER_ID, $integer);
	}


	/**
	 * @return CategoryQuery
	 */
	function orderByUserIdAsc() {
		return $this->orderBy(Category::USER_ID, self::ASC);
	}

	/**
	 * @return CategoryQuery
	 */
	function orderByUserIdDesc() {
		return $this->orderBy(Category::USER_ID, self::DESC);
	}

	/**
	 * @return CategoryQuery
	 */
	function groupByUserId() {
		return $this->groupBy(Category::USER_ID);
	}

	/**
	 * @return CategoryQuery
	 */
	function andName($varchar) {
		return $this->addAnd(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameNot($varchar) {
		return $this->andNot(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameLike($varchar) {
		return $this->andLike(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameNotLike($varchar) {
		return $this->andNotLike(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameGreater($varchar) {
		return $this->andGreater(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameGreaterEqual($varchar) {
		return $this->andGreaterEqual(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameLess($varchar) {
		return $this->andLess(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameLessEqual($varchar) {
		return $this->andLessEqual(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameNull() {
		return $this->andNull(Category::NAME);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameNotNull() {
		return $this->andNotNull(Category::NAME);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameBetween($varchar, $from, $to) {
		return $this->andBetween(Category::NAME, $varchar, $from, $to);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameBeginsWith($varchar) {
		return $this->andBeginsWith(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameEndsWith($varchar) {
		return $this->andEndsWith(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function andNameContains($varchar) {
		return $this->andContains(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orName($varchar) {
		return $this->or(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameNot($varchar) {
		return $this->orNot(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameLike($varchar) {
		return $this->orLike(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameNotLike($varchar) {
		return $this->orNotLike(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameGreater($varchar) {
		return $this->orGreater(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameGreaterEqual($varchar) {
		return $this->orGreaterEqual(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameLess($varchar) {
		return $this->orLess(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameLessEqual($varchar) {
		return $this->orLessEqual(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameNull() {
		return $this->orNull(Category::NAME);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameNotNull() {
		return $this->orNotNull(Category::NAME);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameBetween($varchar, $from, $to) {
		return $this->orBetween(Category::NAME, $varchar, $from, $to);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameBeginsWith($varchar) {
		return $this->orBeginsWith(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameEndsWith($varchar) {
		return $this->orEndsWith(Category::NAME, $varchar);
	}

	/**
	 * @return CategoryQuery
	 */
	function orNameContains($varchar) {
		return $this->orContains(Category::NAME, $varchar);
	}


	/**
	 * @return CategoryQuery
	 */
	function orderByNameAsc() {
		return $this->orderBy(Category::NAME, self::ASC);
	}

	/**
	 * @return CategoryQuery
	 */
	function orderByNameDesc() {
		return $this->orderBy(Category::NAME, self::DESC);
	}

	/**
	 * @return CategoryQuery
	 */
	function groupByName() {
		return $this->groupBy(Category::NAME);
	}


}