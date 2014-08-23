<?php

class SubitemsController extends ApplicationController {

	/**
	 * Returns all Subitem records matching the query. Examples:
	 * GET /subitems?column=value&order_by=column&dir=DESC&limit=20&page=2&count_only
	 * GET /rest/subitems.json&limit=5
	 *
	 * @return Subitem[]
	 */
	function index() {
		$q = Subitem::getQuery(@$_GET);

		// paginate
		$limit = empty($_REQUEST['limit']) ? 25 : $_REQUEST['limit'];
		$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
		$class = 'Subitem';
		$method = 'doSelectIterator';
		$this['pager'] = new QueryPager($q, $limit, $page, $class, $method);

		if (isset($_GET['count_only'])) {
			return $this['pager'];
		}
		return $this['subitems'] = $this['pager']->fetchPage();
	}

	/**
	 * Form to create or edit a Subitem. Example:
	 * GET /subitems/edit/1
	 *
	 * @return Subitem
	 */
	function edit($id = null) {
		return $this->getSubitem($id)->fromArray(@$_GET);
	}

	/**
	 * Saves a Subitem. Examples:
	 * POST /subitems/save/1
	 * POST /rest/subitems/.json
	 * PUT /rest/subitems/1.json
	 */
	function save($id = null) {
		$subitem = $this->getSubitem($id);

		try {
			$subitem->fromArray($_REQUEST);
			if ($subitem->validate()) {
				$subitem->save();
				$this->flash['messages'][] = 'Subitem saved';
				$this->redirect('subitems/show/' . $subitem->getId());
			}
			$this->flash['errors'] = $subitem->getValidationErrors();
		} catch (Exception $e) {
			$this->flash['errors'][] = $e->getMessage();
		}

		$this->redirect('subitems/edit/' . $subitem->getId() . '?' . http_build_query($_REQUEST));
	}

	/**
	 * Returns the Subitem with the id. Examples:
	 * GET /subitems/show/1
	 * GET /rest/subitems/1.json
	 *
	 * @return Subitem
	 */
	function show($id = null) {
		return $this->getSubitem($id);
	}

	/**
	 * Deletes the Subitem with the id. Examples:
	 * GET /subitems/delete/1
	 * DELETE /rest/subitems/1.json
	 */
	function delete($id = null) {
		$subitem = $this->getSubitem($id);

		try {
			if (null !== $subitem && $subitem->delete()) {
				$this['messages'][] = 'Subitem deleted';
			} else {
				$this['errors'][] = 'Subitem could not be deleted';
			}
		} catch (Exception $e) {
			$this['errors'][] = $e->getMessage();
		}

		if ($this->outputFormat === 'html') {
			$this->flash['errors'] = @$this['errors'];
			$this->flash['messages'] = @$this['messages'];
			$this->redirect('subitems');
		}
	}

	/**
	 * @return Subitem
	 */
	private function getSubitem($id = null) {
		// look for id in param or in $_REQUEST array
		if (null === $id && isset($_REQUEST[Subitem::getPrimaryKey()])) {
			$id = $_REQUEST[Subitem::getPrimaryKey()];
		}

		if ('' === $id || null === $id) {
			// if no primary key provided, create new Subitem
			$this['subitem'] = new Subitem;
		} else {
			// if primary key provided, retrieve the record from the db
			$this['subitem'] = Subitem::retrieveByPK($id);
		}
		return $this['subitem'];
	}

}