<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Istiaq Alam - Portfolio</title>
  <meta name="description"
    content="Istiaq Alam is a Computer Science & Engineering student specializing in Cyber Security, Ethical Hacking, and Web Development. Based in Dhaka, Bangladesh." />
  <meta name="author" content="Istiaq Alam" />
  <meta name="robots" content="index, follow" />
  <meta name="theme-color" content="#1a1a2e" />

  <!-- Canonical -->
  <link rel="canonical" href="https://istiaq-alam.me" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/icon.png') }}" type="image/x-icon" />
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/icon.png') }}" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/icon.png') }}" />

  <!-- Web App Manifest -->
  <link rel="manifest" href="/site.webmanifest" />

  <!-- Open Graph -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Istiaq Alam Portfolio" />
  <meta property="og:title" content="Istiaq Alam - Front-End Developer & Web Designer | Cyber Security Background" />
  <meta property="og:description"
    content="Istiaq Alam is a Computer Science & Engineering student specializing in Cyber Security, Ethical Hacking, and Web Development. Based in Dhaka, Bangladesh." />
  <meta property="og:url" content="https://istiaq-alam.me" />
  <meta property="og:image" content="https://istiaq-alam.me/assets/images/istiaq.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:locale" content="en_US" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Istiaq Alam - Front-End Developer & Web Designer | Cyber Security Background" />
  <meta name="twitter:description"
    content="CSE student passionate about Ethical Hacking, Penetration Testing, and secure Web Development. Explore my projects and research." />
  <meta name="twitter:image" content="https://istiaq-alam.me/assets/images/istiaq.jpg" />

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@type": "Person",
    "name": "Istiaq Alam",
    "url": "https://istiaq-alam.me",
    "image": "https://istiaq-alam.me/assets/images/istiaq.jpg",
    "jobTitle": "Web Development Intern at Variation Communications Ltd",
    "description": "Computer Science & Engineering student specializing in Cyber Security, Ethical Hacking, and Web Development.",
    "email": "istiak.apk@gmail.com",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Dhaka",
      "addressCountry": "BD"
    },
    "sameAs": [
      "https://github.com/Istiaq-Alam",
      "https://www.facebook.com/IstiaqTusher.apk",
      "https://www.instagram.com/istiaq_tusher.apk"
    ]
  }
  </script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <!-- Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body oncontextmenu="return false;">
  <canvas id="matrix"></canvas>
  <!--
    - #MAIN
  -->

  <main>

    <!--
      - #SIDEBAR
    -->

    <aside class="sidebar" data-sidebar>

      <div class="sidebar-info">

        <figure class="avatar-box">
          <img src="{{ asset('assets/images/istiaq.jpg') }}" alt="Istiaq Alam" width="80">
        </figure>

        <div class="info-content">
          <h1 class="name" title="Istiaq Alam">Istiaq Alam</h1>
          <!--Cyber Security Enthusiast & CSE Student-->
          <p class="title">Web Development Intern,<br>Variation Communications Ltd </p>
        </div>

        <button class="info_more-btn" data-sidebar-btn>
          <span>Show Contacts</span>

          <ion-icon name="chevron-down"></ion-icon>
        </button>

      </div>

      <div class="sidebar-info_more">

        <div class="separator"></div>

        <ul class="contacts-list">

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">Email</p>

              <a href="mailto:istiak.apk@gmail.com" class="contact-link">istiak.apk@gmail.com</a>
            </div>

          </li>

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="phone-portrait-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">Phone</p>

              <a href="tel:+8801765376101" class="contact-link">+88
                01765376101</a>
            </div>

          </li>

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="calendar-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">Birthday</p>

              <time datetime="1982-06-23">February 25, 2001</time>
            </div>

          </li>

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">Location</p>

              <address>Dhaka, Bangladesh</address>
            </div>

          </li>

        </ul>

        <div class="separator"></div>

        <ul class="social-list">

          <li class="social-item">
            <a href="https://www.facebook.com/IstiaqTusher.apk" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li class="social-item">
            <a href="https://github.com/Istiaq-Alam" class="social-link">
              <ion-icon name="logo-github"></ion-icon>
            </a>
          </li>

          <li class="social-item">
            <a href="https://www.linkedin.com/in/istiaq-alam.apk" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

          <li class="social-item">
            <a href="https://rxresu.me/istiaq-alam/istiaq-alam" target="_blank" title="Istiaq Alam Resume">
              <img width="18px" src="{{ asset('assets/images/cv.png') }}"></img>
            </a>
          </li>

        </ul>

      </div>

    </aside>

    <!--
      - #main-content
    -->

    <div class="main-content">

      <!--
        - #NAVBAR
      -->

      <nav class="navbar">

        <ul class="navbar-list">

          <li class="navbar-item">
            <button class="navbar-link  active" data-nav-link>About</button>
          </li>

          <li class="navbar-item">
            <button class="navbar-link" data-nav-link>Resume</button>
          </li>

          <li class="navbar-item">
            <button class="navbar-link" data-nav-link>Projects</button>
          </li>

          <li class="navbar-item">
            <button class="navbar-link" data-nav-link>Research</button>
          </li>

          <li class="navbar-item">
            <button class="navbar-link" data-nav-link>Contact</button>
          </li>

        </ul>

      </nav>

      <!--
        - #ABOUT
      -->

      <article class="about  active" data-page="about">

        <header>
          <h2 class="h2 article-title">About me</h2>
        </header>

        <section class="about-text">
          <p>
            🔐 I'm a Computer Science & Engineering student with a deep
            interest in Cyber Security and Ethical Hacking.
            I enjoy discovering system vulnerabilities, understanding digital
            threats, and crafting defenses that make
            the web a safer place. Currently engaged in hands-on learning
            through CTFs, simulation environments, and
            open-source security projects.
          </p>

          <p>
            I build secure and user-friendly websites that are functional and
            visually striking. My approach integrates
            clean coding practices with a strong focus on digital safety. I
            aim to make every site not only eye-catching
            but also aligned with cybersecurity best practices.
            <br> <br>
          <p align="center">"Securing the digital world, one line of code at a time."</p>
          </p>
        </section>
        <div class="center">
          <!-- <img src="https://tryhackme-badges.s3.amazonaws.com/TheSpyder.apk.png" alt="TheSpyder.apk" />  -->
          <iframe width="332" height="96" src="https://tryhackme.com/api/v2/badges/public-profile?userPublicId=5309241"
            style='border: none ;'></iframe>
        </div>

        <!--
          - service
        -->

        <section class="service">

          <h3 class="h3 service-title">What i'm doing</h3>

          <ul class="service-list">

            <li class="service-item">

              <div class="service-icon-box">
                <img src="{{ asset('assets/images/icon-design.svg') }}" alt="design icon" width="40">
              </div>

              <div class="service-content-box">
                <h4 class="h4 service-item-title">Penetration Testing</h4>

                <p class="service-item-text">
                  Identifying vulnerabilities and securing applications
                  through ethical hacking techniques.
                </p>
              </div>

            </li>

            <li class="service-item">

              <div class="service-icon-box">
                <img src="{{ asset('assets/images/icon-dev.svg') }}" alt="Web development icon" width="40">
              </div>

              <div class="service-content-box">
                <h4 class="h4 service-item-title">Web development</h4>

                <p class="service-item-text">
                  Building modern, responsive, and secure websites with
                  attention to usability and performance
                </p>
              </div>

            </li>

            <li class="service-item">

              <div class="service-icon-box">
                <img src="{{ asset('assets/images/ctf.png') }}" alt="mobile app icon" width="40">
              </div>

              <div class="service-content-box">
                <h4 class="h4 service-item-title">CTF & Labs</h4>

                <p class="service-item-text">
                  Capture the Flags, joining computer security competitions.
                </p>
              </div>

            </li>

            <li class="service-item">

              <div class="service-icon-box">
                <img src="{{ asset('assets/images/doc.png') }}" alt="camera icon" width="40">
              </div>

              <div class="service-content-box">
                <h4 class="h4 service-item-title">Security Documentation</h4>

                <p class="service-item-text">
                  Creating security reports, vulnerability assessments, and
                  guides for secure practices.
                </p>
              </div>

            </li>

          </ul>

        </section>

        <!--
          - Github Projects
        -->

        <section class="testimonials">

          <h3 class="h3 testimonials-title">Github Projects</h3>

          <ul class="testimonials-list has-scrollbar">
            @foreach ($githubProjects as $project)
            <li class="testimonials-item">
              <div class="content-card" data-testimonials-item>
                <figure class="testimonials-avatar-box">
                  <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" width="60" data-testimonials-avatar>
                </figure>
                <h4 class="h4 testimonials-item-title" data-testimonials-title>{{ $project->title }}</h4>
                <div class="testimonials-text" data-testimonials-text>
                  <p>{{ $project->description }}</p>
                </div>
              </div>
            </li>
            @endforeach
          </ul>

        </section>

        <!--
          - testimonials modal
        -->

        <div class="modal-container" data-modal-container>

          <div class="overlay" data-overlay></div>

          <section class="testimonials-modal">

            <button class="modal-close-btn" data-modal-close-btn>
              <ion-icon name="close-outline"></ion-icon>
            </button>

            <div class="modal-img-wrapper">
              <figure class="modal-avatar-box">
                <img src="{{ asset('assets/images/avatar-1.png') }}" alt="Daniel lewis" width="80" data-modal-img>
              </figure>

              <img src="{{ asset('assets/images/icon-quote.svg') }}" alt="quote icon">
            </div>

            <div class="modal-content">

              <h4 class="h3 modal-title" data-modal-title></h4>

              <time datetime="2024-04-28">2026</time>

              <div data-modal-text>
                <p>
                  .
                </p>
              </div>

            </div>

          </section>

        </div>

        <!--
          - Certificates
        -->

        <section class="clients">

          <h3 class="h3 clients-title">Certificates</h3>

          <ul class="clients-list has-scrollbar">
            @foreach ($certificates as $certificate)
            <li class="clients-item">
              <a onclick="openModal('{{ $certificate->image_url }}')">
                <img src="{{ $certificate->image_url }}" alt="{{ $certificate->title }}">
              </a>
            </li>
            @endforeach
          </ul>
          <!-- Modal -->
          <div id="imgModal" class="modals">
            <span onclick="closeModal()"></span>
            <img class="modals-content" id="modalImage">
          </div>

        </section>

      </article>

      <!--
        - #RESUME
      -->

      <article class="resume" data-page="resume">

        <header>
          <h2 class="h2 article-title">Resume</h2>
        </header>

        <section class="timeline">

          <div class="title-wrapper">
            <div class="icon-box">
              <ion-icon name="book-outline"></ion-icon>
            </div>

            <h3 class="h3">Education</h3>
          </div>

          <ol class="timeline-list">

            <li class="timeline-item">

              <h4 class="h4 timeline-item-title">Notre Dame University
                Bangladesh</h4>

              <span>2022 — Present</span>

              <p class="timeline-text">
                I am currently pursuing a Bachelor of Science in Computer
                Science and Engineering at Notre Dame
                University Bangladesh, where I'm developing a strong
                foundation in programming, system design, and
                technology.
              </p>

            </li>

            <li class="timeline-item">

              <h4 class="h4 timeline-item-title">Government Laboratory High
                School & Collage</h4>

              <span>2019 — 2021</span>

              <p class="timeline-text">
                I have completed my Higher Secondary Certificate (H.S.C) in 2021
                from Government Laboratory High School &
                College with GPA-5
              </p>

            </li>

            <li class="timeline-item">

              <h4 class="h4 timeline-item-title">Motijheel Govt. Boys High
                School</h4>

              <span>2009 — 2019</span>

              <p class="timeline-text">
                I have completed my Secondary School Certificate (S.S.C) in 2019
                from Motijheel Govt. Boys High School with
                GPA-4.78
              </p>

            </li>

          </ol>

        </section>

        <section class="timeline">

          <div class="title-wrapper">
            <div class="icon-box">
              <ion-icon name="book-outline"></ion-icon>
            </div>

            <h3 class="h3">Experience</h3>
          </div>

          <ol class="timeline-list">

            <li class="timeline-item">

              <h4 class="h4 timeline-item-title">Graphics Designer</h4>

              <span>Notre Dame University Bangladesh Computer Club <br>
                2024 — Present</span>

              <p class="timeline-text">
                Since 2023, I have been working as a Graphics Designer at the
                Notre Dame University Bangladesh Computer
                Club, where I design digital visuals for events, social media,
                and official branding. I have a passion
                for digital graphics art, with experience in both vector and
                raster-based design tools
              </p>

            </li>

            <li class="timeline-item">

              <h4 class="h4 timeline-item-title">Bash Terminal System</h4>

              <span>2019 — Present</span>

              <p class="timeline-text">
                I have over five years of experience using Kali Linux and
                other Bash-based terminal systems, which has
                given me strong command-line and security knowledge.
              </p>

            </li>

            <li class="timeline-item">

              <h4 class="h4 timeline-item-title">Web designer</h4>

              <span>2022 — Present</span>

              <p class="timeline-text">
                I also bring two years of hands-on experience in web design,
                specializing in creating responsive and
                user-friendly interfaces using HTML and CSS.
              </p>

            </li>

          </ol>

        </section>

        <section class="skill">

          <h3 class="h3 skills-title">My skills</h3>

          <ul class="skills-list content-card">
            @foreach ($skills as $skill)
            <li class="skills-item">
              <div class="title-wrapper">
                <h5 class="h5">{{ $skill->name }}</h5>
                <data value="{{ $skill->percentage }}">{{ $skill->percentage }}%</data>
              </div>
              <div class="skill-progress-bg">
                <div class="skill-progress-fill" style="width: {{ $skill->percentage }}%;"></div>
              </div>
            </li>
            @endforeach
          </ul> <br> <br>

          <h3 class="h3 skills-title">Languages :</h3>
          <div class="skills-list content-card">
            <ul>
              <li class="h5"> ▨ C/C++ : Problem Solving </li>
              <li class="h5"> ▨ Shell/Bash : Linux Terminal & Operating
                Systems </li>
              <li class="h5"> ▨ Java : Game Development </li>
              <li class="h5"> ▨ Javascript : Web Development </li>
              <li class="h5"> ▨ mySQL : Database Management </li>
              <li class="h5"> ▨ Python : Still Learning Progress </li>
            </ul>
          </div>

        </section>

      </article>

      <!--
        - #PORTFOLIO
      -->

      <article class="portfolio" data-page="projects">

        <header>
          <h2 class="h2 article-title">Projects</h2>
        </header>

        <section class="projects">

          <ul class="filter-list">

            <li class="filter-item">
              <button class="active" data-filter-btn>All</button>
            </li>

            <li class="filter-item">
              <button data-filter-btn>CyberSecurity</button>
            </li>

            <li class="filter-item">
              <button data-filter-btn>Applications</button>
            </li>

            <li class="filter-item">
              <button data-filter-btn>Web development</button>
            </li>

            <li class="filter-item">
              <button data-filter-btn>Learn</button>
            </li>

          </ul>

          <div class="filter-select-box">

            <button class="filter-select" data-select>

              <div class="select-value" data-selecct-value>Select
                category</div>

              <div class="select-icon">
                <ion-icon name="chevron-down"></ion-icon>
              </div>

            </button>

            <ul class="select-list">

              <li class="select-item">
                <button data-select-item>All</button>
              </li>

              <li class="select-item">
                <button data-select-item>CyberSecurity</button>
              </li>

              <li class="select-item">
                <button data-select-item>Applications</button>
              </li>

              <li class="select-item">
                <button data-select-item>Web development</button>
              </li>

              <li class="select-item">
                <button data-select-item>Learn</button>
              </li>

            </ul>

          </div>

          <ul class="project-list">
            @foreach ($projects as $project)
            <li class="project-item  active" data-filter-item data-category="{{ strtolower($project->category) }}">
              <a href="{{ $project->project_url ?? '#' }}">
                <figure class="project-img">
                  <div class="project-item-icon-box">
                    <ion-icon name="eye-outline"></ion-icon>
                  </div>
                  <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" loading="lazy">
                </figure>
                <h3 class="project-title">{{ $project->title }}</h3>
                <p class="project-category">{{ $project->sub_category ?? $project->category }}</p>
              </a>
            </li>
            @endforeach
          </ul>

        </section>

      </article>

      <!--
        - #Research
      -->

      <article class="blog" data-page="research">

        <header>
          <h2 class="h2 article-title">Research</h2>
        </header>

        <section class="blog-posts">

          <ul class="blog-posts-list">
            @foreach ($researches as $research)
            <li class="blog-post-item">
              <a href="{{ \App\Support\ImageUrl::resolve($research->research_url) ?? '#' }}" target="_blank">
                <figure class="blog-banner-box">
                  <img src="{{ $research->thumbnail_url }}" alt="{{ $research->title }}" loading="lazy">
                </figure>
                <div class="blog-content">
                  <div class="blog-meta">
                    <p class="blog-category">{{ $research->category }}</p>
                    <span class="dot"></span>
                    <time>{{ $research->published_date }}</time>
                  </div>
                  <h3 class="h3 blog-item-title">{{ $research->title }}</h3>
                  <p class="blog-text">{{ $research->description }}</p>
                </div>
              </a>
            </li>
            @endforeach
          </ul>

        </section>

      </article>

      <!--
        - #CONTACT
      -->

      <article class="contact" data-page="contact">

        <header>
          <h2 class="h2 article-title">Contact</h2>
        </header>

        <section class="mapbox" data-mapbox>
          <figure>
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4756.2784681175535!2d90.42392311476712!3d23.718054609071274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sbd!4v1748547351561!5m2!1sen!2sbd"
              width="400" height="600" style="border:0;" allowfullscreen loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </figure>
        </section>

        <section class="contact-form">

          <h3 class="h3 form-title">Contact Form</h3>

          @if (session('success'))
            <p class="form-success" role="status">{{ session('success') }}</p>
          @endif

          @if ($errors->any())
            <p class="form-success" role="alert">{{ $errors->first() }}</p>
          @endif

          <form action="{{ route('contact.store') }}" method="POST" class="form" data-form>
            @csrf

            <div class="input-wrapper">
              <input type="text" name="fullname" class="form-input" placeholder="Full name" required data-form-input>

              <input type="email" name="email" class="form-input" placeholder="Email address" required data-form-input>
            </div>

            <textarea name="message" class="form-input" placeholder="Your Message" required data-form-input></textarea>
            <div class="input-wrapper">
              <button class="form-btn" type="submit" disabled data-form-btn>
                <ion-icon name="paper-plane"></ion-icon>
                <span>Send Message</span>
              </button>

              <a class="form-btr" href="{{ asset('assets/pdf/istiaq-alam.pdf') }}" target="_blank" title="Download Resume">
                <img width="18px" src="{{ asset('assets/images/cv.png') }}"></img>
                <span>Download Resume</span></a>
            </div>
          </form>


        </section>

      </article>

    </div>

  </main>

  <!--
    - custom js link
  -->
  <script src="{{ asset('assets/js/script.js') }}"></script>

  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
istiak

</html>