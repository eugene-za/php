<?php

namespace app\model;

class Task extends \core\Model
{

	/**
	 * Write new task
	 * @param array $data
	 * @return string
	 */
	function create($data)
	{
		$sql = 'INSERT INTO `tasks` (`name`, `email`, `text`) VALUES (:name, :email, :text)';
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute($data);

		return $result ? $this->db->lastInsertId() : 'Database error';
	}

	/**
	 * Get tasks list
	 * @param int|string $limit
	 * @param int|string $offset
	 * @param string $order_by
	 * @return array
	 */
	function get($limit, $offset, $order)
	{
		$sql = "SELECT `id`, `name`, `email`, `text`, `status`, `edited_by_admin`
				FROM `tasks`
				ORDER BY {$order['by']} {$order['direction']}
				LIMIT :limit OFFSET :offset";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
		$stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get total count of tasks
	 * @return string
	 */
	public function get_count()
	{
		$sql = 'SELECT count(*) AS `count` FROM `tasks`';

		return $this->db->query($sql)->fetch()['count'];
	}

	/**
	 * Get single task
	 * @param int|string $id
	 * @return mixed
	 */
	public function get_task($id)
	{
		$sql = "SELECT `id`, `name`, `email`, `text`, `status`
				FROM `tasks`
				WHERE `id` = :id";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Update task text
	 * @param int|string $id
	 * @param string $text
	 * @return int|string
	 */
	public function update_text($id, $text)
	{
		$sql = 'UPDATE `tasks` SET `text` = :text, `edited_by_admin` = 1 WHERE `id` = :id';
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':text', $text, \PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
		$result = $stmt->execute();

		return $result ? $stmt->rowCount() : 'Database error';
	}

	/**
	 * Update task status
	 * @param int|string $id
	 * @param  int|string$status
	 * @return int|string
	 */
	public function update_status($id, $status)
	{
		$sql = 'UPDATE `tasks` SET `status` = :status WHERE `id` = :id';
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':status', $status, \PDO::PARAM_INT);
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
		$result = $stmt->execute();

		return $result ? $stmt->rowCount() : 'Database error';
	}

}
