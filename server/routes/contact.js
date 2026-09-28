import { Router } from 'express';
import { sendContactEmail } from '../mailer.js';

const router = Router();

// POST /api/contact
router.post('/', async (req, res) => {
  const { name, phone, message } = req.body;

  if (!name?.trim()) {
    return res.status(400).json({ message: 'Укажите ваше имя' });
  }
  if (!phone?.trim()) {
    return res.status(400).json({ message: 'Укажите номер телефона' });
  }
  // Basic phone sanity check — at least 7 digits
  const digits = phone.replace(/\D/g, '');
  if (digits.length < 7) {
    return res.status(400).json({ message: 'Введите корректный номер телефона' });
  }

  try {
    await sendContactEmail({
      name:    name.trim(),
      phone:   phone.trim(),
      message: message?.trim() || '',
    });
    return res.json({ message: 'Заявка отправлена! Мы перезвоним вам в ближайшее время.' });
  } catch (err) {
    console.error('contact email error:', err);
    return res.status(500).json({ message: 'Ошибка отправки. Попробуйте позвонить напрямую.' });
  }
});

export default router;
