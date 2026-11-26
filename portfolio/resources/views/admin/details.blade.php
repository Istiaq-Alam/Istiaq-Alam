@extends('admin.layout')

@section('title', 'Edit Details')

@section('content')
  <div class="page-head">
    <h1>Edit Details</h1>
    <button class="btn" type="submit" form="details-form">Save</button>
  </div>
  <style>
    .page-head { display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:12px; }
    .page-head h1 { margin:0; }
    .resume-box { background:var(--bg); border:1px solid var(--line); border-radius:8px; padding:14px; margin-bottom:18px; }
    .resume-head { display:flex; align-items:center; gap:10px; margin:-14px -14px 12px; padding:10px 14px; border-radius:8px 8px 0 0; }
    .resume-head h2 { margin:0; font-size:0.95rem; text-transform:uppercase; letter-spacing:.06em; }
    .icon-btn { width:30px; height:30px; padding:0; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0; }
    .icon-btn svg { width:16px; height:16px; }
    .resume-education { border-top:3px solid var(--accent); }
    .resume-education .resume-head { background:rgba(0,209,178,.12); color:var(--accent); }
    .resume-experience { border-top:3px solid #4ea8ff; }
    .resume-experience .resume-head { background:rgba(78,168,255,.12); color:#4ea8ff; }
    .resume-list { display:flex; flex-direction:column; gap:12px; margin-bottom:12px; }
  </style>
  <div class="card">
    <h2>Profile image</h2>
    <p class="item-meta">
      Shown in the sidebar and on the social card. A portrait photo works best; JPEG, PNG or WebP up to 8&nbsp;MB.
    </p>
    <div style="display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap;margin-top:10px">
      <img id="profile-photo-preview" src="{{ $photo }}" alt="Current profile image"
        style="max-width:160px;height:auto;border-radius:8px;border:1px solid var(--line);background:var(--bg)">
      <div style="flex:1;min-width:240px">
        <label for="profile_photo">New image</label>
        <input id="profile_photo" type="file" accept="image/jpeg,image/png,image/webp">
        <p id="profile-photo-status" class="item-meta" role="status" aria-live="polite">
          Choosing a file replaces the current image right away.
        </p>
      </div>
    </div>
  </div>
  <div class="card">
    <form id="details-form" method="POST" action="{{ route('admin.details.update') }}">
      @csrf
      @method('PUT')

      <h2>Main page</h2>

      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name', $details['name']) }}" required>

      <label for="job_title">Job title (use a new line for the second line)</label>
      <textarea id="job_title" name="job_title" required>{{ old('job_title', $details['job_title']) }}</textarea>

      <label for="about_1">About me, paragraph 1</label>
      <textarea id="about_1" name="about_1" required>{{ old('about_1', $details['about_1']) }}</textarea>

      <label for="about_2">About me, paragraph 2</label>
      <textarea id="about_2" name="about_2" required>{{ old('about_2', $details['about_2']) }}</textarea>

      <div class="resume-box resume-education">
      <div class="resume-head"><button type="button" class="btn icon-btn" data-add="education-list" data-section="education" aria-label="Add education" title="Add education"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></button><h2>Resume: Education</h2></div>
      <div class="resume-list" id="education-list">
      @foreach ($details['education'] as $i => $item)
        <div class="item entry">
          <label>Title</label>
          <input type="text" name="education[{{ $i }}][title]" value="{{ old("education.$i.title", $item['title']) }}" required>
          <label>Period</label>
          <input type="text" name="education[{{ $i }}][period]" value="{{ old("education.$i.period", $item['period']) }}" required>
          <label>Description</label>
          <textarea name="education[{{ $i }}][text]" required>{{ old("education.$i.text", $item['text']) }}</textarea>
          <button type="button" class="btn danger btn-remove">Remove</button>
        </div>
      @endforeach
      </div>
      </div>

      <div class="resume-box resume-experience">
      <div class="resume-head"><button type="button" class="btn icon-btn" data-add="experience-list" data-section="experience" aria-label="Add experience" title="Add experience"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></button><h2>Resume: Experience</h2></div>
      <div class="resume-list" id="experience-list">
      @foreach ($details['experience'] as $i => $item)
        <div class="item entry">
          <label>Title</label>
          <input type="text" name="experience[{{ $i }}][title]" value="{{ old("experience.$i.title", $item['title']) }}" required>
          <label>Period (use a new line for the company line)</label>
          <textarea name="experience[{{ $i }}][period]" required>{{ old("experience.$i.period", $item['period']) }}</textarea>
          <label>Description</label>
          <textarea name="experience[{{ $i }}][text]" required>{{ old("experience.$i.text", $item['text']) }}</textarea>
          <button type="button" class="btn danger btn-remove">Remove</button>
        </div>
      @endforeach
      </div>
      </div>

    </form>
  </div>

  <div class="card">
    <h2>Social preview</h2>
    <p class="item-meta">
      The image shown when the site is shared. It follows the fields above as you type and is saved with them.
    </p>
    <canvas id="og-card-preview" width="1200" height="630"
      style="display:block;width:100%;max-width:640px;height:auto;margin-top:10px;border-radius:8px;border:1px solid var(--line)"></canvas>
  </div>

  <p id="og-card-status" class="item-meta" role="status" aria-live="polite">
    The social preview image is rebuilt from these details every time you save.
  </p>

  <template id="education-template">
    <div class="item entry">
      <label>Title</label>
      <input type="text" name="education[__i__][title]" required>
      <label>Period</label>
      <input type="text" name="education[__i__][period]" required>
      <label>Description</label>
      <textarea name="education[__i__][text]" required></textarea>
      <button type="button" class="btn danger btn-remove">Remove</button>
    </div>
  </template>

  <template id="experience-template">
    <div class="item entry">
      <label>Title</label>
      <input type="text" name="experience[__i__][title]" required>
      <label>Period (use a new line for the company line)</label>
      <textarea name="experience[__i__][period]" required></textarea>
      <label>Description</label>
      <textarea name="experience[__i__][text]" required></textarea>
      <button type="button" class="btn danger btn-remove">Remove</button>
    </div>
  </template>

  <script>
    document.querySelectorAll('[data-add]').forEach(function (button) {
      button.addEventListener('click', function () {
        var list = document.getElementById(button.dataset.add);
        var template = document.getElementById(button.dataset.section + '-template');
        var next = list.querySelectorAll('.entry').length + Date.now();
        var html = template.innerHTML.replace(/__i__/g, next);
        list.insertAdjacentHTML('afterbegin', html);
      });
    });

    document.addEventListener('click', async function (event) {
      if (event.target.classList.contains('btn-remove')) {
        var entry = event.target.closest('.entry');
        if (await verifyAdminPassword('Remove this entry?')) {
          entry.remove();
        }
      }
    });
  </script>

  <script src="{{ asset('assets/js/og-card.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var canRenderCard = !!window.OgCard;

      var config = {
        endpoint: @json(route('admin.og-image.store')),
        csrf: @json(csrf_token()),
        photo: @json('/profile-photo?v='.\App\Support\SiteDetails::photoVersion()),
        name: @json($details['name']),
        jobTitle: @json($details['job_title']),
        summary: @json(\App\Support\SiteDetails::summary($details, 220)),
        domain: @json(parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'www.istiaq-alam.me'),
      };

      var preview = document.getElementById('og-card-preview');
      var timer = null;

      var fieldValue = function (selector, fallback) {
        var field = document.querySelector(selector);
        return field ? field.value : fallback;
      };

      var drawCard = function () {
        if (!preview || !canRenderCard) return;

        window.OgCard.preview(preview, {
          name: fieldValue('#name', config.name),
          jobTitle: fieldValue('#job_title', config.jobTitle),
          summary: fieldValue('#about_1', config.summary),
          photo: config.photo,
          domain: config.domain,
        });
      };

      var drawCardSoon = function () {
        clearTimeout(timer);
        timer = setTimeout(drawCard, 250);
      };

      ['#name', '#job_title', '#about_1'].forEach(function (selector) {
        var field = document.querySelector(selector);
        if (field) field.addEventListener('input', drawCardSoon);
      });

      drawCardSoon();

      // Replacing the profile image uploads it immediately and rebuilds the card.
      var photoField = document.getElementById('profile_photo');
      var photoPreview = document.getElementById('profile-photo-preview');
      var photoStatus = document.getElementById('profile-photo-status');

      var setPhotoStatus = function (message) {
        if (photoStatus) photoStatus.textContent = message;
      };

      if (photoField && photoPreview) {
        photoField.addEventListener('change', function () {
          var file = photoField.files && photoField.files[0];
          if (!file) return;

          if (! /^image\/(jpeg|png|webp)$/.test(file.type)) {
            setPhotoStatus('Choose a JPEG, PNG or WebP image.');
            return;
          }

          if (file.size > 8 * 1024 * 1024) {
            setPhotoStatus('That image is larger than 8 MB.');
            return;
          }

          var local = URL.createObjectURL(file);
          photoPreview.src = local;
          setPhotoStatus('Uploading…');

          var body = new FormData();
          body.append('photo', file);

          fetch(@json(route('admin.photo.store')), {
            method: 'POST',
            body: body,
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': config.csrf },
          }).then(function (response) {
            if (!response.ok) throw new Error('Upload failed with HTTP ' + response.status);
            return response.json();
          }).then(function (payload) {
            URL.revokeObjectURL(local);
            photoPreview.src = payload.url;
            photoField.value = '';
            config.photo = payload.proxy;
            drawCard();
            setPhotoStatus('Profile image updated. Rebuilding the social preview…');

            return canRenderCard ? window.OgCard.regenerate(config) : null;
          }).then(function () {
            setPhotoStatus('Profile image and social card updated.');
          }).catch(function (error) {
            URL.revokeObjectURL(local);
            photoPreview.src = @json($photo);
            setPhotoStatus('The image could not be uploaded; the previous one is still in use.');
            if (window.console && console.warn) console.warn('[profile-photo]', error);
          });
        });
      }

      @if (session('og_updated_required'))
        if (canRenderCard) window.OgCard.regenerate(config);
      @endif
    });
  </script>
@endsection
