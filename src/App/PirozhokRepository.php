<?php
namespace App;

use PDO;

/**
 * Репозиторий для пирожков
 */
class PirozhokRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Получает список пирожков с фильтрацией, сортировкой и пагинацией
     * @param array $filters
     * @return array
     */
    public function getAll(array $filters = []): array
    {
        $query = "SELECT * FROM pirozhki WHERE 1=1";
        $params = [];

        if (!empty($filters['fillings'])) {
            $placeholders = implode(',', array_fill(0, count($filters['fillings']), '?'));
            $query .= " AND filling IN ($placeholders)";
            $params = array_merge($params, $filters['fillings']);
        }

        if (!empty($filters['dough'])) {
            $query .= " AND dough = ?";
            $params[] = $filters['dough'];
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'price') {
                $query .= " ORDER BY price ASC";
            } elseif ($filters['sort'] === 'time') {
                $query .= " ORDER BY prep_time ASC";
            }
        }

        $limit = (int)($filters['limit'] ?? 9999);
        $offset = (int)($filters['offset'] ?? 0);

        $query .= " LIMIT $limit OFFSET $offset";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Добавляет новый пирожок
     * @param array $data
     * @return bool
     */
    public function add(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO pirozhki (price, filling, prep_time, dough) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['price'],
            $data['filling'],
            $data['prep_time'],
            $data['dough']
        ]);
    }
}