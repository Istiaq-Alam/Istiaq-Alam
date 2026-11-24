# Portfolio Deployment and Maintenance Guide

The site runs on Laravel, is hosted on Vercel at https://www.istiaq-alam.me/, and uses:

- **Neon Postgres** for all content (projects, certificates, research, skills, messages, settings, admin login).
- **Vercel Blob** for uploaded images (`portfolio-uploads` store).

Changes made in the admin panel on the live site are saved straight to the live database and live images. There is no separate local copy to deploy.

## 1. Admin panel: adding, editing and deleting projects

1. Open https://www.istiaq-alam.me/admin/login and sign in.
2. Go to **Projects** in the admin menu.
3. To add a project, click **+ Add Project**, fill in the form, and click **Save**. To change one, click **Edit** on its card, change the fields, and click **Save**. To remove one, click **Delete** on its card and confirm with your admin password.
4. Refresh https://www.istiaq-alam.me/ to see the change. The homepage updates right away; there is no deploy step.

Form fields:

| Field | Notes |
|---|---|
| Title, Category, Sub category | Category must be one of: CyberSecurity, Applications, Web development, Learn, Github |
| Description | Plain text |
| Project URL | Link to the live project or repository |
| Thumbnail | Image upload, max 2 MB (JPEG, PNG, WebP, GIF or SVG) |
| Square image | Image upload, max 2 MB, same formats |
| GitHub featured | Tick to show in the GitHub section |
| Sort order | Lower numbers show first |

Research, Skills, Certificates and Messages have their own menu items with the same add, edit and delete pattern.

### Preparing images

- Project thumbnail: about 800 px wide, under 200 KB.
- Project square image: 800 × 800, under 200 KB.
- Use WebP or JPEG. Use PNG only when transparency is needed.
- Resize with squoosh.app, or with ImageMagick: `magick input.png -resize 1200x1200\> -quality 80 output.webp`

### Where uploads are saved

- Uploaded images are stored in the **Vercel Blob** store `portfolio-uploads`. Each database row keeps the public `https://cwtitrh33oywbnc7.public.blob.vercel-storage.com/...` URL.
- The nine images from before the Blob change are still in the repository under `portfolio/public/assets/uploads/` and are served from the site itself.
- To view the stored files, open the Vercel dashboard for the project, go to **Storage**, and open `portfolio-uploads`. You can also list them from a terminal (see section 4).

## 2. Where the data lives

| Content | Location | Hosted by |
|---|---|---|
| Projects, certificates, research, skills, contact messages, site settings, admin user | Neon database `portfolio-db` | Neon, through the Vercel Marketplace |
| Uploaded images | Blob store `portfolio-uploads` | Vercel Blob |
| Original 9 images | `public/assets/uploads/` in the git repository | GitHub |
| Code and templates | git repository `main` branch | GitHub, deployed by Vercel on each push |

Neon's dashboard is reached from the Vercel project under **Storage**. The Vercel project's production environment has the variables `DB_URL`, `DB_CONNECTION=pgsql`, `APP_KEY`, `BLOB_READ_WRITE_TOKEN` and `BLOB_STORE_ID`. Do not change `APP_KEY`, or existing login sessions break.

## 3. Changing code or the site design

Code changes are the only thing that needs a deploy.

```
cd portfolio
git pull
git add <files>
git commit -m "Describe the change"
git push origin main
```

Vercel builds and deploys each push to `main` automatically. Check the result at https://www.istiaq-alam.me/ once the deployment shows **Ready** in the Vercel dashboard.

## 4. Backing up

Back up both the database and the images. Do this before large changes, and at least once a month.

### Database (Neon)

Run from a machine that has `pg_dump` installed (`sudo apt install postgresql-client`). Use the **unpooled** connection string, which is stored in the Vercel project as `DATABASE_URL_UNPOOLED`.

```
vercel env pull .env.neon --environment production
set -a; . ./.env.neon; set +a
pg_dump "$DATABASE_URL_UNPOOLED" --format=custom --file=backups/portfolio-$(date +%F).dump
```

- `.env.neon` contains database credentials. Do not commit it; it is already in `.gitignore`.
- To restore a dump into a database: `pg_restore --clean --no-owner -d "$DATABASE_URL_UNPOOLED" backups/<file>.dump`. Only restore into a database you intend to overwrite.

### Images (Vercel Blob)

Download every blob in the store into a local folder:

```
vercel blob list --rw-token "$BLOB_READ_WRITE_TOKEN" --limit 1000
vercel blob get <blob-url> --access public -o backups/images/<file-name>
```

Use the URLs from the `list` output. The token is a secret stored in Vercel; copy it from the Vercel dashboard (Storage → `portfolio-uploads` → Settings) into your shell for this session only. Do not commit it. The `backups/` folder is not in `.gitignore`, so add it there or keep backups on a drive outside the project.

### Repository

The code and the original nine images are backed up by GitHub. Keep the repository on GitHub and do not delete the `main` branch.

## 5. Vercel environment variables

Set these in **Project Settings → Environment Variables** for Production. Do not put secrets in `vercel.json`.

| Variable | Purpose |
|---|---|
| `APP_KEY` | Laravel encryption key. Copy from the local `.env`. |
| `APP_URL` | `https://www.istiaq-alam.me` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | Neon pooled connection string |
| `BLOB_READ_WRITE_TOKEN` | Vercel Blob token for uploads (sensitive) |
| `BLOB_STORE_ID` | Vercel Blob store ID |

If the site shows a 500 error, check that `APP_KEY` and `DB_URL` are set.

## 6. Limits to keep in mind

| Limit | Value | Notes |
|---|---|---|
| Function response | 4.5 MB | The homepage HTML must stay well below this. Images are linked by URL, so the page stays small. |
| Blob free tier | 1 GB storage, 10 GB transfer per month | Check the store size in the Vercel dashboard. |
| Neon free plan | Storage and compute limits apply | Check usage under **Storage** in the Vercel dashboard. |

## 7. Known limitations

- **Images from before the Blob change** are served from the repository, not Blob. Moving them to Blob is a separate task.
- **Uploads on a local machine** go to Blob too, because the local `.env` points at the same Neon database. A local admin change changes the live site.
- **The homepage loads everything on one page.** This is fine for a portfolio. If you add hundreds of items, consider pagination.

## 8. Troubleshooting

| Symptom | Likely cause | Fix |
|---|---|---|
| 500 error with no detail | `APP_KEY` or `DB_URL` missing in Vercel | Add the variable under Environment Variables and redeploy |
| Uploaded image not showing | `BLOB_READ_WRITE_TOKEN` missing or expired | Check the variable in Vercel and redeploy |
| Image upload fails with a validation error | File is over 2 MB or not an allowed type | Resize or convert the file, then try again |
| Site shows raw PHP text or downloads `index.php` | A `filesystem` route in `vercel.json` | Remove it, then commit and push |
| Changes not visible after a code push | Deployment still building | Wait for **Ready** in the Vercel dashboard, then hard-refresh |
