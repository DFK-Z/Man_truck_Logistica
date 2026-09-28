import jwt from 'jsonwebtoken';

/**
 * Verifies the JWT from the Authorization header.
 * Attaches req.user = { id, name, email, role } on success.
 */
export function requireAuth(req, res, next) {
  const header = req.headers.authorization;
  if (!header || !header.startsWith('Bearer ')) {
    return res.status(401).json({ message: 'Не авторизован' });
  }

  const token = header.slice(7);
  try {
    const payload = jwt.verify(token, process.env.JWT_SECRET);
    req.user = payload;
    next();
  } catch {
    return res.status(401).json({ message: 'Токен недействителен или истёк' });
  }
}

/**
 * Must be used after requireAuth.
 * Blocks access for non-admin users.
 */
export function requireAdmin(req, res, next) {
  if (req.user?.role !== 'admin') {
    return res.status(403).json({ message: 'Доступ запрещён. Только для администраторов.' });
  }
  next();
}
