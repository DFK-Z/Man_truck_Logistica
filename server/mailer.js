import nodemailer from 'nodemailer';
import dotenv from 'dotenv';
dotenv.config();

const transporter = nodemailer.createTransport({
  host:   process.env.MAIL_HOST,
  port:   Number(process.env.MAIL_PORT),
  secure: process.env.MAIL_SECURE === 'true',
  auth: {
    user: process.env.MAIL_USER,
    pass: process.env.MAIL_PASS,
  },
});

/**
 * Send a contact/callback request notification to the site owner.
 * @param {{ name: string, phone: string, message?: string }} data
 */
export async function sendContactEmail({ name, phone, message }) {
  const date = new Date().toLocaleString('ru-RU', { timeZone: 'Europe/Moscow' });

  await transporter.sendMail({
    from: `"МАН Логистика — Сайт" <${process.env.MAIL_USER}>`,
    to:   process.env.MAIL_TO,
    subject: `📞 Новая заявка с сайта — ${name}`,
    html: `
      <div style="font-family: Arial, sans-serif; max-width: 520px; margin: 0 auto; background: #f9f9f9; border-radius: 12px; overflow: hidden; border: 1px solid #e5e5e5;">
        <div style="background: linear-gradient(135deg, #f97316, #ea580c); padding: 24px 28px;">
          <h2 style="margin: 0; color: #fff; font-size: 20px;">📞 Новая заявка с сайта</h2>
          <p style="margin: 4px 0 0; color: rgba(255,255,255,0.8); font-size: 14px;">МАН Логистика — Волгоград</p>
        </div>
        <div style="padding: 28px;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="padding: 10px 0; color: #888; font-size: 13px; width: 120px;">Имя</td>
              <td style="padding: 10px 0; color: #111; font-size: 15px; font-weight: 600;">${name}</td>
            </tr>
            <tr style="border-top: 1px solid #eee;">
              <td style="padding: 10px 0; color: #888; font-size: 13px;">Телефон</td>
              <td style="padding: 10px 0;">
                <a href="tel:${phone.replace(/\D/g,'')}" style="color: #f97316; font-size: 18px; font-weight: 700; text-decoration: none;">${phone}</a>
              </td>
            </tr>
            ${message ? `
            <tr style="border-top: 1px solid #eee;">
              <td style="padding: 10px 0; color: #888; font-size: 13px; vertical-align: top;">Сообщение</td>
              <td style="padding: 10px 0; color: #333; font-size: 14px; line-height: 1.5;">${message}</td>
            </tr>` : ''}
            <tr style="border-top: 1px solid #eee;">
              <td style="padding: 10px 0; color: #888; font-size: 13px;">Время</td>
              <td style="padding: 10px 0; color: #666; font-size: 13px;">${date} (МСК)</td>
            </tr>
          </table>

          <div style="margin-top: 24px; padding: 16px; background: #fff3ed; border-radius: 8px; border-left: 4px solid #f97316;">
            <p style="margin: 0; color: #c2410c; font-size: 13px; font-weight: 600;">Клиент ожидает звонка. Рекомендуем перезвонить в течение 30 минут.</p>
          </div>
        </div>
        <div style="padding: 16px 28px; background: #f0f0f0; text-align: center;">
          <p style="margin: 0; color: #aaa; font-size: 12px;">Уведомление с сайта logistika-volgograd.ru</p>
        </div>
      </div>
    `,
  });
}
