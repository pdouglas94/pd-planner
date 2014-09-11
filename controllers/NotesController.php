<?php

class NotesController extends ApplicationController {

	/**
	 * Returns all Note records matching the query. Examples:
	 * GET /notes?column=value&order_by=column&dir=DESC&limit=20&page=2&count_only
	 * GET /rest/notes.json&limit=5
	 *
	 * @return Note[]
	 */
	function index() {
		$q = Note::getQuery(@$_GET);

		// paginate
		$limit = empty($_REQUEST['limit']) ? 25 : $_REQUEST['limit'];
		$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
		$class = 'Note';
		$method = 'doSelectIterator';
		$this['pager'] = new QueryPager($q, $limit, $page, $class, $method);

		if (isset($_GET['count_only'])) {
			return $this['pager'];
		}
		return $this['notes'] = $this['pager']->fetchPage();
	}

	/**
	 * Form to create or edit a Note. Example:
	 * GET /notes/edit/1
	 *
	 * @return Note
	 */
	function edit($user_id = null) {
		return $this->getNote($user_id)->fromArray(@$_GET);
	}

	/**
	 * Saves a Note. Examples:
	 * POST /notes/save/1
	 * POST /rest/notes/.json
	 * PUT /rest/notes/1.json
	 */
	function save($user_id = null) {
		$note = $this->getNote($user_id);

		try {
			$note->fromArray($_REQUEST);
			if ($note->validate()) {
				$note->save();
				$this->flash['messages'][] = 'Note saved';
				$this->redirect('notes/show/' . $note->getUserId());
			}
			$this->flash['errors'] = $note->getValidationErrors();
		} catch (Exception $e) {
			$this->flash['errors'][] = $e->getMessage();
		}

		$this->redirect('notes/edit/' . $note->getUserId() . '?' . http_build_query($_REQUEST));
	}

	/**
	 * Returns the Note with the user_id. Examples:
	 * GET /notes/show/1
	 * GET /rest/notes/1.json
	 *
	 * @return Note
	 */
	function show($user_id = null) {
		return $this->getNote($user_id);
	}

	/**
	 * Deletes the Note with the user_id. Examples:
	 * GET /notes/delete/1
	 * DELETE /rest/notes/1.json
	 */
	function delete($user_id = null) {
		$note = $this->getNote($user_id);

		try {
			if (null !== $note && $note->delete()) {
				$this['messages'][] = 'Note deleted';
			} else {
				$this['errors'][] = 'Note could not be deleted';
			}
		} catch (Exception $e) {
			$this['errors'][] = $e->getMessage();
		}

		if ($this->outputFormat === 'html') {
			$this->flash['errors'] = @$this['errors'];
			$this->flash['messages'] = @$this['messages'];
			$this->redirect('notes');
		}
	}

	/**
	 * @return Note
	 */
	private function getNote($user_id = null) {
		// look for id in param or in $_REQUEST array
		if (null === $user_id && isset($_REQUEST[Note::getPrimaryKey()])) {
			$user_id = $_REQUEST[Note::getPrimaryKey()];
		}

		if ('' === $user_id || null === $user_id) {
			// if no primary key provided, create new Note
			$this['note'] = new Note;
		} else {
			// if primary key provided, retrieve the record from the db
			$this['note'] = Note::retrieveByPK($user_id);
		}
		return $this['note'];
	}

}