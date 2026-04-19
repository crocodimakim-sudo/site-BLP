let projects = [];

let currentProject = null;
let currentSlideIndex = 0;

function renderProjects() {
    const grid = document.getElementById("projectsGrid");

    projects.forEach((project, index) => {
        const card = document.createElement("div");
        card.className = "project-card";
        card.onclick = () => openModal(index);

        // O3: бейдж category (второй бейдж если есть)
        const categoryBadge = project.category
            ? '<span class="project-category">' + project.category + '</span>'
            : '';

        // O1: placeholder если нет изображений
        if (project.images.length === 0) {
            card.innerHTML =
                '<div class="mini-slider mini-slider--empty" id="miniSlider-' + index + '">' +
                '<div class="mini-slider__placeholder"><svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg></div>' +
                '<span class="project-tag">' + project.tag + '</span>' +
                categoryBadge +
                '</div>' +
                '<div class="project-info"><h3 class="project-name">' + project.name + '</h3><div class="project-location"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' + project.location + '</div></div>';
            grid.appendChild(card);
            return;
        }

        const slidesHtml = project.images.map((img, i) => {
            const activeClass = i === 0 ? "active" : "";
            return '<div class="mini-slide ' + activeClass + '" data-index="' + i + '"><img src="' + img + '" alt="' + project.name + ' - фото ' + (i+1) + '" loading="lazy"></div>';
        }).join("");

        card.innerHTML =
            '<div class="mini-slider" id="miniSlider-' + index + '">' + slidesHtml +
            '<span class="project-tag">' + project.tag + '</span>' +
            categoryBadge +
            '<span class="slide-counter">1 / ' + project.images.length + '</span>' +
            '<button class="mini-nav prev" onclick="event.stopPropagation(); changeMiniSlide(' + index + ', -1)"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg></button>' +
            '<button class="mini-nav next" onclick="event.stopPropagation(); changeMiniSlide(' + index + ', 1)"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></button>' +
            '<div class="expand-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg></div></div>' +
            '<div class="project-info"><h3 class="project-name">' + project.name + '</h3><div class="project-location"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' + project.location + '</div></div>';

        grid.appendChild(card);
    });
}

function changeMiniSlide(projectIndex, direction) {
    const slider = document.getElementById("miniSlider-" + projectIndex);
    const slides = slider.querySelectorAll(".mini-slide");
    const counter = slider.querySelector(".slide-counter");

    let current = Array.from(slides).findIndex(s => s.classList.contains("active"));
    let next = current + direction;

    if (next >= slides.length) next = 0;
    if (next < 0) next = slides.length - 1;

    slides[current].classList.remove("active");
    slides[next].classList.add("active");
    counter.textContent = (next + 1) + " / " + slides.length;
}

function openModal(projectIndex) {
    currentProject = projects[projectIndex];
    currentSlideIndex = 0;

    const modal = document.getElementById("projectModal");
    const slider = document.getElementById("modalSlider");
    const thumbs = document.getElementById("modalThumbs");

    // O1: если нет изображений — не открываем модалку
    if (!currentProject.images || currentProject.images.length === 0) {
        return;
    }

    const slidesHtml = currentProject.images.map((img, i) => `
        <div class="fullscreen-slide ${i === 0 ? 'active' : ''}" data-index="${i}">
            <img src="${img}" alt="${currentProject.name} - ${i+1}">
        </div>
    `).join("");

    slider.innerHTML = slidesHtml;

    const thumbsHtml = currentProject.images.map((img, i) => `
        <div class="modal-thumb ${i === 0 ? 'active' : ''}" onclick="goToSlide(${i})">
            <img src="${img}" alt="thumbnail ${i+1}">
        </div>
    `).join("");

    thumbs.innerHTML = thumbsHtml;

    document.getElementById("modalTitle").textContent = currentProject.name;
    document.getElementById("modalLocationText").textContent = currentProject.location;

    modal.classList.add("active");
    document.body.style.overflow = "hidden";

    document.addEventListener("keydown", handleKeydown);
}

function closeModal() {
    const modal = document.getElementById("projectModal");
    modal.classList.remove("active");
    document.body.style.overflow = "";
    document.removeEventListener("keydown", handleKeydown);
}

function changeModalSlide(direction) {
    const slides = document.querySelectorAll(".fullscreen-slide");

    let next = currentSlideIndex + direction;
    if (next >= slides.length) next = 0;
    if (next < 0) next = slides.length - 1;

    goToSlide(next);
}

function goToSlide(index) {
    const slides = document.querySelectorAll(".fullscreen-slide");
    const thumbs = document.querySelectorAll(".modal-thumb");

    slides[currentSlideIndex].classList.remove("active");
    thumbs[currentSlideIndex].classList.remove("active");

    currentSlideIndex = index;

    slides[currentSlideIndex].classList.add("active");
    thumbs[currentSlideIndex].classList.add("active");

    thumbs[currentSlideIndex].scrollIntoView({ behavior: "smooth", inline: "center", block: "nearest" });
}

function handleKeydown(e) {
    if (e.key === "Escape") closeModal();
    if (e.key === "ArrowLeft") changeModalSlide(-1);
    if (e.key === "ArrowRight") changeModalSlide(1);
}

document.getElementById("projectModal").addEventListener("click", function(e) {
    if (e.target === this) closeModal();
});

fetch('/blp/blocks/get_projects.php')
    .then(r => r.json())
    .then(data => {
        projects = data;
        renderProjects();
    })
    .catch(() => {
        document.getElementById("projectsGrid").innerHTML =
            '<p style="color:red;padding:2rem;">Ошибка загрузки проектов</p>';
    });
