import { Router } from 'express';
import path from 'path';
import { fileURLToPath } from 'url';
import fs from 'fs';
import pool from '../db.js';
import { requireAuth, requireAdmin } from '../middleware/auth.js';
import { upload } from '../middleware/upload.js';

const router = Router();
const __dirname = path.dirname(fileURLToPath(import.meta.url));

// ─── GET /api/trucks — public list ────────────────────────────────────────
router.get('/', async (_req, res) => {
  try {
    const result = await pool.query(
      'SELECT id, brand, model, image, views, created_at FROM trucks ORDER BY created_at DESC'
    );
    return res.json(result.rows);
  } catch (err) {
    console.error('trucks list error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── GET /api/trucks/:id — public detail ──────────────────────────────────
router.get('/:id', async (req, res) => {
  const id = parseInt(req.params.id, 10);
  if (isNaN(id)) return res.status(400).json({ message: 'Неверный ID' });

  try {
    // Increment views
    const result = await pool.query(
      `UPDATE trucks SET views = views + 1
       WHERE id = $1
       RETURNING id, brand, model, image, views, created_at`,
      [id]
    );
    if (result.rows.length === 0) {
      return res.status(404).json({ message: 'Грузовик не найден' });
    }
    return res.json(result.rows[0]);
  } catch (err) {
    console.error('truck detail error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── POST /api/trucks — admin create ──────────────────────────────────────
router.post('/', requireAuth, requireAdmin, upload.single('image'), async (req, res) => {
  const { brand, model } = req.body;

  if (!brand?.trim() || !model?.trim()) {
    return res.status(400).json({ message: 'Бренд и модель обязательны' });
  }

  const imagePath = req.file ? `trucks/${req.file.filename}` : null;

  try {
    const result = await pool.query(
      `INSERT INTO trucks (brand, model, image)
       VALUES ($1, $2, $3)
       RETURNING id, brand, model, image, views, created_at`,
      [brand.trim(), model.trim(), imagePath]
    );
    return res.status(201).json(result.rows[0]);
  } catch (err) {
    console.error('truck create error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── PUT /api/trucks/:id — admin update ───────────────────────────────────
router.put('/:id', requireAuth, requireAdmin, upload.single('image'), async (req, res) => {
  const id = parseInt(req.params.id, 10);
  if (isNaN(id)) return res.status(400).json({ message: 'Неверный ID' });

  const { brand, model } = req.body;
  if (!brand?.trim() || !model?.trim()) {
    return res.status(400).json({ message: 'Бренд и модель обязательны' });
  }

  try {
    // Fetch existing record to know old image path
    const existing = await pool.query('SELECT image FROM trucks WHERE id = $1', [id]);
    if (existing.rows.length === 0) {
      return res.status(404).json({ message: 'Грузовик не найден' });
    }

    let imagePath = existing.rows[0].image;

    if (req.file) {
      // Delete old image file if present
      if (imagePath) {
        const oldFile = path.join(__dirname, '..', 'uploads', imagePath);
        if (fs.existsSync(oldFile)) fs.unlinkSync(oldFile);
      }
      imagePath = `trucks/${req.file.filename}`;
    }

    const result = await pool.query(
      `UPDATE trucks SET brand = $1, model = $2, image = $3
       WHERE id = $4
       RETURNING id, brand, model, image, views, created_at`,
      [brand.trim(), model.trim(), imagePath, id]
    );
    return res.json(result.rows[0]);
  } catch (err) {
    console.error('truck update error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

// ─── DELETE /api/trucks/:id — admin delete ────────────────────────────────
router.delete('/:id', requireAuth, requireAdmin, async (req, res) => {
  const id = parseInt(req.params.id, 10);
  if (isNaN(id)) return res.status(400).json({ message: 'Неверный ID' });

  try {
    const result = await pool.query(
      'DELETE FROM trucks WHERE id = $1 RETURNING image',
      [id]
    );
    if (result.rows.length === 0) {
      return res.status(404).json({ message: 'Грузовик не найден' });
    }

    // Delete image file
    const imagePath = result.rows[0].image;
    if (imagePath) {
      const filePath = path.join(__dirname, '..', 'uploads', imagePath);
      if (fs.existsSync(filePath)) fs.unlinkSync(filePath);
    }

    return res.json({ message: 'Грузовик удалён' });
  } catch (err) {
    console.error('truck delete error:', err);
    return res.status(500).json({ message: 'Ошибка сервера' });
  }
});

export default router;
