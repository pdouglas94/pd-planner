<?php

abstract class baseItemQuery extends Query {

	function __construct($table_name = null, $alias = null) {
		if (null === $table_name) {
			$table_name = Item::getTableName();
		}
		return parent::__construct($table_name, $alias);
	}

	/**
	 * Returns new instance of self by passing arguments directly to constructor.
	 * @param string $alias
	 * @return ItemQuery
	 */
	static function create($table_name = null, $alias = null) {
		return new ItemQuery($table_name, $alias);
	}

	/**
	 * @return Item[]
	 */
	function select() {
		return Item::doSelect($this);
	}

	/**
	 * @return Item
	 */
	function selectOne() {
		$records = Item::doSelect($this);
		return array_shift($records);
	}

	/**
	 * @return int
	 */
	function delete(){
		return Item::doDelete($this);
	}

	/**
	 * @return int
	 */
	function count(){
		return Item::doCount($this);
	}

	/**
	 * @return ItemQuery
	 */
	function addAnd($column, $value=null, $operator=self::EQUAL, $quote = null, $type = null) {
		if (null !== $type && Item::isTemporalType($type)) {
			$value = Item::coerceTemporalValue($value, $type);
		}
		if (null === $value && is_array($column) && Model::isTemporalType($type)) {
			$column = Item::coerceTemporalValue($column, $type);
		}
		return parent::addAnd($column, $value, $operator, $quote);
	}

	/**
	 * @return ItemQuery
	 */
	function addOr($column, $value=null, $operator=self::EQUAL, $quote = null, $type = null) {
		if (null !== $type && Item::isTemporalType($type)) {
			$value = Item::coerceTemporalValue($value, $type);
		}
		if (null === $value && is_array($column) && Model::isTemporalType($type)) {
			$column = Item::coerceTemporalValue($column, $type);
		}
		return parent::addOr($column, $value, $operator, $quote);
	}

	/**
	 * @return ItemQuery
	 */
	function andId($integer) {
		return $this->addAnd(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdNot($integer) {
		return $this->andNot(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdLike($integer) {
		return $this->andLike(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdNotLike($integer) {
		return $this->andNotLike(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdGreater($integer) {
		return $this->andGreater(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdGreaterEqual($integer) {
		return $this->andGreaterEqual(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdLess($integer) {
		return $this->andLess(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdLessEqual($integer) {
		return $this->andLessEqual(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdNull() {
		return $this->andNull(Item::ID);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdNotNull() {
		return $this->andNotNull(Item::ID);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdBetween($integer, $from, $to) {
		return $this->andBetween(Item::ID, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdBeginsWith($integer) {
		return $this->andBeginsWith(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdEndsWith($integer) {
		return $this->andEndsWith(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andIdContains($integer) {
		return $this->andContains(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orId($integer) {
		return $this->or(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdNot($integer) {
		return $this->orNot(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdLike($integer) {
		return $this->orLike(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdNotLike($integer) {
		return $this->orNotLike(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdGreater($integer) {
		return $this->orGreater(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdGreaterEqual($integer) {
		return $this->orGreaterEqual(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdLess($integer) {
		return $this->orLess(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdLessEqual($integer) {
		return $this->orLessEqual(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdNull() {
		return $this->orNull(Item::ID);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdNotNull() {
		return $this->orNotNull(Item::ID);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdBetween($integer, $from, $to) {
		return $this->orBetween(Item::ID, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdBeginsWith($integer) {
		return $this->orBeginsWith(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdEndsWith($integer) {
		return $this->orEndsWith(Item::ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orIdContains($integer) {
		return $this->orContains(Item::ID, $integer);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByIdAsc() {
		return $this->orderBy(Item::ID, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByIdDesc() {
		return $this->orderBy(Item::ID, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupById() {
		return $this->groupBy(Item::ID);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryId($integer) {
		return $this->addAnd(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdNot($integer) {
		return $this->andNot(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdLike($integer) {
		return $this->andLike(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdNotLike($integer) {
		return $this->andNotLike(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdGreater($integer) {
		return $this->andGreater(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdGreaterEqual($integer) {
		return $this->andGreaterEqual(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdLess($integer) {
		return $this->andLess(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdLessEqual($integer) {
		return $this->andLessEqual(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdNull() {
		return $this->andNull(Item::CATEGORY_ID);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdNotNull() {
		return $this->andNotNull(Item::CATEGORY_ID);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdBetween($integer, $from, $to) {
		return $this->andBetween(Item::CATEGORY_ID, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdBeginsWith($integer) {
		return $this->andBeginsWith(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdEndsWith($integer) {
		return $this->andEndsWith(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andCategoryIdContains($integer) {
		return $this->andContains(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryId($integer) {
		return $this->or(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdNot($integer) {
		return $this->orNot(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdLike($integer) {
		return $this->orLike(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdNotLike($integer) {
		return $this->orNotLike(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdGreater($integer) {
		return $this->orGreater(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdGreaterEqual($integer) {
		return $this->orGreaterEqual(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdLess($integer) {
		return $this->orLess(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdLessEqual($integer) {
		return $this->orLessEqual(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdNull() {
		return $this->orNull(Item::CATEGORY_ID);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdNotNull() {
		return $this->orNotNull(Item::CATEGORY_ID);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdBetween($integer, $from, $to) {
		return $this->orBetween(Item::CATEGORY_ID, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdBeginsWith($integer) {
		return $this->orBeginsWith(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdEndsWith($integer) {
		return $this->orEndsWith(Item::CATEGORY_ID, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orCategoryIdContains($integer) {
		return $this->orContains(Item::CATEGORY_ID, $integer);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByCategoryIdAsc() {
		return $this->orderBy(Item::CATEGORY_ID, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByCategoryIdDesc() {
		return $this->orderBy(Item::CATEGORY_ID, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupByCategoryId() {
		return $this->groupBy(Item::CATEGORY_ID);
	}

	/**
	 * @return ItemQuery
	 */
	function andComplete($tinyint) {
		return $this->addAnd(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteNot($tinyint) {
		return $this->andNot(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteLike($tinyint) {
		return $this->andLike(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteNotLike($tinyint) {
		return $this->andNotLike(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteGreater($tinyint) {
		return $this->andGreater(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteGreaterEqual($tinyint) {
		return $this->andGreaterEqual(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteLess($tinyint) {
		return $this->andLess(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteLessEqual($tinyint) {
		return $this->andLessEqual(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteNull() {
		return $this->andNull(Item::COMPLETE);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteNotNull() {
		return $this->andNotNull(Item::COMPLETE);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteBetween($tinyint, $from, $to) {
		return $this->andBetween(Item::COMPLETE, $tinyint, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteBeginsWith($tinyint) {
		return $this->andBeginsWith(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteEndsWith($tinyint) {
		return $this->andEndsWith(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function andCompleteContains($tinyint) {
		return $this->andContains(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orComplete($tinyint) {
		return $this->or(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteNot($tinyint) {
		return $this->orNot(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteLike($tinyint) {
		return $this->orLike(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteNotLike($tinyint) {
		return $this->orNotLike(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteGreater($tinyint) {
		return $this->orGreater(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteGreaterEqual($tinyint) {
		return $this->orGreaterEqual(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteLess($tinyint) {
		return $this->orLess(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteLessEqual($tinyint) {
		return $this->orLessEqual(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteNull() {
		return $this->orNull(Item::COMPLETE);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteNotNull() {
		return $this->orNotNull(Item::COMPLETE);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteBetween($tinyint, $from, $to) {
		return $this->orBetween(Item::COMPLETE, $tinyint, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteBeginsWith($tinyint) {
		return $this->orBeginsWith(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteEndsWith($tinyint) {
		return $this->orEndsWith(Item::COMPLETE, $tinyint);
	}

	/**
	 * @return ItemQuery
	 */
	function orCompleteContains($tinyint) {
		return $this->orContains(Item::COMPLETE, $tinyint);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByCompleteAsc() {
		return $this->orderBy(Item::COMPLETE, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByCompleteDesc() {
		return $this->orderBy(Item::COMPLETE, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupByComplete() {
		return $this->groupBy(Item::COMPLETE);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescription($longvarchar) {
		return $this->addAnd(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionNot($longvarchar) {
		return $this->andNot(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionLike($longvarchar) {
		return $this->andLike(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionNotLike($longvarchar) {
		return $this->andNotLike(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionGreater($longvarchar) {
		return $this->andGreater(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionGreaterEqual($longvarchar) {
		return $this->andGreaterEqual(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionLess($longvarchar) {
		return $this->andLess(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionLessEqual($longvarchar) {
		return $this->andLessEqual(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionNull() {
		return $this->andNull(Item::DESCRIPTION);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionNotNull() {
		return $this->andNotNull(Item::DESCRIPTION);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionBetween($longvarchar, $from, $to) {
		return $this->andBetween(Item::DESCRIPTION, $longvarchar, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionBeginsWith($longvarchar) {
		return $this->andBeginsWith(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionEndsWith($longvarchar) {
		return $this->andEndsWith(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andDescriptionContains($longvarchar) {
		return $this->andContains(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescription($longvarchar) {
		return $this->or(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionNot($longvarchar) {
		return $this->orNot(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionLike($longvarchar) {
		return $this->orLike(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionNotLike($longvarchar) {
		return $this->orNotLike(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionGreater($longvarchar) {
		return $this->orGreater(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionGreaterEqual($longvarchar) {
		return $this->orGreaterEqual(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionLess($longvarchar) {
		return $this->orLess(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionLessEqual($longvarchar) {
		return $this->orLessEqual(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionNull() {
		return $this->orNull(Item::DESCRIPTION);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionNotNull() {
		return $this->orNotNull(Item::DESCRIPTION);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionBetween($longvarchar, $from, $to) {
		return $this->orBetween(Item::DESCRIPTION, $longvarchar, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionBeginsWith($longvarchar) {
		return $this->orBeginsWith(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionEndsWith($longvarchar) {
		return $this->orEndsWith(Item::DESCRIPTION, $longvarchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orDescriptionContains($longvarchar) {
		return $this->orContains(Item::DESCRIPTION, $longvarchar);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByDescriptionAsc() {
		return $this->orderBy(Item::DESCRIPTION, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByDescriptionDesc() {
		return $this->orderBy(Item::DESCRIPTION, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupByDescription() {
		return $this->groupBy(Item::DESCRIPTION);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriority($integer) {
		return $this->addAnd(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityNot($integer) {
		return $this->andNot(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityLike($integer) {
		return $this->andLike(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityNotLike($integer) {
		return $this->andNotLike(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityGreater($integer) {
		return $this->andGreater(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityGreaterEqual($integer) {
		return $this->andGreaterEqual(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityLess($integer) {
		return $this->andLess(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityLessEqual($integer) {
		return $this->andLessEqual(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityNull() {
		return $this->andNull(Item::PRIORITY);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityNotNull() {
		return $this->andNotNull(Item::PRIORITY);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityBetween($integer, $from, $to) {
		return $this->andBetween(Item::PRIORITY, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityBeginsWith($integer) {
		return $this->andBeginsWith(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityEndsWith($integer) {
		return $this->andEndsWith(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andPriorityContains($integer) {
		return $this->andContains(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriority($integer) {
		return $this->or(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityNot($integer) {
		return $this->orNot(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityLike($integer) {
		return $this->orLike(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityNotLike($integer) {
		return $this->orNotLike(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityGreater($integer) {
		return $this->orGreater(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityGreaterEqual($integer) {
		return $this->orGreaterEqual(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityLess($integer) {
		return $this->orLess(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityLessEqual($integer) {
		return $this->orLessEqual(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityNull() {
		return $this->orNull(Item::PRIORITY);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityNotNull() {
		return $this->orNotNull(Item::PRIORITY);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityBetween($integer, $from, $to) {
		return $this->orBetween(Item::PRIORITY, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityBeginsWith($integer) {
		return $this->orBeginsWith(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityEndsWith($integer) {
		return $this->orEndsWith(Item::PRIORITY, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orPriorityContains($integer) {
		return $this->orContains(Item::PRIORITY, $integer);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByPriorityAsc() {
		return $this->orderBy(Item::PRIORITY, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByPriorityDesc() {
		return $this->orderBy(Item::PRIORITY, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupByPriority() {
		return $this->groupBy(Item::PRIORITY);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgress($integer) {
		return $this->addAnd(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressNot($integer) {
		return $this->andNot(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressLike($integer) {
		return $this->andLike(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressNotLike($integer) {
		return $this->andNotLike(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressGreater($integer) {
		return $this->andGreater(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressGreaterEqual($integer) {
		return $this->andGreaterEqual(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressLess($integer) {
		return $this->andLess(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressLessEqual($integer) {
		return $this->andLessEqual(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressNull() {
		return $this->andNull(Item::PROGRESS);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressNotNull() {
		return $this->andNotNull(Item::PROGRESS);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressBetween($integer, $from, $to) {
		return $this->andBetween(Item::PROGRESS, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressBeginsWith($integer) {
		return $this->andBeginsWith(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressEndsWith($integer) {
		return $this->andEndsWith(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function andProgressContains($integer) {
		return $this->andContains(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgress($integer) {
		return $this->or(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressNot($integer) {
		return $this->orNot(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressLike($integer) {
		return $this->orLike(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressNotLike($integer) {
		return $this->orNotLike(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressGreater($integer) {
		return $this->orGreater(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressGreaterEqual($integer) {
		return $this->orGreaterEqual(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressLess($integer) {
		return $this->orLess(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressLessEqual($integer) {
		return $this->orLessEqual(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressNull() {
		return $this->orNull(Item::PROGRESS);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressNotNull() {
		return $this->orNotNull(Item::PROGRESS);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressBetween($integer, $from, $to) {
		return $this->orBetween(Item::PROGRESS, $integer, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressBeginsWith($integer) {
		return $this->orBeginsWith(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressEndsWith($integer) {
		return $this->orEndsWith(Item::PROGRESS, $integer);
	}

	/**
	 * @return ItemQuery
	 */
	function orProgressContains($integer) {
		return $this->orContains(Item::PROGRESS, $integer);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByProgressAsc() {
		return $this->orderBy(Item::PROGRESS, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByProgressDesc() {
		return $this->orderBy(Item::PROGRESS, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupByProgress() {
		return $this->groupBy(Item::PROGRESS);
	}

	/**
	 * @return ItemQuery
	 */
	function andName($varchar) {
		return $this->addAnd(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameNot($varchar) {
		return $this->andNot(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameLike($varchar) {
		return $this->andLike(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameNotLike($varchar) {
		return $this->andNotLike(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameGreater($varchar) {
		return $this->andGreater(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameGreaterEqual($varchar) {
		return $this->andGreaterEqual(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameLess($varchar) {
		return $this->andLess(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameLessEqual($varchar) {
		return $this->andLessEqual(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameNull() {
		return $this->andNull(Item::NAME);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameNotNull() {
		return $this->andNotNull(Item::NAME);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameBetween($varchar, $from, $to) {
		return $this->andBetween(Item::NAME, $varchar, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameBeginsWith($varchar) {
		return $this->andBeginsWith(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameEndsWith($varchar) {
		return $this->andEndsWith(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function andNameContains($varchar) {
		return $this->andContains(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orName($varchar) {
		return $this->or(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameNot($varchar) {
		return $this->orNot(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameLike($varchar) {
		return $this->orLike(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameNotLike($varchar) {
		return $this->orNotLike(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameGreater($varchar) {
		return $this->orGreater(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameGreaterEqual($varchar) {
		return $this->orGreaterEqual(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameLess($varchar) {
		return $this->orLess(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameLessEqual($varchar) {
		return $this->orLessEqual(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameNull() {
		return $this->orNull(Item::NAME);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameNotNull() {
		return $this->orNotNull(Item::NAME);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameBetween($varchar, $from, $to) {
		return $this->orBetween(Item::NAME, $varchar, $from, $to);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameBeginsWith($varchar) {
		return $this->orBeginsWith(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameEndsWith($varchar) {
		return $this->orEndsWith(Item::NAME, $varchar);
	}

	/**
	 * @return ItemQuery
	 */
	function orNameContains($varchar) {
		return $this->orContains(Item::NAME, $varchar);
	}


	/**
	 * @return ItemQuery
	 */
	function orderByNameAsc() {
		return $this->orderBy(Item::NAME, self::ASC);
	}

	/**
	 * @return ItemQuery
	 */
	function orderByNameDesc() {
		return $this->orderBy(Item::NAME, self::DESC);
	}

	/**
	 * @return ItemQuery
	 */
	function groupByName() {
		return $this->groupBy(Item::NAME);
	}


}