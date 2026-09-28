/**
 * Run once to apply schema.sql to the database.
 * On Railway: run via shell or as a one-off job.
 * Locally: node migrate.js
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import pool from './db.js';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const sql = fs.readFileSync(path.join(__dirname, 'schema.sql'), 'utf8');

try {
  await pool.query(sql);
  console.log('✅ Migration applied successfully');
} catch (err) {
  console.error('❌ Migration failed:', err.message);
} finally {
  await pool.end();
}
