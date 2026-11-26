/*
 * Builds the 1200x630 Open Graph card from the saved portfolio details and
 * uploads it, so social previews follow whatever is typed into the admin form.
 * No server image extension is needed: the card is drawn in the browser.
 */
(function () {
  'use strict';

  var WIDTH = 1200;
  var HEIGHT = 630;
  var TEAL = '#00d1b2';
  var FONT = 'Poppins, "DejaVu Sans", system-ui, -apple-system, "Segoe UI", sans-serif';

  function roundRect(ctx, x, y, w, h, r) {
    var radius = Math.min(r, w / 2, h / 2);
    ctx.beginPath();
    if (ctx.roundRect) {
      ctx.roundRect(x, y, w, h, radius);
      return;
    }
    ctx.moveTo(x + radius, y);
    ctx.lineTo(x + w - radius, y);
    ctx.quadraticCurveTo(x + w, y, x + w, y + radius);
    ctx.lineTo(x + w, y + h - radius);
    ctx.quadraticCurveTo(x + w, y + h, x + w - radius, y + h);
    ctx.lineTo(x + radius, y + h);
    ctx.quadraticCurveTo(x, y + h, x, y + h - radius);
    ctx.lineTo(x, y + radius);
    ctx.quadraticCurveTo(x, y, x + radius, y);
    ctx.closePath();
  }

  function font(weight, size) {
    return weight + ' ' + size + 'px ' + FONT;
  }

  // Emoji and other characters a canvas font may not carry are dropped instead
  // of turning into empty boxes on the card.
  function clean(text) {
    return String(text || '')
      .replace(/[\u{1F000}-\u{1FAFF}\u{2600}-\u{27BF}\u{2B00}-\u{2BFF}\u{FE0F}\u{200D}]/gu, ' ')
      .replace(/[^\S\r\n]+/g, ' ')
      .trim();
  }

  function spacedText(ctx, text, x, y, spacing) {
    var cursor = x;
    for (var i = 0; i < text.length; i++) {
      ctx.fillText(text.charAt(i), cursor, y);
      cursor += ctx.measureText(text.charAt(i)).width + spacing;
    }
  }

  function fitFont(ctx, text, weight, startSize, minSize, maxWidth) {
    var size = startSize;
    ctx.font = font(weight, size);
    while (ctx.measureText(text).width > maxWidth && size > minSize) {
      size -= 2;
      ctx.font = font(weight, size);
    }
    return size;
  }

  function wrapLines(ctx, text, maxWidth, maxLines) {
    var words = clean(text).split(' ').filter(Boolean);
    var lines = [];
    var line = '';

    words.forEach(function (word) {
      var candidate = line ? line + ' ' + word : word;
      if (ctx.measureText(candidate).width <= maxWidth || !line) {
        line = candidate;
        return;
      }
      lines.push(line);
      line = word;
    });
    if (line) lines.push(line);

    if (lines.length <= maxLines) return lines;

    var kept = lines.slice(0, maxLines);
    var last = kept[maxLines - 1];
    while (last.length > 1 && ctx.measureText(last + '…').width > maxWidth) {
      last = last.slice(0, -1);
    }
    kept[maxLines - 1] = last.replace(/[\s,.;:!?'-]+$/, '') + '…';

    return kept;
  }

  function jobLines(jobTitle) {
    return String(jobTitle || '')
      .split(/\r?\n/)
      .map(function (line) { return clean(line).replace(/,$/, ''); })
      .filter(Boolean)
      .slice(0, 2);
  }

  function delay(ms) {
    return new Promise(function (resolve) { setTimeout(resolve, ms); });
  }

  var photoCache = {};

  function loadPhoto(src) {
    if (!src) return Promise.resolve(null);
    if (photoCache[src]) return Promise.resolve(photoCache[src]);

    return new Promise(function (resolve) {
      var image = new Image();
      image.onload = function () {
        photoCache[src] = image;
        resolve(image);
      };
      image.onerror = function () { resolve(null); };
      image.src = src;
    });
  }

  var fontsPromise = null;

  // Loaded once per page; the live preview re-renders on every keystroke.
  function loadFonts() {
    if (fontsPromise) return fontsPromise;

    if (!document.fonts || !document.fonts.load) {
      fontsPromise = Promise.resolve();
      return fontsPromise;
    }

    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap';

    var ready = new Promise(function (resolve) {
      link.onload = resolve;
      link.onerror = resolve;
    });
    document.head.appendChild(link);

    // A missing font or an offline browser must not block the card.
    fontsPromise = Promise.race([ready, delay(3000)]).then(function () {
      return Promise.race([
        Promise.all([
          document.fonts.load('700 76px Poppins'),
          document.fonts.load('400 25px Poppins'),
          document.fonts.load('600 22px Poppins'),
        ]),
        delay(3000),
      ]);
    });

    return fontsPromise;
  }

  function paintBackground(ctx) {
    ctx.fillStyle = '#0a141f';
    ctx.fillRect(0, 0, WIDTH, HEIGHT);

    ctx.strokeStyle = 'rgba(255, 255, 255, 0.035)';
    ctx.lineWidth = 1;
    for (var x = 0; x <= WIDTH; x += 120) {
      ctx.beginPath();
      ctx.moveTo(x + 0.5, 0);
      ctx.lineTo(x + 0.5, HEIGHT);
      ctx.stroke();
    }
    for (var y = 0; y <= HEIGHT; y += 120) {
      ctx.beginPath();
      ctx.moveTo(0, y + 0.5);
      ctx.lineTo(WIDTH, y + 0.5);
      ctx.stroke();
    }

    var glow = ctx.createRadialGradient(980, 190, 0, 980, 190, 720);
    glow.addColorStop(0, 'rgba(0, 209, 178, 0.20)');
    glow.addColorStop(0.55, 'rgba(0, 209, 178, 0.05)');
    glow.addColorStop(1, 'rgba(0, 209, 178, 0)');
    ctx.fillStyle = glow;
    ctx.fillRect(0, 0, WIDTH, HEIGHT);
  }

  function paintPhoto(ctx, photo) {
    var box = { x: 800, y: 118, w: 330, h: 400 };
    var inset = 9;
    var radius = 22;

    ctx.save();
    ctx.shadowColor = 'rgba(0, 209, 178, 0.35)';
    ctx.shadowBlur = 45;
    ctx.fillStyle = '#ffffff';
    roundRect(ctx, box.x, box.y, box.w, box.h, radius);
    ctx.fill();
    ctx.restore();

    var inner = {
      x: box.x + inset,
      y: box.y + inset,
      w: box.w - inset * 2,
      h: box.h - inset * 2,
    };

    ctx.save();
    roundRect(ctx, inner.x, inner.y, inner.w, inner.h, radius - 8);
    ctx.clip();

    if (photo && photo.naturalWidth && photo.naturalHeight) {
      var scale = Math.max(inner.w / photo.naturalWidth, inner.h / photo.naturalHeight);
      var drawW = photo.naturalWidth * scale;
      var drawH = photo.naturalHeight * scale;
      ctx.drawImage(photo, inner.x + (inner.w - drawW) / 2, inner.y + (inner.h - drawH) / 2, drawW, drawH);
    } else {
      ctx.fillStyle = '#12202d';
      ctx.fillRect(inner.x, inner.y, inner.w, inner.h);
    }
    ctx.restore();

    ctx.strokeStyle = TEAL;
    ctx.lineWidth = 6;
    roundRect(ctx, box.x - 3, box.y - 3, box.w + 6, box.h + 6, radius + 3);
    ctx.stroke();
  }

  function paintText(ctx, data) {
    var left = 84;
    var columnWidth = 660;

    ctx.textBaseline = 'alphabetic';

    ctx.fillStyle = TEAL;
    ctx.font = font(600, 20);
    spacedText(ctx, 'PORTFOLIO', left, 152, 8);

    var name = clean(data.name) || 'Portfolio';
    fitFont(ctx, name, 700, 76, 42, columnWidth);
    ctx.fillStyle = '#ffffff';
    ctx.fillText(name, left, 252);

    var lines = jobLines(data.jobTitle);
    var jobY = 306;
    lines.forEach(function (line, index) {
      fitFont(ctx, line, 400, 34, 22, columnWidth);
      ctx.fillStyle = index === 0 ? '#e7edf4' : '#8fa0b2';
      ctx.fillText(line, left, jobY + index * 44);
    });

    ctx.fillStyle = TEAL;
    ctx.fillRect(left, 392, 64, 4);

    ctx.font = font(400, 25);
    ctx.fillStyle = '#93a4b6';
    wrapLines(ctx, data.summary, columnWidth, 3).forEach(function (line, index) {
      ctx.fillText(line, left, 442 + index * 38);
    });

    ctx.font = font(600, 22);
    ctx.fillStyle = TEAL;
    ctx.fillText(clean(data.domain) || 'www.istiaq-alam.me', left, 574);
  }

  async function render(config) {
    await loadFonts();

    var photo = await loadPhoto(config.photo);

    var canvas = document.createElement('canvas');
    canvas.width = WIDTH;
    canvas.height = HEIGHT;

    var ctx = canvas.getContext('2d');
    paintBackground(ctx);
    paintPhoto(ctx, photo);
    paintText(ctx, config);

    return canvas;
  }

  function setStatus(message, isError) {
    var status = document.getElementById('og-card-status');
    if (!status) return;
    status.textContent = message;
    status.style.color = isError ? '#ff8080' : '';
  }

  function upload(config, canvas) {
    return new Promise(function (resolve, reject) {
      canvas.toBlob(function (blob) {
        if (!blob) return reject(new Error('The card could not be encoded.'));

        var body = new FormData();
        body.append('image', blob, 'og-card.jpg');

        fetch(config.endpoint, {
          method: 'POST',
          body: body,
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': config.csrf,
          },
        }).then(function (response) {
          if (!response.ok) throw new Error('Upload failed with HTTP ' + response.status);
          return response.json();
        }).then(function (payload) {
          if (!payload || !payload.url) throw new Error('The upload did not return a URL.');
          resolve(payload.url);
        }).catch(reject);
      }, 'image/jpeg', 0.92);
    });
  }

  // Draws the card into a visible canvas, for the admin live preview.
  function preview(canvas, config) {
    return render(config).then(function (card) {
      var ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(card, 0, 0, canvas.width, canvas.height);
      return canvas;
    }).catch(function (error) {
      if (window.console && console.warn) console.warn('[og-card]', error);
      return null;
    });
  }

  function regenerate(config) {
    return render(config).then(function (canvas) {
      return upload(config, canvas).then(function (url) {
        setStatus('Social preview image updated.');
        return url;
      });
    }).catch(function (error) {
      setStatus('The social preview image could not be updated; the previous one is still in use.', true);
      if (window.console && console.warn) console.warn('[og-card]', error);
      return null;
    });
  }

  window.OgCard = { render: render, preview: preview, regenerate: regenerate };
})();
