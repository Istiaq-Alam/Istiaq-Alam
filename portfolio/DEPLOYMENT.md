# Portfolio Deployment and Maintenance Guide

This site runs on Laravel with SQLite and is deployed to Vercel.

## 1. Why the 500 error happened

Vercel limits what a function can return to **4.5 MB**. The homepage embedded every project, certificate and research image as base64 text inside the HTML, which made it about **7.1 MB**. Vercel then returned:

```
500 FUNCTION_RESPONSE_PAYLOAD_TOO_LARGE
```

The fix:

- Images are stored as files in `public/assets/uploads/`.
- The database stores only the file path (for example `assets/uploads/projects-7-square_image.png`).
- The homepage is now about **49 KB**.
- `vercel.json` serves `/assets/...` files directly, without running PHP.

Do **not** add `filesystem` as a route in `vercel.json`. It makes Vercel serve `public/index.php` as a plain file, which breaks the whole site.

## 2. Vercel environment variables

Set these in Project Settings → Environment Variables (Production). Most are already in `vercel.json`.

| Variable | Value |
|---|---|
| `APP_KEY` | Output of `php artisan key:generate --show` (copy it from your local `.env`) |
| `APP_URL` | `https://www.istiaq-alam.me` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `sqlite` |
| `DB_DATABASE` | `/tmp/database.sqlite` |
| `SESSION_DRIVER` | `cookie` |
| `CACHE_STORE` | `array` |

`.env` is excluded from deploys, so `APP_KEY` must be set in the dashboard. Without it, Laravel returns a 500 error.

## 3. Limits to keep in mind

| Limit | Value | Notes |
|---|---|---|
| Function response | 4.5 MB | Homepage HTML must stay well below this. Keep it under about 1 MB. |
| Function bundle | 250 MB uncompressed | Current size is far below this. |
| Writable `/tmp` | Up to 500 MB | `api/index.php` copies the SQLite file here on each cold start. |
| `database.sqlite` | Keep under about 50 MB | Currently about 7.4 MB. |

Images are the main risk. One embedded 1 MB image adds about 1.3 MB of base64 to the page. Never store image data in the database.

## 4. Preventing the error from coming back

- Never paste `data:image/...` text into any URL field in the admin panel. Upload the file, or link to a hosted image.
- Do not upload images on the live site. Vercel's filesystem is read-only, and changes made there are lost on restart.
- Do not restore an old `database.sqlite` from before the fix without running the check in section 6.

## 5. Adding a project or certificate

Changes on the live site are not saved. Add content locally, then deploy.

1. **Prepare the images.**
   - Project thumbnail: about 800 px wide, under 200 KB
   - Project square image: 800 × 800, under 200 KB
   - Certificate: 1200–1600 px on the long edge, under 300 KB
   - Use WebP or JPEG. Use PNG only when transparency is needed.
   - Resize with squoosh.app, or with ImageMagick:
     ```
     magick input.png -resize 1200x1200\> -quality 80 output.webp
     ```
2. **Start the site locally.**
   ```
   cd portfolio
   php artisan serve
   ```
   Open `http://127.0.0.1:8000/admin` and log in.
3. **Add the project or certificate** in the admin panel and save. Files are stored in `public/assets/uploads/`.
4. **Check it locally.** Open `http://127.0.0.1:8000/` and confirm the content and images display. Then run the check in section 6.
5. **Commit and push.**
   ```
   git add database/database.sqlite public/assets/uploads
   git commit -m "Add new project"
   git push origin main
   ```
6. **Check the live site** at https://www.istiaq-alam.me/ after the Vercel deployment finishes.

## 6. Pre-deploy check

Run these from the `portfolio` folder while the local server is running. Both must pass before you commit.

```
curl -s -o /dev/null -w "homepage bytes: %{size_download}\n" http://127.0.0.1:8000/
sqlite3 database/database.sqlite "select count(*) from projects where thumbnail like 'data:%' or square_image like 'data:%'; select count(*) from certificates where image like 'data:%'; select count(*) from researches where thumbnail like 'data:%';"
```

- The homepage size should be well under 4,500,000 bytes.
- Every count should be `0`. A non-zero count means image data has been stored in the database again.

## 7. Database maintenance

- **Back up with git.** Commit before large changes. To restore an earlier version:
  ```
  git checkout <commit> -- database/database.sqlite
  ```
- **Shrink the file** after deleting rows or replacing images:
  ```
  sqlite3 database/database.sqlite "VACUUM;"
  ```
  Then check the size with `ls -lh database/database.sqlite`.

## 8. Known limitations

- **Live edits are not saved.** The live database is a temporary copy in `/tmp`, rebuilt from git on each deploy.
- **Contact-form messages are not saved** on the live site. They are lost when the server restarts.
- **Everything loads on one page.** This is fine for a portfolio. If you add hundreds of items, consider pagination and recheck the homepage size.

For persistent live edits and messages, move the database to a hosted service such as Neon, Turso, or Supabase, and store images in external object storage.

## 9. Troubleshooting

| Symptom | Likely cause | Fix |
|---|---|---|
| `500 FUNCTION_RESPONSE_PAYLOAD_TOO_LARGE` | Image data is embedded in the page | Run the check in section 6 and convert any `data:` rows to files |
| Site shows raw PHP text or downloads `index.php` | A `filesystem` route in `vercel.json` | Remove it, then commit and push |
| 500 error with no payload message | `APP_KEY` not set in Vercel | Add it under Environment Variables and redeploy |
| Images missing on the live site | Uploads or database not committed | Commit `public/assets/uploads` and `database/database.sqlite` together |
| Uploaded image fails on the live site | Vercel filesystem is read-only | Upload locally, then deploy |
