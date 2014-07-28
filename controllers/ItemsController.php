<?php

class ItemsController extends ApplicationController {

	/**
	 * Returns all Item records matching the query. Examples:
	 * GET /items?column=value&order_by=column&dir=DESC&limit=20&page=2&count_only
	 * GET /rest/items.json&limit=5
	 *
	 * @return Item[]
	 */
	function index() {
		$q = Item::getQuery(@$_GET);

		// paginate
		$limit = empty($_REQUEST['limit']) ? 25 : $_REQUEST['limit'];
		$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
		$class = 'Item';
		$method = 'doSelectIterator';
		$this['pager'] = new QueryPager($q, $limit, $page, $class, $method);

		if (isset($_GET['count_only'])) {
			return $this['pager'];
		}
		return $this['items'] = $this['pager']->fetchPage();
	}

	/**
	 * Form to create or edit a Item. Example:
	 * GET /items/edit/1
	 *
	 * @return Item
	 */
	function edit($id = null) {
		return $this->getItem($id)->fromArray(@$_GET);
	}

	/**
	 * Saves a Item. Examples:
	 * POST /items/save/1
	 * POST /rest/items/.json
	 * PUT /rest/items/1.json
	 */
	function save($id = null) {
		$item = $this->getItem($id);
		
		if ($item->isNew()) {
			$item->setCategoryId($_REQUEST['category_id']);
		}

		try {
			$item->fromArray($_REQUEST);
			if ($item->validate()) {
				$item->save();
				$this->flash['messages'][] = 'Item saved';
				$this->redirect('items/show/' . $item->getId());
			}
			$this->flash['errors'] = $item->getValidationErrors();
		} catch (Exception $e) {
			$this->flash['errors'][] = $e->getMessage();
		}

		$this->redirect('items/edit/' . $item->getId() . '?' . http_build_query($_REQUEST));
	}

	/**
	 * Returns the Item with the id. Examples:
	 * GET /items/show/1
	 * GET /rest/items/1.json
	 *
	 * @return Item
	 */
	function show($id = null) {
		return $this->getItem($id);
	}

	/**
	 * Deletes the Item with the id. Examples:
	 * GET /items/delete/1
	 * DELETE /rest/items/1.json
	 */
	function delete($id = null) {
		$item = $this->getItem($id);

		try {
			if (null !== $item && $item->delete()) {
				$this['messages'][] = 'Item deleted';
			} else {
				$this['errors'][] = 'Item could not be deleted';
			}
		} catch (Exception $e) {
			$this['errors'][] = $e->getMessage();
		}

		if ($this->outputFormat === 'html') {
			$this->flash['errors'] = @$this['errors'];
			$this->flash['messages'] = @$this['messages'];
			$this->redirect('items');
		}
	}

	/**
	 * @return Item
	 */
	private function getItem($id = null) {
		// look for id in param or in $_REQUEST array
		if (null === $id && isset($_REQUEST[Item::getPrimaryKey()])) {
			$id = $_REQUEST[Item::getPrimaryKey()];
		}

		if ('' === $id || null === $id) {
			// if no primary key provided, create new Item
			$this['item'] = new Item;
		} else {
			// if primary key provided, retrieve the record from the db
			$this['item'] = Item::retrieveByPK($id);
		}
		return $this['item'];
	}

}