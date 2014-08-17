<?php

class CategoriesController extends ApplicationController {

	/**
	 * Returns all Category records matching the query. Examples:
	 * GET /categories?column=value&order_by=column&dir=DESC&limit=20&page=2&count_only
	 * GET /rest/categories.json&limit=5
	 *
	 * @return Category[]
	 */
	function index() {
		$q = Category::getQuery(@$_GET);

		// paginate
		$limit = empty($_REQUEST['limit']) ? 25 : $_REQUEST['limit'];
		$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
		$class = 'Category';
		$method = 'doSelectIterator';
		$this['pager'] = new QueryPager($q, $limit, $page, $class, $method);

		if (isset($_GET['count_only'])) {
			return $this['pager'];
		}
		return $this['categories'] = $this['pager']->fetchPage();
	}

	/**
	 * Form to create or edit a Category. Example:
	 * GET /categories/edit/1
	 *
	 * @return Category
	 */
	function edit($id = null) {
		return $this->getCategory($id)->fromArray(@$_GET);
	}

	/**
	 * Saves a Category. Examples:
	 * POST /categories/save/1
	 * POST /rest/categories/.json
	 * PUT /rest/categories/1.json
	 */
	function save($id = null) {
		$category = $this->getCategory($id);
		
		if ($category->isNew()){
			$category->setUserId($_REQUEST['userId']);
		}
		
		try {
			$category->fromArray($_REQUEST);
			if ($category->validate()) {
				$category->save();
				$this->flash['messages'][] = 'Category saved';
				$this->redirect('categories/show/' . $category->getId());
			}
			$this->flash['errors'] = $category->getValidationErrors();
		} catch (Exception $e) {
			$this->flash['errors'][] = $e->getMessage();
		}

		$this->redirect('categories/edit/' . $category->getId() . '?' . http_build_query($_REQUEST));
	}

	/**
	 * Returns the Category with the id. Examples:
	 * GET /categories/show/1
	 * GET /rest/categories/1.json
	 *
	 * @return Category
	 */
	function show($id = null) {
		return $this->getCategory($id);
	}

	/**
	 * Deletes the Category with the id. Examples:
	 * GET /categories/delete/1
	 * DELETE /rest/categories/1.json
	 */
	function delete($id = null) {
		$category = $this->getCategory($id);

		try {
			if (null !== $category && $category->delete()) {
				$this['messages'][] = 'Category deleted';
			} else {
				$this['errors'][] = 'Category could not be deleted';
			}
		} catch (Exception $e) {
			$this['errors'][] = $e->getMessage();
		}

		if ($this->outputFormat === 'html') {
			$this->flash['errors'] = @$this['errors'];
			$this->flash['messages'] = @$this['messages'];
			$this->redirect('categories');
		}
	}
	
	function getUserData() {
		$reply = array();
		if($_REQUEST['userId']) {
			$user = User::retrieveById($_REQUEST['userId']);
		}
		$categories = $user->getCategorysRelatedByUserId();
		$reply['todos'] = array();
		foreach($categories as $cat) {
			$todos = $cat->getItemsRelatedByCategoryId();
			$reply['todos'][$cat->getId()] = $todos;
		}
		$reply['categories'] = $categories;
		return $reply;
	}

	/**
	 * @return Category
	 */
	private function getCategory($id = null) {
		// look for id in param or in $_REQUEST array
		if (null === $id && isset($_REQUEST[Category::getPrimaryKey()])) {
			$id = $_REQUEST[Category::getPrimaryKey()];
		}

		if ('' === $id || null === $id) {
			// if no primary key provided, create new Category
			$this['category'] = new Category;
		} else {
			// if primary key provided, retrieve the record from the db
			$this['category'] = Category::retrieveByPK($id);
		}
		return $this['category'];
	}

}