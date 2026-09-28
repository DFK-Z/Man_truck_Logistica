import { Router } from 'express';
import pool from '../db.js';
import { requireAuth, requireAdmin } from '../middleware/auth.js';

const router = Router();

// ─── GET /api/reviews — public paginated list (approved only) ─────────────
router.get('/', async (req, res) => {
  const page  = Math.max(1, parseInt(req.query.page  || '1',  10));
  const limit = Math.min(50, Math.max(1, parseInt(req.query.limit || '12', 10)));
  const offset = (page - 1) * limit;

  try {
    const [rows, count] = await Promise.all([
      pool.query(
        `SELECT r.id, r.message, r.rating, r.is_approved, r.created_at,
                u.id AS user_id, u.name AS user_name
         FROM reviews r
         JOIN users u ON u.id = r.user_id
         WHERE r.is_approved = TRUE
         ORDER BY r.created_at DESC
         LIMIT $1 OFFSET $2`,
        [limit, offset]
      ),
      pool.query(
        'SELECT COUNT(*) FROM reviews WHERE is_approved = TRUE'
      ),
    ]);

    return res.json({
      data:        rows.rows,
      total:       parseInt(count.rows[0].count, 10),
      page,
      limit,
      total_pages: Math.ceil(parseInt(count.rows[0].count, 10) / limit),
    });
  } catch (err) {
    console.error('reviews list error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── GET /api/reviews/latest — public, 3 most recent approved ─────────────
router.get('/latest', async (_req, res) => {
  try {
    const result = await pool.query(
      `SELECT r.id, r.message, r.rating, r.created_at,
              u.name AS user_name
       FROM reviews r
       JOIN users u ON u.id = r.user_id
       WHERE r.is_approved = TRUE
       ORDER BY r.created_at DESC
       LIMIT 3`
    );
    return res.json(result.rows);
  } catch (err) {
    console.error('reviews latest error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── POST /api/reviews — authenticated users submit a review ──────────────
router.post('/', requireAuth, async (req, res) => {
  const { message, rating } = req.body;

  if (!message || message.trim().length < 3) {
    return res.status(400).json({ message: 'Отзыв должен содержать не менее 3 символов' });
  }
  if (message.trim().length > 1000) {
    return res.status(400).json({ message: 'Отзыв должен содержать не более 1000 символов' });
  }

  const ratingNum = rating ? parseInt(rating, 10) : 5;
  if (isNaN(ratingNum) || ratingNum < 1 || ratingNum > 5) {
    return res.status(400).json({ message: 'Рейтинг должен быть от 1 до 5' });
  }

  try {
    const result = await pool.query(
      `INSERT INTO reviews (user_id, message, rating, is_approved)
       VALUES ($1, $2, $3, TRUE)
       RETURNING id, message, rating, is_approved, created_at`,
      [req.user.id, message.trim(), ratingNum]
    );
    return res.status(201).json(result.rows[0]);
  } catch (err) {
    console.error('review create error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── GET /api/reviews/admin — admin: all reviews ──────────────────────────
router.get('/admin', requireAuth, requireAdmin, async (_req, res) => {
  try {
    const result = await pool.query(
      `SELECT r.id, r.message, r.rating, r.is_approved, r.created_at,
              u.id AS user_id, u.name AS user_name
       FROM reviews r
       LEFT JOIN users u ON u.id = r.user_id
       ORDER BY r.created_at DESC`
    );
    return res.json(result.rows);
  } catch (err) {
    console.error('admin reviews list error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── PATCH /api/reviews/:id/toggle — admin: toggle approval ──────────────
router.patch('/:id/toggle', requireAuth, requireAdmin, async (req, res) => {
  const id = parseInt(req.params.id, 10);
  if (isNaN(id)) return res.status(400).json({ message: 'Неверный ID' });

  try {
    const result = await pool.query(
      `UPDATE reviews SET is_approved = NOT is_approved
       WHERE id = $1
       RETURNING id, is_approved`,
      [id]
    );
    if (result.rows.length === 0) {
      return res.status(404).json({ message: 'Отзыв не найден' });
    }
    const status = result.rows[0].is_approved ? 'одобрен' : 'скрыт';
    return res.json({ ...result.rows[0], message: `Отзыв ${status}` });
  } catch (err) {
    console.error('review toggle error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── DELETE /api/reviews/:id — admin: delete review ──────────────────────
router.delete('/:id', requireAuth, requireAdmin, async (req, res) => {
  const id = parseInt(req.params.id, 10);
  if (isNaN(id)) return res.status(400).json({ message: 'Неверный ID' });

  try {
    const result = await pool.query(
      'DELETE FROM reviews WHERE id = $1 RETURNING id',
      [id]
    );
    if (result.rows.length === 0) {
      return res.status(404).json({ message: 'Отзыв не найден' });
    }
    return res.json({ message: 'Отзыв удалён' });
  } catch (err) {
    console.error('review delete error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

export default router;
